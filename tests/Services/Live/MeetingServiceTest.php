<?php
/**
 * Test class for the MeetingService.
 * @package \kenobi883\GoToMeeting\Services\Live
 */

namespace kenobi883\GoToMeeting\Services\Live;

use Carbon\Carbon;
use kenobi883\GoToMeeting\LiveServiceTestCase;
use kenobi883\GoToMeeting\Services\MeetingService;

class MeetingServiceTest extends LiveServiceTestCase
{
    /**
     * @var \kenobi883\GoToMeeting\Services\MeetingService
     */
    protected $meetingService;

    public function __construct()
    {
        parent::__construct();
        $liveCredentials = array(
            'apiKey' => '',
            'userId' => '',
            'password' => ''
        );
        if (strlen($liveCredentials['apiKey']) > 0) {
            $this->client = $this->configureLiveClient($liveCredentials);
            $this->meetingService = new MeetingService($this->client);
        }
    }

    public function testGetScheduledMeetings()
    {
        $meetings = $this->meetingService->getScheduledMeetings();
        $this->assertNotEmpty($meetings);
        $actualMeeting = $meetings[0];
        $this->assertInstanceOf('\kenobi883\GoToMeeting\Models\Meeting', $actualMeeting);
        $this->assertAttributeContains('scheduled', 'meetingType', $actualMeeting, null, true);
    }

    public function testGetHistoricalMeetings()
    {
        $startDate = Carbon::now('UTC');
        $startDate->subMonth();
        $endDate = Carbon::now('UTC');
        $meetings = $this->meetingService->getHistoricalMeetings($startDate, $endDate);
        $this->assertNotEmpty($meetings);
        $actualMeeting = $meetings[0];
        $this->assertNotNull($actualMeeting);
        $this->assertInstanceOf('\kenobi883\GoToMeeting\Models\Meeting', $actualMeeting);
        $actualDate = Carbon::instance($actualMeeting->getDate());
        $this->assertTrue($actualDate->between($startDate, $endDate));
    }
}
 