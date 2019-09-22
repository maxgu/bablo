<?php


namespace Domain\Command\AddExpense;


class AddExpenseContext
{
    /**
     * @var string
     */
    private $slug;

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
     * @param string $slug
     * @param string $description
     * @param int $amount
     * @param string $paidBy
     */
    public function __construct(string $slug, string $description, int $amount, string $paidBy)
    {
        $this->slug = $slug;
        $this->description = $description;
        $this->amount = $amount;
        $this->paidBy = $paidBy;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
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