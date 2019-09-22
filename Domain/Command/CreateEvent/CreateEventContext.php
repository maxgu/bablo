<?php


namespace Domain\Command\CreateEvent;


class CreateEventContext
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $members;

    /**
     * @param string $name
     * @param string $members
     */
    public function __construct(string $name, string $members)
    {
        $this->name = $name;
        $this->members = $members;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMembers(): string
    {
        return $this->members;
    }
}