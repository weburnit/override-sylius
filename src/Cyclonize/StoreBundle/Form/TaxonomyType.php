<?php
/**
 * Created by PhpStorm.
 * User: paulaan
 * Date: 9/30/14
 * Time: 11:40 AM
 */

namespace Cyclonize\StoreBundle\Form;

use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonomyType as Base;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaxonomyType extends Base
{

    public function __construct(){

    }
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Cyclonize\StoreBundle\Entity\Taxonomy'
        ));
    }


} 