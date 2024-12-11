<?php

/**
 * ����� ������� Tags (���������� �� ��������)
 * ������������ ����� ��� ������ � ����������� � ��������
 * ����� � ����� ������ �������������� ������� Model_XXXXMapper
 *
 * @uses       Model_XXXMapper
 * @package    �li-azot-m5
 * @subpackage Model
 */
class Model_Tags {

    /** ID ������������
     * @var int
     */
    protected $_id;

    /** ����� �������
     * @var DateTime
     */
    protected $_ts;

    /** ���� (������) ��� ����������� ������
     * @var string
     */
    protected $_topic;

    /** �������� ����
     * @var string
     */
    protected $_name_topic;

    /** ��������� �������������� �������
     * ��. "02AMIAK:02F4.PNT" =>"02NH3_F4"
     * @var string
     */
    protected $_alias;

    /** �������� ���������� ��������������� �������
     * @var string
     */
    protected $_name_alias;

    /** �������� �������
     * ��. 02NH3_F4 => F (������)
     * @var string
     */
    protected $_tag_param;

    /** �������� ��������� �������
     * ��. F => ������
     * @var string
     */
    protected $_name_param;

    /** ������� ��������� ��������
     * ��.
     * @var string
     */
    protected $_value_unit;

    /** ��� ��������
     * ��. ��/��2
     * @var string
     */
    protected $_value_type;

    /** ����� �����������
     * @var float
     */
    protected $_scale_min;
    
    /** ����� ������������
     * @var float
     */
    protected $_scale_max;

    /** ������������ �����������
     * @var float
     */
    protected $_signal_min;

    /** ������������ ������������
     * @var float
     */
    protected $_signal_max;

    /** ���������� �����������
     * @var float
     */
    protected $_blocking_min;

    /** ���������� ������������
     * @var float
     */
    protected $_blocking_max;

    /** �����������
     * @var string
     */
    protected $_comment;

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
            $this->setMapper(new Model_TagsMapper());
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
     * ���������� ���� (������) ��� ����������� ������
     *
     * @param  string $aTopic
     * @return Model_XXXX
     */
    public function setTopic($aTopic) {
        if($aTopic === null){
            $this->_topic = null;
        }else{
            $this->_topic = (string) $aTopic;
        }

        return $this;
    }

    /**---------------------------
     * �������� ���� (������) ��� ����������� ������
     *
     * @return string
     */
    public function getTopic() {
        return $this->_topic;
    }

    /**-----------------------------------
     * ���������� �������� ����
     *
     * @param  string $aName_topic
     * @return Model_XXXX
     */
    public function setName_topic($aName_topic) {
        if($aName_topic === null){
            $this->_name_topic = null;
        }else{
            $this->_name_topic = (string) $aName_topic;
        }

        return $this;
    }

    /**---------------------------
     * �������� �������� ����
     *
     * @return string
     */
    public function getName_topic() {
        return $this->_name_topic;
    }

    /**-----------------------------------
     * ���������� ��������� �������������� �������
     *
     * @param  string $aAlias
     * @return Model_XXXX
     */
    public function setAlias($aAlias) {
        if($aAlias === null){
            $this->_alias = null;
        }else{
            $this->_alias = (string) $aAlias;
        }

        return $this;
    }

    /**---------------------------
     * �������� ��������� �������������� �������
     *
     * @return string
     */
    public function getAlias() {
        return $this->_alias;
    }

    /**
     * ���������� �������� ���������� ��������������� �������
     *
     * @param  string $aName_alias
     * @return Model_XXXX
     */
    public function setName_alias($aName_alias) {
        if($aName_alias === null){
            $this->_name_alias = null;
        }else{
            $this->_name_alias = (string) $aName_alias;
        }

        return $this;
    }

    /**
     * �������� �������� ���������� ��������������� �������
     *
     * @return string
     */
    public function getName_alias() {
        return $this->_name_alias;
    }

    /**
     * ���������� �������� �������
     *
     * @param  string $aTag_param
     * @return Model_XXXX
     */
    public function setTag_param($aTag_param) {
        if($aTag_param === null){
            $this->_tag_param = null;
        }else{
            $this->_tag_param = (string) $aTag_param;
        }

        return $this;
    }

