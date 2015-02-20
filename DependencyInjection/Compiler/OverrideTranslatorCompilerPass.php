<?php

namespace HS\TranslationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Override the translator class in the service container
 */
class OverrideTranslatorCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('translator.default');
        $definition->setClass('HS\TranslationBundle\Translation\Translator');
    }
}
