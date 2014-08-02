<?php
/**
 * Test class for the GroupService.
 * @package \kenobi883\GoToMeeting\Services
 */

namespace kenobi883\GoToMeeting\Services;

use \kenobi883\GoToMeeting\Models\Group;

class GroupServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetGroups()
    {
        $responseArray = array(
            'groupkey' => 300000000000011,
            'parentKey' => 300000000000011,
            'groupName' => 'Something 1, Inc.',
            'status' => 'active',
            'numOrganizers' => 7
        );
        $expectedGroup = new Group($responseArray);
        $client = $this->getMockBuilder('Client')
            ->setMethods(array(
                'sendRequest'
            ))
            ->getMock();
        $client->method('sendRequest')
            ->will($this->returnValue(array(
                $responseArray
            )));
        $groupService = new GroupService($client);
        $actualGroups = $groupService->getGroups();
        $this->assertNotEmpty($actualGroups);
        $this->assertNotNull($actualGroups[0]);
        $this->assertEquals($actualGroups[0], $expectedGroup);
    }
}
 