<?php

namespace Samenjoy\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *
 * @author sasedev <seif.salah@gmail.com>
 *         @ORM\Table(name="sej_roles")
 *         @ORM\Entity(repositoryClass="Samenjoy\DataBundle\Repository\RoleRepository")
 *         @ORM\HasLifecycleCallbacks
 *         @UniqueEntity(fields="name")
 */
class Role implements RoleInterface
{

    /**
     *
     * @var bigint @ORM\Column(name="id", type="bigint", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="SEQUENCE")
     *      @ORM\SequenceGenerator(sequenceName="sej_roles_id_seq", initialValue=1, allocationSize=1)
     */
    protected $id;

    /**
     *
     * @var string @ORM\Column(name="name", type="text", length=102, nullable=false)
     *      @Assert\Length(max=100)
     *      @Assert\Regex(pattern="/^ROLE\_[A-Z](([A-Z0-9\_]+[A-Z0-9])|[A-Z0-9])$/")
     */
    protected $name;

    /**
     *
     * @var string @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     *
     * @var Collection @ORM\ManyToMany(targetEntity="Role", inversedBy="childs")
     *      @ORM\JoinTable(
     *      name="sej_role_parents",
     *      joinColumns={@ORM\JoinColumn(name="id_role_child", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_role_parent", referencedColumnName="id")}
     *      )
     *      @ORM\OrderBy({"name" = "ASC"})
     */
    protected $parents;

    /**
     *
     * @var Collection @ORM\ManyToMany(targetEntity="Role", mappedBy="parents")
     *      @ORM\JoinTable(
     *      name="sej_role_parents",
     *      joinColumns={@ORM\JoinColumn(name="id_role_parent", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_role_child", referencedColumnName="id")}
     *      )
     *      @ORM\OrderBy({"name" = "ASC"})
     */
    protected $childs;

    /**
     *
     * @var Collection @ORM\ManyToMany(targetEntity="User",
     *      mappedBy="userRoles")
     *      @ORM\JoinTable(name="sej_users_roles",
     *      joinColumns={
     *      @ORM\JoinColumn(name="id_role", referencedColumnName="id")
     *      },
     *      inverseJoinColumns={
     *      @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     *      }
     *      )
     */
    protected $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parents = new ArrayCollection();
        $this->childs = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Role
     */
    public function setName($name)
    {

        $this->name = trim(strtoupper($name));

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
     * Set description
     *
     * @param string $roleDescription
     *
     * @return Role
     */
    public function setDescription($roleDescription)
    {

        $this->description = $roleDescription;

        return $this;

    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {

        return $this->description;

    }

    /**
     * Add Role
     *
     * @param Role $role
     *
     * @return Role
     */
    public function addParent(Role $role)
    {

        $this->parents[] = $role;

        return $this;

    }

    /**
     * Remove Role
     *
     * @param Role $role
     *
     * @return Role
     */
    public function removeParent(Role $role)
    {

        $this->parents->removeElement($role);

        return $this;

    }

    /**
     * Set Role Collection
     *
     * @param Collection $roles
     *
     * @return Role
     */
    public function setParents(Collection $roles)
    {

        $this->parents = $roles;

        return $this;

    }

    /**
     * Get Role ArrayCollection
     *
     * @return ArrayCollection
     */
    public function getParents()
    {

        return $this->parents;

    }

    /**
     * Add Role
     *
     * @param Role $role
     *
     * @return Role
     */
    public function addChild(Role $role)
    {

        $this->childs[] = $role;

        return $this;

    }

    /**
     * Remove Role
     *
     * @param Role $role
     *
     * @return Role
     */
    public function removeChild(Role $role)
    {

        $this->childs->removeElement($role);

        return $this;

    }

    /**
     * Set Role Collection
     *
     * @param Collection $roles
     *
     * @return Role
     */
    public function setChilds(Collection $roles)
    {

        $this->childs = $roles;

        return $this;

    }

    /**
     * Get Role ArrayCollection
     *
     * @return ArrayCollection
     */
    public function getChilds()
    {

        return $this->childs;

    }

    /**
     * Add User
     *
     * @param User $user
     *
     * @return User
     */
    public function addUser(User $user)
    {

        $this->users[] = $user;

        return $this;

    }

    /**
     * Remove User
     *
     * @param User $user
     *
     * @return User
     */
    public function removeUser(User $user)
    {

        $this->users->removeElement($user);

        return $this;

    }

    /**
     * Set User Collection
     *
     * @param Collection $users
     *
     * @return User
     */
    public function setUsers(Collection $users)
    {

        $this->users = $users;

        return $this;

    }

    /**
     * Get User ArrayCollection
     *
     * @return ArrayCollection
     */
    public function getUsers()
    {

        return $this->users;

    }

    /**
     * (non-PHPdoc) @see \Symfony\Component\Security\Core\Role\RoleInterface::getRole()
     *
     * @return string
     */
    public function getRole()
    {

        return $this->getName();

    }

    /**
     * string representation of the object
     *
     * @return string
     */
    public function __toString()
    {

        return (string) $this->getName();

    }
}