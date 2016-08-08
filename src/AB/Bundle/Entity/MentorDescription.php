<?php
namespace AB\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="descriptions")
 */
class MentorDescription
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $university;

    /**
     * @ORM\Column(type="text")
     */
    protected $subject;

    /**
     * @ORM\Column(type="text")
     */
    protected $school;

    /**
     * @ORM\Column(type="text")
     */
    protected $introduction;

    /**
     * @ORM\Column(type="text")
     */
    protected $extracurriculars;

    /**
     * @ORM\Column(type="text")
     */
    protected $uniActivities;

    /**
     * @ORM\Column(type="text")
     */
    protected $whyme;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUniversity()
    {
        return $this->university;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getSchool()
    {
        return $this->school;
    }

    public function getIntroduction()
    {
        return $this->introduction;
    }

    public function getExtracurriculars()
    {
        return $this->extracurriculars;
    }

    public function getUniActivities()
    {
        return $this->uniActivities;
    }

    public function getWhyme()
    {
        return $this->whyme;
    }
}