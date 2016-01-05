<?php

namespace Samenjoy\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;

/**
 * @author sasedev <seif.salah@gmail.com>
 *         @ORM\Table(name="sej_user_addresses")
 *         @ORM\Entity(repositoryClass="Samenjoy\DataBundle\Repository\UserAddressRepository")
 *         @ORM\HasLifecycleCallbacks
 *
 */
class UserAddress
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sej_user_addresses_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Samenjoy\DataBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    protected $user;

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
     * @var \DateTime
     *
     * @ORM\Column(name="dtcrea", type="datetimetz", nullable=true)
     */
    protected $dtCrea;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtupdate", type="datetimetz", nullable=true)
     *      @Gedmo\Timestampable(on="update")
     */
    protected $dtUpdate;

}