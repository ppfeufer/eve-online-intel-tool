<?php
/**
 * GetCorporationsCorporationIdOutpostsOutpostIdService
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
 * GetCorporationsCorporationIdOutpostsOutpostIdService Class Doc Comment
 *
 * @category Class
 * @description service object
 * @package  WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class GetCorporationsCorporationIdOutpostsOutpostIdService implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'get_corporations_corporation_id_outposts_outpost_id_service';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'service_name' => 'string',
        'minimum_standing' => 'double',
        'surcharge_per_bad_standing' => 'double',
        'discount_per_good_standing' => 'double'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'service_name' => null,
        'minimum_standing' => 'double',
        'surcharge_per_bad_standing' => 'double',
        'discount_per_good_standing' => 'double'
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
        'service_name' => 'service_name',
        'minimum_standing' => 'minimum_standing',
        'surcharge_per_bad_standing' => 'surcharge_per_bad_standing',
        'discount_per_good_standing' => 'discount_per_good_standing'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'service_name' => 'setServiceName',
        'minimum_standing' => 'setMinimumStanding',
        'surcharge_per_bad_standing' => 'setSurchargePerBadStanding',
        'discount_per_good_standing' => 'setDiscountPerGoodStanding'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'service_name' => 'getServiceName',
        'minimum_standing' => 'getMinimumStanding',
        'surcharge_per_bad_standing' => 'getSurchargePerBadStanding',
        'discount_per_good_standing' => 'getDiscountPerGoodStanding'
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

    const SERVICE_NAME_BOUNTY_MISSIONS = 'Bounty Missions';
    const SERVICE_NAME_ASSASSINATION_MISSIONS = 'Assassination Missions';
    const SERVICE_NAME_COURIER_MISSIONS = 'Courier Missions';
    const SERVICE_NAME_INTERBUS = 'Interbus';
    const SERVICE_NAME_REPROCESSING_PLANT = 'Reprocessing Plant';
    const SERVICE_NAME_REFINERY = 'Refinery';
    const SERVICE_NAME_MARKET = 'Market';
    const SERVICE_NAME_BLACK_MARKET = 'Black Market';
    const SERVICE_NAME_STOCK_EXCHANGE = 'Stock Exchange';
    const SERVICE_NAME_CLONING = 'Cloning';
    const SERVICE_NAME_SURGERY = 'Surgery';
    const SERVICE_NAME_DNA_THERAPY = 'DNA Therapy';
    const SERVICE_NAME_REPAIR_FACILITIES = 'Repair Facilities';
    const SERVICE_NAME_FACTORY = 'Factory';
    const SERVICE_NAME_LABORATORY = 'Laboratory';
    const SERVICE_NAME_GAMBLING = 'Gambling';
    const SERVICE_NAME_FITTING = 'Fitting';
    const SERVICE_NAME_PAINTSHOP = 'Paintshop';
    const SERVICE_NAME_NEWS = 'News';
    const SERVICE_NAME_STORAGE = 'Storage';
    const SERVICE_NAME_INSURANCE = 'Insurance';
    const SERVICE_NAME_DOCKING = 'Docking';
    const SERVICE_NAME_OFFICE_RENTAL = 'Office Rental';
    const SERVICE_NAME_JUMP_CLONE_FACILITY = 'Jump Clone Facility';
    const SERVICE_NAME_LOYALTY_POINT_STORE = 'Loyalty Point Store';
    const SERVICE_NAME_NAVY_OFFICES = 'Navy Offices';
    const SERVICE_NAME_SECURITY_OFFICE = 'Security Office';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getServiceNameAllowableValues()
    {
        return [
            self::SERVICE_NAME_BOUNTY_MISSIONS,
            self::SERVICE_NAME_ASSASSINATION_MISSIONS,
            self::SERVICE_NAME_COURIER_MISSIONS,
            self::SERVICE_NAME_INTERBUS,
            self::SERVICE_NAME_REPROCESSING_PLANT,
            self::SERVICE_NAME_REFINERY,
            self::SERVICE_NAME_MARKET,
            self::SERVICE_NAME_BLACK_MARKET,
            self::SERVICE_NAME_STOCK_EXCHANGE,
            self::SERVICE_NAME_CLONING,
            self::SERVICE_NAME_SURGERY,
            self::SERVICE_NAME_DNA_THERAPY,
            self::SERVICE_NAME_REPAIR_FACILITIES,
            self::SERVICE_NAME_FACTORY,
            self::SERVICE_NAME_LABORATORY,
            self::SERVICE_NAME_GAMBLING,
            self::SERVICE_NAME_FITTING,
            self::SERVICE_NAME_PAINTSHOP,
            self::SERVICE_NAME_NEWS,
            self::SERVICE_NAME_STORAGE,
            self::SERVICE_NAME_INSURANCE,
            self::SERVICE_NAME_DOCKING,
            self::SERVICE_NAME_OFFICE_RENTAL,
            self::SERVICE_NAME_JUMP_CLONE_FACILITY,
            self::SERVICE_NAME_LOYALTY_POINT_STORE,
            self::SERVICE_NAME_NAVY_OFFICES,
            self::SERVICE_NAME_SECURITY_OFFICE,
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
        $this->container['service_name'] = isset($data['service_name']) ? $data['service_name'] : null;
        $this->container['minimum_standing'] = isset($data['minimum_standing']) ? $data['minimum_standing'] : null;
        $this->container['surcharge_per_bad_standing'] = isset($data['surcharge_per_bad_standing']) ? $data['surcharge_per_bad_standing'] : null;
        $this->container['discount_per_good_standing'] = isset($data['discount_per_good_standing']) ? $data['discount_per_good_standing'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['service_name'] === null) {
            $invalidProperties[] = "'service_name' can't be null";
        }
        $allowedValues = $this->getServiceNameAllowableValues();
        if (!in_array($this->container['service_name'], $allowedValues)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'service_name', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['minimum_standing'] === null) {
            $invalidProperties[] = "'minimum_standing' can't be null";
        }
        if ($this->container['surcharge_per_bad_standing'] === null) {
            $invalidProperties[] = "'surcharge_per_bad_standing' can't be null";
        }
        if ($this->container['discount_per_good_standing'] === null) {
            $invalidProperties[] = "'discount_per_good_standing' can't be null";
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

        if ($this->container['service_name'] === null) {
            return false;
        }
        $allowedValues = $this->getServiceNameAllowableValues();
        if (!in_array($this->container['service_name'], $allowedValues)) {
            return false;
        }
        if ($this->container['minimum_standing'] === null) {
            return false;
        }
        if ($this->container['surcharge_per_bad_standing'] === null) {
            return false;
        }
        if ($this->container['discount_per_good_standing'] === null) {
            return false;
        }
        return true;
    }


    /**
     * Gets service_name
     *
     * @return string
     */
    public function getServiceName()
    {
        return $this->container['service_name'];
    }

    /**
     * Sets service_name
     *
     * @param string $service_name service_name string
     *
     * @return $this
     */
    public function setServiceName($service_name)
    {
        $allowedValues = $this->getServiceNameAllowableValues();
        if (!in_array($service_name, $allowedValues)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'service_name', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['service_name'] = $service_name;

        return $this;
    }

    /**
     * Gets minimum_standing
     *
     * @return double
     */
    public function getMinimumStanding()
    {
        return $this->container['minimum_standing'];
    }

    /**
     * Sets minimum_standing
     *
     * @param double $minimum_standing minimum_standing number
     *
     * @return $this
     */
    public function setMinimumStanding($minimum_standing)
    {
        $this->container['minimum_standing'] = $minimum_standing;

        return $this;
    }

    /**
     * Gets surcharge_per_bad_standing
     *
     * @return double
     */
    public function getSurchargePerBadStanding()
    {
        return $this->container['surcharge_per_bad_standing'];
    }

    /**
     * Sets surcharge_per_bad_standing
     *
     * @param double $surcharge_per_bad_standing surcharge_per_bad_standing number
     *
     * @return $this
     */
    public function setSurchargePerBadStanding($surcharge_per_bad_standing)
    {
        $this->container['surcharge_per_bad_standing'] = $surcharge_per_bad_standing;

        return $this;
    }

    /**
     * Gets discount_per_good_standing
     *
     * @return double
     */
    public function getDiscountPerGoodStanding()
    {
        return $this->container['discount_per_good_standing'];
    }

    /**
     * Sets discount_per_good_standing
     *
     * @param double $discount_per_good_standing discount_per_good_standing number
     *
     * @return $this
     */
    public function setDiscountPerGoodStanding($discount_per_good_standing)
    {
        $this->container['discount_per_good_standing'] = $discount_per_good_standing;

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


