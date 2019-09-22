<?php

declare(strict_types=1);

namespace Domain\Command\CreateEvent;

use Domain\Repository\EventRepositoryInterface;
use Psr\Container\ContainerInterface;

class CreateEventCommandFactory
{
    public function __invoke(ContainerInterface $container) : CreateEventCommand
    {
        return new CreateEventCommand(
            $container->get(EventRepositoryInterface::class),
            $container->get(CreateEventValidator::class)
        );
    }
}
