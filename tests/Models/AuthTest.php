<?php
/**
 * Auth model test class
 * @package \kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;


class AuthTest extends \PHPUnit_Framework_TestCase
{
    public function testParseFromJson()
    {
        $responseArray = array(
            'access_token' => '3645136ef45675a113adb18027dd7df8',
            'expires_in' => '30758399',
            'refresh_token' => '1dd48bf4aa453162521250d772a03ae6',
            'organizer_key' => '300000000000384444',
            'account_key' => '300000000000329487',
            'account_type' => 'corporate',
            'firstName' => 'Test',
            'lastName' => 'Test',
            'email' => 'test@test.com'
        );
        $authObject = new Auth();
        $authObject->parseFromJson($responseArray);
        $this->assertThat($authObject, $this->attributeEqualTo('accessToken', $responseArray['access_token']));
        $this->assertThat($authObject, $this->attributeEqualTo('expiresIn', $responseArray['expires_in']));
        $this->assertThat($authObject, $this->attributeEqualTo('refreshToken', $responseArray['refresh_token']));
        $this->assertThat($authObject, $this->attributeEqualTo('organizerKey', $responseArray['organizer_key']));
        $this->assertThat($authObject, $this->attributeEqualTo('accountKey', $responseArray['account_key']));
        $this->assertThat($authObject, $this->attributeEqualTo('accountType', $responseArray['account_type']));
        $this->assertThat($authObject, $this->attributeEqualTo('firstName', $responseArray['firstName']));
        $this->assertThat($authObject, $this->attributeEqualTo('lastName', $responseArray['lastName']));
        $this->assertThat($authObject, $this->attributeEqualTo('email', $responseArray['email']));
    }
}
