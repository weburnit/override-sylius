<?php
/**
 * Created by PhpStorm.
 * User: paulaan
 * Date: 9/30/14
 * Time: 11:40 AM
 */

namespace Cyclonize\StoreBundle\Form;

use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonType as Base;
use Symfony\Component\Form\FormBuilderInterface;

class TaxonType extends Base
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('solrIndex','checkbox')
            ->add('showOnShop','checkbox')
            ->add('indexLayout')
        ->add('file');
    }


} 