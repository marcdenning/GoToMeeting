<?php
/**
 * Client class for managing API requests
 * @package kenobi883\GoToMeeting
 */

namespace kenobi883\GoToMeeting;

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
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->guzzleClient = new \GuzzleHttp\Client(array(
            'base_url' => $this->endpoint
        ));
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
     * @param string $method HTTP method for the request
     * @param string $path relative URL to append to the root API endpoint
     * @param \GuzzleHttp\Query $query optional data to send along with request
     * @param bool $isAuthRequest optional flag to not pass the OAuth token with request
     *  because we do not have it yet
     * @return mixed
     */
    public function sendRequest($method, $path, $query = null, $isAuthRequest = false)
    {
        $guzzleClient = $this->getGuzzleClient();
        $request = $guzzleClient->createRequest($method, $path);
        $request->addHeaders(array(
            'Accept' => 'application/json',
            'Content-type' => 'application/json'
        ));
        if (!$isAuthRequest && isset($this->auth)) {
            $accessToken = $this->auth->getAccessToken();
            $request->addHeader('Authorization', "OAuth oauth_token={$accessToken}");
            $request->setPath("G2M/rest/{$path}");
        }
        if ($query != null) {
            $request->setQuery($query);
        }
        $response = $guzzleClient->send($request);
        return $response->json();
    }

}
