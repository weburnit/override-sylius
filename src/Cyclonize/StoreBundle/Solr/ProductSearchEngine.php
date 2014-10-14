<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HotelSearchEngine
 *
 * @author paul.aan
 */

namespace Cyclonize\StoreBundle\Solr;

use Cyclonize\StoreBundle\Solr\AbstractSearchEngine;
use Cyclonize\StoreBundle\Form\SolrProductFilterType;
use Cyclonize\StoreBundle\Entity\Product;

class ProductSearchEngine extends AbstractSearchEngine {

    public function __construct($controller, $page = 1, $amount = 20) {
        parent::__construct($controller, $page, $amount);
        $this->buildFilter();
//        var_dump(get_class($this->form));exit;
        $this->setQueryFields('description^10 category^10');
    }

    public function buildFilter($filter = null) {
        if (!is_object($this->filter))
            $this->filter = new ProductSearchFilter();
        $this->bindFilterData();
    }

    protected function bindFilterData() {
        $form = $this->controller->createForm(new SolrProductFilterType($this->controller->get('translator')), $this->filter);
        $form->bind($this->controller->getRequest());
        $this->form = $form;
    }

    public function initializeQuery($bq = null) {
        $query = $this->client->createSelect();
        if ($bq != null && !empty($bq)) {
            $dismax = $query->getDisMax();
            $dismax->setQueryFields('tags^4 name^4 description^4');
            if (isset($bq['query']))
                $query->setQuery($bq['query']);
            if (isset($bq['boost']))
                $dismax->setBoostQuery($bq['boost']);
        }

        $this->query = $query;
    }

    public function getResults() {
        $this->initializeQuery();
        $assetic = $this->controller->get('templating.helper.assets');
        $this->setResults();
        $Products = array();

        foreach ($this->results->getDocuments() as $item) {
            $Product = new \Cyclonize\StoreBundle\Entity\Product();
            $Product->adoptSolr($item);
            $Product->setId((int) str_replace("Product_", '', $item->id));
            $Product->setAssetic($assetic);
            $Products[] = $Product;
        }
        return $Products;
    }

}
