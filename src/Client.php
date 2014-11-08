<?php
/**
 * Client class for managing API requests
 * @package kenobi883\GoToMeeting
 */

namespace kenobi883\GoToMeeting;
use GuzzleHttp\Query;
use kenobi883\GoToMeeting\Models\Auth;

/**
 * Class Client
 * @package kenobi883\GoToMeeting
 */
class Client
{
    /**
     * @var string root URL for authorizing requests
     */
    private $endpoint = 'https://api.citrixonline.com/';

    /**
     * @var string key to access the API
     */
    private $apiKey;

    /**
     * @var \GuzzleHttp\Client
     */
    private $guzzleClient;

    /**
     * @var \kenobi883\GoToMeeting\Models\Auth
     */
    private $auth;

    /**
     * Default constructor.
     *
     * Configures the client for authenticating.
     *
     * @param string $apiKey client ID or API key
     * @param string|null $accessToken optionally provide an obtained OAuth access token
     *   to configure the auth property
     */
    public function __construct($apiKey, $accessToken = NULL)
    {
        $this->apiKey = $apiKey;
        $this->guzzleClient = new \GuzzleHttp\Client(array(
            'base_url' => $this->endpoint
        ));
        if ($accessToken !== NULL) {
            $auth = new Auth();
            $auth->setAccessToken($accessToken);
            $this->setAuth($auth);
        }
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getGuzzleClient()
    {
        return $this->guzzleClient;
    }

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function setGuzzleClient($client)
    {
        $this->guzzleClient = $client;
    }

    /**
     * @return Models\Auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param Models\Auth $auth
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle sending requests to the API. All responses returned as JSON.
     *
     * Request body sent as JSON.
     *
     * @param string $method HTTP method for the request
     * @param string $path relative URL to append to the root API endpoint
     * @param \GuzzleHttp\Query $query optional data to send along with request
     * @param bool $isAuthRequest optional flag to not pass the OAuth token with request
     *  because we do not have it yet
     * @param array $postBody body content for a POST or PUT request
     * @return mixed
     * @throws \GuzzleHttp\Exception\RequestException
     */
    public function sendRequest($method, $path, Query $query = null, $isAuthRequest = false, $postBody = null)
    {
        $guzzleClient = $this->getGuzzleClient();
        $options = array(
            'headers' => array(
                'Accept' => 'application/json',
                'Content-type' => 'application/json'
            )
        );
        if (!$isAuthRequest && isset($this->auth)) {
            $accessToken = $this->auth->getAccessToken();
            $options['headers']['Authorization'] = "OAuth oauth_token={$accessToken}";
            $path = "G2M/rest/{$path}";
        }
        if ($query != null) {
            $options['query'] = $query;
        }
        if ($postBody != null && ($method == 'POST' || $method == 'PUT')) {
            $options['json'] = $postBody;
        }
        $request = $guzzleClient->createRequest($method, $path, $options);
        $response = $guzzleClient->send($request);
        return $response->json();
    }

}
