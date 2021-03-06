<?php declare(strict_types=1);

namespace Shopware\Core\System;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class System extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/DependencyInjection/'));
        $loader->load('sales_channel.xml');
        $loader->load('country.xml');
        $loader->load('currency.xml');
        $loader->load('locale.xml');
        $loader->load('listing.xml');
        $loader->load('snippet.xml');
        $loader->load('tax.xml');
        $loader->load('unit.xml');
        $loader->load('user.xml');
        $loader->load('language.xml');
        $loader->load('integration.xml');
        $loader->load('state_machine.xml');
    }
}
