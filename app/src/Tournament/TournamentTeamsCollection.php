<?php
declare(strict_types=1);

namespace App\Tournament;

use App\Entity\Team;
use Countable;
use IteratorAggregate;
use Traversable;

class TournamentTeamsCollection implements Countable, IteratorAggregate
{
    /** @var Team[] */
    private array $teams;

    public function __construct(array $teams = [])
    {
        $this->teams = $teams;
    }

    public function add(Team $team)
    {

    }

    public function count(): int
    {
        return count($this->getTeams());
    }

    public function getIterator(): Traversable
    {
        // TODO: Implement getIterator() method.
    }

    public function getTeams(): array
    {
        return $this->teams;
    }
}