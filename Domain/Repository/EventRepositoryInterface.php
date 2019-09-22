<?php


namespace Domain\Repository;


use Domain\Entity\Event;

interface EventRepositoryInterface
{
    public function add(Event $event): void;

    public function findBySlug(string $slug): Event;
}