<?php
/**
 * Representation of a meeting in the API.
 * @package kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;
use kenobi883\GoToMeeting\Services\MeetingService;

/**
 * Class Meeting
 *
 * @package kenobi883\GoToMeeting\Models
 */
class Meeting implements \JsonSerializable
{
    const TYPE_IMMEDIATE = 'Immediate';
    const TYPE_SCHEDULED = 'Scheduled';
    const TYPE_RECURRING = 'Recurring';

    const CONFERENCE_CALL_PSTN = 'PSTN';
    const CONFERENCE_CALL_FREE = 'Free';
    const CONFERENCE_CALL_HYBRID = 'Hybrid';
    const CONFERENCE_CALL_PRIVATE = 'Private';
    const CONFERENCE_CALL_VOIP = 'VoIP';

    /**
     * @var int
     */
    private $uniqueMeetingId;

    /**
     * @var int
     */
    private $meetingId;

    /**
     * @var \DateTime
     */
    private $createTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var \DateTime
     */
    private $startTime;

    /**
     * @var \DateTime
     */
    private $endTime;

    /**
     * @var string
     */
    private $conferenceCallInfo;

    /**
     * @var bool
     */
    private $passwordRequired;

    /**
     * @var string
     */
    private $meetingType;

    /**
     * @var int
     */
    private $maxParticipants;

    /**
     * @var int
     */
    private $duration;

    /**
     * @var int
     */
    private $numberOfAttendees;

    /**
     * @var int
     */
    private $organizerKey;

    /**
     * @var int
     */
    private $meetingInstanceKey;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $joinUrl;

    /**
     * Constructor for a meeting.
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
    public function getConferenceCallInfo()
    {
        return $this->conferenceCallInfo;
    }

    /**
     * @param string $conferenceCallInfo
     */
    public function setConferenceCallInfo($conferenceCallInfo)
    {
        $this->conferenceCallInfo = $conferenceCallInfo;
    }

    /**
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @param \DateTime $createTime
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * @return int
     */
    public function getMaxParticipants()
    {
        return $this->maxParticipants;
    }

    /**
     * @param int $maxParticipants
     */
    public function setMaxParticipants($maxParticipants)
    {
        $this->maxParticipants = $maxParticipants;
    }

    /**
     * @return int
     */
    public function getMeetingId()
    {
        return $this->meetingId;
    }

    /**
     * @param int $meetingId
     */
    public function setMeetingId($meetingId)
    {
        $this->meetingId = $meetingId;
    }

    /**
     * @return string
     */
    public function getMeetingType()
    {
        return $this->meetingType;
    }

    /**
     * @param string $meetingType
     */
    public function setMeetingType($meetingType)
    {
        $this->meetingType = $meetingType;
    }

    /**
     * @return boolean
     */
    public function getPasswordRequired()
    {
        return $this->passwordRequired;
    }

    /**
     * @param boolean $passwordRequired
     */
    public function setPasswordRequired($passwordRequired)
    {
        $this->passwordRequired = $passwordRequired;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
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
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return int
     */
    public function getUniqueMeetingId()
    {
        return $this->uniqueMeetingId;
    }

    /**
     * @param int $uniqueMeetingId
     */
    public function setUniqueMeetingId($uniqueMeetingId)
    {
        $this->uniqueMeetingId = $uniqueMeetingId;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getNumberOfAttendees()
    {
        return $this->numberOfAttendees;
    }

    /**
     * @param int $numberOfAttendees
     */
    public function setNumberOfAttendees($numberOfAttendees)
    {
        $this->numberOfAttendees = $numberOfAttendees;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getMeetingInstanceKey()
    {
        return $this->meetingInstanceKey;
    }

    /**
     * @param int $meetingInstanceKey
     */
    public function setMeetingInstanceKey($meetingInstanceKey)
    {
        $this->meetingInstanceKey = $meetingInstanceKey;
    }

    /**
     * @return int
     */
    public function getOrganizerKey()
    {
        return $this->organizerKey;
    }

    /**
     * @param int $organizerKey
     */
    public function setOrganizerKey($organizerKey)
    {
        $this->organizerKey = $organizerKey;
    }

    /**
     * @return string
     */
    public function getJoinUrl()
    {
        return $this->joinUrl;
    }

    /**
     * @param string $joinUrl
     */
    public function setJoinUrl($joinUrl)
    {
        $this->joinUrl = $joinUrl;
    }

    /**
     * Parse each known property into the model from an array of values.
     *
     * @param array $response
     */
    public function parseFromJson($response)
    {
        if (isset($response['uniqueMeetingId'])) {
            $this->setUniqueMeetingId((int) $response['uniqueMeetingId']);
        }
        if (isset($response['meetingId'])) {
            $this->setMeetingId((int) $response['meetingId']);
        }
        if (isset($response['meetingid'])) {
            $this->setMeetingId((int) $response['meetingid']);
        }
        if (isset($response['createTime'])) {
            $this->setCreateTime(new \DateTime($response['createTime']));
        }
        if (isset($response['status'])) {
            $this->setStatus($response['status']);
        }
        if (isset($response['subject'])) {
            $this->setSubject($response['subject']);
        }
        if (isset($response['startTime'])) {
            $this->setStartTime(new \DateTime($response['startTime']));
        }
        if (isset($response['endTime'])) {
            $this->setEndTime(new \DateTime($response['endTime']));
        }
        if (isset($response['conferenceCallInfo'])) {
            $this->setConferenceCallInfo($response['conferenceCallInfo']);
        }
        if (isset($response['passwordRequired'])) {
            $this->setPasswordRequired($response['passwordRequired'] == 'true');
        }
        if (isset($response['meetingType'])) {
            $this->setMeetingType($response['meetingType']);
        }
        if (isset($response['maxParticipants'])) {
            $this->setMaxParticipants((int) $response['maxParticipants']);
        }
        if (isset($response['numAttendees'])) {
            $this->setNumberOfAttendees((int) $response['numAttendees']);
        }
        if (isset($response['duration'])) {
            $this->setDuration((int) $response['duration']);
        }
        if (isset($response['organizerkey'])) {
            $this->setOrganizerKey((int) $response['organizerkey']);
        }
        if (isset($response['meetingInstanceKey'])) {
            $this->setMeetingInstanceKey((int) $response['meetingInstanceKey']);
        }
        if (isset($response['date'])) {
            $this->setDate(new \DateTime($response['date']));
        }
        if (isset($response['joinURL'])) {
            $this->setJoinUrl($response['joinURL']);
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

    /**
     * Construct a representation specific for passing *into* the API and encode as JSON.
     *
     * @return array value of the meeting for sending to the API
     */
    public function toArrayForApi()
    {
        $meetingArray = array();
        $meetingArray['subject'] = $this->getSubject();
        $meetingArray['starttime'] = $this->getStartTime()->format(MeetingService::DATE_FORMAT_INPUT);
        $meetingArray['endtime'] = $this->getEndTime()->format(MeetingService::DATE_FORMAT_INPUT);
        $meetingArray['passwordrequired'] = $this->getPasswordRequired() ? 'true' : 'false';
        $meetingArray['conferencecallinfo'] = $this->getConferenceCallInfo();
        $meetingArray['timezonekey'] = ''; // Deprecated API parameter, but required to be provided as blank string
        $meetingArray['meetingtype'] = $this->getMeetingType();
        return $meetingArray;
    }
}
