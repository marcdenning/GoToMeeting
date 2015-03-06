<?php
/**
 * Base TestCase class for a live service test.
 * @package \kenobi883\GoToMeeting
 */

namespace kenobi883\GoToMeeting;


use GuzzleHttp\Subscriber\Log\Formatter;
use GuzzleHttp\Subscriber\Log\LogSubscriber;
use kenobi883\GoToMeeting\Services\AuthService;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

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
        $logger = new Logger('Live Tests');
        $logger->pushHandler(new StreamHandler('./development.log', Logger::DEBUG));
        $client = new Client($liveCredentials['apiKey']);
        $client->getGuzzleClient()->getEmitter()->attach(new LogSubscriber($logger, Formatter::DEBUG));
        $authService = new AuthService($client);
        $auth = $authService->authenticate($liveCredentials['userId'], $liveCredentials['password']);
        $client->setAuth($auth);
        return $client;
    }
}