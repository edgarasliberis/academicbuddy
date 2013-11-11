<?php
namespace AB\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="pupil")
 */
class Pupil
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	/*
		Personal infromation
	*/

	/**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $lastName;

	/**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

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
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */    	
    protected $schoolName;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank()
     */
    protected $schoolGraduationYear;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $schoolCity;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\NotBlank()
     */
    protected $schoolGrade;

    /*
    	University choice and motivation
    */

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */ 
    protected $universityRegion;

    /**
     * @ORM\ManyToOne(targetEntity="CourseCategory", inversedBy="courses")
     * @ORM\JoinColumn(name="course_category_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    protected $courseCategory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */ 
    protected $courseName;    

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $motivation;

    /*
    	Additional fields
    */

    /**
     * @ORM\Column(type="boolean")
     */ 
    protected $active;

    /**
     * @ORM\Column(type="integer")
     */ 
    protected $phase;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Pupil
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Pupil
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Pupil
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
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
     * Set universityChoice
     *
     * @param string $universityChoice
     * @return Pupil
     */
    public function setUniversityChoice($universityChoice)
    {
        $this->universityChoice = $universityChoice;
    
        return $this;
    }

    /**
     * Get universityChoice
     *
     * @return string 
     */
    public function getUniversityChoice()
    {
        return $this->universityChoice;
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
     * Set active
     *
     * @param boolean $active
     * @return Pupil
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
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