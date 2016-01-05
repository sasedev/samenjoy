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
 *         @ORM\Table(name="sej_staticpages")
 *         @ORM\Entity(repositoryClass="Samenjoy\DataBundle\Repository\StaticpageRepository")
 *         @ORM\HasLifecycleCallbacks
 *         @UniqueEntity(fields={"url", "lang"})
 */
class Staticpage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sej_staticpages_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text", nullable=false)
     */
    protected $url;

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
     * @ORM\Column(name="content1", type="text", nullable=true)
     */
    protected $content1;

    /**
     * @var string
     *
     * @ORM\Column(name="content2", type="text", nullable=true)
     */
    protected $content2;

    /**
     * @var string
     *
     * @ORM\Column(name="content3", type="text", nullable=true)
     */
    protected $content3;

    /**
     * @var string
     *
     * @ORM\Column(name="content4", type="text", nullable=true)
     */
    protected $content4;

    /**
     * @var string
     *
     * @ORM\Column(name="content5", type="text", nullable=true)
     */
    protected $content5;

    /**
     * @var string
     *
     * @ORM\Column(name="content6", type="text", nullable=true)
     */
    protected $content6;

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
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set $url
     *
     * @param string $url
     *
     * @return Staticpage this
     */
    public function setUrl($url)
    {
        $this->url = $url;
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
     * @return Staticpage this
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
     * @return Staticpage this
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
    public function getContent1()
    {
        return $this->content1;
    }

    /**
     * Set $content1
     *
     * @param string $content1
     *
     * @return Staticpage this
     */
    public function setContent1($content1)
    {
        $this->content1 = $content1;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getContent2()
    {
        return $this->content2;
    }

    /**
     * Set $content2
     *
     * @param string $content2
     *
     * @return Staticpage this
     */
    public function setContent2($content2)
    {
        $this->content2 = $content2;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getContent3()
    {
        return $this->content3;
    }

    /**
     * Set $content3
     *
     * @param string $content3
     *
     * @return Staticpage this
     */
    public function setContent3($content3)
    {
        $this->content3 = $content3;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getContent4()
    {
        return $this->content4;
    }

    /**
     * Set $content4
     *
     * @param string $content4
     *
     * @return Staticpage this
     */
    public function setContent4($content4)
    {
        $this->content4 = $content4;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getContent5()
    {
        return $this->content5;
    }

    /**
     * Set $content5
     *
     * @param string $content5
     *
     * @return Staticpage this
     */
    public function setContent5($content5)
    {
        $this->content5 = $content5;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getContent6()
    {
        return $this->content6;
    }

    /**
     * Set $content6
     *
     * @param string $content6
     *
     * @return Staticpage this
     */
    public function setContent6($content6)
    {
        $this->content6 = $content6;
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
     * @return Staticpage this
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
     * @return Staticpage this
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
     * @return Staticpage this
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
     * @return Staticpage this
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
     * @return Staticpage this
     */
    public function setDtUpdate(\DateTime $dtUpdate)
    {
        $this->dtUpdate = $dtUpdate;
        return $this;
    }

}
