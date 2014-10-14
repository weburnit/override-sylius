<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SolrEntity
 *
 * @author paulaan
 */

namespace Cyclonize\StoreBundle\Entity;

interface SolrEntityInterface {
    function parseSolrDocument(&$doc);
    function getKind();
}