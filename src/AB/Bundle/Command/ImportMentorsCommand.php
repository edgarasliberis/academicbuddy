<?php
namespace AB\Bundle\Command;

use AB\Bundle\Entity\Course;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AB\Bundle\Entity\University;

class ImportMentorsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('ab:mentorimport')
            ->setDescription('Import mentor data')
            ->addArgument('mentorinput', InputArgument::REQUIRED, 'Path to the exported mentor data CSV file')
            ->addArgument('uniinput', InputArgument::REQUIRED, 'Path to the exported mentor uni data CSV file')
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

        $inputMentors = $input->getArgument('mentorinput');
        $inputUnis = $input->getArgument('uniinput');

        $mentors = $this->getRows($inputMentors);
        $unis = $this->getRows($inputUnis);


        $discriminator = $this->getContainer()->get('pugx_user.manager.user_discriminator');
        $discriminator->setClass('AB\Bundle\Entity\Mentor');
        $userManager = $this->getContainer()->get('pugx_user_manager');


        $count = 0;
        foreach ($mentors as $data) {
            $mentor = $userManager->createUser();

            // Empty course on initialization bug
            $courses = $mentor->getCourses();
            foreach ($courses as $course) $mentor->removeCourse($course);

            $mentor->setFirstName($data[1]);
            $mentor->setLastName($data[2]);
            $mentor->setEmail($data[3]);


            $mentorExists = $em->getRepository('ABBundle:User')->findOneBy(array('email' => $data[3]));
            if ($mentorExists != null) continue;

            $mentor->setHomeCity($data[4]);
            $mentor->setFacebookId($data[5]);
            $mentor->setLinkedinId($data[6]);
            $mentor->setSchoolName($this->removeSlashes($data[7]));
            $mentor->setSchoolCity($data[8]);
            $mentor->setSchoolGraduationYear($data[9]);
            $mentor->setAbout($this->removeSlashes($data[10]));

            foreach ($unis as $uni) {
                if ($uni[0] == $data[0]) {
                    $course = new Course();

                    $uniname = $this->removeSlashes($uni[1]);
                    $university = $em->getRepository('ABBundle:University')
                        ->findOneByName($uniname);
                    if ($university == null) {
                        $output->writeln($data[3].print_r($uni));
                    }
                    else $course->setUniversity($university);

                    $course->setCollege($this->removeSlashes($uni[2]));
                    $course->setName($this->removeSlashes($uni[3]));

                    $category = $em->getRepository('ABBundle:CourseCategory')->findOneById($uni[4] + 1);
                    if ($category == null) {
                        $output->writeln($data[3].print_r($uni));
                    }
                    else $course->setCourseCategory($category);

                    $course->setStartYear($uni[5]);
                    $course->setGraduationYear($uni[6]);

                    $mentor->addCourse($course);
                }
            }
            $tokenGenerator = $this->getContainer()->get('fos_user.util.token_generator');
            $mentor->setConfirmationToken($tokenGenerator->generateToken());

            $userManager->updateUser($mentor, true);
            $count++;
        }
        $output->writeln("Success, updated $count");
    }
}
?>
