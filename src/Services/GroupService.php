<?php
/**
 * Service to interact with groups endpoint.
 * @package kenobi883\GoToMeeting\Services
 */

namespace kenobi883\GoToMeeting\Services;

use kenobi883\GoToMeeting\Models\Group;

class GroupService extends AbstractService
{
    /**
     * Retrieve all groups for the corporate account.
     *
     * Requires a corporate account and a user with the admin role.
     *
     * @return array Group objects for the account
     */
    public function getGroups()
    {
        $guzzleClient = $this->client->getGuzzleClient();
        $request = $guzzleClient->createRequest('GET', 'groups');
        $jsonBody = $this->sendRequest($request);
        $groups = array();
        foreach ($jsonBody as $groupResponse) {
            $groups[] = new Group($groupResponse);
        }
        return $groups;
    }
} 