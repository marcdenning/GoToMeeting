<?php
/**
 * Meeting service class.
 * @package kenobi883\GoToMeeting
 */

namespace kenobi883\GoToMeeting\Services;
use \GuzzleHttp\Client;
use GuzzleHttp\Query;
use kenobi883\GoToMeeting\Models\Auth;
use kenobi883\GoToMeeting\Models\Meeting;

/**
 * Class MeetingService provides access to meeting API methods.
 *
 * @package kenobi883\GoToMeeting
 */
class MeetingService {

    /**
     * @var string root URL for the GoToMeeting API
     */
    private $apiEndpoint = 'https://api.citrixonline.com/G2M/rest/';

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var \kenobi883\GoToMeeting\Models\Auth
     */
    private $auth;

    /**
     * Default constructor to build and configure the guzzleClient.
     */
    public function __construct()
    {
        $this->client = new Client(array(
            'base_url' => $this->apiEndpoint
        ));
    }

    /**
     * @return Auth
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param Auth $auth
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
    }

    /**
     * Retrieve a specific meeting from the API.
     *
     * @param int $meetingId meeting to retrieve
     * @return \kenobi883\GoToMeeting\Models\Meeting
     */
    public function getMeeting($meetingId)
    {
        $request = $this->client->createRequest('GET', "meetings/{$meetingId}");
        $jsonBody = $this->sendRequest($request);
        $meeting = new Meeting($jsonBody[0]);
        return $meeting;
    }

    /**
     * Retrieve a set of meetings.
     *
     * Retrieve all future meetings using $scheduled. To retrieve historical meetings, specify $history
     * and $startDate and $endDate.
     *
     * @param bool $scheduled get all future meetings
     * @param bool $history get past meetings, must also provide $startDate and $endDate
     * @param \DateTime $startDate optional unless $history is true
     * @param \DateTime $endDate optional unless $history is true
     * @throws \Exception if history is true but start and end dates are not provided, throw an exception
     * @return array parsed Meeting objects
     */
    public function getMeetings($scheduled = true, $history = false, $startDate = null, $endDate = null)
    {
        // Create and build API request
        $request = $this->client->createRequest('GET', 'meetings');
        $query = new Query();

        // Set up parameters for request
        if ($history && ($startDate === null || $endDate === null))
        {
            throw new \Exception('To retrieve historical meetings, startDate and endDate must be specified.');
        }

        // Adjust start and end dates to the UTC timezone if provided
        $utcTimeZone = new \DateTimeZone('UTC');
        if ($startDate !== null)
        {
            $startDate->setTimezone($utcTimeZone);
            $query->add('startDate', $startDate->format(\DateTime::ISO8601));
        }
        if ($endDate !== null)
        {
            $endDate->setTimezone($utcTimeZone);
            $query->add('endDate', $endDate->format(\DateTime::ISO8601));
        }

        // Interpret scheduled and history parameters as strings for attaching to request
        $query->add('scheduled', $scheduled ? 'true' : 'false');
        $query->add('history', $history ? 'true' : 'false');

        // Send request
        $jsonBody = $this->sendRequest($request);

        // Parse each meeting result
        $meetings = array();
        foreach ($jsonBody as $oneMeeting)
        {
            $meeting = new Meeting($oneMeeting);
            $meetings[] = $meeting;
        }
        return $meetings;
    }

    /**
     * Send a request populated with appropriate headers.
     *
     * @param \GuzzleHttp\Message\Request $request
     * @return mixed JSON response data from request
     */
    protected function sendRequest($request)
    {
        $request->addHeaders(array(
            'Accept' => 'application/json',
            'Content-type' => 'application/json',
            'Authorization' => "Oauth oauth_token={$this->auth->getAccessToken()}"
        ));
        $response = $this->client->send($request);
        return $response->json();
    }

}