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
 *
 * @author sasedev <seif.salah@gmail.com>
 *         @ORM\Table(name="sej_discounts")
 *         @ORM\Entity(repositoryClass="Samenjoy\DataBundle\Repository\DiscountRepository")
 *         @ORM\HasLifecycleCallbacks
 *         @UniqueEntity(fields={"prodGroup", "conditionType", "condition1", "condition2"})
 */
class Discount
{
    /**
     *
     * @var integer
     */
    const TYPE_SIMPLE = 1;

    /**
     *
     * @var integer
     */
    const TYPE_BRAND = 2;

    /**
     *
     * @var integer
     */
    const TYPE_WEEKLY = 3;


    /**
     *
     * @var integer
     */
    const INACTIVE = 1;


    /**
     *
     * @var integer
     */
    const ACTIVE = 2;


    /**
     *
     * @var integer
     */
    const ENDACTIVE = 3;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sej_discounts_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @var ProdGroup
     *
     * @ORM\ManyToOne(targetEntity="Samenjoy\DataBundle\Entity\ProdGroup", inversedBy="discounts",
     *      cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_prodgroup", referencedColumnName="id")
     * })
     */
    protected $prodGroup;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text", nullable=false)
     */
    protected $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="conditiontype", type="integer", nullable=false)
     */
    protected $conditionType = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="condition1", type="text", nullable=true)
     */
    protected $condition1;

    /**
     * @var string
     *
     * @ORM\Column(name="condition2", type="text", nullable=true)
     */
    protected $condition2;

    /**
     * @var float
     *
     * @ORM\Column(name="discount", type="float", precision=10, scale=0, nullable=false)
     */
    protected $discount = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer", nullable=false)
     */
    protected $active = self::INACTIVE;

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

    /**
     * @var Collection @ORM\OneToMany(targetEntity="DiscountTrans", mappedBy="discount",
     *      cascade={"persist", "remove"})
     *      @ORM\OrderBy({"dtCrea" = "DESC"})
     */
    protected $translations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDtCrea(new \DateTime('now'));

        $this->setTranslations(new ArrayCollection());
    }

    /**
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return ProdGroup
     */
    public function getProdGroup()
    {
        return $this->prodGroup;
    }

    /**
     * Set $prodGroup
     *
     * @param ProdGroup $prodGroup
     *
     * @return Discount this
     */
    public function setProdGroup(ProdGroup $prodGroup)
    {
        $this->prodGroup = $prodGroup;
        return $this;
    }

    /**
     * @param string $lang
     *
     * @return string
     */
    public function getTitle($lang = null)
    {
        if (null == $lang || trim($lang) == '') {
            return $this->title;
        } else {
            foreach ($this->getTranslations() as $trans) {
                if ($trans->getLang() == $lang) {
                    return $trans->getTitle();
                }
            }
            return $this->title;
        }
    }

    /**
     * Set $title
     *
     * @param string $title
     *
     * @return Discount this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getConditionType()
    {
        return $this->conditionType;
    }

    /**
     * Set $conditionType
     *
     * @param
     *            $conditionType
     * @return Discount this
     */
    public function setConditionType($conditionType)
    {
        $this->conditionType = $conditionType;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getCondition1()
    {
        return $this->condition1;
    }

    /**
     * Set $condition1
     *
     * @param string $condition1
     *
     * @return Discount this
     */
    public function setCondition1($condition1)
    {
        $this->condition1 = $condition1;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getCondition2()
    {
        return $this->condition2;
    }

    /**
     * Set $condition2
     *
     * @param string $condition2
     *
     * @return Discount this
     */
    public function setCondition2($condition2)
    {
        $this->condition2 = $condition2;
        return $this;
    }

    /**
     *
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set $discount
     *
     * @param
     *            $discount
     * @return Discount this
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set $active
     *
     * @param
     *            $active
     * @return Discount this
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     *
     * @return DateTime
     */
    public function getDtCrea()
    {
        return $this->dtCrea;
    }

    /**
     * Set $dtCrea
     *
     * @param \DateTime $dtCrea
     *
     * @return Discount this
     */
    public function setDtCrea(\DateTime $dtCrea)
    {
        $this->dtCrea = $dtCrea;
        return $this;
    }

    /**
     *
     * @return DateTime
     */
    public function getDtUpdate()
    {
        return $this->dtUpdate;
    }

    /**
     * Set $dtUpdate
     *
     * @param \DateTime $dtUpdate
     *
     * @return Discount this
     */
    public function setDtUpdate(\DateTime $dtUpdate)
    {
        $this->dtUpdate = $dtUpdate;
        return $this;
    }

    /**
     * @param DiscountTrans $translation
     *
     * @return Discount
     */
    public function addTranslation(DiscountTrans $translation)
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * @param DiscountTrans $translation
     *
     * @return Discount
     */
    public function removeTranslation(DiscountTrans $translation)
    {
        $this->translations->removeElement($translation);

        return $this;
    }

    /**
     *
     * @return Collection
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Set $translations
     *
     * @param Collection $translations
     *
     * @return Discount this
     */
    public function setTranslations(Collection $translations)
    {
        $this->translations = $translations;
        return $this;
    }

}
