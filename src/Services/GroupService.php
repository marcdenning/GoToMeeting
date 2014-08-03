<?php
/**
 * Service to interact with groups endpoint.
 * @package kenobi883\GoToMeeting\Services
 */

namespace kenobi883\GoToMeeting\Services;

use kenobi883\GoToMeeting\Models\Group;
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
}
