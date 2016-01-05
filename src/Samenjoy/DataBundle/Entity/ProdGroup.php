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
 *         @ORM\Table(name="sej_prodgroups")
 *         @ORM\Entity(repositoryClass="Samenjoy\DataBundle\Repository\ProdGroupRepository")
 *         @ORM\HasLifecycleCallbacks
 *         @UniqueEntity(fields="name")
 */
class ProdGroup
{

    /**
     * @var integer
     */
    const ST_VISIBLE = 1;

    /**
     * @var integer
     */
    const ST_HIDDEN = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sej_prodgroups_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @var Brand
     *
     * @ORM\ManyToOne(targetEntity="Samenjoy\DataBundle\Entity\Brand", inversedBy="prodGroups",
     *      cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_brand", referencedColumnName="id")
     * })
     */
    protected $brand;

    /**
     * @var ColType
     *
     * @ORM\ManyToOne(targetEntity="Samenjoy\DataBundle\Entity\ColType", inversedBy="prodGroups",
     *      cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type", referencedColumnName="id")
     * })
     */
    protected $type;

    /**
     * @var ColGroup
     *
     * @ORM\ManyToOne(targetEntity="Samenjoy\DataBundle\Entity\ColGroup", inversedBy="prodGroups",
     *      cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_group", referencedColumnName="id")
     * })
     */
    protected $group;

    /**
     * @var ColWeekly
     *
     * @ORM\ManyToOne(targetEntity="Samenjoy\DataBundle\Entity\ColWeekly", inversedBy="prodGroups",
     *      cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_weekly", referencedColumnName="id")
     * })
     */
    protected $week;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text", nullable=false)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="text", nullable=true)
     */
    protected $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text", nullable=true)
     */
    protected $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="weight", type="bigint", nullable=false)
     */
    protected $weight = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    protected $price = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="bigint", nullable=false)
     */
    protected $quantity = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="initprice", type="float", precision=10, scale=0, nullable=false)
     */
    protected $initPrice = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="initquantity", type="bigint", nullable=false)
     */
    protected $initQuantity = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="maxreduction", type="float", precision=10, scale=0, nullable=false)
     */
    protected $maxreduction = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="metakeywords", type="text", nullable=true)
     */
    protected $metaKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="metadescription", type="text", nullable=true)
     */
    protected $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="htmltitle", type="text", nullable=true)
     */
    protected $htmlTitle;

    /**
     *
     * @var integer @ORM\Column(name="visibility", type="integer", nullable=false)
     *
     */
    protected $visible = self::ST_VISIBLE;

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
     * @var Collection @ORM\OneToMany(targetEntity="ProdGroupTrans", mappedBy="prodGroup", cascade={"persist", "remove"})
     *      @ORM\OrderBy({"dtCrea" = "DESC"})
     */
    protected $translations;

    /**
     * @var Collection @ORM\OneToMany(targetEntity="ProdGroupImage", mappedBy="prodGroup", cascade={"persist", "remove"})
     *      @ORM\OrderBy({"dtCrea" = "DESC"})
     */
    protected $images;

    /**
     * @var Collection @ORM\OneToMany(targetEntity="Product", mappedBy="prodGroup", cascade={"persist", "remove"})
     *      @ORM\OrderBy({"dtCrea" = "DESC"})
     */
    protected $products;

    /**
     * @var Collection @ORM\OneToMany(targetEntity="Discount", mappedBy="prodGroup", cascade={"persist", "remove"})
     *      @ORM\OrderBy({"dtCrea" = "DESC"})
     */
    protected $discounts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDtCrea(new \DateTime('now'));

        $this->setTranslations(new ArrayCollection());

        $this->setImages(new ArrayCollection());

        $this->setProducts(new ArrayCollection());

        $this->setDiscounts(new ArrayCollection());
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
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set $brand
     *
     * @param Brand $brand
     *
     * @return ProdGroup this
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     *
     * @return ColType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set $type
     *
     * @param ColType $type
     *
     * @return ProdGroup this
     */
    public function setType(ColType $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     *
     * @return ColGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set $group
     *
     * @param ColGroup $group
     *
     * @return ProdGroup this
     */
    public function setGroup(ColGroup $group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     *
     * @return ColWeekly
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * Set $week
     *
     * @param ColWeekly $week
     *
     * @return ProdGroup this
     */
    public function setWeek(ColWeekly $week)
    {
        $this->week = $week;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set $name
     *
     * @param string $name
     *
     * @return ProdGroup this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set $title
     *
     * @param string $title
     *
     * @return ProdGroup this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set $description
     *
     * @param string $description
     *
     * @return ProdGroup this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set $logo
     *
     * @param string $logo
     *
     * @return ProdGroup this
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set $image
     *
     * @param string $image
     *
     * @return ProdGroup this
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set $weight
     *
     * @param
     *            $weight
     * @return ProdGroup this
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set $price
     *
     * @param
     *            $price
     * @return ProdGroup this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set $quantity
     *
     * @param
     *            $quantity
     * @return ProdGroup this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     *
     * @return float
     */
    public function getInitPrice()
    {
        return $this->initPrice;
    }

    /**
     * Set $initPrice
     *
     * @param
     *            $initPrice
     * @return ProdGroup this
     */
    public function setInitPrice($initPrice)
    {
        $this->initPrice = $initPrice;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getInitQuantity()
    {
        return $this->initQuantity;
    }

    /**
     * Set $initQuantity
     *
     * @param
     *            $initQuantity
     * @return ProdGroup this
     */
    public function setInitQuantity($initQuantity)
    {
        $this->initQuantity = $initQuantity;
        return $this;
    }

    /**
     *
     * @return float
     */
    public function getMaxreduction()
    {
        return $this->maxreduction;
    }

    /**
     * Set $maxreduction
     *
     * @param
     *            $maxreduction
     * @return ProdGroup this
     */
    public function setMaxreduction($maxreduction)
    {
        $this->maxreduction = $maxreduction;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set $metaKeywords
     *
     * @param string $metaKeywords
     *
     * @return ProdGroup this
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set $metaDescription
     *
     * @param string $metaDescription
     *
     * @return ProdGroup this
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getHtmlTitle()
    {
        return $this->htmlTitle;
    }

    /**
     * Set $htmlTitle
     *
     * @param string $htmlTitle
     *
     * @return ProdGroup this
     */
    public function setHtmlTitle($htmlTitle)
    {
        $this->htmlTitle = $htmlTitle;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set $visible
     *
     * @param
     *            $visible
     * @return ProdGroup this
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
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
     * @return ProdGroup this
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
     * @return ProdGroup this
     */
    public function setDtUpdate(\DateTime $dtUpdate)
    {
        $this->dtUpdate = $dtUpdate;
        return $this;
    }

    /**
     * @param ProdGroupTrans $translation
     *
     * @return ProdGroup
     */
    public function addTranslation(ProdGroupTrans $translation)
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * @param ProdGroupTrans $translation
     *
     * @return ProdGroup
     */
    public function removeTranslation(ProdGroupTrans $translation)
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
     * @return ProdGroup this
     */
    public function setTranslations(Collection $translations)
    {
        $this->translations = $translations;
        return $this;
    }

    /**
     * @param ProdGroupImage $image
     *
     * @return ProdGroup
     */
    public function addImage(ProdGroupImage $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * @param ProdGroupImage $image
     *
     * @return ProdGroup
     */
    public function removeImage(ProdGroupImage $image)
    {
        $this->images->removeElement($image);

        return $this;
    }

    /**
     *
     * @return Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set $images
     *
     * @param Collection $images
     *
     * @return ProdGroup this
     */
    public function setImages(Collection $images)
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @param Product $product
     *
     * @return ProdGroup
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * @param Product $product
     *
     * @return ProdGroup
     */
    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);

        return $this;
    }

    /**
     *
     * @return Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set $products
     *
     * @param Collection $products
     *
     * @return ProdGroup this
     */
    public function setProducts(Collection $products)
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @param Discount $discount
     *
     * @return ProdGroup
     */
    public function addDiscount(Discount $discount)
    {
        $this->discounts[] = $discount;

        return $this;
    }

    /**
     * @param Discount $discount
     *
     * @return ProdGroup
     */
    public function removeDiscount(Discount $discount)
    {
        $this->discounts->removeElement($discount);

        return $this;
    }

    /**
     *
     * @return Collection
     */
    public function getDiscounts()
    {
        return $this->discounts;
    }

    /**
     * Set $discounts
     *
     * @param Collection $discounts
     *
     * @return ProdGroup this
     */
    public function setDiscounts(Collection $discounts)
    {
        $this->discounts = $discounts;
        return $this;
    }

}
