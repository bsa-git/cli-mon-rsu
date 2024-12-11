<?php

/**
 * ����� ������� HistCurrentData (������� ������ � �������)
 * ������������ ����� ��� ������ � �������� ������� � �������
 * ����� � ����� ������ �������������� ������� Model_XXXXMapper
 *
 * @uses       Model_XXXMapper
 * @package    �li-azot-m5
 * @subpackage Model
 */
class Model_HistCurrentData {

    /** ��������� �������� ������ � �������
     * @var DateTime
     */
    protected $_time;
    /** �������� ������� � ������� ������
     * @var string
     */
    protected $_source;
    /** ������ ������� � ������� ������
     * @var string
     */
    protected $_status;
    /** �������� ������� � ������� ������
     * @var string
     */
    protected $_description;
    /** �������� � �������
     * @var float
     */
    protected $_value;

    /** ������ ����� ����� ����� ������ � �������� ����������
     * @var Model_UserMapper
     */
    protected $_mapper;

    /*-------------------------------------------------------
     * Constructor
     *
     * @param  array|null $aOptions
     * @return void
    */
    public function __construct(array $aOptions = null) {
        if (is_array($aOptions)) {
            $this->setValues($aOptions);
        }
    }

    /**----------------------------------
     * Overloading: allow property access
     *
     * @param  string $aName
     * @param  mixed $aValue
     * @return void
     */
    public function __set($aName, $aValue) {
        $method = 'set' . $aName;
        if ('mapper' == $aName || !method_exists($this, $method)) {
            throw Exception('Invalid property specified');
        }
        $this->$method($aValue);
    }

