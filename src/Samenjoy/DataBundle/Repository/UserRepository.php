<?php
namespace Samenjoy\DataBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Samenjoy\DataBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @author sasedev <seif.salah@gmail.com>
 *
 */
class UserRepository extends EntityRepository implements UserProviderInterface
{

    /**
     * Used for Authentification Security
     * (non-PHPdoc) @see \Symfony\Component\Security\Core\User\UserProviderInterface::loadUserByUsername()
     *
     * @param string $username
     *
     * @throws UsernameNotFoundException
     *
     * @return Ambigous <\Doctrine\ORM\mixed, mixed, \Doctrine\ORM\Internal\Hydration\mixed,
     *         \Doctrine\DBAL\Driver\Statement, \Doctrine\Common\Cache\mixed>
     */
    public function loadUserByUsername($username)
    {

        $q = $this->createQueryBuilder('u')
        ->where('u.username = :username')
        ->andWhere('u.lockout = :lockout')
        ->setParameter('username', $username)
        ->setParameter('lockout', User::LOCKOUT_UNLOCKED)
        ->getQuery();

        try {
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            throw new UsernameNotFoundException(
                sprintf('Unable to find an active User identified by "%s".', $username),
                null,
                0,
                $e
            );
        }

        return $user;

    }

    /**
     * Used for Authentification Security
     * (non-PHPdoc) @see \Symfony\Component\Security\Core\User\UserProviderInterface::refreshUser()
     *
     * @param UserInterface $user
     *
     * @return User
     */
    public function refreshUser(UserInterface $user)
    {

        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        return $this->loadUserByUsername($user->getUsername());

    }

