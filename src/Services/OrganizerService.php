<?php
/**
 * Service to interact with Organizers endpoint.
 * @package \kenobi883\GoToMeeting\Services
 */
namespace kenobi883\GoToMeeting\Services;

use GuzzleHttp\Query;
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
}
