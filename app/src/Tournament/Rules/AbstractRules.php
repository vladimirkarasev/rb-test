<?php
declare(strict_types=1);

namespace App\Tournament\Rules;

use App\Tournament\TournamentMatchesDayInterface;

abstract class AbstractRules implements TournamentRuleInterface
{
    protected TournamentMatchesDayInterface $matchesDay;

    public function setVisitor(TournamentMatchesDayInterface $matchesDay): TournamentRuleInterface
    {
        $this->matchesDay = $matchesDay;
        return $this;
    }

    public function getVisitor(): TournamentMatchesDayInterface
    {
        return $this->matchesDay;
    }
}