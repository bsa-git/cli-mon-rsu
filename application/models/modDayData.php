<?php

/**
 * ����� ������� DayData (�������� ������)
 * ������������ ����� ��� ������ � ��������� �������
 * ����� � ����� ������ �������������� ������� Model_XXXXMapper
 *
 * @uses       Model_XXXMapper
 * @package    �li-azot-m5
 * @subpackage Model
 */
class Model_DayData {

    /** ID ������������
     * @var int
     */
    protected $_id;

    /** ����� �������
     * @var DateTime
     */
    protected $_ts;

    /** ID Tag
     * @var int
     */
    protected $_tag_id;

    /** �������� �������
     * @var string
     */
    protected $_name;

    /** ���� �������� ������ � �������
     * @var Date
     */
    protected $_date_hist;

    /** ����� �������� ������ � �������
     * @var Time
     */
    protected $_time_hist;

    /** �������� ������ � �������
     * @var Decimal
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
     * Lazy loads Default_Model_Buh1cMapper instance if no mapper registered.
     *
     * @return Model_XXXXMapper
     */
    public function getMapper() {
        if (null === $this->_mapper) {
            $this->setMapper(new Model_DayDataMapper());
        }
        return $this->_mapper;
    }

    //=============== �������� �������� ===============//

    /**-----------------------------------
     * ���������� ID ������ ��� ���������
     *
     * @param  string $aID
     * @return Model_XXXX
     */
    public function setId($aID) {
        if($aID === null){
            $this->_id = null;
        }else{
            $this->_id = (int) $aID;
        }

        return $this;
    }

    /**---------------------------
     * �������� �������� ��������
     *
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**-----------------------------------
     * ���������� ����� �������
     *
     * @param  string $aTS
     * @return Model_XXXX
     */
    public function setTs($aTS) {
        if($aTS === null){
            $this->_ts = null;
        }else{
            $this->_ts = (string) $aTS;
        }

        return $this;
    }

    /**---------------------------
     * �������� �������� ��������
     *
     * @return string
     */
    public function getTs() {
        return $this->_ts;
    }

    /**-----------------------------------
     * ���������� ID Tag
     *
     * @param  string $aTag_id
     * @return Model_XXXX
     */
    public function setTag_id($aTag_id) {
        if($aTag_id === null){
            $this->_tag_id = null;
        }else{
            $this->_tag_id = (int) $aTag_id;
        }

        return $this;
    }

    /**---------------------------
     * �������� ID Tag
     *
     * @return string
     */
    public function getTag_id() {
        return $this->_tag_id;
    }

    /**-----------------------------------
     * ���������� ������� �������
     *
     * @param  string $aName
     * @return Model_XXXX
     */
    public function setName($aName) {
        if($aName === null){
            $this->_name = null;
        }else{
            $this->_name = (string) $aName;
        }

        return $this;
    }

    /**---------------------------
     * �������� ������� �������
     *
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**-----------------------------------
     * ���������� ���� �������� ������ � �������
     *
     * @param  string $aDate_hist
     * @return Model_XXXX
     */
    public function setDate_hist($aDate_hist) {
        if($aDate_hist === null){
            $this->_date_hist = null;
        }else{
            $this->_date_hist = (string) $aDate_hist;
        }

        return $this;
    }

    /**---------------------------
     * �������� ���� �������� ������ � �������
     *
     * @return string
     */
    public function getDate_hist() {
        return $this->_date_hist;
    }
    
    /**-----------------------------------
     * ���������� ����� �������� ������ � �������
     *
     * @param  string $aTime_hist
     * @return Model_XXXX
     */
    public function setTime_hist($aTime_hist) {
        if($aTime_hist === null){
            $this->_time_hist = null;
        }else{
            $this->_time_hist = (string) $aTime_hist;
        }

        return $this;
    }

    /**---------------------------
     * �������� ����� �������� ������ � �������
     *
     * @return string
     */
    public function getTime_hist() {
        return $this->_time_hist;
    }

    /**-----------------------------------
     * ���������� �������� ������ � �������
     *
     * @param  float $aValue
     * @return Model_XXXX
     */
    public function setValue($aValue) {
        if($aValue === null){
            $this->_value = null;
        }else{
            $this->_value = (float)$aValue;
        }

        return $this;
    }

    /**---------------------------
     * �������� �������� ������ � �������
     *
     * @return float
     */
    public function getValue() {
        return $this->_value;
    }


    //====================== ������ ������� ======================//


    /**-----------------------------
    * ��������� ������ �������
    *
    * @return Model_XXXX
    */
    public function save() {
        $this->getMapper()->save($this);
        return $this;
    }

    
    /**-----------------------------------------------------
    * �������� ������ � ���� ��������
    *
    *
    * @return array //������ �������� Model_XXXX
    */
    public function fetchAll() {
        return $this->getMapper()->fetchAll();
    }

    /**-----------------------------------------------------
    * �������� ������ � ���������� �������
    *
    *
    * @return array //������ �������� Model_XXXX
    */
    public function fetch() {
        $this->getMapper()->fetch($this);
        return $this;
    }
        
    /**-----------------------------
    * ������� ��� ������ �� ��������
    *
    * @return int //���������� ��������� �������
    */
    public function deleteAll() {
        $count = $this->getMapper()->deleteAll();
        return $count;
    }

    /**-----------------------------
    * ���������� ���. ������� � ���� ������
    *
    * @return int //���������� ��������� �������
    */
    public function restrictRows() {
        $count = $this->getMapper()->restrictRows();
        return $count;
    }

    /**-----------------------------
    * ������� ������������� ������ � ���� ������
    *
    * @return int //���������� ��������� �������
    */
    public function deleteDouble() {
        $count = $this->getMapper()->deleteDouble($this);
        return $count;
    }
}

?>