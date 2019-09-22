<?php


namespace Domain\Query\ReadEvent;


use Domain\Command\Exception\ValidationException;
use Domain\Entity\Event;
use Domain\Repository\EventRepositoryInterface;

class ReadEventQuery
{
    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    /**
     * @var ReadEventValidator
     */
    private $validator;

    /**
     * @param EventRepositoryInterface $eventRepository
     * @param ReadEventValidator $validator
     */
    public function __construct(
        EventRepositoryInterface $eventRepository,
        ReadEventValidator $validator
    ) {
        $this->eventRepository = $eventRepository;
        $this->validator = $validator;
    }

    public function execute($slug): Event
    {
        if (!$this->validator->isValid($slug)) {
            throw new ValidationException($this->validator->getMessagesAsString());
        }

        return $this->eventRepository->findBySlug($slug);
    }
}