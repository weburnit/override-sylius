<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TourSearchFilter
 *
 * @author apple
 */

namespace Cyclonize\StoreBundle\Solr;

use Cyclonize\StoreBundle\Entity\Coordinate;
use Cyclonize\StoreBundle\Solr\AbstractFilter;
use Cyclonize\StoreBundle\Entity\Product;

class ProductSearchFilter extends AbstractFilter {

    public function __construct() {
        parent::__construct();
    }

    public function setQuery() {
        $this->query[] = 'id:Product_*';
        $this->query[] = 'deleted:false';
//        $this->query[] = 'status:1';
        $this->buildKeywordsQuery();
        return $this;
    }

    public function buildKeywordsQuery() {
        $textSearch = array();
        if (!isset($this->metadata['search']))
            $search = '*';
        else {
            $search = $this->metadata['search'];
            $terms = array_filter(explode(" ", $search));
            $textQuery = array();
            foreach ($terms as $term) {
                $textQuery[] = '*' . $term . '*';
            }
            $search = '(' . implode(' OR ', $textQuery) . ')';
            unset($this->metadata['search']);
        }
        $textSearch[] = 'product:' . $search . '^15';
        $textSearch[] = 'description:' . $search . '^10';
        if (!empty($textSearch))
            $this->query[] = '(' . implode(' OR ', array_unique($textSearch)) . ')';

        $passedFields = array();
        $facilities = array();
        if (is_array($this->metadata))
            foreach ($this->metadata as $key => $value) {
                $matchall = (int) $value == -1 ? true : false;
                if (preg_match("/(min|max)/", $key)) {
                    $field = substr($key, 3, strlen($key));
                    if (!isset($passedFields[$field])) {
                        $passedFields[$field] = true;
                        $min = 'min' . $field;
                        $max = 'max' . $field;
                        if (!is_null($this->$min) && !is_null($this->$max)) {
                            $this->query[] = '(' . $field . ':[' . $this->$min . ' TO ' . $this->$max . '])';
                        } else if (!is_null($this->$min))
                            $this->query[] = '(' . $field . ':[' . $this->$min . ' TO *])';
                        else if (!is_null($this->$max))
                            $this->query[] = '(' . $field . ':[0 TO ' . $this->$max . '])';
                    }
                }
                else if (is_int($value))
                    $this->query[] = '(' . $key . ':' . $value . ')';
                else if (is_string($value)) {
                    $facilities[] = '(' . $key . ':' . $value . '*)';
                } else if (is_array($value)) {
                    $subQuery = array();
                    foreach ($value as $term) {
                        $subQuery[] = $key . ':' . $term;
                    }
                    if (count($subQuery))
                        $this->query[] = '(' . implode(" OR ", $subQuery) . ')';
                }
            }
        if (count($facilities))
            $this->query[] = '(' . implode(' AND ', $facilities) . ')';

        return $this;
    }

    public function setMindate($min) {
        if ($min) {
            $now = new \DateTime($min);
//        var_dump($min);exit;
            $this->metadata['mindate'] = $now->format("Y-m-d\TH:i:s\Z");
        }
    }

    public function setMaxdate($max) {
        if ($max) {
            $now = new \DateTime($max);
            $this->metadata['maxdate'] = $now->format("Y-m-d\TH:i:s\Z");
        }
    }

    public function setCategory($value) {
        return $this->setType($value);
    }

    public function setType($value) {
        $types = array_filter(explode(",", $value));
        if (count($types)) {
            foreach ($types as $key => $value) {
                $types[$key] = '"' . $value . '"';
            }
            $this->metadata['type'] = $types;
        } else
            $this->metadata = $value;
        return $this;
    }

}
