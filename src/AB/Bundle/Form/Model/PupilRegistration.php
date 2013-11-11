<?php
namespace AB\Bundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use AB\Bundle\Entity\Pupil;

class PupilRegistration
{
    /**
     * @Assert\Type(type="AB\Bundle\Entity\Pupil")
     * @Assert\Valid()
     */
    public $pupil;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    public function setPupil(Pupil $pupil)
    {
        $this->pupil = $pupil;
    }

    public function getPupil()
    {
        return $this->pupil;
    }

    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (Boolean) $termsAccepted;
    }
}