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
     * @ORM\OneToMany(targetEntity="Pupil", mappedBy="group", cascade={"persist"})
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
    public function addPupils(\AB\Bundle\Entity\Pupil $pupil)
    {
        $this->pupils[] = $pupil;
        $pupil->setGroup($this);
        return $this;
    }

    /**
     * Remove pupils
     *
     * @param \AB\Bundle\Entity\Pupil $pupil
     */
    public function removePupils(\AB\Bundle\Entity\Pupil $pupil)
    {
        $this->pupils->removeElement($pupil);
    }

    /**
     * Remove all pupils
     */
    public function removeAllPupils()
    {
        $this->pupils->clear();
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

    public function setSecondaryMentor(\AB\Bundle\Entity\Mentor $secondaryMentor = null)
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