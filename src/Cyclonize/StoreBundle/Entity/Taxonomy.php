<?php
/**
 * Created by PhpStorm.
 * User: paulaan
 * Date: 9/30/14
 * Time: 3:33 PM
 */

namespace Cyclonize\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Taxonomy\Model\Taxonomy as BaseTaxonomy;

/**
 * Taxon
 *
 * @ORM\Table(name="sylius_taxonomy")
 * @ORM\Entity()
 */
class Taxonomy extends BaseTaxonomy
{


} 