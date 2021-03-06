<?php
/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in 
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object|Class
 * @copyright  Copyright (c) 2009-2016 pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PEL
 */


namespace Pimcore\Model\Object\ClassDefinition\Data;

use Pimcore\Model;

class QuantityValue extends Model\Object\ClassDefinition\Data
{

    /**
     * Static type of this element
     *
     * @var string
     */
    public $fieldtype = "quantityValue";

    /**
     * @var float
     */
    public $width;

    /**
     * @var float
     */
    public $defaultValue;

    /**
     * @var string
     */
    public $defaultUnit;

    /**
     * @var array()
     */
    public $validUnits;

    /**
     * Type for the column to query
     *
     * @var int
     */
    public $queryColumnType = array(
        "value" => "double",
        "unit" => "bigint(20)"
    );

    /**
     * Type for the column
     *
     * @var string
     */
    public $columnType = array(
        "value" => "double",
        "unit" => "bigint(20)"
    );

    /**
     * Type for the generated phpdoc
     *
     * @var string
     */
    public $phpdocType = "Pimcore\\Model\\Object\\Data\\QuantityValue";

    /**
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param integer $width
     * @return void
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return integer
     */
    public function getDefaultValue()
    {
        if ($this->defaultValue !== null) {
            return (double) $this->defaultValue;
        }
    }

    /**
     * @param integer $defaultValue
     * @return void
     */
    public function setDefaultValue($defaultValue)
    {
        if (strlen(strval($defaultValue)) > 0) {
            $this->defaultValue = $defaultValue;
        }
    }

    /**
     * @param  array() $validUnits
     * @return void
     */
    public function setValidUnits($validUnits)
    {
        $this->validUnits = $validUnits;
    }

    /**
     * @return array()
     */
    public function getValidUnits()
    {
        return $this->validUnits;
    }

    /**
     * @return string
     */
    public function getDefaultUnit()
    {
        return $this->defaultUnit;
    }

    /**
     * @param string $defaultUnit
     */
    public function setDefaultUnit($defaultUnit)
    {
        $this->defaultUnit = $defaultUnit;
    }




    /**
     * @see Object_Class_Data::getDataForResource
     * @param float $data
     * @param null|Model\Object\AbstractObject $object
     * @param mixed $params
     * @return float
     */
    public function getDataForResource($data, $object = null, $params = array())
    {
        if ($data instanceof \Pimcore\Model\Object\Data\QuantityValue) {
            return array(
                $this->getName() . "__value" => $data->getValue(),
                $this->getName() . "__unit" => $data->getUnitId()
            );
        }
        return array(
            $this->getName() . "__value" => null,
            $this->getName() . "__unit" => null
        );
    }

    /**
     * @see Object_Class_Data::getDataFromResource
     * @param float $data
     * @param null|Model\Object\AbstractObject $object
     * @param mixed $params
     * @return float
     */
    public function getDataFromResource($data, $object = null, $params = array())
    {
        if ($data[$this->getName() . "__value"] && $data[$this->getName() . "__unit"]) {
            return new  \Pimcore\Model\Object\Data\QuantityValue($data[$this->getName() . "__value"], $data[$this->getName() . "__unit"]);
        }
        return;
    }

    /**
     * @see Object_Class_Data::getDataForQueryResource
     * @param float $data
     * @param null|Model\Object\AbstractObject $object
     * @param mixed $params
     * @return float
     */
    public function getDataForQueryResource($data, $object = null, $params = array())
    {
        return $this->getDataForResource($data);
    }

    /**
     * @see Object_Class_Data::getDataForEditmode
     * @param float $data
     * @param null|Model\Object\AbstractObject $object
     * @param mixed $params
     * @return float
     */
    public function getDataForEditmode($data, $object = null, $params = array())
    {
        if ($data instanceof  \Pimcore\Model\Object\Data\QuantityValue) {
            return array(
                "value" => $data->getValue(),
                "unit" => $data->getUnitId()
            );
        }

        return;
    }

    /**
     * @see Object_Class_Data::getDataFromEditmode
     * @param float $data
     * @param Model\Object\Concrete $object
     * @param mixed $params
     * @return float
     */
    public function getDataFromEditmode($data, $object = null, $params = array())
    {
        if ($data["value"] || $data["unit"]) {
            return new \Pimcore\Model\Object\Data\QuantityValue($data["value"], $data["unit"]);
        }
        return;
    }

    /**
     * @see Object_Class_Data::getVersionPreview
     * @param float $data
     * @param null|Object\AbstractObject $object
     * @param mixed $params
     * @return float
     */
    public function getVersionPreview($data, $object = null, $params = array())
    {
        if ($data instanceof \Pimcore\Model\Object\Data\QuantityValue) {
            return $data->getValue() . " " . $data->getUnit()->getAbbreviation();
        }
        return "";
    }

