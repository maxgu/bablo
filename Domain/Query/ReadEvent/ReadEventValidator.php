<?php


namespace Domain\Query\ReadEvent;


class ReadEventValidator
{
    public function isValid(string $slug): bool
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