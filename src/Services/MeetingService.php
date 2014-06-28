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
 * @package kenobi883\GoToMeeting
 */
class MeetingService extends AbstractService
{

    private $endpoint = 'G2M/rest/';

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
     * Retrieve a set of meetings.
     *
     * Retrieve all future meetings using $scheduled. To retrieve historical meetings, specify $history
     * and $startDate and $endDate.
     *
     * @param bool $scheduled get all future meetings
     * @param bool $history get past meetings, must also provide $startDate and $endDate
     * @param \DateTime $startDate optional unless $history is true
     * @param \DateTime $endDate optional unless $history is true
     * @throws \Exception if history is true but start and end dates are not provided, throw an exception
     * @return array parsed Meeting objects
     */
    public function getMeetings($scheduled = true, $history = false, $startDate = null, $endDate = null)
    {
        // Create and build API request
        $guzzleClient = $this->client->getGuzzleClient();
        $request = $guzzleClient->createRequest('GET', 'meetings');
        $query = new Query();

        // Set up parameters for request
        if ($history && ($startDate === null || $endDate === null))
        {
            throw new \Exception('To retrieve historical meetings, startDate and endDate must be specified.');
        }

        // Adjust start and end dates to the UTC timezone if provided
        $utcTimeZone = new \DateTimeZone('UTC');
        if ($startDate !== null)
        {
            $startDate->setTimezone($utcTimeZone);
            $query->add('startDate', $startDate->format(\DateTime::ISO8601));
        }
        if ($endDate !== null)
        {
            $endDate->setTimezone($utcTimeZone);
            $query->add('endDate', $endDate->format(\DateTime::ISO8601));
        }

        // Interpret scheduled and history parameters as strings for attaching to request
        $query->add('scheduled', $scheduled ? 'true' : 'false');
        $query->add('history', $history ? 'true' : 'false');

        // Send request
        $jsonBody = $this->sendRequest($request);

        // Parse each meeting result
        $meetings = array();
        foreach ($jsonBody as $oneMeeting)
        {
            $meeting = new Meeting($oneMeeting);
            $meetings[] = $meeting;
        }
        return $meetings;
    }
}
