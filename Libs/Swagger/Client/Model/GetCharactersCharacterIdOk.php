<?php

/**
 * GetCharactersCharacterIdOk
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
 * GetCharactersCharacterIdOk Class Doc Comment
 *
 * @category Class
 * @description 200 ok object
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class GetCharactersCharacterIdOk implements ModelInterface, ArrayAccess {

	const DISCRIMINATOR = null;

	/**
	 * The original name of the model.
	 *
	 * @var string
	 */
	protected static $swaggerModelName = 'get_characters_character_id_ok';

	/**
	 * Array of property to type mappings. Used for (de)serialization
	 *
	 * @var string[]
	 */
	protected static $swaggerTypes = [
		'name' => 'string',
		'description' => 'string',
		'corporation_id' => 'int',
		'alliance_id' => 'int',
		'birthday' => '\DateTime',
		'gender' => 'string',
		'race_id' => 'int',
		'bloodline_id' => 'int',
		'ancestry_id' => 'int',
		'security_status' => 'float',
		'faction_id' => 'int'
	];

	/**
	 * Array of property to format mappings. Used for (de)serialization
	 *
	 * @var string[]
	 */
	protected static $swaggerFormats = [
		'name' => null,
		'description' => null,
		'corporation_id' => 'int32',
		'alliance_id' => 'int32',
		'birthday' => 'date-time',
		'gender' => null,
		'race_id' => 'int32',
		'bloodline_id' => 'int32',
		'ancestry_id' => 'int32',
		'security_status' => 'float',
		'faction_id' => 'int32'
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
		'name' => 'name',
		'description' => 'description',
		'corporation_id' => 'corporation_id',
		'alliance_id' => 'alliance_id',
		'birthday' => 'birthday',
		'gender' => 'gender',
		'race_id' => 'race_id',
		'bloodline_id' => 'bloodline_id',
		'ancestry_id' => 'ancestry_id',
		'security_status' => 'security_status',
		'faction_id' => 'faction_id'
	];

	/**
	 * Array of attributes to setter functions (for deserialization of responses)
	 *
	 * @var string[]
	 */
	protected static $setters = [
		'name' => 'setName',
		'description' => 'setDescription',
		'corporation_id' => 'setCorporationId',
		'alliance_id' => 'setAllianceId',
		'birthday' => 'setBirthday',
		'gender' => 'setGender',
		'race_id' => 'setRaceId',
		'bloodline_id' => 'setBloodlineId',
		'ancestry_id' => 'setAncestryId',
		'security_status' => 'setSecurityStatus',
		'faction_id' => 'setFactionId'
	];

	/**
	 * Array of attributes to getter functions (for serialization of requests)
	 *
	 * @var string[]
	 */
	protected static $getters = [
		'name' => 'getName',
		'description' => 'getDescription',
		'corporation_id' => 'getCorporationId',
		'alliance_id' => 'getAllianceId',
		'birthday' => 'getBirthday',
		'gender' => 'getGender',
		'race_id' => 'getRaceId',
		'bloodline_id' => 'getBloodlineId',
		'ancestry_id' => 'getAncestryId',
		'security_status' => 'getSecurityStatus',
		'faction_id' => 'getFactionId'
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

	const GENDER_FEMALE = 'female';
	const GENDER_MALE = 'male';

	/**
	 * Gets allowable values of the enum
	 *
	 * @return string[]
	 */
	public function getGenderAllowableValues() {
		return [
			self::GENDER_FEMALE,
			self::GENDER_MALE,
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
	public function __construct(array $data = null) {
		$this->container['name'] = isset($data['name']) ? $data['name'] : null;
		$this->container['description'] = isset($data['description']) ? $data['description'] : null;
		$this->container['corporation_id'] = isset($data['corporation_id']) ? $data['corporation_id'] : null;
		$this->container['alliance_id'] = isset($data['alliance_id']) ? $data['alliance_id'] : null;
		$this->container['birthday'] = isset($data['birthday']) ? $data['birthday'] : null;
		$this->container['gender'] = isset($data['gender']) ? $data['gender'] : null;
		$this->container['race_id'] = isset($data['race_id']) ? $data['race_id'] : null;
		$this->container['bloodline_id'] = isset($data['bloodline_id']) ? $data['bloodline_id'] : null;
		$this->container['ancestry_id'] = isset($data['ancestry_id']) ? $data['ancestry_id'] : null;
		$this->container['security_status'] = isset($data['security_status']) ? $data['security_status'] : null;
		$this->container['faction_id'] = isset($data['faction_id']) ? $data['faction_id'] : null;
	}

	/**
	 * Show all the invalid properties with reasons.
	 *
	 * @return array invalid properties with reasons
	 */
	public function listInvalidProperties() {
		$invalidProperties = [];

		if($this->container['name'] === null) {
			$invalidProperties[] = "'name' can't be null";
		}
		if($this->container['corporation_id'] === null) {
			$invalidProperties[] = "'corporation_id' can't be null";
		}
		if($this->container['birthday'] === null) {
			$invalidProperties[] = "'birthday' can't be null";
		}
		if($this->container['gender'] === null) {
			$invalidProperties[] = "'gender' can't be null";
		}
		$allowedValues = $this->getGenderAllowableValues();
		if(!in_array($this->container['gender'], $allowedValues)) {
			$invalidProperties[] = sprintf(
				"invalid value for 'gender', must be one of '%s'", implode("', '", $allowedValues)
			);
		}

		if($this->container['race_id'] === null) {
			$invalidProperties[] = "'race_id' can't be null";
		}
		if($this->container['bloodline_id'] === null) {
			$invalidProperties[] = "'bloodline_id' can't be null";
		}
		if(!is_null($this->container['security_status']) && ($this->container['security_status'] > 10)) {
			$invalidProperties[] = "invalid value for 'security_status', must be smaller than or equal to 10.";
		}

		if(!is_null($this->container['security_status']) && ($this->container['security_status'] < -10)) {
			$invalidProperties[] = "invalid value for 'security_status', must be bigger than or equal to -10.";
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

		if($this->container['name'] === null) {
			return false;
		}
		if($this->container['corporation_id'] === null) {
			return false;
		}
		if($this->container['birthday'] === null) {
			return false;
		}
		if($this->container['gender'] === null) {
			return false;
		}
		$allowedValues = $this->getGenderAllowableValues();
		if(!in_array($this->container['gender'], $allowedValues)) {
			return false;
		}
		if($this->container['race_id'] === null) {
			return false;
		}
		if($this->container['bloodline_id'] === null) {
			return false;
		}
		if($this->container['security_status'] > 10) {
			return false;
		}
		if($this->container['security_status'] < -10) {
			return false;
		}
		return true;
	}

	/**
	 * Gets name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->container['name'];
	}

	/**
	 * Sets name
	 *
	 * @param string $name name string
	 *
	 * @return $this
	 */
	public function setName($name) {
		$this->container['name'] = $name;

		return $this;
	}

	/**
	 * Gets description
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->container['description'];
	}

	/**
	 * Sets description
	 *
	 * @param string $description description string
	 *
	 * @return $this
	 */
	public function setDescription($description) {
		$this->container['description'] = $description;

		return $this;
	}

	/**
	 * Gets corporation_id
	 *
	 * @return int
	 */
	public function getCorporationId() {
		return $this->container['corporation_id'];
	}

	/**
	 * Sets corporation_id
	 *
	 * @param int $corporation_id The character's corporation ID
	 *
	 * @return $this
	 */
	public function setCorporationId($corporation_id) {
		$this->container['corporation_id'] = $corporation_id;

		return $this;
	}

	/**
	 * Gets alliance_id
	 *
	 * @return int
	 */
	public function getAllianceId() {
		return $this->container['alliance_id'];
	}

	/**
	 * Sets alliance_id
	 *
	 * @param int $alliance_id The character's alliance ID
	 *
	 * @return $this
	 */
	public function setAllianceId($alliance_id) {
		$this->container['alliance_id'] = $alliance_id;

		return $this;
	}

	/**
	 * Gets birthday
	 *
	 * @return \DateTime
	 */
	public function getBirthday() {
		return $this->container['birthday'];
	}

	/**
	 * Sets birthday
	 *
	 * @param \DateTime $birthday Creation date of the character
	 *
	 * @return $this
	 */
	public function setBirthday($birthday) {
		$this->container['birthday'] = $birthday;

		return $this;
	}

	/**
	 * Gets gender
	 *
	 * @return string
	 */
	public function getGender() {
		return $this->container['gender'];
	}

	/**
	 * Sets gender
	 *
	 * @param string $gender gender string
	 *
	 * @return $this
	 */
	public function setGender($gender) {
		$allowedValues = $this->getGenderAllowableValues();
		if(!in_array($gender, $allowedValues)) {
			throw new \InvalidArgumentException(
			sprintf(
				"Invalid value for 'gender', must be one of '%s'", implode("', '", $allowedValues)
			)
			);
		}
		$this->container['gender'] = $gender;

		return $this;
	}

	/**
	 * Gets race_id
	 *
	 * @return int
	 */
	public function getRaceId() {
		return $this->container['race_id'];
	}

	/**
	 * Sets race_id
	 *
	 * @param int $race_id race_id integer
	 *
	 * @return $this
	 */
	public function setRaceId($race_id) {
		$this->container['race_id'] = $race_id;

		return $this;
	}

	/**
	 * Gets bloodline_id
	 *
	 * @return int
	 */
	public function getBloodlineId() {
		return $this->container['bloodline_id'];
	}

	/**
	 * Sets bloodline_id
	 *
	 * @param int $bloodline_id bloodline_id integer
	 *
	 * @return $this
	 */
	public function setBloodlineId($bloodline_id) {
		$this->container['bloodline_id'] = $bloodline_id;

		return $this;
	}

	/**
	 * Gets ancestry_id
	 *
	 * @return int
	 */
	public function getAncestryId() {
		return $this->container['ancestry_id'];
	}

	/**
	 * Sets ancestry_id
	 *
	 * @param int $ancestry_id ancestry_id integer
	 *
	 * @return $this
	 */
	public function setAncestryId($ancestry_id) {
		$this->container['ancestry_id'] = $ancestry_id;

		return $this;
	}

	/**
	 * Gets security_status
	 *
	 * @return float
	 */
	public function getSecurityStatus() {
		return $this->container['security_status'];
	}

	/**
	 * Sets security_status
	 *
	 * @param float $security_status security_status number
	 *
	 * @return $this
	 */
	public function setSecurityStatus($security_status) {

		if(!is_null($security_status) && ($security_status > 10)) {
			throw new \InvalidArgumentException('invalid value for $security_status when calling GetCharactersCharacterIdOk., must be smaller than or equal to 10.');
		}
		if(!is_null($security_status) && ($security_status < -10)) {
			throw new \InvalidArgumentException('invalid value for $security_status when calling GetCharactersCharacterIdOk., must be bigger than or equal to -10.');
		}

		$this->container['security_status'] = $security_status;

		return $this;
	}

	/**
	 * Gets faction_id
	 *
	 * @return int
	 */
	public function getFactionId() {
		return $this->container['faction_id'];
	}

	/**
	 * Sets faction_id
	 *
	 * @param int $faction_id ID of the faction the character is fighting for, if the character is enlisted in Factional Warfare
	 *
	 * @return $this
	 */
	public function setFactionId($faction_id) {
		$this->container['faction_id'] = $faction_id;

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
