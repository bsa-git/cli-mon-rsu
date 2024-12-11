<?php

/**
 * Модуль взаимодействия с обьектом -> Model_HistDayData
 * и базой данных Hist
 *
 * @uses       Model_DbTable_XXXX
 * @package    cli-azot-m5
 * @subpackage Model
 */
class Model_HistDayDataMapper {
    /**
     * @var Model_DbTable_XXXX
     */
    protected $_dbTable;

    /**------------------------------------------------
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

    /**-----------------------------------------
     * Получим обьект таблицы Model_DbTable_XXXX
     * для работы с базой данных
     *
     * @return Model_DbTable_XXXX
     */
    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Model_DbTable_HistDayData');
        }
        return $this->_dbTable;
    }

    /**-----------------------------
     * Получить данные о тегах заданных в конфигурации
     * за сутки
     *
     * @return array        //Массив обьектов данных из истории
     */
    public function fetchTags() {
        $arrObjects = array();
        //--------------------------------
        //Получим период времени
        $arrDates = strBox::getDateTimePeriod("day");
        //Получим массив позиций
        $arrDayTags = array_keys(myConfig::$arrDayTags);
        //Выполним запрос к базе данных
        foreach($arrDayTags as $tag) {
            $res = $this->getDbTable()->selectData('get_tag',array($tag,$arrDates["date_min"],$arrDates["date_max"]));
            while($arrResult = $res->Fetch()) {
                //Скорректируем дату-время
                $my_time = $arrResult['Time'];//2006-10-16 1:00:00.00
                $my_time = substr($my_time,0,-3);//$my_time = 2006-10-16 1:00:00
                $arr_date = explode(" ",$my_time);//$arr_date[0] = 2006-10-16;$arr_date[1] = 1:00:00
                //Replace date=2006-10-16 0:00:00 to date=2006-10-15 24:00:00
                if (($arr_date[1]=="0:00:00")or($arr_date[1]=="00:00:00")) {
                    $arr_date[0] = strBox::getPreviousDate($arr_date[0]);
                    $arr_date[1] = "23:59:59";
                    $my_time = $arr_date[0]." ".$arr_date[1];
                };
                $arrResult['Time'] = $my_time;
                $oObject = new Model_HistDayData($arrResult);
                $arrObjects[] = $oObject;
            }
        }
        return $arrObjects;
    }

    /**-----------------------------
     * Получить данные о конкретном теге
     * за сутки
     *
     * @param string $aTag  //Название позиции в истории
     * @return array        //Массив обьектов данных из истории
     */
    public function fetchTag($aTag) {
        $arrObjects = array();
        //--------------------------------
        //Получим период времени
        $arrDates = strBox::getDateTimePeriod("day");
        $source = $aTag;
        $res = $this->getDbTable()->selectData('get_tag',array($source,$arrDates["date_min"],$arrDates["date_max"]));
        while($arrResult = $res->Fetch()) {
            //Скорректируем дату-время
            $my_time = $arrResult['Time'];//2006-10-16 1:00:00.00
            $my_time = substr($my_time,0,-3);//$my_time = 2006-10-16 1:00:00
            $arr_date = explode(" ",$my_time);//$arr_date[0] = 2006-10-16;$arr_date[1] = 1:00:00
            //Replace date=2006-10-16 0:00:00 to date=2006-10-15 24:00:00
            if (($arr_date[1]=="0:00:00")or($arr_date[1]=="00:00:00")) {
                $arr_date[0] = strBox::getPreviousDate($arr_date[0]);
                $arr_date[1] = "23:59:59";
                $my_time = $arr_date[0]." ".$arr_date[1];
            };
            $arrResult['Time'] = $my_time;
            $oObject = new Model_HistDayData($arrResult);
            $arrObjects[] = $oObject;
        }
        return $arrObjects;
    }
}

?>