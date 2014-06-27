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
class Client {

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

} 