<?php

namespace Domain\Query\ReadEvent;

class ReadEventDTO
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string[]
     */
    private $members;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $data['members'] = explode(',', $data['members']);
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
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getMembers(): array
    {
        return $this->members;
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