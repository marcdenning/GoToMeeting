<?php
/**
 * Meeting service class.
 * @package kenobi883\GoToMeeting
 */

namespace kenobi883\GoToMeeting\Services;

use GuzzleHttp\Query;
use kenobi883\GoToMeeting\Models\Attendee;
use kenobi883\GoToMeeting\Models\Meeting;

/**
 * Class MeetingService provides access to meeting API methods.
 *
 * @package kenobi883\GoToMeeting\Services
 */
class MeetingService extends AbstractService
{
    const DATE_FORMAT_INPUT = 'Y-m-d\TH:i:s\Z';

    /**
     * @var string
     */
    protected $endpoint = 'meetings';

    /**
     * Retrieve a specific meeting from the API.
     *
     * @param int $meetingId meeting to retrieve
     * @return \kenobi883\GoToMeeting\Models\Meeting
     */
    public function getMeeting($meetingId)
    {
        $jsonBody = $this->client->sendRequest('GET', "{$this->endpoint}/{$meetingId}");
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
        $startDate->setTimezone($utcTimeZone);
        $endDate->setTimezone($utcTimeZone);

        $query->add('startDate', $startDate->format(self::DATE_FORMAT_INPUT))
            ->add('endDate', $endDate->format(self::DATE_FORMAT_INPUT))
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
     * @param Meeting $meeting
     * @return Meeting
     */
    public function createMeeting(Meeting $meeting)
    {
        $meetingArray = $meeting->toArrayForApi();
        $jsonBody = $this->client->sendRequest('POST', $this->endpoint, null, false, $meetingArray);

        // Merge attributes returned in response to existing Meeting instance
        $meeting->parseFromJson($jsonBody[0]);
        return $meeting;
    }

    /**
     * Delete the specified meeting.
     *
     * @param int $meetingId
     */
    public function deleteMeeting($meetingId)
    {
        $this->client->sendRequest('DELETE', "{$this->endpoint}/{$meetingId}");
    }

    /**
     * Update the provided meeting with set values.
     *
     * @param Meeting $meeting
     */
    public function updateMeeting(Meeting $meeting)
    {
        $meetingId = $meeting->getMeetingId();
        $meetingArray = $meeting->toArrayForApi();
        $this->client->sendRequest('PUT', "{$this->endpoint}/{$meetingId}", null, false, $meetingArray);
    }

    /**
     * Retrieve the join URL for the given meeting.
     *
     * @param int $meetingId
     * @return string
     */
    public function startMeeting($meetingId)
    {
        $responseArray = $this->client->sendRequest('GET', "{$this->endpoint}/{$meetingId}/start");
        return $responseArray['hostURL'];
    }

    /**
     * Get attendees for the specified meeting instance key and date range.
     *
     * Instance keys may only be obtained for historical meetings.
     *
     * @param string $meetingInstanceKey
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array includes `meetings` and `attendees` keys mapping to arrays of the Meeting and Attendee
     *  instances returned from the API
     */
    public function getAttendeesByMeeting($meetingInstanceKey, \DateTime $startDate, \DateTime $endDate)
    {
        $url = "{$this->endpoint}/{$meetingInstanceKey}/attendees";
        $query = new Query();
        $query->add('startDate', $startDate->format(MeetingService::DATE_FORMAT_INPUT))
            ->add('endDate', $endDate->format(MeetingService::DATE_FORMAT_INPUT));
        $jsonBody = $this->client->sendRequest('GET', $url, $query);
        $meetings = array();
        $attendees = array();
        foreach ($jsonBody as $meetingAttendee) {
            $meetings[] = new Meeting($meetingAttendee);
            $attendees[] = new Attendee($meetingAttendee);
        }
        return array(
            'meetings' => $meetings,
            'attendees' => $attendees
        );
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
        // Send request
        $jsonBody = $this->client->sendRequest('GET', $this->endpoint, $query);

        // Parse each meeting result
        $meetings = array();
        $jsonMeetings = $jsonBody;
        if (isset($jsonBody['meetings'])) {
            $jsonMeetings = $jsonBody['meetings'];
        }
        foreach ($jsonMeetings as $oneMeeting) {
            $meeting = new Meeting($oneMeeting);
            $meetings[] = $meeting;
        }
        return $meetings;
    }
}
