<?php
/**
 * GetCharactersCharacterIdMedalsGraphic
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
 * GetCharactersCharacterIdMedalsGraphic Class Doc Comment
 *
 * @category Class
 * @description graphic object
 * @package  WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class GetCharactersCharacterIdMedalsGraphic implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'get_characters_character_id_medals_graphic';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'part' => 'int',
        'layer' => 'int',
        'graphic' => 'string',
        'color' => 'int'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'part' => 'int32',
        'layer' => 'int32',
        'graphic' => null,
        'color' => 'int32'
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
        'part' => 'part',
        'layer' => 'layer',
        'graphic' => 'graphic',
        'color' => 'color'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'part' => 'setPart',
        'layer' => 'setLayer',
        'graphic' => 'setGraphic',
        'color' => 'setColor'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'part' => 'getPart',
        'layer' => 'getLayer',
        'graphic' => 'getGraphic',
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
        $this->container['part'] = isset($data['part']) ? $data['part'] : null;
        $this->container['layer'] = isset($data['layer']) ? $data['layer'] : null;
        $this->container['graphic'] = isset($data['graphic']) ? $data['graphic'] : null;
        $this->container['color'] = isset($data['color']) ? $data['color'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['part'] === null) {
            $invalidProperties[] = "'part' can't be null";
        }
        if ($this->container['layer'] === null) {
            $invalidProperties[] = "'layer' can't be null";
        }
        if ($this->container['graphic'] === null) {
            $invalidProperties[] = "'graphic' can't be null";
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

        if ($this->container['part'] === null) {
            return false;
        }
        if ($this->container['layer'] === null) {
            return false;
        }
        if ($this->container['graphic'] === null) {
            return false;
        }
        return true;
    }


    /**
     * Gets part
     *
     * @return int
     */
    public function getPart()
    {
        return $this->container['part'];
    }

    /**
     * Sets part
     *
     * @param int $part part integer
     *
     * @return $this
     */
    public function setPart($part)
    {
        $this->container['part'] = $part;

        return $this;
    }

    /**
     * Gets layer
     *
     * @return int
     */
    public function getLayer()
    {
        return $this->container['layer'];
    }

    /**
     * Sets layer
     *
     * @param int $layer layer integer
     *
     * @return $this
     */
    public function setLayer($layer)
    {
        $this->container['layer'] = $layer;

        return $this;
    }

    /**
     * Gets graphic
     *
     * @return string
     */
    public function getGraphic()
    {
        return $this->container['graphic'];
    }

    /**
     * Sets graphic
     *
     * @param string $graphic graphic string
     *
     * @return $this
     */
    public function setGraphic($graphic)
    {
        $this->container['graphic'] = $graphic;

        return $this;
    }

    /**
     * Gets color
     *
     * @return int
     */
    public function getColor()
    {
        return $this->container['color'];
    }

    /**
     * Sets color
     *
     * @param int $color color integer
     *
     * @return $this
     */
    public function setColor($color)
    {
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


