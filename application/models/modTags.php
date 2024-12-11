<?php

/**
 * Класс обьекта Tags (информация по позициям)
 * Представляет класс для работы с информацией о позициях
 * связь с базой данных осуществляется классом Model_XXXXMapper
 *
 * @uses       Model_XXXMapper
 * @package    сli-azot-m5
 * @subpackage Model
 */
class Model_Tags {

    /** ID пользователя
     * @var int
     */
    protected $_id;

    /** Метка времени
     * @var DateTime
     */
    protected $_ts;

    /** Тема (контур) для группировки данных
     * @var string
     */
    protected $_topic;

    /** Название темы
     * @var string
     */
    protected $_name_topic;

    /** Текстовый индентификатор позиции
     * пр. "02AMIAK:02F4.PNT" =>"02NH3_F4"
     * @var string
     */
    protected $_alias;

    /** Описание текстового индентификатора позиции
     * @var string
     */
    protected $_name_alias;

    /** Параметр позиции
     * пр. 02NH3_F4 => F (расход)
     * @var string
     */
    protected $_tag_param;

    /** Название параметра позиции
     * пр. F => Расход
     * @var string
     */
    protected $_name_param;

    /** Единица измерения значения
     * пр.
     * @var string
     */
    protected $_value_unit;

    /** Тип значения
     * пр. кг/см2
     * @var string
     */
    protected $_value_type;

    /** Шкала минимальная
     * @var float
     */
    protected $_scale_min;
    
    /** Шкала максимальная
     * @var float
     */
    protected $_scale_max;

    /** Сигнализация минимальная
     * @var float
     */
    protected $_signal_min;

    /** Сигнализация максимальная
     * @var float
     */
    protected $_signal_max;

    /** Блокировка минимальная
     * @var float
     */
    protected $_blocking_min;

    /** Блокировка максимальная
     * @var float
     */
    protected $_blocking_max;

    /** Комментарий
     * @var string
     */
    protected $_comment;

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
            $this->setMapper(new Model_TagsMapper());
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
     * Установить Тему (контур) для группировки данных
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
     * Получить Тему (контур) для группировки данных
     *
     * @return string
     */
    public function getTopic() {
        return $this->_topic;
    }

    /**-----------------------------------
     * Установить Название темы
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
     * Получить Название темы
     *
     * @return string
     */
    public function getName_topic() {
        return $this->_name_topic;
    }

    /**-----------------------------------
     * Установить Текстовый индентификатор позиции
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
     * Получить Текстовый индентификатор позиции
     *
     * @return string
     */
    public function getAlias() {
        return $this->_alias;
    }

    /**
     * Установить Описание текстового индентификатора позиции
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
     * Получить Описание текстового индентификатора позиции
     *
     * @return string
     */
    public function getName_alias() {
        return $this->_name_alias;
    }

    /**
     * Установить Параметр позиции
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
     * Получить Параметр позиции
     *
     * @return string
     */
    public function getTag_param() {
        return $this->_tag_param;
    }

    /**
     * Установить Название параметра позиции
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
     * Получить Название параметра позиции
     *
     * @return string
     */
    public function getName_param() {
        return $this->_name_param;
    }

    /**
     * Установить Единицу измерения значения
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
     * Получить Единицу измерения значения
     *
     * @return string
     */
    public function getValue_unit() {
        return $this->_value_unit;
    }

    /**
     * Установить Тип значения
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
     * Получить Тип значения
     *
     * @return string
     */
    public function getValue_type() {
        return $this->_value_type;
    }

    /**
     * Установить Шкалу минимальную
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
     * Получить Шкалу минимальную
     *
     * @return string
     */
    public function getScale_min() {
        return $this->_scale_min;
    }

    /**
     * Установить Шкалу максимальную
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
     * Получить Шкалу максимальную
     *
     * @return string
     */
    public function getScale_max() {
        return $this->_scale_max;
    }

    /**
     * Установить Сигнализацию минимальную
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
     * Получить Сигнализацию минимальную
     *
     * @return string
     */
    public function getSignal_min() {
        return $this->_signal_min;
    }

    /**
     * Установить Сигнализацию максимальную
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
     * Получить Сигнализацию максимальную
     *
     * @return string
     */
    public function getSignal_max() {
        return $this->_signal_max;
    }

    /**
     * Установить Блокировку минимальную
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
     * Получить Блокировку минимальную
     *
     * @return string
     */
    public function getBlocking_min() {
        return $this->_blocking_min;
    }

    /**
     * Установить Блокировку максимальную
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
     * Получить Блокировку максимальную
     *
     * @return string
     */
    public function getBlocking_max() {
        return $this->_blocking_max;
    }

    /**
     * Установить Комментарий
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
     * Получить Комментарий
     *
     * @return string
     */
    public function getComment() {
        return $this->_comment;
    }


    //====================== МЕТОДЫ ОБЬЕКТА ======================//


    /**
    * Сохранить данные обьекта
    *
    * @return Model_XXXX
    */
    public function save() {
        $this->getMapper()->save($this);
        return $this;
    }

    
    /**
    * Получить данные о всех обьектах
    *
    *
    * @return array //Массив обьектов Model_XXXX
    */
    public function fetchAll() {
        return $this->getMapper()->fetchAll();
    }
    
    /**
    * Получить данные о тегах 
    * для соответсвующих алиасов
    *
    * @param array $arrAlias
    * @return array //Массив обьектов Model_XXXX
    */
    public function fetchTags($arrAlias) {
        return $this->getMapper()->fetchTags($arrAlias);
    }

    /**
    * Получить данные о конкретном обьекте
    *
    *
    * @return object //Обьект Model_XXXX
    */
    public function fetch() {
        $this->getMapper()->fetch($this);
        return $this;
    }

    /**
    * Найти запись по полям обьекта
    *
    *
    * @return object //Обьект Model_XXXX
    */
    public function find() {
        $this->getMapper()->find($this);
        return $this;
    }
        
    /**
    * Удалить все данные об обьектах
    *
    * @return int //Количество удаленных записей
    */
    public function deleteAll() {
        $count = $this->getMapper()->deleteAll();
        return $count;
    }
    
    //====================== МЕТОДЫ КЛАССА ======================//
    /**
     * Вставить/Обновить записи в таблицу "Tags"
     *
     * @return int // количество вставленных/обновленных записей
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
            //Получим обьект Model_Tags
            $oTag = new Model_Tags();
            $oTag->alias = $key;
            $oTag->find();
            if ($oTag->id) {// Если есть такая позиция в базе, проверим на обновление
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
            } else {// Если нет такой позиции в базе, вставим запись
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