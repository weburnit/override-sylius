<?php

namespace Cyclonize\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Banner controller.
 *
 * @Route("/render")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/topmenu")
     * @Template("SyliusWebBundle:Frontend:menu.html.twig")
     */
    public function renderTopMenuAction()
    {
        return array();
    }

    /**
     * @Route("/homepage/gallery", name="render_homepage_slider")
     * @Template()
     */
    public function renderHomePageSliderAction()
    {
        $em = $this->getDoctrine()->getManager();
        $galleries = $em->getRepository("CyclonizeStoreBundle:Banner")->findBy(array('status' => 1), array('indexLayout' => 'ASC'), 5, 0);
        return array('galleries' => $galleries);
    }

    /**
     * @Route("/shop/taxon/{id}/{layout}", name="render_shop_taxon")
     * @Cache(public=true,expires="tomorrow")
     */
    public function renderShopTaxonAction($id, $layout){
        $repository = $this->container->get('sylius.repository.product');
        $taxonRepository = $this->container->get('sylius.repository.taxon');
        $taxon = $taxonRepository->find($id);
        $products = $repository->getTaxonProducts($id);
        $content = $this->renderView('CyclonizeStoreBundle:Shop:taxon'.$layout.'.html.twig',array('products' => $products, 'taxon' => $taxon));
        return new Response($content);
    }
}