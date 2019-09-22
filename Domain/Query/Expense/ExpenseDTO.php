<?php

namespace Domain\Query\Expense;

class ExpenseDTO
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var int
     */
    private $eventId;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $paidBy;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->populate($data);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getEventId(): int
    {
        return $this->eventId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getPaidBy(): string
    {
        return $this->paidBy;
    }

    /**
     * @param array $properties
     * @return array
     */
    public function extract(array $properties = [])
    {
        $state = get_object_vars($this);

        if (empty($properties)) {
            return $state;
        }

        $rawArray = array_fill_keys($properties, null);

        return array_intersect_key($state, $rawArray);
    }

    /**
     * @param array $array
     * @return $this
     */
    public function populate(array $array = [])
    {
        $state = get_object_vars($this);

        $stateIntersect = array_intersect_key($array, $state);

        foreach ($stateIntersect as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }
}