<?php
namespace AB\Bundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups")
 */
class Group
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Pupil", mappedBy="group")
     */
    protected $pupils;

    /**
     * @ORM\OneToOne(targetEntity="Mentor", inversedBy="mentorOf")
     */
    protected $mentor;

    /**
     * @ORM\ManyToOne(targetEntity="Mentor")
     */
    protected $secondaryMentor;

    public function __construct()
    {
        $this->pupils = new ArrayCollection();
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
     * Add pupils
     *
     * @param \AB\Bundle\Entity\Pupil $pupils
     * @return University
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

    public function getMentor()
    {
        return $this->mentor;
    }

    public function setMentor(\AB\Bundle\Entity\Mentor $mentor)
    {
        $this->mentor = $mentor;
        return $this;
    }

    public function getSecondaryMentor()
    {
        return $this->secondaryMentor;
    }

    public function setSecondaryMentor(\AB\Bundle\Entity\Mentor $secondaryMentor)
    {
        $this->secondaryMentor = $secondaryMentor;
        return $this;
    }

    public function __toString()
    {
        //return $this->name;
        return null;
    }

}