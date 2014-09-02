<?php
/**
 * Service test class for the meetings.
 * @package \kenobi883\GoToMeeting\Services
 */

namespace kenobi883\GoToMeeting\Services;


use Carbon\Carbon;
use kenobi883\GoToMeeting\Models\Meeting;

class MeetingServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider singleMeetingProvider
     */
    public function testGetMeeting($responseArray, $expectedMeeting)
    {
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->method('sendRequest')
            ->will($this->returnValue(array(
                $responseArray
            )));
        $meetingService = new MeetingService($client);
        $actualMeeting = $meetingService->getMeeting($responseArray['meetingId']);
        $this->assertNotNull($actualMeeting);
        $this->assertInstanceOf('\kenobi883\GoToMeeting\Models\Meeting', $actualMeeting);
        $this->assertEquals($actualMeeting, $expectedMeeting);
    }

    /**
     * @dataProvider singleMeetingProvider
     */
    public function testGetScheduledMeetings($responseArray, $expectedMeeting)
    {
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->method('sendRequest')
            ->will($this->returnValue(array(
                    $responseArray
            )));
        $client->expects($this->once())
            ->method('sendRequest')
            ->with($this->stringContains('GET', false),
                $this->stringContains('meetings'),
                $this->attributeEqualTo('data', array(
                    'scheduled' => 'true'
                )));
        $meetingService = new MeetingService($client);
        $meetings = $meetingService->getScheduledMeetings();
        $this->assertNotEmpty($meetings);
        $actualMeeting = $meetings[0];
        $this->assertNotNull($actualMeeting);
        $this->assertInstanceOf('\kenobi883\GoToMeeting\Models\Meeting', $actualMeeting);
        $this->assertEquals($expectedMeeting, $actualMeeting);
    }

    /**
     * @dataProvider singleMeetingProvider
     */
    public function testGetHistoricalMeetings($responseArray, $expectedMeeting)
    {
        $startDate = new \DateTime($responseArray['startTime']);
        $endDate = new \DateTime($responseArray['startTime']);
        $endDate->add(new \DateInterval('P1D'));
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->method('sendRequest')
            ->will($this->returnValue(array(
                $responseArray
            )));
        $client->expects($this->once())
            ->method('sendRequest')
            ->with($this->stringContains('GET', false),
                $this->stringContains('meetings'),
                $this->attributeEqualTo('data', array(
                    'history' => 'true',
                    'startDate' => $startDate->format(MeetingService::DATE_FORMAT_INPUT),
                    'endDate' => $endDate->format(MeetingService::DATE_FORMAT_INPUT)
                )));
        $meetingService = new MeetingService($client);
        $meetings = $meetingService->getHistoricalMeetings($startDate, $endDate);
        $this->assertNotEmpty($meetings);
        $actualMeeting = $meetings[0];
        $this->assertNotNull($actualMeeting);
        $this->assertInstanceOf('\kenobi883\GoToMeeting\Models\Meeting', $actualMeeting);
        $this->assertEquals($expectedMeeting, $actualMeeting);
    }

    /**
     * @dataProvider createMeetingProvider
     */
    public function testCreateMeeting($meeting, $responseArray)
    {
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->method('sendRequest')
            ->will($this->returnValue($responseArray));
        $client->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo('POST'));
        $meetingService = new MeetingService($client);
        $actualMeeting = $meetingService->createMeeting($meeting);
        $this->assertNotNull($actualMeeting);
        $this->assertInstanceOf('\kenobi883\GoToMeeting\Models\Meeting', $actualMeeting);
        $this->assertObjectHasAttribute('joinUrl', $actualMeeting);
    }

    public function testDeleteMeeting()
    {
        $meetingId = 123456;
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo('DELETE'));
        $meetingService = new MeetingService($client);
        $meetingService->deleteMeeting($meetingId);
    }

    /**
     * @dataProvider updateMeetingProvider
     */
    public function testUpdateMeeting($meeting)
    {
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->method('sendRequest');
        $client->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo('PUT'));
        $meetingService = new MeetingService($client);
        $meetingService->updateMeeting($meeting);
    }

    public function singleMeetingProvider()
    {
        $responseArray = array(
            'uniqueMeetingId' => 1230000000456789,
            'meetingId' => 123456789,
            'createTime' => '2012-06-25T22:10:46.+0000',
            'status' => 'INACTIVE',
            'subject' => 'test',
            'startTime' => '2012-12-01T09:00:00.+0000',
            'endTime' => '2012-12-01T10:00:00.+0000',
            'conferenceCallInfo' => 'Australia: +61 2 9037 1944\nCanada: +1 (647) 977-5956\nUnited Kingdom: +44 (0) 207 151 1850\nIreland: +353 (0) 15 290 180\nUnited States: +1 (773) 945-1031\nAccess Code: 111-952-374',
            'passwordRequired' => 'false',
            'meetingType' => 'scheduled',
            'maxParticipants' => 25
        );
        $expectedMeeting = new Meeting($responseArray);
        return array(
            array(
                $responseArray,
                $expectedMeeting
            )
        );
    }

    public function createMeetingProvider()
    {
        $meeting = new Meeting();
        $meeting->setSubject('test');
        $meeting->setStartTime(Carbon::now('UTC'));
        $meeting->setEndTime(Carbon::now('UTC')->addHour());
        $meeting->setPasswordRequired(false);
        $meeting->setConferenceCallInfo(Meeting::CONFERENCE_CALL_HYBRID);
        $meeting->setMeetingType(Meeting::TYPE_IMMEDIATE);
        $responseArray = array(
            array(
                'joinURL' => 'https://www3.gotomeeting.com/join/762836476',
                'maxParticipants' => 26,
                'uniqueMeetingId' => 200000000212521696,
                'conferenceCallInfo' => 'Australia: +61 2 8355 0000\nCanada: +1 (416) 900-1111\nUnited Kingdom: +44 (0) 203 535 0000\nIreland: +353 (0) 14 000 976\nUnited States: +1 (786) 358-0000\nAccess Code: 762-836-476',
                'meetingid' => 762836476
            )
        );
        return array(
            array(
                $meeting,
                $responseArray
            )
        );
    }

    public function updateMeetingProvider()
    {
        $meeting = new Meeting();
        $meeting->setSubject('test');
        $meeting->setStartTime(Carbon::now('UTC'));
        $meeting->setEndTime(Carbon::now('UTC')->addHour());
        $meeting->setPasswordRequired(false);
        $meeting->setConferenceCallInfo(Meeting::CONFERENCE_CALL_HYBRID);
        $meeting->setMeetingType(Meeting::TYPE_IMMEDIATE);
        return array(
            array(
                $meeting
            )
        );
    }
}
 