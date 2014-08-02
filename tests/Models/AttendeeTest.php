<?php
/**
 * Unit test class for Attendee model.
 * @package kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;


class AttendeeTest extends \PHPUnit_Framework_TestCase
{
    public function testParseFromJson()
    {
        $responseArray = array(
            'firstName' => 'Deepak',
            'lastName' => 'George',
            'email' => 'deepak@somewhere.com',
            'groupName' => 'Some Group, Inc.'
        );
        $attendeeObject = new Attendee();
        $attendeeObject->parseFromJson($responseArray);
        $this->assertThat($attendeeObject, $this->attributeEqualTo('firstName', $responseArray['firstName']));
        $this->assertThat($attendeeObject, $this->attributeEqualTo('lastName', $responseArray['lastName']));
        $this->assertThat($attendeeObject, $this->attributeEqualTo('email', $responseArray['email']));
        $this->assertThat($attendeeObject, $this->attributeEqualTo('groupName', $responseArray['groupName']));
    }
}
 