<?php
/**
 * Unit test class for the Meeting model.
 * @package kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;


use Carbon\Carbon;

class MeetingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider futureMeetingProvider
     */
    public function testParseFromJson($responseArray)
    {
        $meetingObject = new Meeting();
        $meetingObject->parseFromJson($responseArray);
        $this->assertThat($meetingObject, $this->attributeEqualTo('uniqueMeetingId', $responseArray['uniqueMeetingId']));
        $this->assertThat($meetingObject, $this->attributeEqualTo('meetingId', $responseArray['meetingId']));
        $this->assertThat($this->getObjectAttribute($meetingObject, 'createTime'), $this->isInstanceOf('DateTime'));
        $this->assertThat($meetingObject, $this->attributeEqualTo('status', $responseArray['status']));
        $this->assertThat($meetingObject, $this->attributeEqualTo('subject', $responseArray['subject']));
        $this->assertThat($this->getObjectAttribute($meetingObject, 'startTime'), $this->isInstanceOf('DateTime'));
        $this->assertThat($this->getObjectAttribute($meetingObject, 'endTime'), $this->isInstanceOf('DateTime'));
        $this->assertThat($meetingObject, $this->attributeEqualTo('conferenceCallInfo', $responseArray['conferenceCallInfo']));
        $this->assertThat($meetingObject, $this->attribute($this->isFalse(), 'passwordRequired'));
        $this->assertThat($meetingObject, $this->attributeEqualTo('meetingType', $responseArray['meetingType']));
        $this->assertThat($meetingObject, $this->attributeEqualTo('maxParticipants', $responseArray['maxParticipants']));
    }

    /**
     * @dataProvider historicalMeetingProvider
     */
    public function testParseFromJsonHistorical($responseArray)
    {
        $meetingObject = new Meeting();
        $meetingObject->parseFromJson($responseArray);
        $this->assertThat($meetingObject, $this->attributeEqualTo('uniqueMeetingId', $responseArray['uniqueMeetingId']));
        $this->assertThat($meetingObject, $this->attributeEqualTo('meetingId', $responseArray['meetingId']));
        $this->assertThat($meetingObject, $this->attributeEqualTo('subject', $responseArray['subject']));
        $this->assertThat($meetingObject, $this->attributeEqualTo('organizerKey', $responseArray['organizerkey']));
        $this->assertThat($meetingObject, $this->attributeEqualTo('meetingInstanceKey', $responseArray['meetingInstanceKey']));
        $this->assertThat($meetingObject, $this->attributeEqualTo('duration', $responseArray['duration']));
        $this->assertThat($meetingObject, $this->attributeEqualTo('numberOfAttendees', $responseArray['numAttendees']));
        $this->assertThat($this->getObjectAttribute($meetingObject, 'date'), $this->isInstanceOf('\DateTime'));
    }

    /**
     * @dataProvider futureMeetingProvider
     */
    public function testJsonSerialize($responseArray)
    {
        $meetingObject = new Meeting($responseArray);
        $meetingJson = $meetingObject->jsonSerialize();
        $this->assertArrayHasKey('uniqueMeetingId', $meetingJson);
        $this->assertArrayHasKey('meetingId', $meetingJson);
        $this->assertArrayHasKey('createTime', $meetingJson);
        $this->assertArrayHasKey('status', $meetingJson);
        $this->assertArrayHasKey('subject', $meetingJson);
        $this->assertArrayHasKey('startTime', $meetingJson);
        $this->assertArrayHasKey('endTime', $meetingJson);
        $this->assertArrayHasKey('conferenceCallInfo', $meetingJson);
        $this->assertArrayHasKey('passwordRequired', $meetingJson);
        $this->assertArrayHasKey('meetingType', $meetingJson);
        $this->assertArrayHasKey('maxParticipants', $meetingJson);
    }

    /**
     * @dataProvider futureMeetingProvider
     */
    public function testJsonEncode($responseArray)
    {
        $meetingObject = new Meeting($responseArray);
        $meetingJson = json_encode($meetingObject);
        $this->assertContains('subject', $meetingJson);
        $this->assertContains($meetingObject->getSubject(), $meetingJson);
    }

    /**
     * @dataProvider createMeetingProvider
     */
    public function testToArrayForApi($meeting, $jsonArray)
    {
        $actualJsonArray = $meeting->toArrayForApi();
        $this->assertEquals($jsonArray, $actualJsonArray);
    }

    /**
     * @dataProvider updateMeetingProvider
     */
    public function testToArrayForApiUpdate($meeting, $jsonArray)
    {
        $actualJsonArray = $meeting->toArrayForApi();
        $this->assertEquals($jsonArray, $actualJsonArray);
    }

    public function futureMeetingProvider()
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
        return array(
            array(
                $responseArray
            )
        );
    }

    public function historicalMeetingProvider()
    {
        $responseArray = array(
            'organizerkey' => '123456',
            'meetingInstanceKey' => 300000000001087884,
            'meetingId' => 340974607,
            'uniqueMeetingId' => 300000000001110778,
            'subject' => 'Meet Now',
            'date' => '2012-06-13T12:48:13.+0000',
            'duration' => 60,
            'numAttendees' => 2
        );
        return array(
            array(
                $responseArray
            )
        );
    }

    public function createMeetingProvider()
    {
        $jsonArray = array(
            'subject' => 'test',
            'starttime' => '2011-12-01T09:00:00Z',
            'endtime' => '2012-11-01T10:00:00Z',
            'passwordrequired' => 'false',
            'conferencecallinfo' => 'Hybrid',
            'timezonekey' => '',
            'meetingtype' => 'Scheduled'
        );
        $meeting = new Meeting();
        $meeting->setSubject($jsonArray['subject']);
        $meeting->setStartTime(new Carbon($jsonArray['starttime']));
        $meeting->setEndTime(new Carbon($jsonArray['endtime']));
        $meeting->setPasswordRequired(false);
        $meeting->setConferenceCallInfo($jsonArray['conferencecallinfo']);
        $meeting->setMeetingType($jsonArray['meetingtype']);
        return array(
            array(
                $meeting,
                $jsonArray
            )
        );
    }

    public function updateMeetingProvider()
    {
        $jsonArray = array(
            'subject' => 'test',
            'starttime' => '2011-12-01T09:00:00Z',
            'endtime' => '2012-11-01T10:00:00Z',
            'passwordrequired' => 'false',
            'conferencecallinfo' => 'Hybrid',
            'timezonekey' => '',
            'meetingtype' => 'Scheduled',
        );
        $meeting = new Meeting();
        $meeting->setSubject($jsonArray['subject']);
        $meeting->setStartTime(new Carbon($jsonArray['starttime']));
        $meeting->setEndTime(new Carbon($jsonArray['endtime']));
        $meeting->setPasswordRequired(false);
        $meeting->setConferenceCallInfo($jsonArray['conferencecallinfo']);
        $meeting->setMeetingType($jsonArray['meetingtype']);
        $recurringJsonArray = array(
            'subject' => 'test',
            'starttime' => '2011-12-01T09:00:00Z',
            'endtime' => '2012-11-01T10:00:00Z',
            'passwordrequired' => 'false',
            'conferencecallinfo' => 'Hybrid',
            'timezonekey' => '',
            'meetingtype' => 'Recurring',
            'uniquemeetinginstance' => 1230000000456789
        );
        $recurringMeeting = new Meeting();
        $recurringMeeting->setSubject($recurringJsonArray['subject']);
        $recurringMeeting->setStartTime(new Carbon($recurringJsonArray['starttime']));
        $recurringMeeting->setEndTime(new Carbon($recurringJsonArray['endtime']));
        $recurringMeeting->setPasswordRequired(false);
        $recurringMeeting->setConferenceCallInfo($recurringJsonArray['conferencecallinfo']);
        $recurringMeeting->setMeetingType($recurringJsonArray['meetingtype']);
        $recurringMeeting->setUniqueMeetingId($recurringJsonArray['uniquemeetinginstance']);
        return array(
            array(
                $meeting,
                $jsonArray
            ),
            array(
                $recurringMeeting,
                $recurringJsonArray
            )
        );
    }
}
 