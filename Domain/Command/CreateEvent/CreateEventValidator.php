<?php


namespace Domain\Command\CreateEvent;


class CreateEventValidator
{
    public function isValid(CreateEventContext $context): bool
    {
        return true;
    }

    public function getMessagesAsString(): string
    {

    }

    public function getMessages(): array
    {

    }
}