<?php
namespace AB\Bundle\Command;

use AB\Bundle\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SendMentorInvitationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ab:sendinvites')
            ->setDescription('Mentor data')
            ->addArgument('mentorinput', InputArgument::REQUIRED, 'Path to the exported mentor data CSV file');
    }

    private function getRows($file) {
        $rows = array();
        if (($handle = fopen($file, "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle, null, ",")) !== FALSE) {
                $i++;
                if ($i == 1) continue;
                $rows[] = $data;
            }
            fclose($handle);
        }
        return $rows;
    }

    private function removeSlashes($string) {
        return str_replace(array('/', '\\'), '', $string);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $mailer = $this->getContainer()->get('ab_user.mailer');

        $inputMentors = $input->getArgument('mentorinput');
        $mentors = $this->getRows($inputMentors);

        $count = 0;
        foreach ($mentors as $data) {
            $mentorArray = array();
            $mentorArray['email'] = $data[2];
            $mentorArray['name'] = $data[0] . ' ' . $data[1];
            $mentorArray['about'] = $this->removeSlashes($data[6]);
            $mailer->sendMentorInvitationMessage($mentorArray);
            ++$count;
        }
        $output->writeln("Success, updated $count");
    }
}
?>
