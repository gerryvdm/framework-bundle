<?php

namespace Netshark\Bundle\FrameworkBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class NetsharkFrameworkExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('netshark_framework.validator.mapping_dirs', $config['validation']['mappings']);

        if ($config['param_converter']['form_type']) {
            $container->getDefinition('netshark_framework.param_converter.form_type')->addTag('request.param_converter');
        }
    }

    public function getAlias()
    {
        return 'netshark_framework';
    }
}
