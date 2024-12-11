<?php

/**
 * ������ �������������� � �������� -> Model_HistDayData
 * � ����� ������ Hist
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

    /**
     * ������� ������ ������� Model_DbTable_XXXX
     * ��� ������ � ����� ������
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
     * �������� ������ � ����� �������� � ������������
     * ��  ���������� ������
     *
     * @param string $timePeriod // day; current_minute; current_sec 
     * @return array             //������ �������� ������ �� �������
     */
    public function fetchTags($timePeriod = "current_minute") {
        $arrObjects = array();
        $arrValues = array();
        //--------------------------------
        //������� ������ �������
        $arrDates = strBox::getDateTimePeriod($timePeriod);
        //������� ������ �������
        $arrCurrentTags = myConfig::$arrCurrentTags;
        foreach ($arrCurrentTags as $tag => $alias) {
            $arrValues[$tag] = 'Source';
        }

        // ������� ������ �������
        $strValues = strBox::getParamFor_OR($arrValues);

        //�������� ������ � ���� ������
        $res = $this->getDbTable()->selectData('get_tags', array($strValues, $arrDates["date_min"]));
        while ($arrResult = $res->Fetch()) {
            //������������� ����-�����
            $my_time = $arrResult['Time']; //2006-10-16 1:00:00.00
            $my_time = substr($my_time, 0, -3); //$my_time = 2006-10-16 1:00:00
            $arrResult['Time'] = $my_time;
            $oObject = new Model_HistCurrentData($arrResult);
            $arrObjects[] = $oObject;
        }
        return $arrObjects;
    }

    /**
     * �������� ������ � ���������� ����
     * �� ���������� ������
     *
     * @param string $aTag  //�������� ������� � �������
     * @return array        //������ �������� ������ �� �������
     */
    public function fetchTag($aTag) {
        $arrObjects = array();
        //--------------------------------
        //������� ������ �������
        $arrDates = strBox::getDateTimePeriod("current_minute");
        $source = $aTag;
        $res = $this->getDbTable()->selectData('get_tag', array($source, $arrDates["date_min"]));
        while ($arrResult = $res->Fetch()) {
            //������������� ����-�����
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