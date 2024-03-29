<?php

use App\Infra\EntityManagerCreator;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManagerInterface;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    EntityManagerInterface::class => fn () => (new EntityManagerCreator())->getEntityManager(),
]);

return $containerBuilder->build();
