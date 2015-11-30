<?php
namespace AB\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AB\Bundle\ApiEntity\ApiGroup;
use AB\Bundle\ApiEntity\ApiUser;
use JMS\Serializer\SerializerBuilder;

class SendGroupMailCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ab:sendmail')
            ->setDescription('Send email to groups specified in the file')
            ->addArgument('pairings_json', InputArgument::REQUIRED, 'JSON file with group allocation, where users are referenced by email.');
    }

    public static function findUserByEmail($em, $email, $type) {
        if(empty($email)) return null;
        return $em->getRepository($type)->findOneBy(array('email' => $email));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $serializer = SerializerBuilder::create()->build();
        $mailer = $this->getContainer()->get('ab_user.mailer');
        $em = $this->getContainer()->get('doctrine')->getManager();

        $list = $input->getArgument('pairings_json');
        $pairingsContents = file_get_contents($list);

        $groups = $serializer->deserialize($pairingsContents, 'array<AB\Bundle\ApiEntity\ApiEmailOnlyGroup>', 'json');

        foreach($groups as $emailGroup) {
            $apiGroup = new ApiGroup();
            $apiGroup->mentor = ApiUser::fromUser(self::findUserByEmail($em, $emailGroup->mentor, 'ABBundle:Mentor'));
            $apiGroup->secondaryMentor = ApiUser::fromUser(self::findUserByEmail($em, $emailGroup->secondaryMentor, 'ABBundle:Mentor'));
            $apiGroup->pupils = array_map(function($u) use ($em, $output) { 
                return ApiUser::fromUser(self::findUserByEmail($em, $u, 'ABBundle:Pupil'));
            }, $emailGroup->pupils);

            $output->writeln($apiGroup->mentor->email);

            $mailer->sendMeetYourGroupMessage($apiGroup);
        }

        //$output->writeln($text);
    }
}

?>
