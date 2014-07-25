<?php
namespace AB\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="course_category")
 */
class CourseCategory
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="courseCategory")
     */
    protected $courses;

    /**
     * @ORM\OneToMany(targetEntity="Pupil", mappedBy="courseCategory")
     */
    protected $pupils;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pupils = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return CourseCategory
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add courses
     *
     * @param \AB\Bundle\Entity\Course $courses
     * @return CourseCategory
     */
    public function addCourse(\AB\Bundle\Entity\Course $courses)
    {
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

    public function __toString() {
        return $this->name;
    }

    /**
     * Add pupils
     *
     * @param \AB\Bundle\Entity\Pupil $pupils
     * @return CourseCategory
     */
    public function addPupil(\AB\Bundle\Entity\Pupil $pupils)
    {
        $this->pupils[] = $pupils;
    
        return $this;
    }

    /**
     * Remove pupils
     *
     * @param \AB\Bundle\Entity\Pupil $pupils
     */
    public function removePupil(\AB\Bundle\Entity\Pupil $pupils)
    {
        $this->pupils->removeElement($pupils);
    }

    /**
     * Get pupils
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPupils()
    {
        return $this->pupils;
    }
}