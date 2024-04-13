<?php
declare(strict_types=1);

namespace App\Tournament;

use App\Tournament\Meeting\TournamentMeetingCollection;
use App\Tournament\Rules\TournamentRuleInterface;
use DateTimeImmutable;

interface TournamentMatchesDayInterface
{
    public function getTournamentMeetingCollection(): TournamentMeetingCollection;

    public function getDateTime(): DateTimeImmutable;

    public function addRule(TournamentRuleInterface $rule): self;

    public function applyRules(TournamentMatchesDay $visitor): void;
}