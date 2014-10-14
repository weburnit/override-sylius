<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author paulaan
 */

namespace Cyclonize\StoreBundle\Solr;

class SpatialSearch {

    private $pt;
    private $d;
    private $fq;
    private $address;

    public function __construct() {
        $this->fq = '{!geofilt}';
    }

    public function getPt() {
        return $this->pt;
    }

    public function getD() {
        return $this->d;
    }

    public function getFq() {
        return $this->fq;
    }

    public function setPt($pt) {
        $this->pt = $pt;
        return $this;
    }

    public function setD($d) {
        $this->d = $d;
        return $this;
    }

    public function setFq($fq) {
        $this->fq = $fq;
        return $this;
    }

    public function isSearchable() {
        if ($this->pt && $this->d)
            return true;
        return false;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

}
