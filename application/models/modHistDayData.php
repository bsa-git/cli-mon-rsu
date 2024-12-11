<?php

/**
 * Класс обьекта HistDayData (суточные данные с истории)
 * Представляет класс для работы с суточными данными по истории
 * связь с базой данных осуществляется классом Model_XXXXMapper
 *
 * @uses       Model_XXXMapper
 * @package    сli-azot-m5
 * @subpackage Model
 */
class Model_HistDayData {

    /** Название позиции в истории данных
     * @var string
     */
    protected $_source;

    /** ДатаВремя хранения данных в истории
     * @var DateTime
     */
    protected $_time;
    /** Статус позиции в истории данных
     * @var string
     */
    protected $_status;
    /** Описание позиции в истории данных
     * @var string
     */
    protected $_description;
    /** Значение в истории
     * @var float
     */
    protected $_value;

    /** Обьект связи между базой данных и обьектом приложения
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
     * Получить массив (ключ =значение) обьекта
     *
     * @return array
     */
    public function getValues() {
        $arrValues = array();
        //-------------------
        //Получим все методы обьекта
        $methods = get_class_methods($this);
        foreach ($methods as $method) {
            //Найдем нужные методы
            if (('getValues' != $method)AND
                ('getMapper' != $method)AND
                (strpos($method, 'get') === 0)) {
                //Если значение не равно NULL, то сохраним его в массиве
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
     * Очистить значения обьекта
     *
     * @return Model_XXXX
     */
    public function clearValues() {

        //-------------------
        $arrValues = $this->getValues();
        //Получим все методы обьекта
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
            $this->setMapper(new Model_HistDayDataMapper());
        }
        return $this->_mapper;
    }

    //=============== СВОЙСТВА ОБЬЕКТОВ ===============//

    /**-----------------------------------
     * Установить Название позиции в истории данных
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
     * Получить Название позиции в истории данных
     *
     * @return string
     */
    public function getSource() {
        return $this->_source;
    }

    /**-----------------------------------
     * Установить ДатаВремя хранения данных в истории
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
     * Получить ДатаВремя хранения данных в истории
     *
     * @return string
     */
    public function getTime() {
        return $this->_time;
    }
    /**-----------------------------------
     * Установить статус позиции в базе данных истории
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
     * Получить статус позиции в базе данных истории
     *
     * @return string
     */
    public function getStatus() {
        return $this->_status;
    }

    /**-----------------------------------
     * Установить описание позиции в базе данных истории
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
     * Получить описание позиции в базе данных истории
     *
     * @return string
     */
    public function getDescription() {
        return $this->_description;
    }
    
    /**-----------------------------------
     * Установить Значение в истории
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
     * Получить Значение в истории
     *
     * @return float
     */
    public function getValue() {
        return $this->_value;
    }



    //====================== МЕТОДЫ ОБЬЕКТА ======================//

    /**Получить данные о всех обьектах
    * 
    *
    *
    * @return array //Массив обьектов Model_XXXX
    */
    public function fetchTags() {
        return $this->getMapper()->fetchTags();
    }

    /**-----------------------------------------------------
    * Получить данные о конкретном обьекте
    *
    *
    * @return array //Массив обьектов Model_XXXX
    */
    public function fetchTag() {
        $this->getMapper()->fetchTag($this);
    }
}

?>