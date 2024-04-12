<?php
declare(strict_types=1);

namespace App\Tournament\Rules;

use App\Tournament\Rules\Exceptions\NumberMatchesPerDayException;

class NumberMatchesPerDayRule extends AbstractRules
{
    private int $count = 0;

    public function __construct(int $count)
    {
        $this->count = $count;
    }

    public function apply(): void
    {
        $visitor = $this->getVisitor();

        if (count($visitor) > $this->getCount()) {

            $meetingCollection = $visitor->getTournamentMeetingCollection()->getIterator();
            $meetingCollectionArray = $meetingCollection->getArrayCopy();
            $lastMeeting = $meetingCollectionArray[array_key_last($meetingCollectionArray)];
            $visitor->getTournamentMeetingCollection()->remove($lastMeeting);

            throw new NumberMatchesPerDayException();
        }
    }

    public function getCount(): int
    {
        return $this->count;
    }
}