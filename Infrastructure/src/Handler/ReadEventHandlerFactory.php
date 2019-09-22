<?php

declare(strict_types=1);

namespace Infrastructure\Handler;

use Domain\Query\Expense\ExpenseQuery;
use Domain\Query\ReadEvent\ReadEventQuery;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ReadEventHandlerFactory
{
    public function __invoke(ContainerInterface $container) : RequestHandlerInterface
    {
        return new ReadEventHandler(
            $container->get(ReadEventQuery::class),
            $container->get(ExpenseQuery::class),
            $container->get(TemplateRendererInterface::class)
        );
    }
}
