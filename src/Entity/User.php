<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="AppUser")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements \Symfony\Component\Security\Core\User\AdvancedUserInterface, \Serializable
{
    public $plainPassword;
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     */
    public $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    public $isActive;
    
    public function getActive() {
        return $this->isActive;
    }

    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }
    
    public function setUsername($username) 
    {
         $this->username = $username;
    }
    
    public function getId() 
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }
    
    public function getPlainPassword() 
    {
        return $this->plainPassword;
    }
    
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
    
    public function setPassword($password) 
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function setEmail($email) 
    {
        $this->email = $email;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    public function isAccountNonExpired(): bool {
        return true;
    }

    public function isAccountNonLocked(): bool {
        return true;
    }

    public function isCredentialsNonExpired(): bool {
        return true;
    }

    public function isEnabled(): bool {
        return $this->isActive;
    }

}