<?php
/**
 * Client configured specifically to authenticate with the API.
 * @package kenobi883\GoToMeeting\Services
 */

namespace kenobi883\GoToMeeting\Services;
use GuzzleHttp\Query;
use kenobi883\GoToMeeting\Client;
use kenobi883\GoToMeeting\Models\Auth;

/**
 * Class AuthService
 *
 * @package kenobi883\GoToMeeting\Services
 */
class AuthService {

    /**
     * @var string root URL for authorizing requests
     */
    private $endpoint = 'oauth/';

    /**
     * @var \kenobi883\GoToMeeting\Client
     */
    private $client;

    /**
     * Default constructor.
     *
     * Configures the guzzleClient for authenticating.
     *
     * @param \kenobi883\GoToMeeting\Client $client
     */
    public function __construct($client)
    {
        $guzzleClient = $client->getGuzzleClient();
        $guzzleClient->getBaseUrl();
        $this->client = $client;
    }

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
        $query->add('grant_type', 'password');
        $query->add('user_id', $userId);
        $query->add('password', $password);
        $query->add('client_id', $this->apiKey);
        $response = $this->client->get('access_token', array(
            'query' => $query
        ));
        return new Auth($response->json());
    }
} 