<?php

namespace HS\TranslationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('hs_translation');

        // missing translation
        $rootNode
            ->children()
                ->arrayNode('gather_missing_translation')
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->arrayNode('bypassed_domains')
                            ->addDefaultChildrenIfNoneSet(0)
                            ->prototype('scalar')
        ;
        
        return $treeBuilder;
    }
}
