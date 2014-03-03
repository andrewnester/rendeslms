<?php

namespace Rendes\Modules\User\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="\Rendes\Modules\User\Repositories\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User extends \CModel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     */
    private $passwordRepeat;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, nullable=false)
     */
    private $role;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activated", type="boolean", nullable=false)
     */
    private $activated;

    /**
     * @var string
     *
     * @ORM\Column(name="activate_code", type="string", length=255, nullable=false)
     */
    private $activateCode;

    /**
     * @var string
     *
     * @ORM\Column(name="access_token", type="string", length=255, nullable=true)
     */
    private $accessToken;

    /**
     * @var string
     *
     * @ORM\Column(name="refreshToken", type="string", length=255, nullable=true)
     */
    private $refreshToken;

    /**
     * @var integer
     *
     * @ORM\Column(name="expires", type="integer", nullable=true)
     */
    private $expires;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="token_updated", type="datetime", nullable=true)
     */
    private $tokenUpdated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=false)
     */
    private $modified;






    public function rules(){
        return array(
            array('name, password', 'required'),
            array('name, email', '\Rendes\Validators\DoctrineUnique', 'on' => 'register'),
            array('passwordRepeat, email', 'required', 'on' => 'register'),
            array('passwordRepeat', 'compare', 'compareAttribute'=>'password', 'on' => 'register'),
        );
    }





    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $passwordEncoder = new \Rendes\Modules\User\Services\PasswordEncoder();
        $this->password = $passwordEncoder->encode(($password));
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /** @ORM\PrePersist */
    public function setCreationDate()
    {
        $this->created = new \DateTime();
        $this->modified = new \DateTime();
    }

    /** @ORM\PreUpdate */
    public function setModifiedDate()
    {
        $this->modified = new \DateTime();
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string|bool
     */
    public function getAccessToken()
    {

        if((time() - $this->getTokenUpdated()->getTimestamp()) >= $this->getExpires() || empty($this->accessToken)){
            return false;
        }
        return $this->accessToken;
    }

    /**
     * @param string $refreshToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param \DateTime $tokenUpdated
     */
    public function setTokenUpdated($tokenUpdated)
    {
        $this->tokenUpdated = $tokenUpdated;
    }

    /**
     * @return \DateTime
     */
    public function getTokenUpdated()
    {
        return $this->tokenUpdated;
    }

    /**
     * @param int $expires
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;
    }

    /**
     * @return int
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param string $activateCode
     */
    public function setActivateCode($activateCode)
    {
        $this->activateCode = $activateCode;
    }

    /**
     * @return string
     */
    public function getActivateCode()
    {
        return $this->activateCode;
    }

    /**
     * @param boolean $activated
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;
    }

    /**
     * @return boolean
     */
    public function getActivated()
    {
        return $this->activated;
    }

    /**
     * @param string $passwordRepeat
     */
    public function setPasswordRepeat($passwordRepeat)
    {
        $passwordEncoder = new \Rendes\Modules\User\Services\PasswordEncoder();
        $this->passwordRepeat = $passwordEncoder->encode(($passwordRepeat));
    }

    /**
     * @return string
     */
    public function getPasswordRepeat()
    {
        return $this->passwordRepeat;
    }





    public function attributeNames()
    {
        return array(
            'id'=>'id',
            'name'=>'name',
            'email'=>'email',
            'created'=>'created',
            'updated'=>'updated'
        );
    }

    public function attributeLabels()
    {
        return array(
            'description' => 'desc',
            'createdString' => 'Creation Date'
        );
    }

}