    /**
     * �������� �������� �������
     *
     * @return string
     */
    public function getTag_param() {
        return $this->_tag_param;
    }

    /**
     * ���������� �������� ��������� �������
     *
     * @param  string $aName_param
     * @return Model_XXXX
     */
    public function setName_param($aName_param) {
        if($aName_param === null){
            $this->_name_param = null;
        }else{
            $this->_name_param = (string) $aName_param;
        }

        return $this;
    }

    /**
     * �������� �������� ��������� �������
     *
     * @return string
     */
    public function getName_param() {
        return $this->_name_param;
    }

    /**
     * ���������� ������� ��������� ��������
     *
     * @param  string $aValue_unit
     * @return Model_XXXX
     */
    public function setValue_unit($aValue_unit) {
        if($aValue_unit === null){
            $this->_value_unit = null;
        }else{
            $this->_value_unit = (string) $aValue_unit;
        }

        return $this;
    }

    /**
     * �������� ������� ��������� ��������
     *
     * @return string
     */
    public function getValue_unit() {
        return $this->_value_unit;
    }

    /**
     * ���������� ��� ��������
     *
     * @param  string $aValue_type
     * @return Model_XXXX
     */
    public function setValue_type($aValue_type) {
        if($aValue_type === null){
            $this->_value_type = null;
        }else{
            $this->_value_type = (string) $aValue_type;
        }

        return $this;
    }

    /**
     * �������� ��� ��������
     *
     * @return string
     */
    public function getValue_type() {
        return $this->_value_type;
    }

    /**
     * ���������� ����� �����������
     *
     * @param  float $aScale_min
     * @return Model_XXXX
     */
    public function setScale_min($aScale_min) {
        if($aScale_min === null){
            $this->_scale_min = null;
        }else{
            $this->_scale_min = (float) $aScale_min;
        }

        return $this;
    }

    /**
     * �������� ����� �����������
     *
     * @return string
     */
    public function getScale_min() {
        return $this->_scale_min;
    }

    /**
     * ���������� ����� ������������
     *
     * @param  float $aScale_max
     * @return Model_XXXX
     */
    public function setScale_max($aScale_max) {
        if($aScale_max === null){
            $this->_scale_max = null;
        }else{
            $this->_scale_max = (float) $aScale_max;
        }

        return $this;
    }

    /**
     * �������� ����� ������������
     *
     * @return string
     */
    public function getScale_max() {
        return $this->_scale_max;
    }

    /**
     * ���������� ������������ �����������
     *
     * @param  float $aSignal_min
     * @return Model_XXXX
     */
    public function setSignal_min($aSignal_min) {
        if($aSignal_min === null){
            $this->_signal_min = null;
        }else{
            $this->_signal_min = (float) $aSignal_min;
        }

        return $this;
    }

    /**
     * �������� ������������ �����������
     *
     * @return string
     */
    public function getSignal_min() {
        return $this->_signal_min;
    }

    /**
     * ���������� ������������ ������������
     *
     * @param  float $aSignal_max
     * @return Model_XXXX
     */
    public function setSignal_max($aSignal_max) {
        if($aSignal_max === null){
            $this->_signal_max = null;
        }else{
            $this->_signal_max = (float) $aSignal_max;
        }

        return $this;
    }

    /**
     * �������� ������������ ������������
     *
     * @return string
     */
    public function getSignal_max() {
        return $this->_signal_max;
    }

    /**
     * ���������� ���������� �����������
     *
     * @param  float $aBlocking_min
     * @return Model_XXXX
     */
    public function setBlocking_min($aBlocking_min) {
        if($aBlocking_min === null){
            $this->_blocking_min = null;
        }else{
            $this->_blocking_min = (float) $aBlocking_min;
        }

        return $this;
    }

    /**
     * �������� ���������� �����������
     *
     * @return string
     */
    public function getBlocking_min() {
        return $this->_blocking_min;
    }

