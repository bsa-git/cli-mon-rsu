<?php

/**
 * ������ �������������� � �������� -> Model_HistDayData
 * � ����� ������ Hist
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
     * ��������� ��������� ������� ������� ��� ������ � ����� ������
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
     * ������� ������ ������� Model_DbTable_XXXX
     * ��� ������ � ����� ������
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
     * �������� ������ � ����� �������� � ������������
     * �� �����
     *
     * @return array        //������ �������� ������ �� �������
     */
    public function fetchTags() {
        $arrObjects = array();
        //--------------------------------
        //������� ������ �������
        $arrDates = strBox::getDateTimePeriod("day");
        //������� ������ �������
        $arrDayTags = array_keys(myConfig::$arrDayTags);
        //�������� ������ � ���� ������
        foreach($arrDayTags as $tag) {
            $res = $this->getDbTable()->selectData('get_tag',array($tag,$arrDates["date_min"],$arrDates["date_max"]));
            while($arrResult = $res->Fetch()) {
                //������������� ����-�����
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
     * �������� ������ � ���������� ����
     * �� �����
     *
     * @param string $aTag  //�������� ������� � �������
     * @return array        //������ �������� ������ �� �������
     */
    public function fetchTag($aTag) {
        $arrObjects = array();
        //--------------------------------
        //������� ������ �������
        $arrDates = strBox::getDateTimePeriod("day");
        $source = $aTag;
        $res = $this->getDbTable()->selectData('get_tag',array($source,$arrDates["date_min"],$arrDates["date_max"]));
        while($arrResult = $res->Fetch()) {
            //������������� ����-�����
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