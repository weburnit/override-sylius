<?php
/**
 * Created by PhpStorm.
 * User: paulaan
 * Date: 9/30/14
 * Time: 2:06 PM
 */

namespace Cyclonize\StoreBundle\EventListener;

use Sylius\Bundle\WebBundle\Event\MenuBuilderEvent;

class MenuBuilderListener
{
    public function addBackendMenuItems(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();


        $childOptions = array(
            'childrenAttributes' => array('class' => 'nav'),
            'labelAttributes'    => array('class' => 'nav-header')
        );
//        var_dump(array_keys($menu->getChildrenAttributes()));exit;
        $menu->addChild('banner', $childOptions, 'sidebar')->setLabel('Banners');
        $menu['banner']->addChild('list', array(
            'route' => 'administration_banner',
            'labelAttributes' => array('icon' => 'glyphicon glyphicon-eye-open'),
        ))->setLabel('Banners');

        $menu['banner']->addChild('new', array(
            'route' => 'administration_banner_new',
            'labelAttributes' => array('icon' => 'glyphicon glyphicon-eye-close'),
        ))->setLabel('New Banner');
    }
} 