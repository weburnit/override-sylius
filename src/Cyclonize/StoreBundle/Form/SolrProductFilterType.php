<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SolrHotelFilterType
 *
 * @author paul.aan
 */

namespace Cyclonize\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Solarium\QueryType\Select\Query;

class SolrProductFilterType extends AbstractType {

    public $advanced;
    private $trans;
    private $expanded;

    public function __construct($trans) {
        $this->trans = $trans;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('search', 'text', array('required' => false));
        $sortBy = array(Query\Query::SORT_ASC => 'Ascending', Query\Query::SORT_DESC => 'Descending');
        $builder
                ->add('minprice', 'number', array('required' => false, 'label' => $this->trans->trans('from')))
                ->add('maxprice', 'number', array('required' => false, 'label' => $this->trans->trans('to')))
                ->add('sort', 'choice', array('required' => false, 'choices' => $sortBy));
        $spatialType = new SpatialSearchType();
        $builder->add('spatial', $spatialType, array('required' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Cyclonize\StoreBundle\Solr\ProductSearchFilter',
            'csrf_protection' => false
        ));
    }

    public function getName() {
        return 'productsearch';
    }

}
