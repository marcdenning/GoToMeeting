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
    protected $endpoint = 'oauth';

    /**
     * Authenticate with the server and retrieve an auth token.
     *
     * Currently implements Citrix's {@link https://developer.citrixonline.com/page/direct-login "Direct Login"} method.
     *
     * @param string $userId
     * @param string $password
     * @return \kenobi883\GoToMeeting\Models\Auth
     */
    public function authenticate($userId, $password)
    {
        $url = "{$this->endpoint}/access_token";
        $query = new Query();
        $query->add('grant_type', 'password')
            ->add('user_id', $userId)
            ->add('password', $password)
            ->add('client_id', $this->client->getApiKey());
        $jsonBody = $this->client->sendRequest('GET', $url, $query);
        return new Auth($jsonBody);
    }
}
