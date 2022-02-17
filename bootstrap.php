<?php declare(strict_types=1);

use Bref\Bref;
use DI\ContainerBuilder;

Bref::setContainer(function () {
    // Create and build the container
    return ( new ContainerBuilder() )
        ->addDefinitions(
            [
                'debug' => true
            ]
    )->build();
});