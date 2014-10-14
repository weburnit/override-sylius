<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractSearchEngine
 *
 * @author paul.aan
 */

namespace Cyclonize\StoreBundle\Solr;

use Cyclonize\StoreBundle\Solr\AbstractFilter;

abstract class AbstractSearchEngine {

    protected $controller;
    protected $client;

    /**
     * @var AbstractFilter $filter
     */
    protected $filter;
    protected $offset;
    protected $amount;
    protected $results;
    protected $count;
    protected $advanced;
    protected $expanded;
    protected $form;
    private $page;
    private $nextPage;
    private $prevPage;
    protected $query;
    private $queryFields;

    const SEARCHING = 1;
    const STATIC_QUERY = 0;

    protected $status;
    protected $sort;

    public function __construct($controller, $page = 1, $amount = 20) {
        $this->status = self::SEARCHING;
        $this->controller = $controller;
        $this->client = $controller->get('solarium.client');
        $this->page = $this->getCurrentPage($page);
        if (!$this->page)
            $this->page = 1;
        if ((int) $amount < 1 || is_null($amount))
            $amount = 20;
        $this->offset = ($this->page - 1) * $amount;
        $this->amount = $amount;
    }

    public function setStatus($status = self::SEARCHING) {
        $this->status = $status;
        return $this;
    }

    public abstract function buildFilter($filter);

    protected abstract function bindFilterData();

    public abstract function getResults();

    public function initializeQuery($bq = null) {
        if (!is_object($this->query)) {
            $query = $this->client->createSelect();
            $this->query = $query;
        }
    }

    protected function setResults() {
        $query = $this->query;
        $queryTypes = $query->getComponentTypes();
        if (count($query->getDisMax()->getOptions()) == 1) {//if this is a normal query, load query from filter
            $queryString = $this->filter->setQuery()->getQuery();
            if ($queryString)
                $query->setQuery($queryString);
            $dismax = $query->getDisMax();
            $dismax->setQueryFields($this->getQueryFields());
            $query->setQuery(null);
            $dismax->setQueryAlternative($queryString);
        }
        if ($this->filter->getSpatial()->isSearchable()) {
//            $queryHelper = \Solarium\Core\Query\Helper::geofilt();
//            $query->geofilt();
            $query->addParam('d', $this->filter->getSpatial()->getD());
            $query->addParam('pt', $this->filter->getSpatial()->getPt());
            $query->addParam('sfield', 'coordinate');
            $query->addParam('fq', $this->filter->getSpatial()->getFq());
        }
        $query->setStart($this->offset)->setRows($this->amount);
        if ($this->sort)
            $query->addSort($this->sort, $query::SORT_DESC);
        else
            $query->addSort('score', $query::SORT_DESC);
        $this->results = $this->client->select($query);
        $this->count = $this->results->getNumFound();
        $this->extractPage();
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
        return $this;
    }

    public function setPage($p) {
        $this->offset = ((int) $p - 1) * $this->amount;
        return $this;
    }

    public function getCount() {
        return $this->count;
    }

    public function getForm() {
        return $this->form;
    }

    public function extractPage() {
        if ($this->page > 1)
            $this->prevPage = $this->page - 1;
        else
            $this->prevPage = 0;

        if ($this->count / $this->amount > $this->page)
            $this->nextPage = $this->page + 1;
        else
            $this->nextPage = 0;

        $session = $this->controller->getRequest()->getSession();
        //array pagination with page number as key and hash as value
        $paginationArray = $session->get($this->controller->getRequest()->attributes->get('_route'));

        if ($this->nextPage) {
            if (is_array($paginationArray) && isset($paginationArray[$this->nextPage]))
                $this->nextPage = $paginationArray[$this->nextPage];
            else {
                $nextSession = md5($this->nextPage . $this->controller->getRequest()->attributes->get('_route'));
                $paginationArray[$nextSession] = $this->nextPage;
                $this->nextPage = $nextSession;
            }
        }
        if ($this->prevPage) {
            if (is_array($paginationArray) && isset($paginationArray[$this->prevPage]))
                $this->prevPage = $paginationArray[$this->prevPage];
            else {
                $prevSession = md5($this->prevPage . $this->controller->getRequest()->attributes->get('_route'));
                $paginationArray[$prevSession] = $this->prevPage;
                $this->prevPage = $prevSession;
            }
        }
        $session->set($this->controller->getRequest()->attributes->get('_route'), $paginationArray);
        $session->save();
    }

    public function getCurrentPage($hash) {
        $paginationArray = $this->controller->getRequest()->getSession()->get($this->controller->getRequest()->attributes->get('_route'));
        if (is_array($paginationArray) && isset($paginationArray[$hash]))
            return (int) $paginationArray[$hash];
        return (int) $hash;
    }

    public function getNextPage() {
        return $this->nextPage;
    }

    public function getPrevPage() {
        return $this->prevPage;
    }

    public function getQueryFields() {
        return $this->queryFields;
    }

    public function setQueryFields($queryFields) {
        $this->queryFields = $queryFields;
        return $this;
    }

    public function __set($name, $value) {
        $this->filter->$name = $value;
    }

    public function getSort() {
        return $this->sort;
    }

    public function setSort($sort) {
        $this->sort = $sort;
        return $this;
    }

}
