<?php
/**
 * Representation of an attendee in the API.
 * @package kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;

/**
 * Class Attendee
 *
 * @package kenobi883\GoToMeeting\Models
 */
class Attendee
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $groupName;

    /**
     * Constructor for an attendee.
     *
     * @param array $response optional response body data to populate model
     */
    public function __construct($response = array())
    {
        $this->parseFromJson($response);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Parse each known property into the model from an array of values.
     *
     * @param array $response
     */
    public function parseFromJson($response)
    {
        if (isset($response['firstName'])) {
            $this->setFirstName($response['firstName']);
        }
        if (isset($response['lastName'])) {
            $this->setLastName($response['lastName']);
        }
        if (isset($response['email'])) {
            $this->setEmail($response['email']);
        }
        if (isset($response['groupName'])) {
            $this->setGroupName($response['groupName']);
        }
    }
}
