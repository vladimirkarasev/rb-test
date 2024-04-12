<?php
declare(strict_types=1);

namespace App\Tournament\Rules;

use App\Tournament\Meeting\TournamentMeeting;
use App\Tournament\Rules\Exceptions\TournamentMeetingNotUniqueException;
use ArrayIterator;

class UniqueMeetingsRule extends AbstractRules
{
    /**
     * @throws \Exception
     */
    public function apply(): void
    {
        $visitor = $this->getVisitor();
        /** @var ArrayIterator $meetingCollection */
        $meetingCollection = $visitor->getTournamentMeetingCollection()->getIterator();

        if (count($meetingCollection) > 1) {
            $meetingCollectionArray = $meetingCollection->getArrayCopy();

            /** @var TournamentMeeting $lastMeeting */
            $lastMeeting = $meetingCollectionArray[array_key_last($meetingCollectionArray)];
            $meetingListExpertLastOne = array_slice($meetingCollectionArray, 0, count($meetingCollectionArray) - 1);

            foreach ($meetingListExpertLastOne as $item) {
                $this->checkUnique(
                    $lastMeeting, $item
                );
            }
        }
    }

    /**
     * @throws TournamentMeetingNotUniqueException
     */
    private function checkUnique(TournamentMeeting $lastMeeting, TournamentMeeting $meeting): void
    {
        if (array_intersect($lastMeeting->getHash(), $meeting->getHash())) {
            throw new TournamentMeetingNotUniqueException();
        }
    }
}