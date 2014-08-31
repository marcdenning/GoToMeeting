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

    protected function setUp()
    {
        if (!isset($this->client)) {
            $this->markTestSkipped('Cannot run live test: No credentials available.');
        }
    }

    protected function configureLiveClient($liveCredentials)
    {
        $client = new Client($liveCredentials['apiKey']);
        $authService = new AuthService($client);
        $auth = $authService->authenticate($liveCredentials['userId'], $liveCredentials['password']);
        $client->setAuth($auth);
        return $client;
    }
}