<?php

namespace Domain\Command\CreateEvent;

use Domain\Command\Exception\ValidationException;
use Domain\Entity\Event;
use Domain\Repository\EventRepositoryInterface;

class CreateEventCommand
{
    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    /**
     * @var CreateEventValidator
     */
    private $validator;

    /**
     * @param EventRepositoryInterface $eventRepository
     * @param CreateEventValidator $validator
     */
    public function __construct(EventRepositoryInterface $eventRepository, CreateEventValidator $validator)
    {
        $this->eventRepository = $eventRepository;
        $this->validator = $validator;
    }

    public function execute(CreateEventContext $context): string
    {
        if (!$this->validator->isValid($context)) {
            throw new ValidationException($this->validator->getMessagesAsString());
        }

        $event = Event::fromUserInput($context->getName(), $context->getMembers());

        $this->eventRepository->add($event);

        return $event->getSlug();
    }
}