    /**
     * ���������� ���������� ������������
     *
     * @param  float $aBlocking_max
     * @return Model_XXXX
     */
    public function setBlocking_max($aBlocking_max) {
        if($aBlocking_max === null){
            $this->_blocking_max = null;
        }else{
            $this->_blocking_max = (float) $aBlocking_max;
        }

        return $this;
    }

    /**
     * �������� ���������� ������������
     *
     * @return string
     */
    public function getBlocking_max() {
        return $this->_blocking_max;
    }

    /**
     * ���������� �����������
     *
     * @param  string $aComment
     * @return Model_XXXX
     */
    public function setComment($aComment) {
        if($aComment === null){
            $this->_comment = null;
        }else{
            $this->_comment = (string) $aComment;
        }

        return $this;
    }

    /**
     * �������� �����������
     *
     * @return string
     */
    public function getComment() {
        return $this->_comment;
    }


    //====================== ������ ������� ======================//


    /**
    * ��������� ������ �������
    *
    * @return Model_XXXX
    */
    public function save() {
        $this->getMapper()->save($this);
        return $this;
    }

    
    /**
    * �������� ������ � ���� ��������
    *
    *
    * @return array //������ �������� Model_XXXX
    */
    public function fetchAll() {
        return $this->getMapper()->fetchAll();
    }
    
    /**
    * �������� ������ � ����� 
    * ��� �������������� �������
    *
    * @param array $arrAlias
    * @return array //������ �������� Model_XXXX
    */
    public function fetchTags($arrAlias) {
        return $this->getMapper()->fetchTags($arrAlias);
    }

    /**
    * �������� ������ � ���������� �������
    *
    *
    * @return object //������ Model_XXXX
    */
    public function fetch() {
        $this->getMapper()->fetch($this);
        return $this;
    }

    /**
    * ����� ������ �� ����� �������
    *
    *
    * @return object //������ Model_XXXX
    */
    public function find() {
        $this->getMapper()->find($this);
        return $this;
    }
        
    /**
    * ������� ��� ������ �� ��������
    *
    * @return int //���������� ��������� �������
    */
    public function deleteAll() {
        $count = $this->getMapper()->deleteAll();
        return $count;
    }
    
    //====================== ������ ������ ======================//
    /**
     * ��������/�������� ������ � ������� "Tags"
     *
     * @return int // ���������� �����������/����������� �������
     */
    static function insertRowsToTagsTable() {
        $insertCount = 0;
        $updateCount = 0;
        $isUpdateCount = FALSE;
        //------------------------------------
        if (!count(myConfig::$arrCurrentDB_Tags)) {
            return;
        }
        foreach (myConfig::$arrCurrentDB_Tags as $key => $arrTags) {
            //������� ������ Model_Tags
            $oTag = new Model_Tags();
            $oTag->alias = $key;
            $oTag->find();
            if ($oTag->id) {// ���� ���� ����� ������� � ����, �������� �� ����������
                $arrTags = Model_DBCommon::ConvertWinUtf($arrTags);
                foreach ($arrTags as $keyTag => $valueTag) {
                    $oTagValue = $oTag->$keyTag;
                    if($valueTag != $oTagValue){
                        sysBox::printTXT("<--- Updated row: alias = $key ;  arrTags->$keyTag = $valueTag ; --->");
                        $isUpdateCount = TRUE;
                        $oTag->$keyTag = $valueTag;
                    }
                }
                if($isUpdateCount){
                    $oTag->ts = strBox::getCurrentDateTime();
                    $oTag->save();
                    $updateCount += 1;
                    $isUpdateCount = FALSE;
                }
            } else {// ���� ��� ����� ������� � ����, ������� ������
                $arrTags = Model_DBCommon::ConvertWinUtf($arrTags);
                $oTag = new Model_Tags($arrTags);
                $oTag->ts = strBox::getCurrentDateTime();
                $oTag->save();
                $insertCount += 1;
            }
        }
        if ($insertCount) {
            sysBox::printTXT("<--- Inserted rows to 'tags' table ( count = $insertCount) --->");
        }
        if ($updateCount) {
            sysBox::printTXT("<--- Updated rows to 'tags' table ( count = $updateCount) --->");
        }
        return $insertCount + $updateCount;
    }
}

?>