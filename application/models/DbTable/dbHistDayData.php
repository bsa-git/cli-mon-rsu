<?php

/**
 * ����� ������ � �������� Sample/hist00.Current ���� ������ ODBC
 *
 * @uses       Model_DBCommon
 * @package    bx-azot
 * @subpackage Model
 */
class Model_DbTable_HistDayData extends Model_DBCommon {


    /*================ ����������� ==================
     * Constructor
     *
     * @param  array|null $options
     * @return void
    */
    public function __construct() {
        $dbName =  parent::$arrParamsODBC['DBName'];
        //������� �������
        parent::__construct (array('name'=>"Sample/$dbName.Current",'adapter'=>'ODBC'));
    }


    /**================= ������ ������� =================
     * SELECT � ���� ������
     *
     * @param  string $aType
     * @param  array $aParams
     * @return array
     */
    public function selectData($aType, array $aParams) {

        //----------------------
        //������� ������ ������� � ���� ������
        $query = $this->_getQuery($aType, $aParams);
        //�������� ������ ������� ��� �������
        $this->_query = $query;
        // ���������� �������
        return $this->_selectData($query);
    }
    /**-------------------------------------
     * INSERT � ���� ������
     *
     * @param  array $aParams
     * @return int
     */
    public function insertData(array $aParams) {
        //----------------------
        //������� ������ ������� � ���� ������
        $fields = $this->_getQryFieldsInsert($aParams);
        $values = $this->_getQryValuesInsert($aParams);
        $query = $this->_getQuery("insert", array($fields,$values));
        //�������� ������ ������� ��� �������
        $this->_query = $query;
        //������� ������
        $count = $this->_insertData($query);
        return $count;
    }
    /**-------------------------------------
     * UPDATE � ���� ������
     *
     * @param  array $aParams
     * @param  array $aWhere
     * @return int
     */
    public function updateData(array $aParams, array $aWhere) {
        //----------------------
        //������� �������� ��� ����������
        $values = $this->_getQryValuesUpdate($aParams);
        $arrParams = array_merge(array($values), $aWhere);
        //������� ������ ��� �����������
        $query = $this->_getQuery('update', $arrParams);
        //�������� ������ ������� ��� �������
        $this->_query = $query;
        // ���������� ����������
        $count = $this->_updateData($query);
        return $count;
    }
    /**--------------------------------------
     * DELETE � ���� ������
     *
     * @param  string $aType
     * @param  array $aWhere
     * @return int
     */
    public function deleteData($aType, array $aParams = null) {

        //----------------------
        //������� ������ ��� �����������
        $query = $this->_getQuery($aType, $aParams);
        //�������� ������ ������� ��� �������
        $this->_query = $query;
        // ���������� ����������
        $count = $this->_deleteData($query);
        return $count;
    }
    /*-------------------------------
     * ������ � ���� ������
     *
     * @param  string $aType
     * @return null|string
    */
    private function _getQuery($aType, array $aParams = null) {
        $table = $this->_name;
        $result = "";
        //---------------------------
        switch($aType) {

            case("get_rows_all"):
                $result = "	SELECT * FROM `$table`  ORDER BY %s";
                $result = sprintf($result, $aParams[0]);
                break;
            case("get_rows"):
                $result = "SELECT * FROM `$table` WHERE `%s` = '%s'";
                $result = sprintf($result, $aParams[0], $aParams[1]);
                break;
            case("get_tag"):
                $result = "SELECT Source, Time, Value FROM $table
         		   WHERE (Source = '%s' AND  Time BETWEEN {ts '%s 01:00:00'} and {ts '%s 00:00:00'})";
                $result = sprintf($result, $aParams[0], $aParams[1], $aParams[2]);
                break;
            default:
                break;
        }
        return $result;
    }
}

?>