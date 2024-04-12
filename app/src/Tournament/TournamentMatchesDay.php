<?php
declare(strict_types=1);

namespace App\Tournament;

use App\Tournament\Meeting\TournamentMeeting;
use App\Tournament\Meeting\TournamentMeetingCollection;
use App\Tournament\Rules\TournamentRuleInterface;
use Countable;
use DateTimeImmutable;

class TournamentMatchesDay implements Countable, TournamentMatchesDayInterface
{
    /** @var DateTimeImmutable Дата проведения турнира */
    private DateTimeImmutable $dateTime;

    /** @var TournamentMeetingCollection Коллекция матчей */
    private TournamentMeetingCollection $tournamentMeetingCollection;

    /** @var TournamentRuleInterface[] */
    private array $rules = [];

    public function __construct(TournamentMeetingCollection $tournamentMeetingCollection)
    {
        $this->tournamentMeetingCollection = $tournamentMeetingCollection;
    }

    public function getTournamentMeetingCollection(): TournamentMeetingCollection
    {
        return $this->tournamentMeetingCollection;
    }

    public function getDateTime(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    /**
     * Количество матчей в день
     * @return int
     */
    public function count(): int
    {
        return $this->getTournamentMeetingCollection()->count();
    }

    public function setDateTime(DateTimeImmutable $dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    public function addMeetingCollection(TournamentMeeting $meeting)
    {
        $clone = clone $this;
        $clone->getTournamentMeetingCollection()->add($meeting);
        $clone->applyRules($clone);

        $this->getTournamentMeetingCollection()->add($meeting);
    }

    public function addRule(TournamentRuleInterface $rule): self
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function applyRules(TournamentMatchesDay $visitor): void
    {
        foreach ($this->rules as $rule) {
            $rule->setVisitor($visitor);
            $rule->apply();
        }
    }

    public function __clone()
    {
        $this->tournamentMeetingCollection = clone $this->tournamentMeetingCollection;
    }
}