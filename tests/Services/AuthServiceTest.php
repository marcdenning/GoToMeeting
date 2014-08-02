<?php
/**
 * Test class for the Authentication service
 * @package \kenobi883\GoToMeeting\Services
 */

namespace kenobi883\GoToMeeting\Services;

use \kenobi883\GoToMeeting\Models\Auth;

class AuthServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testAuthenticateSuccess()
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
        $expectedAuth = new Auth($responseArray);
        $clientMock = $this->getMock('Client', array(
            'sendRequest',
            'getApiKey'
        ));
        $clientMock->method('sendRequest')
            ->will($this->returnValue($responseArray));
        $clientMock->method('getApiKey')
            ->will($this->returnValue('1234567890'));
        $authService = new AuthService($clientMock);
        $actualAuth = $authService->authenticate('test@test.com', 'abc123');
        $this->assertNotNull($actualAuth);
        $this->assertEquals($expectedAuth, $actualAuth);
    }
}
 