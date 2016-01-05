<?php

namespace Samenjoy\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 *
 * @author sasedev <seif.salah@gmail.com>
 *         @ORM\Table(name="sej_brand_i18ns")
 *         @ORM\Entity(repositoryClass="Samenjoy\DataBundle\Repository\BrandTransRepository")
 *         @ORM\HasLifecycleCallbacks
 *         @UniqueEntity(fields={"brand", "lang"})
 */
class BrandTrans
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="bigint", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="SEQUENCE")
	 * @ORM\SequenceGenerator(sequenceName="sej_brand_i18ns_id_seq", allocationSize=1, initialValue=1)
	 */
	protected $id;

	/**
	 * @var Brand
	 *
	 * @ORM\ManyToOne(targetEntity="Samenjoy\DataBundle\Entity\Brand", inversedBy="translations",
	 *      cascade={"persist", "remove"})
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="id_brand", referencedColumnName="id")
	 * })
	 */
	protected $brand;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="lang", type="string", length=20, nullable=false)
	 */
	protected $lang;

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
	 * @var string
	 *
	 * @ORM\Column(name="banner", type="text", nullable=true)
	 */
	protected $banner;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="frontbanner", type="text", nullable=true)
	 */
	protected $frontBanner;

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
	 * @return BrandTrans this
	 */
	public function setBrand(Brand $brand)
	{
		$this->brand = $brand;
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
	 * @return BrandTrans this
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
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set $title
	 *
	 * @param string $title
	 *
	 * @return BrandTrans this
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
	 * @return BrandTrans this
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
	 * @return BrandTrans this
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
	 * @return BrandTrans this
	 */
	public function setImage($image)
	{
		$this->image = $image;
		return $this;
	}

	/**
	 *
	 * @return string
	 */
	public function getBanner()
	{
		return $this->banner;
	}

	/**
	 * Set $banner
	 *
	 * @param string $banner
	 *
	 * @return BrandTrans this
	 */
	public function setBanner($banner)
	{
		$this->banner = $banner;
		return $this;
	}

	/**
	 *
	 * @return string
	 */
	public function getFrontBanner()
	{
		return $this->frontBanner;
	}

	/**
	 * Set $frontBanner
	 *
	 * @param string $frontBanner
	 *
	 * @return BrandTrans this
	 */
	public function setFrontBanner($frontBanner)
	{
		$this->frontBanner = $frontBanner;
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
	 * @return BrandTrans this
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
	 * @return BrandTrans this
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
	 * @return BrandTrans this
	 */
	public function setHtmlTitle($htmlTitle)
	{
		$this->htmlTitle = $htmlTitle;
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
	 * @return BrandTrans this
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
	 * @return BrandTrans this
	 */
	public function setDtUpdate(\DateTime $dtUpdate)
	{
		$this->dtUpdate = $dtUpdate;
		return $this;
	}

}
