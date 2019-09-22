<?php


namespace Domain\Command\AddExpense;


class AddExpenseValidator
{
    public function isValid(AddExpenseContext $context): bool
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