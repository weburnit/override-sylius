<?php
/**
 * Created by PhpStorm.
 * User: paulaan
 * Date: 9/30/14
 * Time: 11:41 AM
 */

namespace Cyclonize\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Taxon as BaseTaxon;

/**
 * Taxon
 *
 * @ORM\Table(name="sylius_taxon")
 * @ORM\Entity()
 */
class Taxon extends BaseTaxon
{

    /**
     * @var boolean
     *
     * @ORM\Column(name="solrIndex", type="boolean")
     */
    protected $solrIndex;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showOnShop", type="boolean")
     */
    protected $showOnShop;


    /**
     * @var string
     *
     * @ORM\Column(name="indexLayout", type="integer")
     */
    protected $indexLayout;

    public function __construct()
    {
        $this->solrIndex = false;
        $this->indexLayout = 0;
        $this->showOnShop = false;
    }

    /**
     * @return string
     */
    public function getIndexLayout()
    {
        return $this->indexLayout;
    }

    /**
     * @param string $indexLayout
     */
    public function setIndexLayout($indexLayout)
    {
        $this->indexLayout = $indexLayout;
    }

    /**
     * @return integer
     */
    public function getSolrIndex()
    {
        return $this->solrIndex;
    }

    /**
     * @param boolean $solrIndex
     */
    public function setSolrIndex($solrIndex)
    {
        $this->solrIndex = $solrIndex;
        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return boolean
     */
    public function isShowOnShop()
    {
        return $this->showOnShop;
    }

    /**
     * @param boolean $showOnShop
     */
    public function setShowOnShop($showOnShop)
    {
        $this->showOnShop = $showOnShop;
        return $this;
    }


} 