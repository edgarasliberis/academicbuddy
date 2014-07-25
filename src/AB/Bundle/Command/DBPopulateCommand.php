<?php
namespace AB\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AB\Bundle\Entity\University;

class DBPopulateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ab:dbpopulate')
            ->setDescription('Populate the database')
            ->addArgument('unilist', InputArgument::REQUIRED, 'Path to a newline-separated list of universities')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $list = $input->getArgument('unilist');
        $lines = file($list, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if($lines == false) {
            $text = 'There was an error reading the university list.';
        } else {
            foreach($lines as $line) {
                $u = explode("|", $line);

                $uni = new University();
                $uni->setName($u[0]);
                $uni->setCountry($u[1]);

                $em->persist($uni);
            }

            $em->flush();
            $text = 'Loaded university names.';
        }

        $output->writeln($text);
    }
}

?>
