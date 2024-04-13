<?php
declare(strict_types=1);

namespace App\Tournament;

use App\Entity\Team;
use App\Tournament\Exceptions\MatchCountEvenException;
use App\Tournament\Meeting\TournamentMeeting;
use App\Tournament\Meeting\TournamentMeetingCollection;
use App\Tournament\Rules\Exceptions\NumberMatchesPerDayException;
use App\Tournament\Rules\Exceptions\TournamentMeetingNotUniqueException;
use App\Tournament\Rules\NumberMatchesPerDayRule;
use App\Tournament\Rules\UniqueMeetingsRule;
use ArrayIterator;
use Countable;
use Doctrine\Common\Collections\Collection;
use IteratorAggregate;
use Traversable;

class TournamentGrid implements Countable, IteratorAggregate
{
    /**
     * Количество турниров в день
     * @var int|null
     */
    private ?int $perDay = 4;

    private ?Collection $teams = null;

    private ?TournamentMeetingCollection $matches;

    public function __construct(Collection $teams, ?int $perDay = null)
    {
        $this->perDay = $perDay ?? $this->perDay;
        $this->teams = $teams;
    }

    /**
     * Сформировать встречи
     * @return void
     * @throws MatchCountEvenException
     */
    public function formMatches()
    {
        $this->matches = new TournamentMeetingCollection();
        $teams = $this->getTeams()->getValues();
        if ((count($teams) % 2) !== 0) throw new MatchCountEvenException();

        $countSlice = 1;
        /** @var Team $team */
        foreach ($teams as $key => $team) {
            $rivals = array_slice($teams, $countSlice);
            if (count($rivals) <= 0) continue;

            /** @var Team $rivalTeam */
            foreach ($rivals as $rivalTeam) {
                $this->matches->add(new TournamentMeeting($team, $rivalTeam));
            }

            $countSlice++;
        }
    }

    public function count(): int
    {
        return $this->teams->count();
    }

    private function tournamentMatchesDayFactory(): TournamentMatchesDay
    {
        $tournamentMatchesDay = new TournamentMatchesDay(new TournamentMeetingCollection());
        $tournamentMatchesDay
            ->addRule(new UniqueMeetingsRule())
            ->addRule(new NumberMatchesPerDayRule($this->perDay));

        return $tournamentMatchesDay;
    }

    private function fillOutStandings(ArrayIterator $matches, array $tournamentMatchesDays = []): array
    {
        $recursiveResult = [];
        $matchesDay = $this->tournamentMatchesDayFactory();
        $matchesArray = $matches->getArrayCopy();

        foreach ($matchesArray as $key => $match) {
            try {
                $matchesDay->addMeetingCollection($match);
                unset($matchesArray[$key]);
            } catch (\Exception $exception) {

            }
        }

        if (count($matchesArray) > 0)
            $recursiveResult = $this->fillOutStandings(new ArrayIterator($matchesArray));


        return array_merge($tournamentMatchesDays, [$matchesDay], $recursiveResult);
    }

    public function getIterator(): Traversable
    {
        $this->formMatches(); // Формируем список матчей
        /** @var ArrayIterator $matches */
        $matches = $this->getMatches()->getIterator();

        $tournamentMatchesDays = $this->fillOutStandings($matches);

//        $tournamentMatchesDays = [
//            $this->tournamentMatchesDayFactory(),
//        ];


//        while ($countResult !== $matches->count()) {
//
//            $countResult++;
//        }


//        foreach ($matches as $key => $match) {
//            foreach ($tournamentMatchesDays as $keyDay => $matchesDay) {
//                try {
//                    $matchesDay->addMeetingCollection($match);
//                } catch (NumberMatchesPerDayException $e) {
////                    $tournamentMatchesDays[] = $this->tournamentMatchesDayFactory();
//                } catch (TournamentMeetingNotUniqueException $exception) {
//
//                }
//            }
//        }


//        while ($countResult !== $matches->count()) {
//            /** @var TournamentMeeting $currentTournamentMeeting */
//
//            if (is_null($matches->current())) $matches->seek(0);
//            $currentTournamentMeeting = $matches->current();
//            $next = true;
//
//            $gridFromDay
//                ->getTournamentMeetingCollection()
//                ->add($currentTournamentMeeting);
//
//            try {
//                $gridFromDay
//                    ->applyRule(new UniqueMeetingsRule())
//                    ->applyRule(new NumberMatchesPerDayRule($this->perDay));
//
//            } catch (NumberMatchesPerDayException $e) {
//                $result[] = $gridFromDay;
//                $gridFromDay = new TournamentMatchesDay(new TournamentMeetingCollection());
//            } catch (TournamentMeetingNotUniqueException $e) {
//                $next = false;
//            }
//
//            if ($next) {
//                $countResult++;
//            }
//
//            $matches->next();
//        }

        return new ArrayIterator($tournamentMatchesDays);
    }

    public function getTeams(): ?Collection
    {
        return $this->teams;
    }

    public function getMatches(): ?TournamentMeetingCollection
    {
        return $this->matches;
    }

    public function getPerDay(): ?int
    {
        return $this->perDay;
    }

    public function setPerDay(?int $perDay): void
    {
        $this->perDay = $perDay;
    }
}