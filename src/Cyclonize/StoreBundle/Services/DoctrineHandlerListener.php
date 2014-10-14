<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SolrHandlerListener
 *
 * @author paulaan
 */

namespace Cyclonize\StoreBundle\Services;

use Cyclonize\StoreBundle\Entity\SolrEntityInterface as SolrEntity;
use Doctrine\ORM\Event\LifecycleEventArgs;

class DoctrineHandlerListener {

    private $solr;
    private $session;
//    private $containter;

    public function __construct($solr, $session) {
        $this->solr = $solr;
        $this->session = $session;
//        var_dump(get_class($container));exit;
//        $this->containter = $container;
    }

    public function preUpdate(LifecycleEventArgs $args) {
        $object = $args->getEntity();
        if ($object instanceof SolrEntity) {
            try {
                $client = $this->solr;
                // get an update query instance
                $update = $client->createUpdate();

                // create a new document for the data
                $doc = $update->createDocument();
                $object->parseSolrDocument($doc);
                $update->addDocument($doc);
                $update->addCommit();
                $result = $client->update($update);
            } catch (\Exception $e) {
                $this->session->getFlashBag()->add('error', $e->getMessage());
            }
        }
    }

    public function postPersist(LifecycleEventArgs $args) {
        $this->preUpdate($args);
    }

    public function prePersist(LifecycleEventArgs $args) {
        
    }

    public function postRemove(LifecycleEventArgs $args) {
        $object = $args->getEntity();
        if ($object instanceof SolrEntity) {
            try {
                $client = $this->solr;
                // get an update query instance
                $update = $client->createUpdate();

                $update->addDeleteById($object->getKind() . '_' . $object->getId());
                $update->addCommit();
                $result = $client->update($update);
            } catch (\Exception $e) {
                $this->session->getFlashBag()->add('error', $e->getMessage());
            }
        }
    }


}
