<?php

/**
 * Модуль взаимодействия с обьектом XXXXX
 * и базой данных
 *
 * @uses       Model_DbTable_XXXX
 * @package    cli-azot-m5
 * @subpackage Model
 */
class Model_TagsMapper {
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
            $this->setDbTable('Model_DbTable_Tags');
        }
        return $this->_dbTable;
    }



    /**
     * Сохраним информацию об обьекте
     *
     * @param  Model_XXXX $aObject
     * @return void
     */
    public function save(Model_Tags $aObject) {

        //--------------------------------
        if (null === ($id = $aObject->id)) {
            $this->getDbTable()->insertData($aObject->getValues());
        } else {
            $this->getDbTable()->updateData($aObject->getValues(),array($id));
        }
    }


    /**
     * Получить данные о всех обьектах Model_XXXX
     *
     *
     * @return array //Массив обьектов Model_XXXX
     */
    public function fetchAll() {
        $arrObjects = array();
        //--------------------------------

        $res = $this->getDbTable()->selectData('get_rows_all',array ("`date_hist`"));
        while($arrResult = $res->Fetch()) {
            $oObject = new Model_Tags($arrResult);
            $arrObjects[] = $oObject;
        }

        return $arrObjects;
    }
    
    /**
     * Получить данные о всех обьектах Model_XXXX
     *
     * @param array $arrAlias
     * @return array //Массив обьектов Model_XXXX
     */
    public function fetchTags($arrAlias) {
        $arrObjects = array();
        //--------------------------------
        
        $inValues = strBox::getParamFor_IN($arrAlias);
        $res = $this->getDbTable()->selectData('get_rows_in',array ("alias",$inValues));
        while($arrResult = $res->Fetch()) {
            $oObject = new Model_Tags($arrResult);
            $arrObjects[] = $oObject;
        }

        return $arrObjects;
    }

    /**
     * Получить данные о конкретном обьекте Model_XXXX
     *
     * @param Model_XXXX $aObject   //Обьект
     * @return void
     */
    public function fetch(Model_Tags $aObject) {

        //--------------------------------
        $id = $aObject->id;
        $res = $this->getDbTable()->selectData('get_rows',array ("id",$id));
        while($arrResult = $res->Fetch()) {
            $aObject->values = $arrResult;
        }
    }

    /**
     * Найти данные о конкретном обьекте Model_XXXX
     * по условиям
     *
     * @param Model_XXXX $aObject   //Обьект
     * @return void
     */
    public function find(Model_Tags $aObject) {

        //--------------------------------
        $arrValues = $aObject->values;
        $strReq = strBox::getParamFor_AND($arrValues);
        $res = $this->getDbTable()->selectData('find',array ($strReq));
        while($arrResult = $res->Fetch()) {
            $aObject->values = $arrResult;
            break;
        }
    }

    
    /**
    * Удалить все данные обьекта Model_XXXX
    *
    * @return int //Количество удаленных записей
     */
    public function deleteAll() {
        $count = $this->getDbTable()->deleteData('delete_all');
        return $count;
    }
}

?>