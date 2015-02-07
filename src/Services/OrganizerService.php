<?php
/**
 * Service to interact with Organizers endpoint.
 * @package \kenobi883\GoToMeeting\Services
 */
namespace kenobi883\GoToMeeting\Services;

use GuzzleHttp\Query;
use kenobi883\GoToMeeting\Models\Attendee;
use kenobi883\GoToMeeting\Models\Meeting;
use kenobi883\GoToMeeting\Models\Organizer;

/**
 * Class OrganizerService
 *
 * @package kenobi883\GoToMeeting\Services
 */
class OrganizerService extends AbstractService
{
    /**
     * @var string
     */
    protected $endpoint = 'organizers';

    /**
     * Get a single organizer by ID.
     *
     * @param int $organizerId
     * @return \kenobi883\GoToMeeting\Models\Organizer
     */
    public function getOrganizerById($organizerId)
    {
        $jsonBody = $this->client->sendRequest('GET', "{$this->endpoint}/{$organizerId}");
        $organizer = new Organizer($jsonBody);
        return $organizer;
    }

    /**
     * Get an organizer by email address.
     *
     * @param string $email
     * @return \kenobi883\GoToMeeting\Models\Organizer
     */
    public function getOrganizerByEmail($email)
    {
        $query = new Query();
        $query->set('email', $email);
        $jsonBody = $this->client->sendRequest('GET', $this->endpoint, $query);
        $organizer = new Organizer($jsonBody);
        return $organizer;
    }

    /**
     * Get all organizers for a given group.
     *
     * Proxies to the group service for organizers because this API call is handles by the group endpoint.
     *
     * @param int $groupKey
     * @return array Organizers for the given Group
     */
    public function getOrganizersByGroup($groupKey)
    {
        $groupService = new GroupService($this->client);
        return $groupService->getOrganizersByGroup($groupKey);
    }

    /**
     * Create a new organizer in the specified group.
     *
     * @param int $groupKey
     * @param Organizer $organizer
     * @return Organizer with organizer key set from response
     */
    public function createOrganizer($groupKey, Organizer $organizer)
    {
        $groupService = new GroupService($this->client);
        return $groupService->createOrganizer($groupKey, $organizer);
    }

    /**
     * Delete the organizer specified by the given key.
     *
     * @param int $organizerKey
     */
    public function deleteOrganizer($organizerKey)
    {
        $this->client->sendRequest('DELETE', "{$this->endpoint}/{$organizerKey}");
    }

    /**
     * Delete the organizer specified by the given email address.
     *
     * @param string $email
     */
    public function deleteOrganizerByEmail($email)
    {
        $query = new Query();
        $query->add('email', $email);
        $this->client->sendRequest('DELETE', $this->endpoint, $query);
    }

    /**
     * Update the organizer status to `active` or `suspended`.
     *
     * @param int $organizerKey
     * @param bool $isActive true to activate the organizer, false to suspend the organizer
     */
    public function updateOrganizerStatus($organizerKey, $isActive = true)
    {
        $requestBody = array(
            'status' => $isActive ? 'active' : 'suspended'
        );
        $this->client->sendRequest('PUT', "{$this->endpoint}/{$organizerKey}", null, false, $requestBody);
    }

    /**
     * Get all attendee information for the specified organizer during the specified date range.
     *
     * @param string $organizerKey
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array includes `meetings` and `attendees` keys mapping to arrays of the Meeting and Attendee
     *  instances returned from the API
     */
    public function getAttendeesByOrganizer($organizerKey, \DateTime $startDate, \DateTime $endDate)
    {
        $url = "{$this->endpoint}/{$organizerKey}/attendees";
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
}
