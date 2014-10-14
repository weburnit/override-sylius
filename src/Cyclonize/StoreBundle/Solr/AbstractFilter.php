<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractFilter
 *
 * @author paul.aan
 */

namespace Cyclonize\StoreBundle\Solr;

abstract class AbstractFilter {

    /**
     * @param query
     */
    protected $query = array();
    public $keywords;
    protected $spatial;
    protected $metadata;

    public function __construct() {
        $this->metadata = array();
        $this->spatial = new SpatialSearch();
    }

    /**
     * 
     * @return SpatialSearch
     */
    public function getSpatial() {
        return $this->spatial;
    }

    public function setSpatial($spatial) {
        $this->spatial = $spatial;
        return $this;
    }

    abstract function setQuery();

    public function getQuery() {
        return implode(' AND ', $this->query);
    }

    public function __get($name) {
        if (isset($this->metadata[$name]))
            return $this->metadata[$name];
        if (isset($this->$name))
            return $this->$name;
    }

    public function __set($name, $value) {
        if (isset($this->metadata[$name]) && $this->metadata[$name])
            return;
        else
            $this->metadata[$name] = $value;
    }

    public abstract function buildKeywordsQuery();
}
