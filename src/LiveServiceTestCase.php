<?php
/**
 * Base TestCase class for a live service test.
 * @package \kenobi883\GoToMeeting
 */

namespace kenobi883\GoToMeeting;


use kenobi883\GoToMeeting\Services\AuthService;

abstract class LiveServiceTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \kenobi883\GoToMeeting\Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $liveCredentials = array(
        'apiKey' => '',
        'userId' => '',
        'password' => ''
    );

    public function __construct()
    {
        parent::__construct();
        if (strlen($this->liveCredentials['apiKey']) > 0) {
            $this->client = new Client($this->liveCredentials['apiKey']);
            $authService = new AuthService($this->client);
            $auth = $authService->authenticate($this->liveCredentials['userId'], $this->liveCredentials['password']);
            $this->client->setAuth($auth);
        }
    }

    protected function setUp()
    {
        if (!isset($this->client)) {
            $this->markTestSkipped('Cannot run live test: No credentials available.');
        }
    }
}