    /**
     * Checks if data is valid for current data field
     *
     * @param mixed $data
     * @param boolean $omitMandatoryCheck
     * @throws Exception
     */
    public function checkValidity($data, $omitMandatoryCheck = false)
    {
        if (!$omitMandatoryCheck && $this->getMandatory() &&
           ($data === null || $data->getValue() === null || $data->getUnitId() === null)) {
            throw new Model\Element\ValidationException(get_class($this).": Empty mandatory field [ ".$this->getName()." ]");
        }

        if (!empty($data)) {
            $value = $data->getValue();
            if ((!empty($value) && !is_numeric($data->getValue())) || !($data->getUnitId())) {
                throw new Model\Element\ValidationException(get_class($this).": invalid dimension unit data");
            }
        }
    }

    /**
     * converts object data to a simple string value or CSV Export
     * @abstract
     * @param Model\Object\AbstractObject $object
     * @param array $params
     * @return string
     */
    public function getForCsvExport($object, $params = array())
    {
        $key = $this->getName();
        $getter = "get".ucfirst($key);
        if ($object->$getter() instanceof \Pimcore\Model\Object\Data\QuantityValue) {
            return $object->$getter()->getValue() . "_" . $object->$getter()->getUnitId();
        } else {
            return null;
        }
    }


    /**
     * fills object field data values from CSV Import String
     * @param string $importValue
     * @param null|Model\Object\AbstractObject $object
     * @param mixed $params
     * @return double
     */
    public function getFromCsvImport($importValue, $object = null, $params = array())
    {
        $values = explode("_", $importValue);

        $value = null;
        if ($values[0] && $values[1]) {
            $number = (double) str_replace(",", ".", $values[0]);
            $value = new  \Pimcore\Model\Object\Data\QuantityValue($number, $values[1]);
        }
        return $value;
    }


       /**
     * converts data to be exposed via webservices
     * @param string $object
     * @param mixed $params
     * @return mixed
     */
    public function getForWebserviceExport($object, $params = array())
    {
        $key = $this->getName();
        $getter = "get".ucfirst($key);

        if ($object->$getter() instanceof \Pimcore\Model\Object\Data\QuantityValue) {
            return array(
                "value" => $object->$getter()->getValue(),
                "unit" => $object->$getter()->getUnitId(),
                "unitAbbreviation" => $object->$getter()->getUnit()->getAbbreviation()
            );
        } else {
            return null;
        }
    }

     /**
     * converts data to be imported via webservices
     * @param mixed $value
     * @param null|Model\Object\AbstractObject $object
     * @param mixed $params
     * @return mixed
     */
    public function getFromWebserviceImport($value, $object = null, $params = array(), $idMapper = null)
    {
        if (empty($value)) {
            return null;
        } elseif ($value["value"] !== null && $value["unit"] !== null && $value["unitAbbreviation"] !== null) {
            $unit = Model\Object\QuantityValue\Unit::getById($value["unit"]);
            if ($unit && $unit->getAbbreviation() == $value["unitAbbreviation"]) {
                return new \Pimcore\Model\Object\Data\QuantityValue($value["value"], $value["unit"]);
            } else {
                throw new \Exception(get_class($this).": cannot get values from web service import - unit id and unit abbreviation do not match with local database");
            }
        } else {
            throw new \Exception(get_class($this).": cannot get values from web service import - invalid data");
        }
    }


    /** Encode value for packing it into a single column.
     * @param mixed $value
     * @param Model\Object\AbstractObject $object
     * @param mixed $params
     * @return mixed
     */
    public function marshal($value, $object = null, $params = array())
    {
        if (is_array($value)) {
            return array(
                "value" => $value[$this->getName() . "__value"],
                "value2" => $value[$this->getName() . "__unit"]
            );
        } else {
            return array(
                "value" => null,
                "value2" => null
            );
        }
    }

    /** See marshal
     * @param mixed $value
     * @param Model\Object\AbstractObject $object
     * @param mixed $params
     * @return mixed
     */
    public function unmarshal($value, $object = null, $params = array())
    {
        if (is_array($value)) {
            return array(
                $this->getName() . "__value" => $value["value"],
                $this->getName() . "__unit" => $value["value2"],

            );
        } else {
            return null;
        }
    }


    public function configureOptions()
    {
        if (!$this->validUnits) {
            $list = new \Pimcore\Model\Object\QuantityValue\Unit\Listing();
            $units = $list->getUnits();
            if (is_array($units)) {
                $this->validUnits = array();
                /** @var  $unit Model\Object\QuantityValue\Unit */
                foreach ($units as $unit) {
                    $this->validUnits[] = $unit->getId();
                }
            }
        }
    }

    /**
     *
     */
    public function __wakeup()
    {
        $this->configureOptions();
    }
}
