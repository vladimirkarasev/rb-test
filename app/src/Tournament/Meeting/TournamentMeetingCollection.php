<?php
declare(strict_types=1);

namespace App\Tournament\Meeting;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

class TournamentMeetingCollection implements Countable, IteratorAggregate
{
    /** @var TournamentMeeting[] */
    private array $meetings = [];

    public function __construct()
    {
    }

    public function add(TournamentMeeting $meeting): void
    {
        $this->meetings[$this->hashKey($meeting->getHash())] = $meeting;
    }

    public function remove(TournamentMeeting $meeting): void
    {
        unset($this->meetings[$this->hashKey($meeting->getHash())]);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->meetings);
    }

    public function count(): int
    {
        return count($this->getMeetings());
    }

    public function getMeetings(): array
    {
        return $this->meetings;
    }

    private function hashKey(array $arrayHash): string
    {
        return md5(implode('.', $arrayHash));
    }
}