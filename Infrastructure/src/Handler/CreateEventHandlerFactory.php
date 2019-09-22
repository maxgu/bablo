<?php

declare(strict_types=1);

namespace Infrastructure\Handler;

use Domain\Command\CreateEvent\CreateEventCommand;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class CreateEventHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        return new CreateEventHandler(
            $container->get(CreateEventCommand::class),
            $container->get(TemplateRendererInterface::class)
        );
    }
}
