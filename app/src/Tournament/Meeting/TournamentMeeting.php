<?php
declare(strict_types=1);

namespace App\Tournament\Meeting;

use App\Entity\Team;

/**
 * Встреча команд
 * @example k1 - k2
 */
class TournamentMeeting
{
    private Team $teamOne;
    private Team $teamTwo;

    public function __construct(
        Team $teamOne,
        Team $teamTwo
    )
    {
        $this->teamOne = $teamOne;
        $this->teamTwo = $teamTwo;
    }

    /**
     * Идентификатор встречи
     * @return array
     */
    public function getHash(): array
    {
        return [
            md5($this->getTeamOne()->getName() . $this->getTeamOne()->getId()),
            md5($this->getTeamTwo()->getName() . $this->getTeamTwo()->getId())
        ];
    }

    public function getTeamTwo(): Team
    {
        return $this->teamTwo;
    }

    public function getTeamOne(): Team
    {
        return $this->teamOne;
    }

    /**
     * Строка встречи
     * @return void
     */
    public function __toString(): string
    {
        return sprintf('%s - %s', $this->getTeamOne()->getName(), $this->getTeamTwo()->getName());
    }
}