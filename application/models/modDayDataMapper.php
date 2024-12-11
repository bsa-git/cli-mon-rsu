<?php

/**
 * ������ �������������� � �������� XXXXX
 * � ����� ������ Bitrix
 *
 * @uses       Model_DbTable_XXXX
 * @package    cli-azot-m5
 * @subpackage Model
 */
class Model_DayDataMapper {
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
            $this->setDbTable('Model_DbTable_DayData');
        }
        return $this->_dbTable;
    }



    /**------------------------------------
     * �������� ���������� �� �������
     *
     * @param  Model_XXXX $aObject
     * @return void
     */
    public function save(Model_DayData $aObject) {

        //--------------------------------
        if (null === ($id = $aObject->id)) {
            $this->getDbTable()->insertData($aObject->getValues());
        } else {
            $this->getDbTable()->updateData($aObject->getValues(),array($id));
        }
    }


    /**-----------------------------
     * �������� ������ � ���� �������� Model_XXXX
     *
     *
     * @return array //������ �������� Model_XXXX
     */
    public function fetchAll() {
        $arrObjects = array();
        //--------------------------------

        $res = $this->getDbTable()->selectData('get_rows_all',array ("`date_hist`"));
        while($arrResult = $res->Fetch()) {
            $oObject = new Model_DayData($arrResult);
            $arrObjects[] = $oObject;
        }

        return $arrObjects;
    }

    /**-----------------------------
     * �������� ������ � ���������� ������� Model_XXXX
     *
     * @param Model_XXXX $aObject   //������
     * @return void
     */
    public function fetch(Model_DayData $aObject) {

        //--------------------------------
        $id = $aObject->id;
        $res = $this->getDbTable()->selectData('get_rows',array ("id",$id));
        while($arrResult = $res->Fetch()) {
            $aObject->values = $arrResult;
        }
    }


    /**-----------------------------
    * ������� ��� ������ ������� Model_XXXX
    *
    * @return int //���������� ��������� �������
     */
    public function deleteAll() {
        $count = $this->getDbTable()->deleteData('delete_all');
        return $count;
    }

    /**-----------------------------
    * ���������� ���. ������� � ���� ������
    *
    * @return int //���������� ��������� �������
     */
    public function restrictRows() {
        $countMax = myConfig::$arrSystem["maxCurrentData"];
        $count = 0;
        $arrDelDays = array();
        //-----------------------
        $res = $this->getDbTable()->selectData('get_data_for_days', array());
        while($arrResult = $res->Fetch()) {
            $count++;
            if($count > $countMax) {
                $arrDelDays[] = $arrResult["date_hist"];
            }
        }
        $count = count($arrDelDays);
        if($count) {
            $strParam = strBox::getParamFor_IN($arrDelDays);
            $count = $this->getDbTable()->deleteData('delete_in2',array("date_hist",$strParam));
        }

        return $count;
    }

    /**-----------------------------
    * ������� ������������� ������ � ���� ������
    *
    * @return int //���������� ��������� �������
    */
    public function deleteDouble(Model_DayData $aObject) {
        $count = 0;
        $arrDelRows = array();
        //-----------------------
        $res = $this->getDbTable()->selectData('get_rows_for_double', array($aObject->name,$aObject->date_hist));
        while($arrResult = $res->Fetch()) {
            $arrDelRows[] = $arrResult["id"];
        }
        $count = count($arrDelRows);
        if($count) {
            $strParam = strBox::getParamFor_IN($arrDelRows);
            $count = $this->getDbTable()->deleteData('delete_in',array($strParam));
        }

        return $count;
    }
}

?>