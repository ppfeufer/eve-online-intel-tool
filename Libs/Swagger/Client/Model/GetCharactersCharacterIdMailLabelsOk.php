<?php

/**
 * GetCharactersCharacterIdMailLabelsOk
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
 * GetCharactersCharacterIdMailLabelsOk Class Doc Comment
 *
 * @category Class
 * @description 200 ok object
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class GetCharactersCharacterIdMailLabelsOk implements ModelInterface, ArrayAccess {

	const DISCRIMINATOR = null;

	/**
	 * The original name of the model.
	 *
	 * @var string
	 */
	protected static $swaggerModelName = 'get_characters_character_id_mail_labels_ok';

	/**
	 * Array of property to type mappings. Used for (de)serialization
	 *
	 * @var string[]
	 */
	protected static $swaggerTypes = [
		'total_unread_count' => 'int',
		'labels' => '\WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\Model\GetCharactersCharacterIdMailLabelsLabel[]'
	];

	/**
	 * Array of property to format mappings. Used for (de)serialization
	 *
	 * @var string[]
	 */
	protected static $swaggerFormats = [
		'total_unread_count' => 'int32',
		'labels' => null
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
		'total_unread_count' => 'total_unread_count',
		'labels' => 'labels'
	];

	/**
	 * Array of attributes to setter functions (for deserialization of responses)
	 *
	 * @var string[]
	 */
	protected static $setters = [
		'total_unread_count' => 'setTotalUnreadCount',
		'labels' => 'setLabels'
	];

	/**
	 * Array of attributes to getter functions (for serialization of requests)
	 *
	 * @var string[]
	 */
	protected static $getters = [
		'total_unread_count' => 'getTotalUnreadCount',
		'labels' => 'getLabels'
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
		$this->container['total_unread_count'] = isset($data['total_unread_count']) ? $data['total_unread_count'] : null;
		$this->container['labels'] = isset($data['labels']) ? $data['labels'] : null;
	}

	/**
	 * Show all the invalid properties with reasons.
	 *
	 * @return array invalid properties with reasons
	 */
	public function listInvalidProperties() {
		$invalidProperties = [];

		if(!is_null($this->container['total_unread_count']) && ($this->container['total_unread_count'] < 0)) {
			$invalidProperties[] = "invalid value for 'total_unread_count', must be bigger than or equal to 0.";
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

		if($this->container['total_unread_count'] < 0) {
			return false;
		}
		return true;
	}

	/**
	 * Gets total_unread_count
	 *
	 * @return int
	 */
	public function getTotalUnreadCount() {
		return $this->container['total_unread_count'];
	}

	/**
	 * Sets total_unread_count
	 *
	 * @param int $total_unread_count total_unread_count integer
	 *
	 * @return $this
	 */
	public function setTotalUnreadCount($total_unread_count) {

		if(!is_null($total_unread_count) && ($total_unread_count < 0)) {
			throw new \InvalidArgumentException('invalid value for $total_unread_count when calling GetCharactersCharacterIdMailLabelsOk., must be bigger than or equal to 0.');
		}

		$this->container['total_unread_count'] = $total_unread_count;

		return $this;
	}

	/**
	 * Gets labels
	 *
	 * @return \WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\Model\GetCharactersCharacterIdMailLabelsLabel[]
	 */
	public function getLabels() {
		return $this->container['labels'];
	}

	/**
	 * Sets labels
	 *
	 * @param \WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\Model\GetCharactersCharacterIdMailLabelsLabel[] $labels labels array
	 *
	 * @return $this
	 */
	public function setLabels($labels) {
		$this->container['labels'] = $labels;

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
