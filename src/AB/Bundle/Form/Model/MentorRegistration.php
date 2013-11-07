<?php
namespace AB\Bundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use AB\Bundle\Entity\Mentor;

class MentorRegistration
{
    /**
     * @Assert\Type(type="AB\Bundle\Entity\Mentor")
     * @Assert\Valid()
     */
    public $mentor;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    public function setMentor(Mentor $mentor)
    {
        $this->mentor = $mentor;
    }

    public function getMentor()
    {
        return $this->mentor;
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