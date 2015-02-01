<?php
/**
 * Service to interact with groups endpoint.
 * @package kenobi883\GoToMeeting\Services
 */

namespace kenobi883\GoToMeeting\Services;

use GuzzleHttp\Query;
use kenobi883\GoToMeeting\Models\Group;
use kenobi883\GoToMeeting\Models\Meeting;
use kenobi883\GoToMeeting\Models\Organizer;

class GroupService extends AbstractService
{
    /**
     * @var string
     */
    protected $endpoint = 'groups';

    /**
     * Retrieve all groups for the corporate account.
     *
     * Requires a corporate account and a user with the admin role.
     *
     * @return array Group objects for the account
     */
    public function getGroups()
    {
        $jsonBody = $this->client->sendRequest('GET', $this->endpoint);
        $groups = array();
        foreach ($jsonBody as $groupResponse) {
            $groups[] = new Group($groupResponse);
        }
        return $groups;
    }

    /**
     * Get the organizers for a particular group.
     *
     * @param int $groupKey
     * @return array Organizers for the account
     */
    public function getOrganizersByGroup($groupKey)
    {
        $jsonBody = $this->client->sendRequest('GET', "{$this->endpoint}/{$groupKey}/organizers");
        $organizers = array();
        foreach ($jsonBody as $organizerResponse) {
            $organizers[] = new Organizer($organizerResponse);
        }
        return $organizers;
    }

    /**
     * Get historical or scheduled meetings by group.
     *
     * @param string $groupKey
     * @param bool $historical
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array Meetings for the given group and optional date range
     * @throws \Exception
     */
    public function getMeetingsByGroup($groupKey, $historical = false, \DateTime $startDate = null, \DateTime $endDate = null)
    {
        if ($historical === true && ($startDate === null || $endDate === null)) {
            throw new \Exception('To retrieve historical meetings, startDate and endDate must be specified.');
        }
        $query = new Query();
        $url = "{$this->endpoint}/{$groupKey}/meetings";

        if ($historical === true) {
            // Adjust start and end dates to the UTC timezone
            $utcTimeZone = new \DateTimeZone('UTC');
            $startDate->setTimezone($utcTimeZone);
            $endDate->setTimezone($utcTimeZone);
            $query->add('historical', 'true')
                ->add('startDate', $startDate->format(MeetingService::DATE_FORMAT_INPUT))
                ->add('endDate', $endDate->format(MeetingService::DATE_FORMAT_INPUT));
        }
        else {
            $query->add('scheduled', 'true');
        }

        // Send request
        $jsonBody = $this->client->sendRequest('GET', $url, $query);

        // Parse each meeting result
        $meetings = array();
        foreach ($jsonBody as $oneMeeting) {
            $meeting = new Meeting($oneMeeting);
            $meetings[] = $meeting;
        }
        return $meetings;
    }
}