    /**
     * Check if is a sublass of the Entity
     * (non-PHPdoc) @see \Symfony\Component\Security\Core\User\UserProviderInterface::supportsClass()
     *
     * @param string $class
     *
     * @return boolean
     */
    public function supportsClass($class)
    {

        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());

    }

    /**
     * Count All
     *
     * @return Ambigous <\Doctrine\ORM\mixed, mixed, multitype:, \Doctrine\DBAL\Driver\Statement,
     *         \Doctrine\Common\Cache\mixed>
     */
    public function count()
    {

        $qb = $this->createQueryBuilder('u')->select('count(u)');
        $query = $qb->getQuery();

        return $query->getSingleScalarResult();

    }

    /**
     * Get Query for All Entities
     *
     * @return \Doctrine\ORM\Query
     */
    public function getAllQuery()
    {

        return $this->createQueryBuilder('u')
        ->orderBy('u.username', 'ASC')
        ->getQuery();

    }

    /**
     * Get All Entities
     *
     * @return Ambigous <\Doctrine\ORM\mixed, \Doctrine\ORM\Internal\Hydration\mixed, \Doctrine\DBAL\Driver\Statement,
     *         \Doctrine\Common\Cache\mixed>
     */
    public function getAll()
    {

        return $this->getAllQuery()->execute();

    }

    /**
     * Count All
     *
     * @return Ambigous <\Doctrine\ORM\mixed, mixed, multitype:, \Doctrine\DBAL\Driver\Statement,
     *         \Doctrine\Common\Cache\mixed>
     */
    public function countSearch($q)
    {

        $qb = $this->createQueryBuilder('u')->select('count(u)')->distinct()
        ->where('LOWER(u.username) LIKE :key')
        ->orWhere('LOWER(u.sageCode) LIKE :key')
        ->orWhere('LOWER(u.email) LIKE :key')
        ->orWhere('LOWER(u.firstName) LIKE :key')
        ->orWhere('LOWER(u.lastName) LIKE :key')
        ->orWhere('LOWER(u.address) LIKE :key')
        ->orWhere('LOWER(u.address2) LIKE :key')
        ->orWhere('LOWER(u.town) LIKE :key')
        ->orWhere('LOWER(u.zipCode) LIKE :key')
        ->orWhere('LOWER(u.mobile) LIKE :key')
        ->orWhere('LOWER(u.phone) LIKE :key')
        ->setParameter('key', '%' . strtolower($q) . '%');
        $query = $qb->getQuery();

        return $query->getSingleScalarResult();

    }

    /**
     * Get Query for All Entities
     *
     * @return \Doctrine\ORM\Query
     */
    public function getAllSearchQuery($q)
    {

        return $this->createQueryBuilder('u')->distinct()
        ->where('LOWER(u.username) LIKE :key')
        ->orWhere('LOWER(u.sageCode) LIKE :key')
        ->orWhere('LOWER(u.email) LIKE :key')
        ->orWhere('LOWER(u.firstName) LIKE :key')
        ->orWhere('LOWER(u.lastName) LIKE :key')
        ->orWhere('LOWER(u.address) LIKE :key')
        ->orWhere('LOWER(u.address2) LIKE :key')
        ->orWhere('LOWER(u.town) LIKE :key')
        ->orWhere('LOWER(u.zipCode) LIKE :key')
        ->orWhere('LOWER(u.mobile) LIKE :key')
        ->orWhere('LOWER(u.phone) LIKE :key')
        ->orderBy('u.username', 'ASC')
        ->setParameter('key', '%' . strtolower($q) . '%')
        ->getQuery();

    }

    /**
     * Get All Entities
     *
     * @return Ambigous <\Doctrine\ORM\mixed, \Doctrine\ORM\Internal\Hydration\mixed, \Doctrine\DBAL\Driver\Statement,
     *         \Doctrine\Common\Cache\mixed>
     */
    public function getAllSearch($q)
    {

        return $this->getAllSearchQuery($q)->execute();

    }

    /**
     * Count All that are Active 1 minute ago
     *
     * @return Ambigous <\Doctrine\ORM\mixed, mixed, multitype:, \Doctrine\DBAL\Driver\Statement,
     *         \Doctrine\Common\Cache\mixed>
     */
    public function countAllActiveNow()
    {

        $delay = new \DateTime();
        $delay->setTimestamp(strtotime('1 minutes ago'));

        $qb = $this->createQueryBuilder('u')->select('count(u)')
        ->where('u.lastActivity > :delay')
        ->orderBy('u.lastActivity', 'ASC')
        ->setParameter('delay', $delay);
        $query = $qb->getQuery();

        return $query->getSingleScalarResult();

    }

    /**
     * Get Query for All Entities that are Active 1 minute ago
     *
     * @return \Doctrine\ORM\Query
     */
    public function getAllActiveNowQuery()
    {

        $delay = new \DateTime();
        $delay->setTimestamp(strtotime('1 minutes ago'));

        return $this->createQueryBuilder('u')
        ->where('u.lastActivity > :delay')
        ->setParameter('delay', $delay)
        ->orderBy('u.lastActivity', 'DESC')
        ->getQuery();

    }

    /**
     * Get All Entities that are Active 1 minute ago
     *
     * @return Ambigous <\Doctrine\ORM\mixed, \Doctrine\ORM\Internal\Hydration\mixed, \Doctrine\DBAL\Driver\Statement,
     *         \Doctrine\Common\Cache\mixed>
     */
    public function getAllActiveNow()
    {

        return $this->getAllActiveNowQuery()->execute();

    }

    /**
     * Count All Unlocked
     *
     * @return Ambigous <\Doctrine\ORM\mixed, mixed, multitype:, \Doctrine\DBAL\Driver\Statement,
     *         \Doctrine\Common\Cache\mixed>
     */
    public function countAllUnlocked()
    {

        $qb = $this->createQueryBuilder('u')->select('count(u)')
        ->where('u.lockout = :lockout')
        ->setParameter('lockout', User::LOCKOUT_UNLOCKED);
        $query = $qb->getQuery();

        return $query->getSingleScalarResult();

    }

    /**
     * Get Query for All Entities where lockout is unlocked
     *
     * @return \Doctrine\ORM\Query
     */
    public function getAllUnlockedQuery()
    {

        return $this->createQueryBuilder('u')
        ->where('u.lockout = :lockout')
        ->setParameter('lockout', User::LOCKOUT_UNLOCKED)
        ->orderBy('u.username', 'ASC')
        ->getQuery();

    }

    /**
     * Get All Entities where lockout is unlocked
     *
     * @return Ambigous <\Doctrine\ORM\mixed, \Doctrine\ORM\Internal\Hydration\mixed, \Doctrine\DBAL\Driver\Statement,
     *         \Doctrine\Common\Cache\mixed>
     */
    public function getAllUnlocked()
    {

        return $this->getAllUnlockedQuery()->execute();

    }
}
