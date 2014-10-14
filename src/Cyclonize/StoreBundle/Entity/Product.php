<?php

namespace Cyclonize\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;

/**
 * Product
 *
 * @ORM\Table(name="sylius_product")
 * @ORM\Entity(repositoryClass="Cyclonize\StoreBundle\Entity\ProductRepository")
 */
class Product extends BaseProduct implements SolrEntityInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="design", type="text")
     */
    private $design;
    /**
     * @var string
     *
     * @ORM\Column(name="specification", type="text")
     */
    private $specification;

    /**
     * @var string
     *
     * @ORM\Column(name="conception", type="text")
     */
    private $conception;

    /**
     * @var string
     *
     * @ORM\Column(name="interaction", type="text")
     */
    private $interaction;

    /**
     * @var string
     *
     * @ORM\Column(name="showcase", type="text")
     */
    private $showcase;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=255)
     */
    private $video;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set design
     *
     * @param string $design
     * @return Product
     */
    public function setDesign($design)
    {
        $this->design = $design;

        return $this;
    }

    /**
     * Get design
     *
     * @return string
     */
    public function getDesign()
    {
        return $this->design;
    }

    /**
     * Set conception
     *
     * @param string $conception
     * @return Product
     */
    public function setConception($conception)
    {
        $this->conception = $conception;

        return $this;
    }

    /**
     * Get conception
     *
     * @return string
     */
    public function getConception()
    {
        return $this->conception;
    }

    /**
     * Set interaction
     *
     * @param string $interaction
     * @return Product
     */
    public function setInteraction($interaction)
    {
        $this->interaction = $interaction;

        return $this;
    }

    /**
     * Get interaction
     *
     * @return string
     */
    public function getInteraction()
    {
        return $this->interaction;
    }

    /**
     * Set showcase
     *
     * @param string $showcase
     * @return Product
     */
    public function setShowcase($showcase)
    {
        $this->showcase = $showcase;

        return $this;
    }

    /**
     * Get showcase
     *
     * @return string
     */
    public function getShowcase()
    {
        return $this->showcase;
    }

    /**
     * Set video
     *
     * @param string $video
     * @return Product
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    function parseSolrDocument(&$doc)
    {
        $doc['price'] = $this->getPrice();
        $doc['taxons'] = $this->getTaxonsAsStringArray();
        $doc['slug'] = $this->getSlug();
        $doc['description'] = $this->getDescription();
        $doc['name'] = $this->getName();
        $doc['objectid'] = $this->getId();
        $doc['id'] = $this->getKind() . '_' . $this->getId();
    }

    function getKind()
    {
        return 'product';
    }


    public function getTaxonsAsStringArray()
    {
        $stringArray = array();
        foreach ($this->taxons as $taxon) {
            $stringArray[] = $taxon->getName();
        }
        return $stringArray;
    }

    /**
     * @return string
     */
    public function getSpecification()
    {
        return $this->specification;
    }

    /**
     * @param string $specification
     */
    public function setSpecification($specification)
    {
        $this->specification = $specification;
        return $this;
    }

    public function getNormalPrice(){
        $variants = $this->getVariants();
        $price = 0;
        foreach($variants as $variant){
            if($variant->getPrice() > $price)
                $price = $variant->getPrice();
        }
        return $price;
    }

}
