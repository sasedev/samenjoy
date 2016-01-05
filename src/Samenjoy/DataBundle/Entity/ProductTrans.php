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
 *         @ORM\Table(name="sej_product_i18ns")
 *         @ORM\Entity(repositoryClass="Samenjoy\DataBundle\Repository\ProductTransRepository")
 *         @ORM\HasLifecycleCallbacks
 *         @UniqueEntity(fields={"product", "lang"})
 */
class ProductTrans
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sej_product_i18ns_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Samenjoy\DataBundle\Entity\Product", inversedBy="translations",
     *      cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_product", referencedColumnName="id")
     * })
     */
    protected $product;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=20, nullable=false)
     */
    protected $lang;

    /**
     * @var string
     *
     * @ORM\Column(name="variants", type="text", nullable=false)
     */
    protected $variant;

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
     * Constructor
     */
    public function __construct()
    {
        $this->setDtCrea(new \DateTime('now'));
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
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set $product
     *
     * @param Product $product
     *
     * @return ProductTrans this
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set $lang
     *
     * @param string $lang
     *
     * @return ProductTrans this
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * Set $variant
     *
     * @param string $variant
     *
     * @return ProductTrans this
     */
    public function setVariant($variant)
    {
        $this->variant = $variant;
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
     * @return ProductTrans this
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
     * @return ProductTrans this
     */
    public function setDtUpdate(\DateTime $dtUpdate)
    {
        $this->dtUpdate = $dtUpdate;
        return $this;
    }
}
