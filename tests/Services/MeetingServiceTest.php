<?php
/**
 * Service test class for the meetings.
 * @package \kenobi883\GoToMeeting\Services
 */

namespace kenobi883\GoToMeeting\Services;


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
}
 