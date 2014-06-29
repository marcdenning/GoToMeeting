<?php
/**
 * Unit test class for Organizer model.
 * @package kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;


class OrganizerTest extends \PHPUnit_Framework_TestCase
{
    public function testParseFromJson()
    {
        $responseArray = array(
            'organizerkey' => 123456,
            'groupkey' => 789,
            'email' => 'test@test.com',
            'firstname' => 'Test',
            'lastname' => 'Test',
            'groupname' => 'testgroup',
            'status' => 'active',
            'maxnumattendeesallowed' => 25
        );
        $organizerObject = new Organizer();
        $organizerObject->parseFromJson($responseArray);
        $this->assertThat($organizerObject, $this->attributeEqualTo('organizerKey', $responseArray['organizerkey']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('groupKey', $responseArray['groupkey']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('email', $responseArray['email']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('firstName', $responseArray['firstname']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('lastName', $responseArray['lastname']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('groupName', $responseArray['groupname']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('status', $responseArray['status']));
        $this->assertThat($organizerObject, $this->attributeEqualTo('maximumAttendeesAllowed', $responseArray['maxnumattendeesallowed']));
    }
}
 