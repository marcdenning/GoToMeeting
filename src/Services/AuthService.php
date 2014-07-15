<?php
/**
 * Service configured to authenticate with the API.
 * @package kenobi883\GoToMeeting\Services
 */

namespace kenobi883\GoToMeeting\Services;

use GuzzleHttp\Query;
use kenobi883\GoToMeeting\Client;
use kenobi883\GoToMeeting\Models\Auth;
use kenobi883\GoToMeeting\Services\AbstractService;

/**
 * Class AuthService
 *
 * @package kenobi883\GoToMeeting\Services
 */
class AuthService extends AbstractService
{
    private $endpoint = 'oauth/';

    /**
     * Authenticate with the server and retrieve an auth token.
     *
     * @param string $userId
     * @param string $password
     * @return \kenobi883\GoToMeeting\Models\Auth
     */
    public function authenticate($userId, $password)
    {
        $query = new Query();
        $guzzleClient = $this->client->getGuzzleClient();
        $request = $guzzleClient->createRequest('GET', $this->endpoint);
        $query->add('grant_type', 'password')
            ->add('user_id', $userId)
            ->add('password', $password)
            ->add('client_id', $this->client->getApiKey());
        $request->setQuery($query);
        $jsonBody = $this->sendRequest($request);
        return new Auth($jsonBody);
    }
}
