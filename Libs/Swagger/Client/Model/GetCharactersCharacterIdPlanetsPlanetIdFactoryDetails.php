<?php

/**
 * GetCharactersCharacterIdPlanetsPlanetIdFactoryDetails
 *
 * PHP version 7
 *
 * @category Class
 * @package  Swagger\Client
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
 * GetCharactersCharacterIdPlanetsPlanetIdFactoryDetails Class Doc Comment
 *
 * @category Class
 * @description factory_details object
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class GetCharactersCharacterIdPlanetsPlanetIdFactoryDetails implements ModelInterface, ArrayAccess {

	const DISCRIMINATOR = null;

	/**
	 * The original name of the model.
	 *
	 * @var string
	 */
	protected static $swaggerModelName = 'get_characters_character_id_planets_planet_id_factory_details';

	/**
	 * Array of property to type mappings. Used for (de)serialization
	 *
	 * @var string[]
	 */
	protected static $swaggerTypes = [
		'schematic_id' => 'int'
	];

	/**
	 * Array of property to format mappings. Used for (de)serialization
	 *
	 * @var string[]
	 */
	protected static $swaggerFormats = [
		'schematic_id' => 'int32'
	];

	/**
	 * Array of property to type mappings. Used for (de)serialization
	 *
	 * @return array
	 */
	public static function swaggerTypes() {
		return self::$swaggerTypes;
	}

	/**
	 * Array of property to format mappings. Used for (de)serialization
	 *
	 * @return array
	 */
	public static function swaggerFormats() {
		return self::$swaggerFormats;
	}

	/**
	 * Array of attributes where the key is the local name,
	 * and the value is the original name
	 *
	 * @var string[]
	 */
	protected static $attributeMap = [
		'schematic_id' => 'schematic_id'
	];

	/**
	 * Array of attributes to setter functions (for deserialization of responses)
	 *
	 * @var string[]
	 */
	protected static $setters = [
		'schematic_id' => 'setSchematicId'
	];

	/**
	 * Array of attributes to getter functions (for serialization of requests)
	 *
	 * @var string[]
	 */
	protected static $getters = [
		'schematic_id' => 'getSchematicId'
	];

	/**
	 * Array of attributes where the key is the local name,
	 * and the value is the original name
	 *
	 * @return array
	 */
	public static function attributeMap() {
		return self::$attributeMap;
	}

	/**
	 * Array of attributes to setter functions (for deserialization of responses)
	 *
	 * @return array
	 */
	public static function setters() {
		return self::$setters;
	}

	/**
	 * Array of attributes to getter functions (for serialization of requests)
	 *
	 * @return array
	 */
	public static function getters() {
		return self::$getters;
	}

	/**
	 * The original name of the model.
	 *
	 * @return string
	 */
	public function getModelName() {
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
	public function __construct(array $data = null) {
		$this->container['schematic_id'] = isset($data['schematic_id']) ? $data['schematic_id'] : null;
	}

	/**
	 * Show all the invalid properties with reasons.
	 *
	 * @return array invalid properties with reasons
	 */
	public function listInvalidProperties() {
		$invalidProperties = [];

		if($this->container['schematic_id'] === null) {
			$invalidProperties[] = "'schematic_id' can't be null";
		}
		return $invalidProperties;
	}

	/**
	 * Validate all the properties in the model
	 * return true if all passed
	 *
	 * @return bool True if all properties are valid
	 */
	public function valid() {

		if($this->container['schematic_id'] === null) {
			return false;
		}
		return true;
	}

	/**
	 * Gets schematic_id
	 *
	 * @return int
	 */
	public function getSchematicId() {
		return $this->container['schematic_id'];
	}

	/**
	 * Sets schematic_id
	 *
	 * @param int $schematic_id schematic_id integer
	 *
	 * @return $this
	 */
	public function setSchematicId($schematic_id) {
		$this->container['schematic_id'] = $schematic_id;

		return $this;
	}

	/**
	 * Returns true if offset exists. False otherwise.
	 *
	 * @param integer $offset Offset
	 *
	 * @return boolean
	 */
	public function offsetExists($offset) {
		return isset($this->container[$offset]);
	}

	/**
	 * Gets offset.
	 *
	 * @param integer $offset Offset
	 *
	 * @return mixed
	 */
	public function offsetGet($offset) {
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
	public function offsetSet($offset, $value) {
		if(is_null($offset)) {
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
	public function offsetUnset($offset) {
		unset($this->container[$offset]);
	}

	/**
	 * Gets the string presentation of the object
	 *
	 * @return string
	 */
	public function __toString() {
		if(defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
			return json_encode(
				ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT
			);
		}

		return json_encode(ObjectSerializer::sanitizeForSerialization($this));
	}

}
