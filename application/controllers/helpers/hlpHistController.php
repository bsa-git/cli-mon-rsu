<?php

/**
 * �������� ��� ����������� ������� (AIM HISTORY)
 *
 *
 * @package    cli-azot-m5
 * @subpackage Helper
 */
class Helper_HistController {

    /**
     * ������� ������ �������� �DayData ��� ����������
     * ������ ���� �������� � ���� ������
     *
     * @param  array $aHistDayDataObjects   //������ �������� �HistDayData
     *
     * @return array                        //������ �������� �DayData
     */
    public function getDayDataObjects(array $aHistDayDataObjects) {
        $arrDayData = array();
        $alias = "";
        $idTag = 0;
        //--------------------------
        //�������� ������ Model_Tags
        $oTags = new Model_Tags();

        foreach ($aHistDayDataObjects as $histDayDataObject) {

            //�������� ������ Model_DayData
            $oDayData = new Model_DayData();
            //������� �������� ��������
            $oTags->clearValues();

            //��������� ������ ��� ������� $oDayData
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

            //�������� ������ � �������
            $arrDayData[] = $oDayData;
        }
        return $arrDayData;
    }

    /**
     * ������� ������ �������� �CurrentData ��� ����������
     * ������ ���� �������� � ���� ������
     *
     * @param  array $aHistCurrentDataObjects   //������ �������� �HistCurrentData
     *
     * @return array                            //������ �������� �CurrentData
     */
    public function getCurrentDataObjects(array $aHistCurrentDataObjects) {
        $arrCurrentData = array();
        //--------------------------
        foreach ($aHistCurrentDataObjects as $histCurrentDataObject) {
            //������� ������ Model_Tags
            $oTag = new Model_Tags();
            //������� ������ Model_CurrentData
            $oCurrentData = new Model_CurrentData();

            //��������� ������ ��� ������� $oDayData
            $tag = $histCurrentDataObject->source;
            $alias = myConfig::$arrCurrentTags[$tag];
            $oTag->alias = $alias;
            $oTag->find();
            // ���� ���� ����� ������� � ����, ������� �� � ������
            if ($oTag->id) {
                $oCurrentData->ts = strBox::getCurrentDateTime();
                $oCurrentData->tag_id = $oTag->id;
                $oCurrentData->name = $alias;
                $timeHist = $histCurrentDataObject->time;
                $oCurrentData->date_hist = strBox::getFormatDateTime($timeHist, "Y-m-d");
                $oCurrentData->time_hist = strBox::getFormatDateTime($timeHist, "H:i:s");
                $oCurrentData->value = $histCurrentDataObject->value;

                //�������� ������ � �������
                $arrCurrentData[] = $oCurrentData;
            }
        }
        return $arrCurrentData;
    }

    /**
     * ������� ������ �CurrentValues ��� ����������
     * ������ � ���� ������
     *
     * @param  array $aHistCurrentDataObjects   //������ �������� �HistCurrentData
     * @param  boolean $forDB                   // For DB
     * @return Model_CurrentValues              //������ $oCurrentValues
     */
    public function getCurrentValuesObjects(array $aHistCurrentDataObjects, $forDB = true) {
        //--------------------------
        //������� ������ Model_CurrentValues
        $oCurrentValues = new Model_CurrentValues();
        // ��������� ��������� ���� � ������� $oCurrentValues
        $histCurrentDataObject = $aHistCurrentDataObjects[0];
        $oCurrentValues->ts = strBox::getCurrentDateTime();
        $timeHist = $histCurrentDataObject->time;
        $oCurrentValues->date_hist = strBox::getFormatDateTime($timeHist, "Y-m-d");
        $oCurrentValues->time_hist = strBox::getFormatDateTime($timeHist, "H:i:s");
        // ��������� ���� name � value
        foreach ($aHistCurrentDataObjects as $histCurrentDataObject) {
            //��������� ������ ��� ������� $oDayData
            $tag = $histCurrentDataObject->source;
            $alias = myConfig::$arrCurrentTags[$tag];
            $value = (string) $histCurrentDataObject->value;

            if ($forDB) {
                //������� ������ Model_Tags
                if ($alias) {
                    $oTag = new Model_Tags();
                    $oTag->alias = $alias;
                    $oTag->find();
                    // ���� ���� ����� ������� � ����, ������� �� � ������
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
        // ������ ��������� ����������� � ������ � � ���������
        $oCurrentValues->name = rtrim($oCurrentValues->name, ';');
        $oCurrentValues->value = rtrim($oCurrentValues->value, ';');
        return $oCurrentValues;
    }

    /**
     * ������� ������������� ������ � ���� ������
     *
     * @param  array $aObjects   //������ ��������
     *
     * @return int              //���. ��������� �������
     */
    public function deleteDoubleRows_DayData(array $aObjects) {
        $count = 0;
        $name = "";
        $date_hist = "";
        //--------------------------
        foreach ($aObjects as $oObject) {
            //������ ������������� ������ � ���� ������
            if ($name !== $oObject->name OR $date_hist !== $oObject->date_hist) {
                $count += $oObject->deleteDouble();
                $name = $oObject->name;
                $date_hist = $oObject->date_hist;
            }
        }
        if ($count) {
            $msg = "WARNING... ������� �� MySQL ������������� ������� - $count";
            sysBox::setDebugInfo("warnings", array("message" => $msg));
            sysBox::printTXT($msg);
        }
        return $count;
    }

    /**
     * ������� ������������� ������ � ���� ������
     *
     * @param  array $aObjects   //������ ��������
     *
     * @return int              //���. ��������� �������
     */
    public function deleteDoubleRows_CurrentData(array $aObjects) {
        $count = 0;
        $name = "";
        $date_hist = "";
        $time_hist = "";
        //--------------------------
        foreach ($aObjects as $oObject) {
            //������ ������������� ������ � ���� ������
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
            $msg = "WARNING... ������� �� MySQL ������������� ������� - $count";
            sysBox::setDebugInfo("warnings", array("message" => $msg));
            sysBox::printTXT($msg);
        }
        return $count;
    }

}

?>