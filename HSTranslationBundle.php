<?php

namespace HS\TranslationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use HS\TranslationBundle\DependencyInjection\Compiler\OverrideTranslatorCompilerPass;

class HSTranslationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new OverrideTranslatorCompilerPass());
    }
}
