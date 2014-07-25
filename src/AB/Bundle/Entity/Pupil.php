<?php
namespace AB\Bundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="pupil")
 * @UniqueEntity(fields = "email", targetClass = "AB\Bundle\Entity\User", message="fos_user.email.already_used")
 */
class Pupil extends User
{
	/*
		Personal infromation
	*/

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $homeCity;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $about;

    /*
    	School information
    */

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */    	
    protected $schoolName;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\NotBlank()
     */
    protected $schoolGraduationYear;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    protected $schoolCity;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\NotBlank()
     */
    protected $schoolGrade;

    /*
    	University choice and motivation
    */

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */ 
    protected $universityRegion;

    /**
     * @ORM\ManyToOne(targetEntity="CourseCategory", inversedBy="pupils")
     */
    protected $courseCategory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */ 
    protected $courseName;    

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     */
    protected $motivation;

    /*
    	Additional fields
    */


    public function __construct()
    {
        parent::__construct();
        $this->courses = new ArrayCollection();
        $this->addRole("ROLE_PUPIL");
    }

    /**
     * Set homeCity
     *
     * @param string $homeCity
     * @return Pupil
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
     * @return Pupil
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
     * @return Pupil
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
     * @return Pupil
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
     * @return Pupil
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
     * Set schoolGrade
     *
     * @param float $schoolGrade
     * @return Pupil
     */
    public function setSchoolGrade($schoolGrade)
    {
        $this->schoolGrade = $schoolGrade;
    
        return $this;
    }

    /**
     * Get schoolGrade
     *
     * @return float 
     */
    public function getSchoolGrade()
    {
        return $this->schoolGrade;
    }


    /**
     * Set courseCategory
     *
     * @param integer $courseCategory
     * @return Pupil
     */
    public function setCourseCategory($courseCategory)
    {
        $this->courseCategory = $courseCategory;
    
        return $this;
    }

    /**
     * Get courseCategory
     *
     * @return integer 
     */
    public function getCourseCategory()
    {
        return $this->courseCategory;
    }

    /**
     * Set motivation
     *
     * @param string $motivation
     * @return Pupil
     */
    public function setMotivation($motivation)
    {
        $this->motivation = $motivation;
    
        return $this;
    }

    /**
     * Get motivation
     *
     * @return string 
     */
    public function getMotivation()
    {
        return $this->motivation;
    }

    /**
     * Set phase
     *
     * @param integer $phase
     * @return Pupil
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
     * Set universityRegion
     *
     * @param string $universityRegion
     * @return Pupil
     */
    public function setUniversityRegion($universityRegion)
    {
        $this->universityRegion = $universityRegion;
    
        return $this;
    }

    /**
     * Get universityRegion
     *
     * @return string 
     */
    public function getUniversityRegion()
    {
        return $this->universityRegion;
    }

    /**
     * Set courseName
     *
     * @param string $courseName
     * @return Pupil
     */
    public function setCourseName($courseName)
    {
        $this->courseName = $courseName;
    
        return $this;
    }

    /**
     * Get courseName
     *
     * @return string 
     */
    public function getCourseName()
    {
        return $this->courseName;
    }
}
