<?php

namespace Samenjoy\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use SASEdev\Commons\SharedBundle\Validator as ExtraAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Encoder\Pbkdf2PasswordEncoder;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @author sasedev <seif.salah@gmail.com>
 *         @ORM\Table(name="sej_users")
 *         @ORM\Entity(repositoryClass="Samenjoy\DataBundle\Repository\UserRepository")
 *         @ORM\HasLifecycleCallbacks
 *         @UniqueEntity(fields="username", groups={"Default", "Registration"})
 *         @UniqueEntity(fields="email", groups={"Default", "Registration", })
 */
class User implements UserInterface, \Serializable
{

    /**
     *
     * @var integer
     */
    const SEXE_MISS = 1;

    /**
     *
     * @var integer
     */
    const SEXE_MRS = 2;

    /**
     *
     * @var integer
     */
    const SEXE_MR = 3;

    /**
     *
     * @var integer
     */
    const LOCKOUT_UNLOCKED = 1;

    /**
     *
     * @var integer
     */
    const LOCKOUT_LOCKED = 2;

    /**
     *
     * @var string
     */
    const LANG_FR = 'fr';

    /**
     *
     * @var string
     */
    const LANG_EN = 'en';

    /**
     *
     * @var string
     */
    const LANG_NL = 'nl';

    /**
     *
     * @var integer
     */
    const DECLINE = 1;

    /**
     *
     * @var integer
     */
    const ACCEPT = 2;

    /**
     *
     * @var bigint @ORM\Column(name="id", type="bigint", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="SEQUENCE")
     *      @ORM\SequenceGenerator(sequenceName="sej_users_id_seq", initialValue=1, allocationSize=1)
     */
    protected $id;

    /**
     *
     * @var string @ORM\Column(name="username", type="text", nullable=false, unique=true)
     *      @Assert\Length(min = "3", max = "100", groups={"Registration"})
     *      @Assert\Regex(pattern="/^[a-z0-9][a-z0-9_]+$/", groups={"Registration"})
     */
    protected $username;

    /**
     *
     * @var string @ORM\Column(name="email", type="text", nullable=true)
     *      @Assert\Email(checkMX=true, checkHost=true, groups={"Registration", "admUpdateMail", "updateMail"})
     */
    protected $email;

    /**
     *
     * @var string @ORM\Column(name="clearpassword", type="text", nullable=true)
     *      @Assert\Length(min="8", max="250", groups={"updatePass"})
     */
    protected $clearPassword;

    /**
     *
     * @var string @ORM\Column(name="passwd", type="text", nullable=true)
     */
    protected $password;

    /**
     *
     * @var string @ORM\Column(name="salt", type="text", nullable=true)
     */
    protected $salt;

    /**
     *
     * @var string @ORM\Column(name="recoverycode", type="text", nullable=true)
     */
    protected $recoveryCode;

    /**
     *
     * @var \DateTime @ORM\Column(name="recoveryexpiration", type="datetimetz", nullable=true)
     */
    protected $recoveryExpiration;

    /**
     *
     * @var integer @ORM\Column(name="lockout", type="integer", nullable=false)
     *      @Assert\Choice(callback="choiceLockoutCallback", groups={"admLockout"})
     */
    protected $lockout;

    /**
     *
     * @var integer @ORM\Column(name="logins", type="bigint", nullable=false)
     */
    protected $logins;

    /**
     *
     * @var \DateTime @ORM\Column(name="lastlogin", type="datetimetz", nullable=true)
     */
    protected $lastLogin;

    /**
     *
     * @var \DateTime @ORM\Column(name="lastactivity", type="datetimetz", nullable=true)
     */
    protected $lastActivity;

    /**
     *
     * @var integer @ORM\Column(name="sexe", type="integer", nullable=true)
     *      @Assert\Choice(callback="choiceSexeCallback", groups={"Registration","admProfile", "profile"})
     */
    protected $sexe;

    /**
     *
     * @var string @ORM\Column(name="lastname", type="text", nullable=true)
     */
    protected $lastName;

    /**
     *
     * @var string @ORM\Column(name="firstname", type="text", nullable=true)
     */
    protected $firstName;

