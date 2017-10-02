<?php

namespace Tms\Bundle\LoggerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tms\Bundle\LoggerBundle\DependencyInjection\Compiler\LoggerSubscriberCompilerPass;

class TmsLoggerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new LoggerSubscriberCompilerPass());
    }
}
