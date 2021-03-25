<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector;
use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::SETS, [
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::CODING_STYLE,
        SetList::PHP_80,
        SetList::PSR_4,
        SetList::CODE_QUALITY_STRICT,
        SetList::EARLY_RETURN,
        //SetList::PERFORMANCE,
        SetList::NAMING,
    ]);

    $parameters->set(Option::SKIP, [
        AddArrayDefaultToArrayPropertyRector::class,
        Rector\Php80\Rector\FunctionLike\UnionTypesRector::class,
        Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector::class,
        Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector::class,
    ]);

};