    /**----------------------------------
     * Overloading: allow property access
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($aName) {
        $method = 'get' . $aName;
        if ('mapper' == $aName || !method_exists($this, $method)) {
            throw Exception('Invalid property specified');
        }
        return $this->$method();
    }


    /**--------------------------------------
     * Set object state
     *
     * @param  array $aValues
     * @return Model_XXXX
     */
    public function setValues(array $aValues) {
        $methods = get_class_methods($this);
        foreach ($aValues as $key => $value) {
            $key = strtolower($key);
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    /**--------------------------------------
     * �������� ������ (���� =��������) �������
     *
     * @return array
     */
    public function getValues() {
        $arrValues = array();
        //-------------------
        //������� ��� ������ �������
        $methods = get_class_methods($this);
        foreach ($methods as $method) {
            //������ ������ ������
            if (('getValues' != $method)AND
                ('getMapper' != $method)AND
                (strpos($method, 'get') === 0)) {
                //���� �������� �� ����� NULL, �� �������� ��� � �������
                $value = $this->$method();
                if(!is_null($value)){
                    $method = strtolower($method);
                    $key = substr($method, 3);
                    $arrValues[$key]=$value;
                }
            }
        }
        return $arrValues;
    }

    /**--------------------------------------
     * �������� �������� �������
     *
     * @return Model_XXXX
     */
    public function clearValues() {

        //-------------------
        $arrValues = $this->getValues();
        //������� ��� ������ �������
        foreach ($arrValues as $key=>$value) {
            $this->$key = NULL;
        }
        return $this;
    }

    /**----------------
     * Set data mapper
     *
     * @param  mixed $aMapper
     * @return Model_XXXX
     */
    public function setMapper($aMapper) {
        $this->_mapper = $aMapper;
        return $this;
    }

    /**
     * Get data mapper
     *
     *
     * @return Model_XXXXMapper
     */
    public function getMapper() {
        if (null === $this->_mapper) {
            $this->setMapper(new Model_HistCurrentDataMapper());
        }
        return $this->_mapper;
    }

    //=========== �������� ������� =====================//

    /**-----------------------------------
     * ���������� �������� ������� � ������� ������
     *
     * @param  string $aSource
     * @return Model_XXXX
     */
    public function setSource($aSource) {
        if($aSource === null){
            $this->_source = null;
        }else{
            $this->_source = (string) $aSource;
        }

        return $this;
    }

    /**---------------------------
     * �������� �������� ������� � ������� ������
     *
     * @return string
     */
    public function getSource() {
        return $this->_source;
    }

    /**-----------------------------------
     * ���������� ��������� �������� ������ � �������
     *
     * @param  string $aTime
     * @return Model_XXXX
     */
    public function setTime($aTime) {
        if($aTime === null){
            $this->_time = null;
        }else{
            $this->_time = (string) $aTime;
        }

        return $this;
    }

    /**---------------------------
     * �������� ��������� �������� ������ � �������
     *
     * @return string
     */
    public function getTime() {
        return $this->_time;
    }

    /**-----------------------------------
     * ���������� ������ ������� � ���� ������ �������
     *
     * @param  string $aStatus
     * @return Model_XXXX
     */
    public function setStatus($aStatus) {
        if($aStatus === null){
            $this->_status = null;
        }else{
            $this->_status = (string) $aStatus;
        }

        return $this;
    }

    /**---------------------------
     * �������� ������ ������� � ���� ������ �������
     *
     * @return string
     */
    public function getStatus() {
        return $this->_status;
    }

    /**-----------------------------------
     * ���������� �������� ������� � ���� ������ �������
     *
     * @param  string $aDescription
     * @return Model_XXXX
     */
    public function setDescription($aDescription) {
        if($aDescription === null){
            $this->_description = null;
        }else{
            $this->_description = (string) $aDescription;
        }

        return $this;
    }

    /**---------------------------
     * �������� �������� ������� � ���� ������ �������
     *
     * @return string
     */
    public function getDescription() {
        return $this->_description;
    }

    /**-----------------------------------
     * ���������� �������� � �������
     *
     * @param  string $aValue
     * @return Model_XXXX
     */
    public function setValue($aValue) {
        if($aValue === null){
            $this->_value = null;
        }else{
            $this->_value = (float) $aValue;
        }

        return $this;
    }

    /**---------------------------
     * �������� �������� � �������
     *
     * @return float
     */
    public function getValue() {
        return $this->_value;
    }



    //====================== ������ ������� ======================//

    /**�������� ������ � ���� ��������
    *
    *
    * @param string $timePeriod // day; current_minute; current_sec 
    * @return array //������ �������� Model_XXXX
    */
    public function fetchTags($timePeriod="current_minute") {
        return $this->getMapper()->fetchTags($timePeriod);
    }
    
    /**�������� ������ � ���� ��������
    *
    *
    * @param string $timePeriod // day; current_minute; current_sec 
    * @return array //������ �������� Model_XXXX
    */
    public function fetchTestTags($timePeriod="current_minute") {
        $arrResult = array();
        //---------
        
        // ������� ����/�����
        $datetime = date("Y-m-d H:i:s");
        
        foreach (myConfig::$arrCurrentTest_Tags as $tag => $params) {
            
            // ������� ����� ���������
            $arrCurrentTags = array_flip (myConfig::$arrCurrentTags);
            $source = $arrCurrentTags[$tag];
            
            // ������� ��������
            $min = $params["scale_min"]; // "scale_max" => 200
            $max = $params["scale_max"];
            $value = rand($min, $max);
            $delta =  rand(1, 100)/1000;
            if($value < $max){
                $value += $delta;
            }
            
            $arrParams = array(
                "time" => $datetime,
                "source" => $source,
                "value" => $value,
                );
            $oHistCurrentData = new Model_HistCurrentData($arrParams);
            
            $arrResult[] = $oHistCurrentData;
        }
        
        return $arrResult;
    }

    /**-----------------------------------------------------
    * �������� ������ � ���������� �������
    *
    *
    * @return array //������ �������� Model_XXXX
    */
    public function fetchTag() {
        $this->getMapper()->fetchTag($this);
    }
}

?>