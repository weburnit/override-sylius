<?php

namespace Cyclonize\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sylius\Bundle\CoreBundle\Form\Type\ProductType as BaseFormType;

class ProductType extends BaseFormType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        $builder
                ->add('design', 'ckeditor', array(
                'transformers'                 => array('html_purifier'),
                'toolbar'                      => array('document','basicstyles'),
                'ui_color'                     => '#fff',
                'startup_outline_blocks'       => false,
                'width'                        => '100%',
                'height'                       => '320',
                'language'                     => 'en-au',
//                'filebrowser_image_browse_url' => array(
//                    'url' => 'relative-url.php?type=file',
//                ),
//                'filebrowser_image_browse_url' => array(
//                    'route'            => 'route_name',
//                    'route_parameters' => array(
//                        'type' => 'image',
//                    ),
//                ),
            ))
                ->add('conception', 'ckeditor', array(
                'transformers'                 => array('html_purifier'),
                'toolbar'                      => array('document','basicstyles'),
                'ui_color'                     => '#fff',
                'startup_outline_blocks'       => false,
                'width'                        => '100%',
                'height'                       => '320',
                'language'                     => 'en-au',
            ))
                ->add('interaction', 'ckeditor', array(
                'transformers'                 => array('html_purifier'),
                'toolbar'                      => array('document','basicstyles'),
                'ui_color'                     => '#fff',
                'startup_outline_blocks'       => false,
                'width'                        => '100%',
                'height'                       => '320',
                'language'                     => 'en-au',
            ))
            ->add('showcase', 'ckeditor', array(
                'transformers'                 => array('html_purifier'),
                'toolbar'                      => array('document','basicstyles'),
                'ui_color'                     => '#fff',
                'startup_outline_blocks'       => false,
                'width'                        => '100%',
                'height'                       => '320',
                'language'                     => 'en-au',
            ))
            ->add('specification', 'ckeditor', array(
                'transformers'                 => array('html_purifier'),
                'toolbar'                      => array('document','basicstyles'),
                'ui_color'                     => '#fff',
                'startup_outline_blocks'       => false,
                'width'                        => '100%',
                'height'                       => '320',
                'language'                     => 'en-au',
            ))
                ->add('video');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Cyclonize\StoreBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'sylius_product';
    }

}
