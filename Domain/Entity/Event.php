<?php


namespace Domain\Entity;


class Event
{
    /**
     * @var int|null
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
     * @var Expense[]
     */
    private $expenses = [];

    /**
     * @param int|null $id
     * @param string $slug
     * @param string $name
     * @param string[] $members
     */
    public function __construct(?int $id, string $slug, string $name, array $members)
    {
        $this->id = $id;
        $this->slug = $slug;
        $this->name = $name;
        $this->members = $members;
    }

    public static function fromStorage(int $id, string $slug, string $name, string $members): self
    {
        $members = explode(',', $members);
        $members = \array_map(function($item){
            return trim($item);
        }, $members);
        return new self($id, $slug, $name, $members);
    }

    public static function fromUserInput(string $name, string $members): self
    {
        $slug = self::generateSlug();

        return new self(null, $slug, $name, explode(',', $members));
    }

    private static function generateSlug(): string
    {
        // without 0, O, I, l
        $characters = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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

    public function fillExpenses(array $expenses): void
    {
        $this->expenses = $expenses;
    }

    public function getMembersWithCalculations(): array
    {
        $totalAmount = 0;

        foreach ($this->expenses as $expense) {
            $totalAmount += $expense->getAmount();
        }

        $avgAmount = (int)round($totalAmount / count($this->members));

        $members = [];
        foreach ($this->members as $member) {
            $members[$member] = [
                'name' => $member,
                'totalExpenses' => 0,
                'calculations' => [],
            ];
        }

        foreach ($this->expenses as $expense) {
            $members[$expense->getPaidBy()]['totalExpenses'] += $expense->getAmount();
        }

        foreach ($members as &$member) {
            $member['mustReturnAmount'] = 0;
            if ($avgAmount > $member['totalExpenses']) {
                $member['mustReturnAmount'] = $avgAmount - $member['totalExpenses'];
            }
        }

        \usort($members, function($a, $b){
            return $a['totalExpenses'] < $b['totalExpenses'];
        });

        for($i=0; $i<count($members); $i++) {
            for($k=count($members)-1; $k>=0; $k--) {
                if ($members[$i]['name'] == $members[$k]['name']) {
                    continue;
                }

                if ($members[$k]['mustReturnAmount'] == 0) {
                    continue;
                }

                if ($members[$i]['totalExpenses'] - $members[$k]['mustReturnAmount'] > 0) {
                    if (!isset($members[$i]['calculations'])) {
                        $members[$i]['calculations'] = [];
                    }

                    $members[$i]['calculations'][$members[$k]['name']] = $members[$k]['mustReturnAmount'];
                }
            }
        }
//die(var_dump($members));
        return $members;
    }
}