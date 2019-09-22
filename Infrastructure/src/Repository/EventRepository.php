<?php

namespace Infrastructure\Repository;

use Domain\Entity\Event;
use Domain\Repository\EventRepositoryInterface;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class EventRepository implements EventRepositoryInterface
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

    public function add(Event $event): void
    {
        $id = $event->getId();

        if (is_null($id)) {
            $this->tableGateway->insert([
                'slug' => $event->getSlug(),
                'name' => $event->getName(),
                'members' => implode(',', $event->getMembers()),
            ]);
        } else {
            $this->tableGateway->update(
                [
                    'slug' => $event->getSlug(),
                    'name' => $event->getName(),
                    'members' => implode(',', $event->getMembers()),
                ],
                ['id' => $id]
            );
        }
    }

    public function findBySlug(string $slug): Event
    {
        $select = new Select();
        $select->where->equalTo('slug', $slug);
        $select->from($this->tableGateway->getTable());
        $select->limit(1)->offset(0);
        $result = $this->tableGateway->selectWith($select)->toArray();

        if (!isset($result[0])) {
            return new Event();
        }

        return Event::fromStorage(
            $result[0]['id'],
            $result[0]['slug'],
            $result[0]['name'],
            $result[0]['members']
        );
    }
}