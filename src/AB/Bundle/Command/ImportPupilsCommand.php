<?php
namespace AB\Bundle\Command;

use AB\Bundle\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AB\Bundle\Entity\University;

class ImportPupilsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ab:pupilimport')
            ->setDescription('Import pupil data')
            ->addArgument('pupilinput', InputArgument::REQUIRED, 'Path to the exported pupil data CSV file')
        ;
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
        $em = $this->getContainer()->get('doctrine')->getEntityManager();

        $inputPupils = $input->getArgument('pupilinput');
        $pupils = $this->getRows($inputPupils);

        $discriminator = $this->getContainer()->get('pugx_user.manager.user_discriminator');
        $discriminator->setClass('AB\Bundle\Entity\Pupil');
        $userManager = $this->getContainer()->get('pugx_user_manager');

        $count = 0;
        foreach ($pupils as $data) {
            $pupil = $userManager->createUser();

            $pupil->setFirstName($data[1]);
            $pupil->setLastName($data[2]);
            $pupil->setHomeCity($data[3]);
            $pupil->setSchoolName($this->removeSlashes($data[4]));
            $pupil->setSchoolGraduationYear($data[5]);
            $pupil->setSchoolCity($data[6]);
            $pupil->setCourseName($data[8]);

            $pupil->setEmail($data[9]);
            $pupilExists = $em->getRepository('ABBundle:Pupil')->findOneBy(array('email' => $data[9]));
            if ($pupilExists != null) continue;

            $pupil->setFacebookId($data[10]);
            $pupil->setLinkedinId($data[11]);

            $pupil->setMotivation($this->removeSlashes($data[12]));
            $pupil->setAbout($this->removeSlashes($data[13]));

            $category = $em->getRepository('ABBundle:CourseCategory')->findOneById($data[16] + 1);
            if ($category == null) {
                $output->writeln(print_r($data));
            }
            else $pupil->setCourseCategory($category);

            $pupil->setSchoolGrade($data[18]);

            $regions = array('England', 'London', 'Scotland', 'Other');
            $region = $regions[intval($data[21])];
            $pupil->setUniversityRegion($region);

            $tokenGenerator = $this->getContainer()->get('fos_user.util.token_generator');
            $pupil->setConfirmationToken($tokenGenerator->generateToken());

            $userManager->updateUser($pupil);
            $count++;
        }
        $output->writeln("Success, updated $count");
    }
}
?>
