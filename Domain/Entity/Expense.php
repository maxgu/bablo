<?php


namespace Domain\Entity;


class Expense
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
     * @param int|null $id
     * @param int $eventId
     * @param string $description
     * @param int $amount
     * @param string $paidBy
     */
    public function __construct(
        ?int $id,
        int $eventId,
        string $description,
        int $amount,
        string $paidBy
    ) {
        $this->id = $id;
        $this->eventId = $eventId;
        $this->description = $description;
        $this->amount = $amount;
        $this->paidBy = $paidBy;
    }

    public static function fromStorage(
        int $id,
        int $eventId,
        string $description,
        int $amount,
        string $paidBy
    ): self {
        return new self($id, $eventId, $description, $amount, $paidBy);
    }

    public static function fromUserInput(
        int $eventId,
        string $description,
        int $amount,
        string $paidBy
    ): self {
        return new self(null, $eventId, $description, $amount, $paidBy);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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
}