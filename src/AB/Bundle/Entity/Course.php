<?php
namespace AB\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Details of a course attended by a mentor 
 *
 * @ORM\Entity
 * @ORM\Table(name="course")
 */
class Course
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Mentor", inversedBy="courses", cascade={"persist","remove"}, fetch="EAGER")
     */
    protected $mentor;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="University", inversedBy="courses")
     * @ORM\JoinColumn(name="university_id", referencedColumnName="id", nullable=false)
     */
    protected $university;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $college;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $startYear;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $graduationYear;

    /**
     * @ORM\ManyToOne(targetEntity="CourseCategory", inversedBy="courses")
     * @ORM\JoinColumn(name="course_category_id", referencedColumnName="id")
     */
    protected $courseCategory;

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
     * @return Course
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
     * Set college
     *
     * @param string $college
     * @return Course
     */
    public function setCollege($college)
    {
        $this->college = $college;
    
        return $this;
    }

    /**
     * Get college
     *
     * @return string 
     */
    public function getCollege()
    {
        return $this->college;
    }

    /**
     * Set startYear
     *
     * @param integer $startYear
     * @return Course
     */
    public function setStartYear($startYear)
    {
        $this->startYear = $startYear;
    
        return $this;
    }

    /**
     * Get startYear
     *
     * @return integer 
     */
    public function getStartYear()
    {
        return $this->startYear;
    }

    /**
     * Set graduationYear
     *
     * @param integer $graduationYear
     * @return Course
     */
    public function setGraduationYear($graduationYear)
    {
        $this->graduationYear = $graduationYear;
    
        return $this;
    }

    /**
     * Get graduationYear
     *
     * @return integer 
     */
    public function getGraduationYear()
    {
        return $this->graduationYear;
    }

    /**
     * Set courseSection
     *
     * @param integer $courseSection
     * @return Course
     */
    public function setCourseSection($courseSection)
    {
        $this->courseSection = $courseSection;
    
        return $this;
    }

    /**
     * Get courseSection
     *
     * @return integer 
     */
    public function getCourseSection()
    {
        return $this->courseSection;
    }

    /**
     * Set mentor
     *
     * @param \AB\Bundle\Entity\Mentor $mentor
     * @return Course
     */
    public function setMentor(\AB\Bundle\Entity\Mentor $mentor = null)
    {
        $this->mentor = $mentor;
    
        return $this;
    }

    /**
     * Get mentor
     *
     * @return \AB\Bundle\Entity\Mentor 
     */
    public function getMentor()
    {
        return $this->mentor;
    }

    /**
     * Set university
     *
     * @param \AB\Bundle\Entity\University $university
     * @return Course
     */
    public function setUniversity(\AB\Bundle\Entity\University $university = null)
    {
        $university->addCourse($this);

        $this->university = $university;
        return $this;
    }

    /**
     * Get university
     *
     * @return \AB\Bundle\Entity\University 
     */
    public function getUniversity()
    {
        return $this->university;
    }

    /**
     * Set courseCategory
     *
     * @param \AB\Bundle\Entity\CourseCategory $courseCategory
     * @return Course
     */
    public function setCourseCategory(\AB\Bundle\Entity\CourseCategory $courseCategory)
    {
        $this->courseCategory = $courseCategory;
    
        return $this;
    }

    /**
     * Get courseCategory
     *
     * @return \AB\Bundle\Entity\CourseCategory 
     */
    public function getCourseCategory()
    {
        return $this->courseCategory;
    }
}