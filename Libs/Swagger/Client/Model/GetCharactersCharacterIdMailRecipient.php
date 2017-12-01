<?php
/**
 * GetCharactersCharacterIdMailRecipient
 *
 * PHP version 7
 *
 * @category Class
 * @package  WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * EVE Swagger Interface
 *
 * An OpenAPI for EVE Online
 *
 * OpenAPI spec version: 0.7.3
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\Model;

use \ArrayAccess;
use \WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\ObjectSerializer;

/**
 * GetCharactersCharacterIdMailRecipient Class Doc Comment
 *
 * @category Class
 * @description recipient object
 * @package  WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class GetCharactersCharacterIdMailRecipient implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'get_characters_character_id_mail_recipient';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'recipient_type' => 'string',
        'recipient_id' => 'int'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'recipient_type' => null,
        'recipient_id' => 'int32'
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'recipient_type' => 'recipient_type',
        'recipient_id' => 'recipient_id'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'recipient_type' => 'setRecipientType',
        'recipient_id' => 'setRecipientId'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'recipient_type' => 'getRecipientType',
        'recipient_id' => 'getRecipientId'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    const RECIPIENT_TYPE_ALLIANCE = 'alliance';
    const RECIPIENT_TYPE_CHARACTER = 'character';
    const RECIPIENT_TYPE_CORPORATION = 'corporation';
    const RECIPIENT_TYPE_MAILING_LIST = 'mailing_list';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getRecipientTypeAllowableValues()
    {
        return [
            self::RECIPIENT_TYPE_ALLIANCE,
            self::RECIPIENT_TYPE_CHARACTER,
            self::RECIPIENT_TYPE_CORPORATION,
            self::RECIPIENT_TYPE_MAILING_LIST,
        ];
    }
    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['recipient_type'] = isset($data['recipient_type']) ? $data['recipient_type'] : null;
        $this->container['recipient_id'] = isset($data['recipient_id']) ? $data['recipient_id'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['recipient_type'] === null) {
            $invalidProperties[] = "'recipient_type' can't be null";
        }
        $allowedValues = $this->getRecipientTypeAllowableValues();
        if (!in_array($this->container['recipient_type'], $allowedValues)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'recipient_type', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['recipient_id'] === null) {
            $invalidProperties[] = "'recipient_id' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        if ($this->container['recipient_type'] === null) {
            return false;
        }
        $allowedValues = $this->getRecipientTypeAllowableValues();
        if (!in_array($this->container['recipient_type'], $allowedValues)) {
            return false;
        }
        if ($this->container['recipient_id'] === null) {
            return false;
        }
        return true;
    }


    /**
     * Gets recipient_type
     *
     * @return string
     */
    public function getRecipientType()
    {
        return $this->container['recipient_type'];
    }

    /**
     * Sets recipient_type
     *
     * @param string $recipient_type recipient_type string
     *
     * @return $this
     */
    public function setRecipientType($recipient_type)
    {
        $allowedValues = $this->getRecipientTypeAllowableValues();
        if (!in_array($recipient_type, $allowedValues)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'recipient_type', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['recipient_type'] = $recipient_type;

        return $this;
    }

    /**
     * Gets recipient_id
     *
     * @return int
     */
    public function getRecipientId()
    {
        return $this->container['recipient_id'];
    }

    /**
     * Sets recipient_id
     *
     * @param int $recipient_id recipient_id integer
     *
     * @return $this
     */
    public function setRecipientId($recipient_id)
    {
        $this->container['recipient_id'] = $recipient_id;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


