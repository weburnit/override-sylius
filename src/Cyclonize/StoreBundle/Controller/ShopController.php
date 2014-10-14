<?php
/**
 * Created by PhpStorm.
 * User: paulaan
 * Date: 10/2/14
 * Time: 9:42 PM
 */

namespace Cyclonize\StoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Banner controller.
 *
 * @Route("/hang-cong-nghe")
 */

class ShopController extends Controller{

    /**
     * @Route("/", name="shop_detail")
     * @Template()
     */
    public function shopDetailAction(){
        $em = $this->getDoctrine()->getManager();
        $taxons = $em->getRepository("CyclonizeStoreBundle:Taxon")->findBy(array('showOnShop' => 1), array('indexLayout' => 'ASC'), 5);
        return array('taxons' => $taxons);
    }
} 