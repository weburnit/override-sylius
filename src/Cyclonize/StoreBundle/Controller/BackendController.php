<?php
/**
 * Created by PhpStorm.
 * User: paulaan
 * Date: 9/30/14
 * Time: 4:34 PM
 */

namespace Cyclonize\StoreBundle\Controller;

use Cyclonize\StoreBundle\Entity\Taxon;
use Cyclonize\StoreBundle\Entity\Taxonomy;
use Cyclonize\StoreBundle\Form\TaxonomyType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Backend controller.
 *
 * @Route("/administration/cyclone")
 */
class BackendController extends Controller{

    /**
     * @Route("/taxonomies/new", name="backend_new_taxonomies")
     */
    public function createTaxonomiesAction(Request $request){
        $formType = new TaxonomyType();
        $taxonomy = new Taxonomy();
        $form = $this->createForm($formType,$taxonomy);

        $newTaxon = new Taxon();
        $taxonomy->setRoot($newTaxon);
        if($request->isMethod('POST')){
            if($form->handleRequest($request)->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($taxonomy);
                $em->flush();
                return new RedirectResponse($this->generateUrl("sylius_backend_taxonomy_index"));
            }
        }

        return new Response($this->renderView('SyliusWebBundle:Backend/Taxonomy:create.html.twig', array('form' => $form->createView())));
    }
} 