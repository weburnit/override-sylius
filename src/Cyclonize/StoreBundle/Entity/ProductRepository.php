<?php

namespace Cyclonize\StoreBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseRepo;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends BaseRepo
{
    public function getTaxonProducts($taxon)
    {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder
            ->innerJoin('product.taxons', 'taxon')
            ->andWhere('taxon = :taxon')
            ->setParameter('taxon', $taxon)
            ->setMaxResults(4);
        $results = $queryBuilder->getQuery()->getResult();//$this->getPaginator($queryBuilder);
        return $results;
    }
}
