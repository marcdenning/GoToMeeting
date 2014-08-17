<?php
/**
 * Representation of an organizer in the API.
 * @package kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;

/**
 * Class Organizer
 * @package kenobi883\GoToMeeting\Models
 */
class Organizer implements \JsonSerializable
{
    /**
     * @var string
     */
    private $organizerKey;

    /**
     * @var string
     */
    private $groupKey;

    /**
     * @var string
     */
    private $email;

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
    private $groupName;

    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $maximumAttendeesAllowed;

    /**
     * Default constructor. Parse provided response from JSON.
     *
     * @param array $response optional parameter to pass in initial values (as if from a JSON response)
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
    public function getGroupKey()
    {
        return $this->groupKey;
    }

    /**
     * @param string $groupKey
     */
    public function setGroupKey($groupKey)
    {
        $this->groupKey = $groupKey;
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
     * @return int
     */
    public function getMaximumAttendeesAllowed()
    {
        return $this->maximumAttendeesAllowed;
    }

    /**
     * @param int $maximumAttendeesAllowed
     */
    public function setMaximumAttendeesAllowed($maximumAttendeesAllowed)
    {
        $this->maximumAttendeesAllowed = $maximumAttendeesAllowed;
    }

    /**
     * @return string
     */
    public function getOrganizerKey()
    {
        return $this->organizerKey;
    }

    /**
     * @param string $organizerKey
     */
    public function setOrganizerKey($organizerKey)
    {
        $this->organizerKey = $organizerKey;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Parse each known property into the model from an array of values.
     *
     * @param array $response values from JSON representation of object
     */
    public function parseFromJson($response)
    {
        if (isset($response['organizerkey'])) {
            $this->setOrganizerKey($response['organizerkey']);
        }
        if (isset($response['groupkey'])) {
            $this->setGroupKey($response['groupkey']);
        }
        if (isset($response['email'])) {
            $this->setEmail($response['email']);
        }
        if (isset($response['firstname'])) {
            $this->setFirstName($response['firstname']);
        }
        if (isset($response['lastname'])) {
            $this->setLastName($response['lastname']);
        }
        if (isset($response['groupname'])) {
            $this->setGroupName($response['groupname']);
        }
        if (isset($response['status'])) {
            $this->setStatus($response['status']);
        }
        if (isset($response['maxnumattendeesallowed'])) {
            $this->setMaximumAttendeesAllowed($response['maxnumattendeesallowed']);
        }
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
