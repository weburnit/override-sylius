<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Sylius\Bundle\CoreBundle\Kernel\Kernel;

/**
 * Sylius application kernel.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class AppKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = array(
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Cyclonize\StoreBundle\CyclonizeStoreBundle(),
            new Trsteel\CkeditorBundle\TrsteelCkeditorBundle(),
            new Nelmio\SolariumBundle\NelmioSolariumBundle(),
        );

        return array_merge(parent::registerBundles(), $bundles);
    }
}
