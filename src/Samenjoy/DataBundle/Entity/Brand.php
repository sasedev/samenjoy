<?php

namespace Samenjoy\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 *
 * @author sasedev <seif.salah@gmail.com>
 *         @ORM\Table(name="sej_brands")
 *         @ORM\Entity(repositoryClass="Samenjoy\DataBundle\Repository\BrandRepository")
 *         @ORM\HasLifecycleCallbacks
 *         @UniqueEntity(fields="name", groups={"create", "Default"})
 */
class Brand
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
	 * @ORM\SequenceGenerator(sequenceName="sej_brands_id_seq", allocationSize=1, initialValue=1)
	 */
	protected $id;

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
	 * @var Collection @ORM\OneToMany(targetEntity="BrandTrans", mappedBy="brand", cascade={"persist", "remove"})
	 *      @ORM\OrderBy({"dtCrea" = "DESC"})
	 */
	protected $translations;

	/**
	 * @var Collection @ORM\OneToMany(targetEntity="ProdGroup", mappedBy="brand", cascade={"persist", "remove"})
	 *      @ORM\OrderBy({"dtCrea" = "DESC"})
	 */
	protected $prodGroups;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->setDtCrea(new \DateTime('now'));

		$this->setTranslations(new ArrayCollection());

		$this->setProdGroups(new ArrayCollection());
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
	 * @return Brand this
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 *
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
	 * @return Brand this
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	/**
	 *
	 * @param string $lang
	 *
	 * @return string
	 */
	public function getDescription($lang = null)
	{
		if (null == $lang || trim($lang) == '') {
			return $this->description;
		} else {
			foreach ($this->getTranslations() as $trans) {
				if ($trans->getLang() == $lang) {
					return $trans->getDescription();
				}
			}
			return $this->description;
		}
	}

	/**
	 * Set $description
	 *
	 * @param string $description
	 *
	 * @return Brand this
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}

	/**
	 *
	 * @param string $lang
	 *
	 * @return string
	 */
	public function getLogo($lang = null)
	{
		if (null == $lang || trim($lang) == '') {
			return $this->logo;
		} else {
			foreach ($this->getTranslations() as $trans) {
				if ($trans->getLang() == $lang) {
					return $trans->getLogo();
				}
			}
			return $this->logo;
		}
	}

	/**
	 * Set $logo
	 *
	 * @param string $logo
	 *
	 * @return Brand this
	 */
	public function setLogo($logo)
	{
		$this->logo = $logo;
		return $this;
	}

	/**
	 *
	 * @param string $lang
	 *
	 * @return string
	 */
	public function getImage($lang = null)
	{
		if (null == $lang || trim($lang) == '') {
			return $this->image;
		} else {
			foreach ($this->getTranslations() as $trans) {
				if ($trans->getLang() == $lang) {
					return $trans->getImage();
				}
			}
			return $this->image;
		}
	}

	/**
	 * Set $image
	 *
	 * @param string $image
	 *
	 * @return Brand this
	 */
	public function setImage($image)
	{
		$this->image = $image;
		return $this;
	}

	/**
	 *
	 * @param string $lang
	 *
	 * @return string
	 */
	public function getBanner($lang = null)
	{
		if (null == $lang || trim($lang) == '') {
			return $this->banner;
		} else {
			foreach ($this->getTranslations() as $trans) {
				if ($trans->getLang() == $lang) {
					return $trans->getBanner();
				}
			}
			return $this->banner;
		}
	}

	/**
	 * Set $banner
	 *
	 * @param string $banner
	 *
	 * @return Brand this
	 */
	public function setBanner($banner)
	{
		$this->banner = $banner;
		return $this;
	}

	/**
	 *
	 * @param string $lang
	 *
	 * @return string
	 */
	public function getFrontBanner($lang = null)
	{
		if (null == $lang || trim($lang) == '') {
			return $this->frontBanner;
		} else {
			foreach ($this->getTranslations() as $trans) {
				if ($trans->getLang() == $lang) {
					return $trans->getFrontBanner();
				}
			}
			return $this->frontBanner;
		}
	}

	/**
	 * Set $frontBanner
	 *
	 * @param string $frontBanner
	 *
	 * @return Brand this
	 */
	public function setFrontBanner($frontBanner)
	{
		$this->frontBanner = $frontBanner;
		return $this;
	}

	/**
	 *
	 * @param string $lang
	 *
	 * @return string
	 */
	public function getMetaKeywords($lang = null)
	{
		if (null == $lang || trim($lang) == '') {
			return $this->metaKeywords;
		} else {
			foreach ($this->getTranslations() as $trans) {
				if ($trans->getLang() == $lang) {
					return $trans->getMetaKeywords();
				}
			}
			return $this->metaKeywords;
		}
	}

	/**
	 * Set $metaKeywords
	 *
	 * @param string $metaKeywords
	 *
	 * @return Brand this
	 */
	public function setMetaKeywords($metaKeywords)
	{
		$this->metaKeywords = $metaKeywords;
		return $this;
	}

	/**
	 *
	 * @param string $lang
	 *
	 * @return string
	 */
	public function getMetaDescription($lang = null)
	{
		if (null == $lang || trim($lang) == '') {
			return $this->metaDescription;
		} else {
			foreach ($this->getTranslations() as $trans) {
				if ($trans->getLang() == $lang) {
					return $trans->getMetaDescription();
				}
			}
			return $this->metaDescription;
		}
	}

	/**
	 * Set $metaDescription
	 *
	 * @param string $metaDescription
	 *
	 * @return Brand this
	 */
	public function setMetaDescription($metaDescription)
	{
		$this->metaDescription = $metaDescription;
		return $this;
	}

	/**
	 *
	 * @param string $lang
	 *
	 * @return string
	 */
	public function getHtmlTitle($lang = null)
	{
		if (null == $lang || trim($lang) == '') {
			return $this->htmlTitle;
		} else {
			foreach ($this->getTranslations() as $trans) {
				if ($trans->getLang() == $lang) {
					return $trans->getHtmlTitle();
				}
			}
			return $this->htmlTitle;
		}
	}

	/**
	 * Set $htmlTitle
	 *
	 * @param string $htmlTitle
	 *
	 * @return Brand this
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
	 * @return Brand this
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
	 * @return Brand this
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
	 * @return Brand this
	 */
	public function setDtUpdate(\DateTime $dtUpdate)
	{
		$this->dtUpdate = $dtUpdate;
		return $this;
	}

	/**
	 * @param BrandTrans $translation
	 *
	 * @return Brand
	 */
	public function addTranslation(BrandTrans $translation)
	{
		$this->translations[] = $translation;

		return $this;
	}

	/**
	 * @param BrandTrans $translation
	 *
	 * @return Brand
	 */
	public function removeTranslation(BrandTrans $translation)
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
	 * @return Brand this
	 */
	public function setTranslations(Collection $translations)
	{
		$this->translations = $translations;
		return $this;
	}

	/**
	 * @param ProdGroup $prodGroup
	 *
	 * @return Brand
	 */
	public function addProdGroup(ProdGroup $prodGroup)
	{
		$this->prodGroups[] = $prodGroup;

		return $this;
	}

	/**
	 * @param ProdGroup $prodGroup
	 *
	 * @return Brand
	 */
	public function removeProdGroup(ProdGroup $prodGroup)
	{
		$this->prodGroups->removeElement($prodGroup);

		return $this;
	}

	/**
	 *
	 * @return Collection
	 */
	public function getProdGroups()
	{
		return $this->prodGroups;
	}

	/**
	 * Set $prodGroups
	 *
	 * @param Collection $prodGroups
	 *
	 * @return Brand this
	 */
	public function setProdGroups(Collection $prodGroups)
	{
		$this->prodGroups = $prodGroups;
		return $this;
	}

	/**
	 *
	 * @return ArrayCollection
	 */
	public function getVProdGroups()
	{
		$products = new ArrayCollection();

		foreach ($this->getProdGroups() as $prod) {
			if ($prod->getVisible() == ProdGroup::ST_VISIBLE) {
				$products->add($prod);
			}
		}

		return $products;
	}

}
