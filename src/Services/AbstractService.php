<?php
/**
 * Abstract service implementation.
 * @package kenobi883\GoToMeeting\Services
 */

namespace kenobi883\GoToMeeting\Services;

/**
 * Abstract service implementation. Additional services should extend this class.
 *
 * @package kenobi883\GoToMeeting\Services
 */
class AbstractService
{

    /**
     * @var string root URL for authorizing requests
     */
    protected $endpoint = '';

    /**
     * @var \kenobi883\GoToMeeting\Client
     */
    protected $client;

    /**
     * @var \kenobi883\GoToMeeting\Models\Auth
     */
    protected $auth;

    /**
     * Default constructor.
     *
     * @param \kenobi883\GoToMeeting\Client $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Send a request populated with appropriate headers.
     *
     * @param \GuzzleHttp\Message\Request $request
     * @return mixed JSON response data from request
     */
    protected function sendRequest($request)
    {
        $guzzleClient = $this->client->getGuzzleClient();
        $accessToken = $this->auth->getAccessToken();
        $request->addHeaders(array(
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
            'Authorization' => "Oauth oauth_token={$accessToken}"
        ));
        $response = $guzzleClient->send($request);
        return $response->json();
    }

}