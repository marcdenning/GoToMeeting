<?php
/**
 * Live test class for the auth service.
 * @package \kenobi883\GoToMeeting\Services\Live
 */

namespace kenobi883\GoToMeeting\Services\Live;


use kenobi883\GoToMeeting\Services\AuthService;

require_once(__DIR__ . '/../../LiveServiceTestCase.php');

class AuthServiceTest extends \kenobi883\GoToMeeting\LiveServiceTestCase
{
    /**
     * @var \kenobi883\GoToMeeting\Services\GroupService
     */
    protected $groupService;

    public function __construct()
    {
        parent::__construct();
        $this->liveCredentials = array(
            'apiKey' => '',
            'userId' => '',
            'password' => ''
        );
        if (strlen($this->liveCredentials['apiKey']) > 0) {
            $this->client = $this->configureLiveClient($this->liveCredentials);
        }
    }

    protected function setUp()
    {
        if (!isset($this->client)) {
            $this->markTestSkipped('Cannot run live test: No credentials available.');
        }
    }

    public function testAuthenticate()
    {
        $authService = new AuthService($this->client);
        $auth = $authService->authenticate($this->liveCredentials['userId'], $this->liveCredentials['password']);
        $this->assertInstanceOf('\kenobi883\GoToMeeting\Models\Auth', $auth);
    }
}
 