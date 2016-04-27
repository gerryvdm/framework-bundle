<?php

namespace Netshark\Bundle\FrameworkBundle;

use Netshark\Bundle\FrameworkBundle\DependencyInjection\Compiler\AddValidationMappingsPass;
use Netshark\Bundle\FrameworkBundle\DependencyInjection\NetsharkFrameworkExtension;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class NetsharkFrameworkBundle extends Bundle
{
	public function getContainerExtension()
    {
        return new NetsharkFrameworkExtension();
    }

	public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddValidationMappingsPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }
}
