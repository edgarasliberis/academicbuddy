<?php
namespace AB\Bundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="mentor")
 * @UniqueEntity(fields = "email", targetClass = "AB\Bundle\Entity\User", message="fos_user.email.already_used")
 */
class Mentor extends User
{
    /*
        Personal infromation
    */

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $homeCity;

    /**
     * @ORM\Column(type="text")
     */
    protected $about;

    /*
    	School information
    */

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */     
    protected $schoolName;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $schoolGraduationYear;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $schoolCity;

    /*
    	University information
    */

    /**
     * @Assert\Valid()
     * @ORM\OneToMany(targetEntity="Course", mappedBy="mentor", cascade={"persist","remove"})
     */
    protected $courses;

    /*
    	Additional fields
    */

    /**
     * @ORM\Column(type="integer")
     */ 
    protected $phase;

    public function __construct()
    {
        parent::__construct();
        $this->courses = new ArrayCollection();
        $this->addRole("ROLE_MENTOR");
        $this->addCourse(new Course()); // an empty Course for the registration form
    }

    /**
     * Set homeCity
     *
     * @param string $homeCity
     * @return Mentor
     */
    public function setHomeCity($homeCity)
    {
        $this->homeCity = $homeCity;
    
        return $this;
    }

    /**
     * Get homeCity
     *
     * @return string 
     */
    public function getHomeCity()
    {
        return $this->homeCity;
    }

    /**
     * Set about
     *
     * @param string $about
     * @return Mentor
     */
    public function setAbout($about)
    {
        $this->about = $about;
    
        return $this;
    }

    /**
     * Get about
     *
     * @return string 
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set schoolName
     *
     * @param string $schoolName
     * @return Mentor
     */
    public function setSchoolName($schoolName)
    {
        $this->schoolName = $schoolName;
    
        return $this;
    }

    /**
     * Get schoolName
     *
     * @return string 
     */
    public function getSchoolName()
    {
        return $this->schoolName;
    }

    /**
     * Set schoolGraduationYear
     *
     * @param integer $schoolGraduationYear
     * @return Mentor
     */
    public function setSchoolGraduationYear($schoolGraduationYear)
    {
        $this->schoolGraduationYear = $schoolGraduationYear;
    
        return $this;
    }

    /**
     * Get schoolGraduationYear
     *
     * @return integer 
     */
    public function getSchoolGraduationYear()
    {
        return $this->schoolGraduationYear;
    }

    /**
     * Set schoolCity
     *
     * @param string $schoolCity
     * @return Mentor
     */
    public function setSchoolCity($schoolCity)
    {
        $this->schoolCity = $schoolCity;
    
        return $this;
    }

    /**
     * Get schoolCity
     *
     * @return string 
     */
    public function getSchoolCity()
    {
        return $this->schoolCity;
    }

    /**
     * Set phase
     *
     * @param integer $phase
     * @return Mentor
     */
    public function setPhase($phase)
    {
        $this->phase = $phase;
    
        return $this;
    }

    /**
     * Get phase
     *
     * @return integer 
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * Add courses
     *
     * @param \AB\Bundle\Entity\Course $courses
     * @return Mentor
     */
    public function addCourse(\AB\Bundle\Entity\Course $courses)
    {
        $courses->setMentor($this);
        $this->courses[] = $courses;
    
        return $this;
    }

    /**
     * Remove courses
     *
     * @param \AB\Bundle\Entity\Course $courses
     */
    public function removeCourse(\AB\Bundle\Entity\Course $courses)
    {
        $this->courses->removeElement($courses);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCourses()
    {
        return $this->courses;
    }

}
