<?php

declare(strict_types=1);

use Domain\Command\AddExpense\AddExpenseCommand;
use Domain\Command\AddExpense\AddExpenseCommandFactory;
use Domain\Command\AddExpense\AddExpenseValidator;
use Domain\Command\CreateEvent\CreateEventCommand;
use Domain\Command\CreateEvent\CreateEventCommandFactory;
use Domain\Command\CreateEvent\CreateEventValidator;
use Domain\Query\Expense\ExpenseQuery;
use Domain\Query\Expense\ExpenseQueryFactory;
use Domain\Query\ReadEvent\ReadEventQuery;
use Domain\Query\ReadEvent\ReadEventQueryFactory;
use Domain\Query\ReadEvent\ReadEventValidator;
use Domain\Repository\EventRepositoryInterface;
use Domain\Repository\ExpenseRepositoryInterface;
use Infrastructure\Handler;
use Infrastructure\Repository\EventRepositoryFactory;
use Infrastructure\Repository\ExpenseRepositoryFactory;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases' => [
            // Fully\Qualified\ClassOrInterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            Handler\PingHandler::class => Handler\PingHandler::class,
            CreateEventValidator::class => CreateEventValidator::class,
            ReadEventValidator::class => ReadEventValidator::class,
            AddExpenseValidator::class => AddExpenseValidator::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories'  => [
            Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
            Handler\CreateEventHandler::class => Handler\CreateEventHandlerFactory::class,
            Handler\ReadEventHandler::class => Handler\ReadEventHandlerFactory::class,
            Handler\AddExpenseHandler::class => Handler\AddExpenseHandlerFactory::class,

            CreateEventCommand::class => CreateEventCommandFactory::class,
            AddExpenseCommand::class => AddExpenseCommandFactory::class,

            ReadEventQuery::class => ReadEventQueryFactory::class,
            ExpenseQuery::class => ExpenseQueryFactory::class,

            EventRepositoryInterface::class => EventRepositoryFactory::class,
            ExpenseRepositoryInterface::class => ExpenseRepositoryFactory::class,
        ],
    ],
];
