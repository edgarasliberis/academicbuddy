<?php
namespace AB\Bundle\Command;

use AB\Bundle\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AB\Bundle\Entity\University;

class PurgeDbCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ab:purgedb')
            ->setDescription('Cleans the database for advancing project stage. Will remove administrators and universities too.')
        ;
    }

    private function emptyRepository($em, $repoName)
    {
        $repo = $em->getRepository($repoName)->findAll();
        foreach ($repo as $e) {
            $em->remove($e);
        }
        $em->flush();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();

        $this->emptyRepository($em, 'ABBundle:Group');
        $this->emptyRepository($em, 'ABBundle:Mentor');
        $this->emptyRepository($em, 'ABBundle:Pupil');
        $this->emptyRepository($em, 'ABBundle:University');

        $output->writeln("Database successfully emptied.");
    }
}
?>
