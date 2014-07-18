<?php
/**
 * Meeting service class.
 * @package kenobi883\GoToMeeting
 */

namespace kenobi883\GoToMeeting\Services;

use GuzzleHttp\Query;
use kenobi883\GoToMeeting\Client;
use kenobi883\GoToMeeting\Models\Auth;
use kenobi883\GoToMeeting\Models\Meeting;

/**
 * Class MeetingService provides access to meeting API methods.
 *
 * @package kenobi883\GoToMeeting\Services
 */
class MeetingService extends AbstractService
{
    /**
     * Retrieve a specific meeting from the API.
     *
     * @param int $meetingId meeting to retrieve
     * @return \kenobi883\GoToMeeting\Models\Meeting
     */
    public function getMeeting($meetingId)
    {
        $guzzleClient = $this->client->getGuzzleClient();
        $request = $guzzleClient->createRequest('GET', "meetings/{$meetingId}");
        $jsonBody = $this->sendRequest($request);
        $meeting = new Meeting($jsonBody[0]);
        return $meeting;
    }

    /**
     * Get all past meetings within the specified time window.
     *
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array parsed Meeting objects
     * @throws \Exception
     */
    public function getHistoricalMeetings(\DateTime $startDate = null, \DateTime $endDate = null)
    {
        // Set up parameters for request
        if ($startDate === null || $endDate === null) {
            throw new \Exception('To retrieve historical meetings, startDate and endDate must be specified.');
        }

        $query = new Query();

        // Adjust start and end dates to the UTC timezone if provided
        $utcTimeZone = new \DateTimeZone('UTC');
        if ($startDate !== null) {
            $startDate->setTimezone($utcTimeZone);
        }
        if ($endDate !== null) {
            $endDate->setTimezone($utcTimeZone);
        }

        $query->add('startDate', $startDate->format(\DateTime::ISO8601))
            ->add('endDate', $endDate->format(\DateTime::ISO8601))
            ->add('history', 'true');

        return $this->getMeetings($query);
    }

    /**
     * Get all future scheduled meetings.
     *
     * @return array parsed Meeting objects
     */
    public function getScheduledMeetings()
    {
        $query = new Query();
        $query->add('scheduled', 'true');
        return $this->getMeetings($query);
    }

    /**
     * Retrieve a set of meetings using the specified query parameters.
     *
     * @param \GuzzleHttp\Query $query
     * @throws \Exception
     * @return array parsed Meeting objects
     */
    protected function getMeetings(Query $query)
    {
        // Create and build API request
        $guzzleClient = $this->client->getGuzzleClient();
        $request = $guzzleClient->createRequest('GET', 'meetings');
        $request->setQuery($query);

        // Send request
        $jsonBody = $this->sendRequest($request);

        // Parse each meeting result
        $meetings = array();
        foreach ($jsonBody as $oneMeeting) {
            $meeting = new Meeting($oneMeeting);
            $meetings[] = $meeting;
        }
        return $meetings;
    }
}
