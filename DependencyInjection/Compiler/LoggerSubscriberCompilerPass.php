<?php

namespace Tms\Bundle\LoggerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class LoggerSubscriberCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $dispatcherDefinition = $container->findDefinition('event_dispatcher');

        $dispatcherDefinition->addMethodCall(
            'addSubscriber',
            array(new Reference('tms_logger.event.subscriber.logger'))
        );
    }
}
