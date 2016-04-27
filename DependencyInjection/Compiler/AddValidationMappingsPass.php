<?php

namespace Netshark\Bundle\FrameworkBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;

final class AddValidationMappingsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('validator.builder')) {
            return;
        }

        $dirs = $container->getParameter('netshark_framework.validator.mapping_dirs');

        if (count($dirs) === 0) {
            return;
        }

        $mappings = $this->findFiles('*.validation.xml', $dirs);

        if (count($mappings)) {
            $container->getDefinition('validator.builder')->addMethodCall('addXmlMappings', [$mappings]);
        }

        $mappings = $this->findFiles('*.validation.yml', $dirs);

        if (count($mappings)) {
            $container->getDefinition('validator.builder')->addMethodCall('addYamlMappings', [$mappings]);
        }
    }

    /**
     * @param string $pattern
     * @param string[] $dirs
     * @return string[]
     */
    private function findFiles($pattern, array $dirs)
    {
        $finder = Finder::create()->files()->name($pattern)->in($dirs);

        return array_map(function (\SplFileInfo $file) {
            return $file->getRealPath();
        }, iterator_to_array($finder));
    }
}
