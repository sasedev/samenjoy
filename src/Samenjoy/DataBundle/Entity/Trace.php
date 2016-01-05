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
 *         @ORM\Table(name="sej_traces")
 *         @ORM\Entity(repositoryClass="Samenjoy\DataBundle\Repository\TraceRepository")
 *         @ORM\HasLifecycleCallbacks
 *
 */
class Trace
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sej_traces_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @var \Samenjoy\DataBundle\Entity\SejUsers
     *
     * @ORM\ManyToOne(targetEntity="Samenjoy\DataBundle\Entity\SejUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(name="user_fullname", type="text", nullable=true)
     */
    protected $fullname;

    /**
     * @var integer
     *
     * @ORM\Column(name="action_type", type="bigint", nullable=false)
     */
    protected $actionType = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="action_entity", type="text", nullable=false)
     */
    protected $actionEntity;

    /**
     * @var integer
     *
     * @ORM\Column(name="action_id", type="bigint", nullable=true)
     */
    protected $actionId;

    /**
     * @var string
     *
     * @ORM\Column(name="msg", type="text", nullable=true)
     */
    protected $msg;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtcrea", type="datetimetz", nullable=true)
     */
    protected $dtcrea;
}
