<?php

/**
 * Помощник для контроллера истории (AIM HISTORY)
 *
 *
 * @package    cli-azot-m5
 * @subpackage Helper
 */
class Helper_HistController {

    /**
     * Получим массив обьектов оDayData для сохранения
     * данных этих обьектов в базе данных
     *
     * @param  array $aHistDayDataObjects   //Массив обьектов оHistDayData
     *
     * @return array                        //Массив обьектов оDayData
     */
    public function getDayDataObjects(array $aHistDayDataObjects) {
        $arrDayData = array();
        $alias = "";
        $idTag = 0;
        //--------------------------
        //Создадим обьект Model_Tags
        $oTags = new Model_Tags();

        foreach ($aHistDayDataObjects as $histDayDataObject) {

            //Создадим обьект Model_DayData
            $oDayData = new Model_DayData();
            //Очистим значения обьектов
            $oTags->clearValues();

            //Установим данные для обьекта $oDayData
            $tag = $histDayDataObject->source;

            if ($alias !== myConfig::$arrDayTags[$tag]) {
                $alias = myConfig::$arrDayTags[$tag];
                $oTags->alias = $alias;
                $oTags->find();
                $idTag = $oTags->id;
                $oDayData->tag_id = $idTag;
            } else {
                $oDayData->tag_id = $idTag;
            }
            $timeHist = $histDayDataObject->time;
            $oDayData->name = $alias;
            $oDayData->date_hist = strBox::getFormatDateTime($timeHist, "Y-m-d");
            $oDayData->time_hist = strBox::getFormatDateTime($timeHist, "H:i:s");
            $oDayData->value = $histDayDataObject->value;

            //Сохраним обьект в массиве
            $arrDayData[] = $oDayData;
        }
        return $arrDayData;
    }

    /**
     * Получим массив обьектов оCurrentData для сохранения
     * данных этих обьектов в базе данных
     *
     * @param  array $aHistCurrentDataObjects   //Массив обьектов оHistCurrentData
     *
     * @return array                            //Массив обьектов оCurrentData
     */
    public function getCurrentDataObjects(array $aHistCurrentDataObjects) {
        $arrCurrentData = array();
        //--------------------------
        foreach ($aHistCurrentDataObjects as $histCurrentDataObject) {
            //Получим обьект Model_Tags
            $oTag = new Model_Tags();
            //Получим обьект Model_CurrentData
            $oCurrentData = new Model_CurrentData();

            //Установим данные для обьекта $oDayData
            $tag = $histCurrentDataObject->source;
            $alias = myConfig::$arrCurrentTags[$tag];
            $oTag->alias = $alias;
            $oTag->find();
            // Если есть такая позиция в базе, запишем ее в массив
            if ($oTag->id) {
                $oCurrentData->ts = strBox::getCurrentDateTime();
                $oCurrentData->tag_id = $oTag->id;
                $oCurrentData->name = $alias;
                $timeHist = $histCurrentDataObject->time;
                $oCurrentData->date_hist = strBox::getFormatDateTime($timeHist, "Y-m-d");
                $oCurrentData->time_hist = strBox::getFormatDateTime($timeHist, "H:i:s");
                $oCurrentData->value = $histCurrentDataObject->value;

                //Сохраним обьект в массиве
                $arrCurrentData[] = $oCurrentData;
            }
        }
        return $arrCurrentData;
    }

    /**
     * Получим обьект оCurrentValues для сохранения
     * данных в базе данных
     *
     * @param  array $aHistCurrentDataObjects   //Массив обьектов оHistCurrentData
     * @param  boolean $forDB                   // For DB
     * @return Model_CurrentValues              //Обьект $oCurrentValues
     */
    public function getCurrentValuesObjects(array $aHistCurrentDataObjects, $forDB = true) {
        //--------------------------
        //Получим обьект Model_CurrentValues
        $oCurrentValues = new Model_CurrentValues();
        // Установим некоторые поля в обьекте $oCurrentValues
        $histCurrentDataObject = $aHistCurrentDataObjects[0];
        $oCurrentValues->ts = strBox::getCurrentDateTime();
        $timeHist = $histCurrentDataObject->time;
        $oCurrentValues->date_hist = strBox::getFormatDateTime($timeHist, "Y-m-d");
        $oCurrentValues->time_hist = strBox::getFormatDateTime($timeHist, "H:i:s");
        // Установим поля name и value
        foreach ($aHistCurrentDataObjects as $histCurrentDataObject) {
            //Установим данные для обьекта $oDayData
            $tag = $histCurrentDataObject->source;
            $alias = myConfig::$arrCurrentTags[$tag];
            $value = (string) $histCurrentDataObject->value;

            if ($forDB) {
                //Получим обьект Model_Tags
                if ($alias) {
                    $oTag = new Model_Tags();
                    $oTag->alias = $alias;
                    $oTag->find();
                    // Если есть такая позиция в базе, запишем ее в массив
                    if ($oTag->id) {
                        $oCurrentValues->name .= $alias . ';';
                        $oCurrentValues->value .= $value . ';';
                    }
                }
            } else {
                $oCurrentValues->name .= $alias . ';';
                $oCurrentValues->value .= $value . ';';
            }
        }
        // Уберем последний разделитель в именах и в значениях
        $oCurrentValues->name = rtrim($oCurrentValues->name, ';');
        $oCurrentValues->value = rtrim($oCurrentValues->value, ';');
        return $oCurrentValues;
    }

    /**
     * Удалить дублированные записи в базе данных
     *
     * @param  array $aObjects   //Массив обьектов
     *
     * @return int              //Кол. удаленных записей
     */
    public function deleteDoubleRows_DayData(array $aObjects) {
        $count = 0;
        $name = "";
        $date_hist = "";
        //--------------------------
        foreach ($aObjects as $oObject) {
            //Удалим дублированные записи в базе данных
            if ($name !== $oObject->name OR $date_hist !== $oObject->date_hist) {
                $count += $oObject->deleteDouble();
                $name = $oObject->name;
                $date_hist = $oObject->date_hist;
            }
        }
        if ($count) {
            $msg = "WARNING... Удалено из MySQL дублированных записей - $count";
            sysBox::setDebugInfo("warnings", array("message" => $msg));
            sysBox::printTXT($msg);
        }
        return $count;
    }

    /**
     * Удалить дублированные записи в базе данных
     *
     * @param  array $aObjects   //Массив обьектов
     *
     * @return int              //Кол. удаленных записей
     */
    public function deleteDoubleRows_CurrentData(array $aObjects) {
        $count = 0;
        $name = "";
        $date_hist = "";
        $time_hist = "";
        //--------------------------
        foreach ($aObjects as $oObject) {
            //Удалим дублированные записи в базе данных
            if ($name !== $oObject->name OR
                    $date_hist !== $oObject->date_hist OR
                    $time_hist !== $oObject->time_hist) {
                $count += $oObject->deleteDouble();
                $name = $oObject->name;
                $date_hist = $oObject->date_hist;
                $time_hist = $oObject->time_hist;
            }
        }
        if ($count) {
            $msg = "WARNING... Удалено из MySQL дублированных записей - $count";
            sysBox::setDebugInfo("warnings", array("message" => $msg));
            sysBox::printTXT($msg);
        }
        return $count;
    }

}

?>