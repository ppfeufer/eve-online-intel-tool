<?php
/**
 * PostCharactersCharacterIdMailLabelsLabel
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
 * PostCharactersCharacterIdMailLabelsLabel Class Doc Comment
 *
 * @category Class
 * @description label object
 * @package  WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class PostCharactersCharacterIdMailLabelsLabel implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'post_characters_character_id_mail_labels_label';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'name' => 'string',
        'color' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'name' => null,
        'color' => null
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
        'name' => 'name',
        'color' => 'color'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'name' => 'setName',
        'color' => 'setColor'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'name' => 'getName',
        'color' => 'getColor'
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

    const COLOR__0000FE = '#0000fe';
    const COLOR__006634 = '#006634';
    const COLOR__0099FF = '#0099ff';
    const COLOR__00FF33 = '#00ff33';
    const COLOR__01FFFF = '#01ffff';
    const COLOR__349800 = '#349800';
    const COLOR__660066 = '#660066';
    const COLOR__666666 = '#666666';
    const COLOR__999999 = '#999999';
    const COLOR__99FFFF = '#99ffff';
    const COLOR__9A0000 = '#9a0000';
    const COLOR_CCFF9A = '#ccff9a';
    const COLOR_E6E6E6 = '#e6e6e6';
    const COLOR_FE0000 = '#fe0000';
    const COLOR_FF6600 = '#ff6600';
    const COLOR_FFFF01 = '#ffff01';
    const COLOR_FFFFCD = '#ffffcd';
    const COLOR_FFFFFF = '#ffffff';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getColorAllowableValues()
    {
        return [
            self::COLOR__0000FE,
            self::COLOR__006634,
            self::COLOR__0099FF,
            self::COLOR__00FF33,
            self::COLOR__01FFFF,
            self::COLOR__349800,
            self::COLOR__660066,
            self::COLOR__666666,
            self::COLOR__999999,
            self::COLOR__99FFFF,
            self::COLOR__9A0000,
            self::COLOR_CCFF9A,
            self::COLOR_E6E6E6,
            self::COLOR_FE0000,
            self::COLOR_FF6600,
            self::COLOR_FFFF01,
            self::COLOR_FFFFCD,
            self::COLOR_FFFFFF,
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
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['color'] = isset($data['color']) ? $data['color'] : '#ffffff';
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['name'] === null) {
            $invalidProperties[] = "'name' can't be null";
        }
        if ((strlen($this->container['name']) > 40)) {
            $invalidProperties[] = "invalid value for 'name', the character length must be smaller than or equal to 40.";
        }

        if ((strlen($this->container['name']) < 1)) {
            $invalidProperties[] = "invalid value for 'name', the character length must be bigger than or equal to 1.";
        }

        $allowedValues = $this->getColorAllowableValues();
        if (!in_array($this->container['color'], $allowedValues)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'color', must be one of '%s'",
                implode("', '", $allowedValues)
            );
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

        if ($this->container['name'] === null) {
            return false;
        }
        if (strlen($this->container['name']) > 40) {
            return false;
        }
        if (strlen($this->container['name']) < 1) {
            return false;
        }
        $allowedValues = $this->getColorAllowableValues();
        if (!in_array($this->container['color'], $allowedValues)) {
            return false;
        }
        return true;
    }


    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string $name name string
     *
     * @return $this
     */
    public function setName($name)
    {
        if ((strlen($name) > 40)) {
            throw new \InvalidArgumentException('invalid length for $name when calling PostCharactersCharacterIdMailLabelsLabel., must be smaller than or equal to 40.');
        }
        if ((strlen($name) < 1)) {
            throw new \InvalidArgumentException('invalid length for $name when calling PostCharactersCharacterIdMailLabelsLabel., must be bigger than or equal to 1.');
        }

        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->container['color'];
    }

    /**
     * Sets color
     *
     * @param string $color Hexadecimal string representing label color, in RGB format
     *
     * @return $this
     */
    public function setColor($color)
    {
        $allowedValues = $this->getColorAllowableValues();
        if (!is_null($color) && !in_array($color, $allowedValues)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'color', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['color'] = $color;

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

