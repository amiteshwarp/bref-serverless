<?php declare(strict_types=1);

use Bref\Bref;
use DI\ContainerBuilder;

Bref::setContainer(function () {
    // Create and build the container
    $containerBuilder = new ContainerBuilder;
    $containerBuilder->addDefinitions(
        [
            'debug' => true
        ]
    );
    return $containerBuilder->build();
});