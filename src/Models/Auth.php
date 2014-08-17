<?php
/**
 * Representation of an authorization response in the API.
 * @package kenobi883\GoToMeeting\Models
 */

namespace kenobi883\GoToMeeting\Models;

/**
 * Class Auth
 * @package kenobi883\GoToMeeting\Models
 */
class Auth implements \JsonSerializable
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var int
     */
    private $expiresIn;

    /**
     * @var string
     */
    private $refreshToken;

    /**
     * @var string
     */
    private $organizerKey;

    /**
     * @var string
     */
    private $accountKey;

    /**
     * @var string
     */
    private $accountType;

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


    public function __construct($response = array())
    {
        $this->parseFromJson($response);
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getAccountKey()
    {
        return $this->accountKey;
    }

    /**
     * @param string $accountKey
     */
    public function setAccountKey($accountKey)
    {
        $this->accountKey = $accountKey;
    }

    /**
     * @return string
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * @param string $accountType
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
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
     * @return int
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @param int $expiresIn
     */
    public function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;
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
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @param array $response decoded JSON response from auth request
     */
    public function parseFromJson($response)
    {
        if (isset($response['access_token'])) {
            $this->setAccessToken($response['access_token']);
        }
        if (isset($response['expires_in'])) {
            $this->setExpiresIn((int) $response['expires_in']);
        }
        if (isset($response['refresh_token'])) {
            $this->setRefreshToken($response['refresh_token']);
        }
        if (isset($response['organizer_key'])) {
            $this->setOrganizerKey($response['organizer_key']);
        }
        if (isset($response['account_key'])) {
            $this->setAccountKey($response['account_key']);
        }
        if (isset($response['account_type'])) {
            $this->setAccountType($response['account_type']);
        }
        if (isset($response['firstName'])) {
            $this->setFirstName($response['firstName']);
        }
        if (isset($response['lastName'])) {
            $this->setLastName($response['lastName']);
        }
        if (isset($response['email'])) {
            $this->setEmail($response['email']);
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
