<?php
declare(strict_types=1);

namespace App\Tournament\Rules;

use App\Tournament\TournamentMatchesDayInterface;

interface TournamentRuleInterface
{
    public function apply(): void;

    public function setVisitor(TournamentMatchesDayInterface $matchesDay): self;

    public function getVisitor(): TournamentMatchesDayInterface;
}