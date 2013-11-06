<?php
namespace AB\StoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="mentor")
 */
class Mentor
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
     * @ORM\Column(type="string", length=255)
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
     * @ORM\Column(type="string", length=255)
     */     
    protected $schoolName;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $schoolGraduationYear;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $schoolCity;

    /*
    	University information
    */

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="mentor")
     */
    protected $courses;

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

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

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
     * @return Mentor
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
     * @return Mentor
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
     * @return Mentor
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
     * Set active
     *
     * @param boolean $active
     * @return Mentor
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
     * @param \AB\StoreBundle\Entity\Course $courses
     * @return Mentor
     */
    public function addCourse(\AB\StoreBundle\Entity\Course $courses)
    {
        $this->courses[] = $courses;
    
        return $this;
    }

    /**
     * Remove courses
     *
     * @param \AB\StoreBundle\Entity\Course $courses
     */
    public function removeCourse(\AB\StoreBundle\Entity\Course $courses)
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