    /**
     *
     * @var \DateTime @ORM\Column(name="birthday", type="date", nullable=true)
     *      @Assert\Date(groups={"admProfile", "profile"})
     */
    protected $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="streetnum", type="text", nullable=true)
     */
    protected $streetNum;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="text", nullable=true)
     */
    protected $address;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="text", nullable=true)
     */
    protected $town;

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="text", nullable=true)
     */
    protected $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="text", nullable=true)
     */
    protected $country;

    /**
     *
     * @var string @ORM\Column(name="phone", type="text", nullable=true)
     *      @ExtraAssert\Phone(groups={"Registration", "admProfile", "profile"})
     */
    protected $phone;

    /**
     *
     * @var string @ORM\Column(name="mobile", type="text", nullable=true)
     *      @ExtraAssert\Phone(groups={"Registration", "admProfile", "profile"})
     */
    protected $mobile;

    /**
     *
     * @var string @ORM\Column(name="lang", type="text", nullable=true)
     *      @Assert\Choice(callback="choiceLangCallback", groups={"Registration", "admProfile", "profile"})
     */
    protected $lang;

    /**
     *
     * @var integer @ORM\Column(name="cgu", type="integer", nullable=false)
     *      @Assert\Choice(callback="choiceTFCallback", groups={"Registration"})
     */
    protected $cgu = self::DECLINE;

    /**
     *
     * @var integer @ORM\Column(name="cgv", type="integer", nullable=false)
     *      @Assert\Choice(callback="choiceTFCallback", groups={"Registration"})
     */
    protected $cgv = self::DECLINE;

    /**
     *
     * @var integer @ORM\Column(name="newsletter", type="integer", nullable=false)
     *      @Assert\Choice(callback="choiceTFCallback", groups={"Registration", "admProfile", "profile"})
     */
    protected $newsletter = self::ACCEPT;

    /**
     *
     * @var bigfloat @ORM\Column(name="balance", type="bigfloat", nullable=true)
     *      @ExtraAssert\Phone(groups={"Registration", "admProfile", "profile"})
     */
    protected $balance;

    /**
     *
     * @var \DateTime @ORM\Column(name="dtcrea", type="datetimetz", nullable=true)
     */
    protected $dtCrea;

    /**
     *
     * @var UserAvatar @ORM\OneToOne(targetEntity="UserAvatar", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $avatar;

    /**
     *
     * @var \DateTime @ORM\Column(name="dtupdate", type="datetimetz", nullable=true)
     *      @Gedmo\Timestampable(on="update")
     */
    protected $dtUpdate;

    /**
     *
     * @var Collection @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     *      @ORM\JoinTable(name="sej_users_roles",
     *      joinColumns={
     *      @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     *      },
     *      inverseJoinColumns={
     *      @ORM\JoinColumn(name="id_role", referencedColumnName="id")
     *      }
     *      )
     */
    protected $userRoles;

    /**
     * Constructor
     */
    public function __construct()
    {

        $this->setDtCrea(new \DateTime('now'));
        $this->setLockout(self::LOCKOUT_UNLOCKED);
        $this->setLogins(0);
        $this->setSalt(md5(uniqid(null, true)));
        $this->setClearPassword(
            self::generateRandomChar(8, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
        );

        $this->setBalance(0);

        $this->setNewsletter(self::ACCEPT);

        $this->setUserRoles(new ArrayCollection());

    }

    /**
     * Get id
     *
     * @return bigint
     */
    public function getId()
    {

        return $this->id;

    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {

        $this->username = trim(strtolower($username));

        return $this;

    }

    /**
     * Get username
     * (non-PHPdoc) @see
     * \Symfony\Component\Security\Core\User\UserInterface::getUsername()
     *
     * @return string
     */
    public function getUsername()
    {

        return $this->username;

    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = trim(strtolower($email));

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
     * Set clearPassword
     *
     * @param string $clearPassword
     *
     * @return User
     */
    public function setClearPassword($clearPassword)
    {

        $this->clearPassword = $clearPassword;

        return $this->setPassword($clearPassword);

    }

    /**
     * Get clearPassword
     *
     * @return string
     */
    public function getClearPassword()
    {

        return $this->clearPassword;

    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {

        $encoder = new Pbkdf2PasswordEncoder('sha512', true, 1000);
        $this->password = $encoder->encodePassword($password, $this->getSalt());

        return $this;

    }

    /**
     * Get password
     * (non-PHPdoc) @see
     * \Symfony\Component\Security\Core\User\UserInterface::getPassword()
     *
     * @return string
     */
    public function getPassword()
    {

        return $this->password;

    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {

        $this->salt = $salt;

        return $this;

    }

    /**
     * Get salt
     * (non-PHPdoc) @see
     * \Symfony\Component\Security\Core\User\UserInterface::getSalt()
     *
     * @return string
     */
    public function getSalt()
    {

        return $this->salt;

    }

    /**
     * Set recoveryCode
     *
     * @param string $recoveryCode
     *
     * @return User
     */
    public function setRecoveryCode($recoveryCode)
    {

        $this->recoveryCode = urlencode(base64_encode($recoveryCode));

        return $this;

    }

    /**
     * Get recoveryCode
     *
     * @return string
     */
    public function getRecoveryCode()
    {

        return $this->recoveryCode;

    }

    /**
     * Set recoveryExpiration
     *
     * @param \DateTime $recoveryExpiration
     *
     * @return User
     */
    public function setRecoveryExpiration(\DateTime $recoveryExpiration = null)
    {

        $this->recoveryExpiration = $recoveryExpiration;

        return $this;

    }

    /**
     * Get recoveryExpiration
     *
     * @return \DateTime
     */
    public function getRecoveryExpiration()
    {

        return $this->recoveryExpiration;

    }

    /**
     * Set lockout
     *
     * @param integer $lockout
     *
     * @return User
     */
    public function setLockout($lockout)
    {

        $this->lockout = $lockout;

        return $this;

    }

    /**
     * Get lockout
     *
     * @return integer
     */
    public function getLockout()
    {

        return $this->lockout;

    }

    /**
     * Set logins
     *
     * @param integer $logins
     *
     * @return User
     */
    public function setLogins($logins)
    {

        $this->logins = $logins;

        return $this;

    }

    /**
     * Get logins
     *
     * @return integer
     */
    public function getLogins()
    {

        return $this->logins;

    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     *
     * @return User
     */
    public function setLastLogin(\DateTime $lastLogin = null)
    {

        $this->lastLogin = $lastLogin;

        return $this;

    }

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {

        return $this->lastLogin;

    }

    /**
     * Set lastActivity
     *
     * @param \DateTime $lastActivity
     *
     * @return User
     */
    public function setLastActivity(\DateTime $lastActivity = null)
    {

        $this->lastActivity = $lastActivity;

        return $this;

    }

    /**
     * Get lastActivity
     *
     * @return \DateTime
     */
    public function getLastActivity()
    {

        return $this->lastActivity;

    }

    /**
     * Set sexe
     *
     * @param integer $sexe
     *
     * @return User
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;

    }

    /**
     * Get sexe
     *
     * @return integer
     */
    public function getSexe()
    {

        return $this->sexe;

    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
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
     * Set firstName
     *
     * @param string $firstName
     *
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
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return User
     */
    public function setBirthday(\DateTime $birthday = null)
    {
        $this->birthday = $birthday;

        return $this;

    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {

        return $this->birthday;

    }

    /**
     *
     * @return string
     */
    public function getStreetNum()
    {
        return $this->streetNum;
    }

    /**
     * Set $streetNum
     *
     * @param string $streetNum
     *
     * @return User this
     */
    public function setStreetNum($streetNum)
    {
        $this->streetNum = $streetNum;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set $address
     *
     * @param string $address
     *
     * @return User this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set $town
     *
     * @param string $town
     *
     * @return User this
     */
    public function setTown($town)
    {
        $this->town = $town;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set $zipcode
     *
     * @param string $zipcode
     *
     * @return User this
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set $country
     *
     * @param string $country
     *
     * @return User this
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;

    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {

        return $this->phone;

    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return User
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;

    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {

        return $this->mobile;

    }

    /**
     * Set lang
     *
     * @param string $lang
     *
     * @return User
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;

    }

    /**
     * Get lang
     *
     * @return string
     */
    public function getLang()
    {

        return $this->lang;

    }

    /**
     * Set balance
     *
     * @param bigfloat $balance
     *
     * @return User
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;

    }

    /**
     * Get balance
     *
     * @return bigfloat
     */
    public function getBalance()
    {

        return $this->balance;

    }

    /**
     * Set cgu
     *
     * @param integer $cgu
     *
     * @return User
     */
    public function setCgu($cgu)
    {
        $this->cgu = $cgu;

        return $this;

    }

    /**
     * Get cgu
     *
     * @return integer
     */
    public function getCgu()
    {

        return $this->cgu;

    }

    /**
     * Set cgv
     *
     * @param integer $cgv
     *
     * @return User
     */
    public function setCgv($cgv)
    {
        $this->cgv = $cgv;

        return $this;

    }

    /**
     * Get cgv
     *
     * @return integer
     */
    public function getCgv()
    {

        return $this->cgv;

    }

    /**
     * Set newsletter
     *
     * @param integer $newsletter
     *
     * @return User
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;

    }

    /**
     * Get newsletter
     *
     * @return integer
     */
    public function getNewsletter()
    {

        return $this->newsletter;

    }

    /**
     * Set dtCrea
     *
     * @param \DateTime $dtCrea
     *
     * @return User
     */
    public function setDtCrea(\DateTime $dtCrea = null)
    {

        $this->dtCrea = $dtCrea;

        return $this;

    }

    /**
     * Get dtCrea
     *
     * @return \DateTime
     */
    public function getDtCrea()
    {

        return $this->dtCrea;

    }

    /**
     * Set dtUpdate
     *
     * @param \DateTime $dtUpdate
     *
     * @return User
     */
    public function setDtUpdate(\DateTime $dtUpdate = null)
    {

        $this->dtUpdate = $dtUpdate;

        return $this;

    }

    /**
     * Get dtUpdate
     *
     * @return \DateTime
     */
    public function getDtUpdate()
    {

        return $this->dtUpdate;

    }

    /**
     *
     * @return UserAvatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set $avatar
     *
     * @param UserAvatar $avatar
     *
     * @return User this
     */
    public function setAvatar(UserAvatar $avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * Add Role
     *
     * @param Role $role
     *
     * @return User
     */
    public function addUserRole(Role $role)
    {

        $this->userRoles[] = $role;

        return $this;

    }

    /**
     * Remove Role
     *
     * @param Role $role
     *
     * @return User
     */
    public function removeUserRole(Role $role)
    {

        $this->userRoles->removeElement($role);

        return $this;

    }

    /**
     * set Role Collection
     *
     * @param Collection $roles
     *
     * @return User
     */
    public function setUserRoles(Collection $roles = null)
    {

        $this->userRoles = $roles;

        return $this;

    }

    /**
     * Get Role ArrayCollection
     *
     * @return ArrayCollection
     */
    public function getUserRoles()
    {

        return $this->userRoles;

    }

    /**
     * Get calculated fullName From username, firstName and lastName
     *
     * @return string
     */
    public function getFullname()
    {

        if (null == $this->getFirstName() && null == $this->getLastName()) {
            return $this->getUsername();
        } elseif (null != $this->getFirstName() && null != $this->getLastName()) {
            return $this->getFirstName() . " " . $this->getLastName();
        } else {
            if (null != $this->getLastName()) {
                return $this->getLastName();
            }
            if (null != $this->getFirstName()) {
                return $this->getFirstName();
            }
        }

    }

    /**
     * Set the lastActivity to now
     *
     * @return User
     */
    public function isActiveNow()
    {

        return $this->setLastActivity(new \DateTime());

    }

    public function toOgone()
    {
        $convertion = array(
           'UserId'        => 'id',
           'GENDER'        => 'Sexe',
           //'CIVILITY'      => 'Sexe',
           'CN'            => 'FullName',
           'ECOM_BILLTO_POSTAL_NAME_FIRST'  => 'FirstName',
           'ECOM_BILLTO_POSTAL_NAME_LAST'   => 'LastName',
           'EMAIL'         => 'Email',
           //'OWNERZIP'      => 'ZipCode',
           //'OWNERADDRESS'  => 'Address',
           //'OWNERADDRESS2' => 'Address2',
           //'OWNERCTY'      => 'Country',
           //'OWNERTOWN'     => 'Town',
           'OWNERTELNO'   => 'Mobile',
           'OWNERTELNO2'    => 'Phone',
           //'ECOM_SHIPTO_DOB' => 'Birthday',
        );

        foreach ($convertion as $ogoneKey => $propelGetter) {
            $convertion[$ogoneKey] = $this->{'get'.$propelGetter}();
        }

        return $convertion;
    }

    /*
     * (non-PHPdoc) @see \Symfony\Component\Security\Core\User\UserInterface::getRoles()
     */
    public function getRoles()
    {
        return $this->userRoles->toArray();
    }

    /**
     * Erases the user credentials.
     * (non-PHPdoc) @see \Symfony\Component\Security\Core\User\UserInterface::eraseCredentials()
     */
    public function eraseCredentials()
    {

        //$this->clearPassword = null;

    }

    /**
     * Serializes the User.
     * The serialized data have to contain the fields used by the equals method
     * and the username.
     * (non-PHPdoc) @see Serializable::serialize()
     *
     * @return string
     */
    public function serialize()
    {

        return serialize(array($this->password, $this->salt, $this->username, $this->email, $this->lockout, $this->id));

    }

    /**
     * Unserializes the User.
     * (non-PHPdoc) @see Serializable::unserialize()
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {

        $data = unserialize($serialized);
        // add a few extra elements in the array to ensure that we have enough
        // keys when
        // unserializing
        // older data which does not include all properties.
        $data = array_merge($data, array_fill(0, 2, null));

        list($this->password, $this->salt, $this->username, $this->email, $this->lockout, $this->id) = $data;

    }

    /**
     * Choice Form lockout
     *
     * @return multitype:string
     */
    public static function choiceLockout()
    {

        return array(
            self::LOCKOUT_UNLOCKED => 'Lockout.choice.' . self::LOCKOUT_UNLOCKED,
            self::LOCKOUT_LOCKED => 'Lockout.choice.' . self::LOCKOUT_LOCKED
        );

    }

    /**
     * Choice Validator lockout
     *
     * @return multitype:string
     */
    public static function choiceLockoutCallback()
    {

        return array(self::LOCKOUT_UNLOCKED, self::LOCKOUT_LOCKED);

    }

    /**
     * Choice Form sexe
     *
     * @return multitype:string
     */
    public static function choiceSexe()
    {

        return array(
            self::SEXE_MISS => 'Sexe.choice.' . self::SEXE_MISS,
            self::SEXE_MRS => 'Sexe.choice.' . self::SEXE_MRS,
            self::SEXE_MR => 'Sexe.choice.' . self::SEXE_MR
        );

    }

    /**
     * Choice Validator sexe
     *
     * @return multitype:integer
     */
    public static function choiceSexeCallback()
    {

        return array(
            self::SEXE_MISS,
            self::SEXE_MRS,
            self::SEXE_MR
        );

    }

    /**
     * Choice Form lang
     *
     * @return multitype:string
     */
    public static function choiceLang()
    {

        return array(
            self::LANG_FR => 'Lang.choice.' . self::LANG_FR,
            self::LANG_EN => 'Lang.choice.' . self::LANG_EN,
            self::LANG_NL => 'Lang.choice.' . self::LANG_NL
        );

    }

    /**
     * Choice Validator lang
     *
     * @return multitype:string
     */
    public static function choiceLangCallback()
    {

        return array(
            self::LANG_FR,
            self::LANG_EN,
            self::LANG_NL
        );

    }

    /**
     * Choice Form cgu
     *
     * @return multitype:string
     */
    public static function choiceTF()
    {

        return array(
            self::DECLINE => 'Action.choice.' . self::DECLINE,
            self::ACCEPT => 'Action.choice.' . self::ACCEPT
        );

    }

    /**
     * Choice Validator cgu
     *
     * @return multitype:string
     */
    public static function choiceTFCallback()
    {

        return array(self::DECLINE, self::ACCEPT);

    }

    /**
     * Get a random char (for generated password)
     *
     * @param integer $length
     * @param string $charset
     *
     * @return string
     */
    public static function generateRandomChar(
        $length,
        $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789#@!?+=*/-'
    ) {

        $str = '';
        $count = strlen($charset);
        while ($length--) {
            $str .= $charset[mt_rand(0, $count - 1)];
        }

        return $str;

    }

    /**
     * string representation of the object
     *
     * @return string
     */
    public function __toString()
    {

        return (string) $this->getFullname();

    }

}