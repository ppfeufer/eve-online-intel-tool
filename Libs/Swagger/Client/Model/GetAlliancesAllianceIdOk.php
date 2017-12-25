<?php

/**
 * GetAlliancesAllianceIdOk
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
 * GetAlliancesAllianceIdOk Class Doc Comment
 *
 * @category Class
 * @description 200 ok object
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class GetAlliancesAllianceIdOk implements ModelInterface, ArrayAccess {
	const DISCRIMINATOR = null;

	/**
	 * The original name of the model.
	 *
	 * @var string
	 */
	protected static $swaggerModelName = 'get_alliances_alliance_id_ok';

	/**
	 * Array of property to type mappings. Used for (de)serialization
	 *
	 * @var string[]
	 */
	protected static $swaggerTypes = [
		'name' => 'string',
		'creator_id' => 'int',
		'creator_corporation_id' => 'int',
		'ticker' => 'string',
		'executor_corporation_id' => 'int',
		'date_founded' => '\DateTime',
		'faction_id' => 'int'
	];

	/**
	 * Array of property to format mappings. Used for (de)serialization
	 *
	 * @var string[]
	 */
	protected static $swaggerFormats = [
		'name' => null,
		'creator_id' => 'int32',
		'creator_corporation_id' => 'int32',
		'ticker' => null,
		'executor_corporation_id' => 'int32',
		'date_founded' => 'date-time',
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
		'creator_id' => 'creator_id',
		'creator_corporation_id' => 'creator_corporation_id',
		'ticker' => 'ticker',
		'executor_corporation_id' => 'executor_corporation_id',
		'date_founded' => 'date_founded',
		'faction_id' => 'faction_id'
	];

	/**
	 * Array of attributes to setter functions (for deserialization of responses)
	 *
	 * @var string[]
	 */
	protected static $setters = [
		'name' => 'setName',
		'creator_id' => 'setCreatorId',
		'creator_corporation_id' => 'setCreatorCorporationId',
		'ticker' => 'setTicker',
		'executor_corporation_id' => 'setExecutorCorporationId',
		'date_founded' => 'setDateFounded',
		'faction_id' => 'setFactionId'
	];

	/**
	 * Array of attributes to getter functions (for serialization of requests)
	 *
	 * @var string[]
	 */
	protected static $getters = [
		'name' => 'getName',
		'creator_id' => 'getCreatorId',
		'creator_corporation_id' => 'getCreatorCorporationId',
		'ticker' => 'getTicker',
		'executor_corporation_id' => 'getExecutorCorporationId',
		'date_founded' => 'getDateFounded',
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
		$this->container['creator_id'] = isset($data['creator_id']) ? $data['creator_id'] : null;
		$this->container['creator_corporation_id'] = isset($data['creator_corporation_id']) ? $data['creator_corporation_id'] : null;
		$this->container['ticker'] = isset($data['ticker']) ? $data['ticker'] : null;
		$this->container['executor_corporation_id'] = isset($data['executor_corporation_id']) ? $data['executor_corporation_id'] : null;
		$this->container['date_founded'] = isset($data['date_founded']) ? $data['date_founded'] : null;
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
		if($this->container['creator_id'] === null) {
			$invalidProperties[] = "'creator_id' can't be null";
		}
		if($this->container['creator_corporation_id'] === null) {
			$invalidProperties[] = "'creator_corporation_id' can't be null";
		}
		if($this->container['ticker'] === null) {
			$invalidProperties[] = "'ticker' can't be null";
		}
		if($this->container['date_founded'] === null) {
			$invalidProperties[] = "'date_founded' can't be null";
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
		if($this->container['creator_id'] === null) {
			return false;
		}
		if($this->container['creator_corporation_id'] === null) {
			return false;
		}
		if($this->container['ticker'] === null) {
			return false;
		}
		if($this->container['date_founded'] === null) {
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
	 * @param string $name the full name of the alliance
	 *
	 * @return $this
	 */
	public function setName($name) {
		$this->container['name'] = $name;

		return $this;
	}

	/**
	 * Gets creator_id
	 *
	 * @return int
	 */
	public function getCreatorId() {
		return $this->container['creator_id'];
	}

	/**
	 * Sets creator_id
	 *
	 * @param int $creator_id ID of the character that created the alliance
	 *
	 * @return $this
	 */
	public function setCreatorId($creator_id) {
		$this->container['creator_id'] = $creator_id;

		return $this;
	}

	/**
	 * Gets creator_corporation_id
	 *
	 * @return int
	 */
	public function getCreatorCorporationId() {
		return $this->container['creator_corporation_id'];
	}

	/**
	 * Sets creator_corporation_id
	 *
	 * @param int $creator_corporation_id ID of the corporation that created the alliance
	 *
	 * @return $this
	 */
	public function setCreatorCorporationId($creator_corporation_id) {
		$this->container['creator_corporation_id'] = $creator_corporation_id;

		return $this;
	}

	/**
	 * Gets ticker
	 *
	 * @return string
	 */
	public function getTicker() {
		return $this->container['ticker'];
	}

	/**
	 * Sets ticker
	 *
	 * @param string $ticker the short name of the alliance
	 *
	 * @return $this
	 */
	public function setTicker($ticker) {
		$this->container['ticker'] = $ticker;

		return $this;
	}

	/**
	 * Gets executor_corporation_id
	 *
	 * @return int
	 */
	public function getExecutorCorporationId() {
		return $this->container['executor_corporation_id'];
	}

	/**
	 * Sets executor_corporation_id
	 *
	 * @param int $executor_corporation_id the executor corporation ID, if this alliance is not closed
	 *
	 * @return $this
	 */
	public function setExecutorCorporationId($executor_corporation_id) {
		$this->container['executor_corporation_id'] = $executor_corporation_id;

		return $this;
	}

	/**
	 * Gets date_founded
	 *
	 * @return \DateTime
	 */
	public function getDateFounded() {
		return $this->container['date_founded'];
	}

	/**
	 * Sets date_founded
	 *
	 * @param \DateTime $date_founded date_founded string
	 *
	 * @return $this
	 */
	public function setDateFounded($date_founded) {
		$this->container['date_founded'] = $date_founded;

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
	 * @param int $faction_id Faction ID this alliance is fighting for, if this alliance is enlisted in factional warfare
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
