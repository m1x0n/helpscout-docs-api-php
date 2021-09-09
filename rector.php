<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Php71\Rector\ClassConst\PublicConstantVisibilityRector;
use Rector\Php74\Rector\Assign\NullCoalescingOperatorRector;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedStrictParamTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByMethodCallTypeRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    //$parameters->set(Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests']);

    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_74);

    // Define what rule sets will be applied
    //$containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::TYPE_DECLARATION);
    $containerConfigurator->import(SetList::TYPE_DECLARATION_STRICT);
    $containerConfigurator->import(SetList::EARLY_RETURN);
    $containerConfigurator->import(SetList::PHP_71);
    $containerConfigurator->import(SetList::PHP_72);
    $containerConfigurator->import(SetList::PHP_73);
    $containerConfigurator->import(SetList::PHP_74);

    // get services (needed for register a single rule)
    $services = $containerConfigurator->services();

    // register a single rule
    $services->set(TypedPropertyRector::class);
    $services->set(NullCoalescingOperatorRector::class);
    $services->set(AddMethodCallBasedStrictParamTypeRector::class);
    $services->set(AddParamTypeDeclarationRector::class);
    $services->set(ParamTypeByMethodCallTypeRector::class);
    $services->set(PublicConstantVisibilityRector::class);
};
