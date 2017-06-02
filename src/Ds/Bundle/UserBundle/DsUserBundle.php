<?php

namespace Ds\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ds\Bundle\UserBundle\DependencyInjection\Compiler;

/**
 * Class DsUserBundle
 */
class DsUserBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new Compiler\ConfigPass);
    }
}
