<?php

namespace Infrastructure\Repository;

use Domain\Entity\Expense;
use Domain\Query\Expense\ExpenseDTO;
use Domain\Repository\ExpenseRepositoryInterface;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    /**
     * @var TableGateway
     */
    private $tableGateway;

    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function add(Expense $expense): void
    {
        $id = $expense->getId();

        if (is_null($id)) {
            $this->tableGateway->insert([
                'eventId' => $expense->getEventId(),
                'description' => $expense->getDescription(),
                'amount' => $expense->getAmount(),
                'paidBy' => $expense->getPaidBy(),
            ]);
        } else {
            $this->tableGateway->update(
                [
                    'eventId' => $expense->getEventId(),
                    'description' => $expense->getDescription(),
                    'amount' => $expense->getAmount(),
                    'paidBy' => $expense->getPaidBy(),
                ],
                ['id' => $id]
            );
        }
    }

    public function findEventId(int $eventId): array
    {
        $select = new Select();
        $select->where->equalTo('eventId', $eventId);
        $select->from($this->tableGateway->getTable());
        $rows = $this->tableGateway->selectWith($select)->toArray();

        $result = [];
        foreach ($rows as $row) {
            $result[] = new Expense(
                $row['id'],
                $row['eventId'],
                $row['description'],
                $row['amount'],
                $row['paidBy']
            );
        }

        return $result;
    }
}