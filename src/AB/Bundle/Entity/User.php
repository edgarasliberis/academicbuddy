<?php
namespace AB\Bundle\Entity;

//use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "pupil" = "Pupil", "mentor" = "Mentor"})
 */
class User extends BaseUser//implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

//    /**
//     * @ORM\Column(type="string", length=32)
//     */
//    protected $salt;
//
//    /**
//     * @ORM\Column(type="string", length=60)
//     */
//    protected $password;
//
//    /**
//     * @ORM\Column(type="string", length=255, unique=true)
//     * @Assert\NotBlank()
//     * @Assert\Email()
//     */
//    protected $email;
//
//    /**
//     * @ORM\Column(type="string", length=10, unique=true)
//     */
//    protected $activationKey;
//
//    /**
//     * @ORM\Column(name="is_active", type="boolean")
//     */
//    protected $isActive;

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
     * @ORM\Column(type="integer")
     */
    protected $phase;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $facebookId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $linkedinId;

    public function __construct()
    {
        parent::__construct();
        $this->setPhase(3); //TODO: fix
        $this->plainPassword = substr(md5(uniqid(null, true)), 0, 5);
    }

    /**
     * @param mixed $phase
     */
    public function setPhase($phase)
    {
        $this->phase = $phase;
    }

    /**
     * @return mixed
     */
    public function getPhase()
    {
        return $this->phase;
    }


//    /**
//     * @inheritDoc
//     */
//    public function getUsername()
//    {
//        return $this->email;
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function getSalt()
//    {
//        return $this->salt;
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function getPassword()
//    {
//        return $this->password;
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function getRoles()
//    {
//        if($this instanceof Pupil) {
//            return array('ROLE_PUPIL');
//        } else if($this instanceof Mentor) {
//            return array('ROLE_MENTOR');
//        }
//        return array('ROLE_ADMIN'); // TODO: solve this properly
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function eraseCredentials()
//    {
//    }
//
//    /**
//     * @see \Serializable::serialize()
//     */
//    public function serialize()
//    {
//        return serialize(array(
//            $this->id,
//        ));
//    }
//
//    /**
//     * @see \Serializable::unserialize()
//     */
//    public function unserialize($serialized)
//    {
//        list (
//            $this->id,
//        ) = unserialize($serialized);
//    }
//
//    /**
//     * Get id
//     *
//     * @return integer
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /**
//     * Set username
//     *
//     * @param string $username
//     * @return User
//     */
//    public function setUsername($username)
//    {
//        $this->email = $username;
//
//        return $this;
//    }
//
//    /**
//     * Set salt
//     *
//     * @param string $salt
//     * @return User
//     */
//    public function setSalt($salt)
//    {
//        $this->salt = $salt;
//
//        return $this;
//    }
//
//    /**
//     * Set password
//     *
//     * @param string $password
//     * @return User
//     */
//    public function setPassword($password)
//    {
//        $this->password = $password;
//
//        return $this;
//    }
//
    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        parent::setEmail($email);
        parent::setUsername($email);
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
//
//    /**
//     * Set activationKey
//     *
//     * @param string $activationKey
//     * @return User
//     */
//    public function setActivationKey($activationKey)
//    {
//        $this->activationKey = $activationKey;
//
//        return $this;
//    }
//
//    /**
//     * Get activationKey
//     *
//     * @return string
//     */
//    public function getActivationKey()
//    {
//        return $this->activationKey;
//    }
//
//    /**
//     * Set isActive
//     *
//     * @param boolean $isActive
//     * @return User
//     */
//    public function setIsActive($isActive)
//    {
//        $this->isActive = $isActive;
//
//        return $this;
//    }
//
//    /**
//     * Get isActive
//     *
//     * @return boolean
//     */
//    public function getIsActive()
//    {
//        return $this->isActive;
//    }
//
//    public function isAccountNonExpired()
//    {
//        return true;
//    }
//
//    public function isAccountNonLocked()
//    {
//        return true;
//    }
//
//    public function isCredentialsNonExpired()
//    {
//        return true;
//    }
//
//    public function isEnabled()
//    {
//        return $this->isActive;
//    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
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
     * @return User
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
     * @param mixed $facebookId
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    }

    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param mixed $linkedinId
     */
    public function setLinkedinId($linkedinId)
    {
        $this->linkedinId = $linkedinId;
    }

    /**
     * @return mixed
     */
    public function getLinkedinId()
    {
        return $this->linkedinId;
    }

}
