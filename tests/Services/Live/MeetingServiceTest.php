<?php
/**
 * Test class for the MeetingService.
 * @package \kenobi883\GoToMeeting\Services\Live
 */

namespace kenobi883\GoToMeeting\Services\Live;

use Carbon\Carbon;
use kenobi883\GoToMeeting\Models\Meeting;
use kenobi883\GoToMeeting\Services\MeetingService;

require_once(__DIR__ . '/../../LiveServiceTestCase.php');

class MeetingServiceTest extends \kenobi883\GoToMeeting\LiveServiceTestCase
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
        $this->assertAttributeNotEmpty('meetingId', $actualMeeting);
        $this->assertAttributeInstanceOf('\DateTime', 'startTime', $actualMeeting);
        $startTime = Carbon::createFromTimestampUTC($actualMeeting->getStartTime()->getTimestamp());
        $this->assertTrue($startTime->between(Carbon::now('UTC')->subYear(), Carbon::now('UTC')->addYear()));
        $this->assertAttributeInstanceOf('\DateTime', 'endTime', $actualMeeting);
        $endTime = Carbon::createFromTimestampUTC($actualMeeting->getEndTime()->getTimestamp());
        $this->assertTrue($endTime->between(Carbon::now('UTC')->subYear(), Carbon::now('UTC')->addYear()));
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

    public function testCreateMeeting()
    {
        $meeting = new Meeting();
        $meeting->setSubject('test');
        $meeting->setStartTime(Carbon::now('UTC')->addHour());
        $meeting->setEndTime(Carbon::now('UTC')->addHours(2));
        $meeting->setPasswordRequired(false);
        $meeting->setConferenceCallInfo(Meeting::CONFERENCE_CALL_HYBRID);
        $meeting->setMeetingType(Meeting::TYPE_IMMEDIATE);
        $actualMeeting = $this->meetingService->createMeeting($meeting);
        $this->assertNotNull($actualMeeting);
        $this->assertInstanceOf('\kenobi883\GoToMeeting\Models\Meeting', $actualMeeting);
        $this->assertObjectHasAttribute('joinUrl', $actualMeeting);
        $this->assertAttributeNotEmpty('joinUrl', $actualMeeting);
        $this->assertObjectHasAttribute('meetingId', $actualMeeting);
        $this->assertAttributeNotEmpty('meetingId', $actualMeeting);
        return $actualMeeting;
    }

    /**
     * @depends testCreateMeeting
     */
    public function testUpdateMeeting(Meeting $meeting)
    {
        $modifiedSubject = 'test modified';
        $meeting->setSubject($modifiedSubject);
        $meeting->setConferenceCallInfo(Meeting::CONFERENCE_CALL_HYBRID);
        $this->meetingService->updateMeeting($meeting);
        $actualMeeting = $this->meetingService->getMeeting($meeting->getMeetingId());
        $this->assertAttributeContains($modifiedSubject, 'subject', $actualMeeting);
        return $meeting;
    }

    /**
     * @depends testCreateMeeting
     */
    public function testStartMeeting(Meeting $meeting)
    {
        $meetingId = $meeting->getMeetingId();
        $hostURL = $this->meetingService->startMeeting($meetingId);
        $this->assertContains($meetingId, $hostURL);
    }

    /**
     * @depends testUpdateMeeting
     */
    public function testDeleteMeeting(Meeting $meeting)
    {
        $meetingId = $meeting->getMeetingId();
        $this->meetingService->deleteMeeting($meetingId);
        $this->setExpectedException('\GuzzleHttp\Exception\ClientException');
        $this->meetingService->getMeeting($meetingId);
    }

    public function createMeetingProvider()
    {
        $meeting = new Meeting();
        $meeting->setSubject('test');
        $meeting->setStartTime(Carbon::now('UTC'));
        $meeting->setEndTime(Carbon::now('UTC')->addHour());
        $meeting->setPasswordRequired(false);
        $meeting->setConferenceCallInfo(Meeting::CONFERENCE_CALL_HYBRID);
        $meeting->setMeetingType(Meeting::TYPE_SCHEDULED);
        return array(
            array(
                $meeting
            )
        );
    }
}
 