<?php

/**
 * Модуль взаимодействия с обьектом -> Model_HistDayData
 * и базой данных Hist
 *
 * @uses       Model_DbTable_XXXX
 * @package    cli-azot-m5
 * @subpackage Model
 */
class Model_HistCurrentDataMapper {

    /**
     * @var Model_DbTable_XXXX
     */
    protected $_dbTable;

    /**
     * Определим экземпляр обьекта таблицы для работы с базой данных
     *
     * @param  Model_DbTable_XXXX $aDBTable
     * @return Model_DbTable_XXXX
     */
    public function setDbTable($aDBTable) {
        if (is_string($aDBTable)) {
            $dbTable = new $aDBTable();
        }
        if (!$dbTable instanceof Model_DBCommon) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    /**
     * Получим обьект таблицы Model_DbTable_XXXX
     * для работы с базой данных
     *
     * @return Model_DbTable_XXXX
     */
    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Model_DbTable_HistCurrentData');
        }
        return $this->_dbTable;
    }

    /**
     * Получить данные о тегах заданных в конфигурации
     * за  предыдущую минуту
     *
     * @param string $timePeriod // day; current_minute; current_sec 
     * @return array             //Массив обьектов данных из истории
     */
    public function fetchTags($timePeriod = "current_minute") {
        $arrObjects = array();
        $arrValues = array();
        //--------------------------------
        //Получим период времени
        $arrDates = strBox::getDateTimePeriod($timePeriod);
        //Получим массив позиций
        $arrCurrentTags = myConfig::$arrCurrentTags;
        foreach ($arrCurrentTags as $tag => $alias) {
            $arrValues[$tag] = 'Source';
        }

        // Получим строку запроса
        $strValues = strBox::getParamFor_OR($arrValues);

        //Выполним запрос к базе данных
        $res = $this->getDbTable()->selectData('get_tags', array($strValues, $arrDates["date_min"]));
        while ($arrResult = $res->Fetch()) {
            //Скорректируем дату-время
            $my_time = $arrResult['Time']; //2006-10-16 1:00:00.00
            $my_time = substr($my_time, 0, -3); //$my_time = 2006-10-16 1:00:00
            $arrResult['Time'] = $my_time;
            $oObject = new Model_HistCurrentData($arrResult);
            $arrObjects[] = $oObject;
        }
        return $arrObjects;
    }

    /**
     * Получить данные о конкретном теге
     * за предыдущую минуту
     *
     * @param string $aTag  //Название позиции в истории
     * @return array        //Массив обьектов данных из истории
     */
    public function fetchTag($aTag) {
        $arrObjects = array();
        //--------------------------------
        //Получим период времени
        $arrDates = strBox::getDateTimePeriod("current_minute");
        $source = $aTag;
        $res = $this->getDbTable()->selectData('get_tag', array($source, $arrDates["date_min"]));
        while ($arrResult = $res->Fetch()) {
            //Скорректируем дату-время
            $my_time = $arrResult['Time']; //2006-10-16 1:00:00.00
            $my_time = substr($my_time, 0, -3); //$my_time = 2006-10-16 1:00:00
            $arrResult['Time'] = $my_time;
            $oObject = new Model_HistCurrentData($arrResult);
            $arrObjects[] = $oObject;
        }
        return $arrObjects;
    }

}

?>