<?php

/**
 * Класс обьекта DayData (суточные данные)
 * Представляет класс для работы с суточными данными
 * связь с базой данных осуществляется классом Model_XXXXMapper
 *
 * @uses       Model_XXXMapper
 * @package    сli-azot-m5
 * @subpackage Model
 */
class Model_DayData {

    /** ID пользователя
     * @var int
     */
    protected $_id;

    /** Метка времени
     * @var DateTime
     */
    protected $_ts;

    /** ID Tag
     * @var int
     */
    protected $_tag_id;

    /** Название позиции
     * @var string
     */
    protected $_name;

    /** Дата хранения данных в истории
     * @var Date
     */
    protected $_date_hist;

    /** Время хранения данных в истории
     * @var Time
     */
    protected $_time_hist;

    /** Значение данных в истории
     * @var Decimal
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
            $this->setMapper(new Model_DayDataMapper());
        }
        return $this->_mapper;
    }

    //=============== СВОЙСТВА ОБЬЕКТОВ ===============//

    /**-----------------------------------
     * Установить ID статьи или категории
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
     * Получить название действия
     *
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**-----------------------------------
     * Установить метку времени
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
     * Получить название действия
     *
     * @return string
     */
    public function getTs() {
        return $this->_ts;
    }

    /**-----------------------------------
     * Установить ID Tag
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
     * Получить ID Tag
     *
     * @return string
     */
    public function getTag_id() {
        return $this->_tag_id;
    }

    /**-----------------------------------
     * Установить назвние позиции
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
     * Получить назвние позиции
     *
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**-----------------------------------
     * Установить Дата хранения данных в истории
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
     * Получить Дата хранения данных в истории
     *
     * @return string
     */
    public function getDate_hist() {
        return $this->_date_hist;
    }
    
    /**-----------------------------------
     * Установить Время хранения данных в истории
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
     * Получить Время хранения данных в истории
     *
     * @return string
     */
    public function getTime_hist() {
        return $this->_time_hist;
    }

    /**-----------------------------------
     * Установить Значение данных в истории
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
     * Получить Значение данных в истории
     *
     * @return float
     */
    public function getValue() {
        return $this->_value;
    }


    //====================== МЕТОДЫ ОБЬЕКТА ======================//


    /**-----------------------------
    * Сохранить данные обьекта
    *
    * @return Model_XXXX
    */
    public function save() {
        $this->getMapper()->save($this);
        return $this;
    }

    
    /**-----------------------------------------------------
    * Получить данные о всех обьектах
    *
    *
    * @return array //Массив обьектов Model_XXXX
    */
    public function fetchAll() {
        return $this->getMapper()->fetchAll();
    }

    /**-----------------------------------------------------
    * Получить данные о конкретном обьекте
    *
    *
    * @return array //Массив обьектов Model_XXXX
    */
    public function fetch() {
        $this->getMapper()->fetch($this);
        return $this;
    }
        
    /**-----------------------------
    * Удалить все данные об обьектах
    *
    * @return int //Количество удаленных записей
    */
    public function deleteAll() {
        $count = $this->getMapper()->deleteAll();
        return $count;
    }

    /**-----------------------------
    * Ограничить кол. записей в базе данных
    *
    * @return int //Количество удаленных записей
    */
    public function restrictRows() {
        $count = $this->getMapper()->restrictRows();
        return $count;
    }

    /**-----------------------------
    * Удалить дублированные записи в базе данных
    *
    * @return int //Количество удаленных записей
    */
    public function deleteDouble() {
        $count = $this->getMapper()->deleteDouble($this);
        return $count;
    }
}

?>