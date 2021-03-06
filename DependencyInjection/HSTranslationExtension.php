<?php

namespace HS\TranslationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class HSTranslationExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        $container->setParameter(
            'hs_translation.translation_directory',
            $config['translation_directory']
        );
        
        $container->setParameter(
            'hs_translation.languages',
            $config['languages']
        );
        
        $container->setParameter(
            'hs_translation.domains',
            $config['domains']
        );
        
        $container->setParameter(
            'hs_translation.gather_missing_translation.enabled',
            $config['gather_missing_translation']['enabled']
        );
        
        $container->setParameter(
            'hs_translation.gather_missing_translation.bypassed_domains',
            $config['gather_missing_translation']['bypassed_domains']
        );
    }
}
