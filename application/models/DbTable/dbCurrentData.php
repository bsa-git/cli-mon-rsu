<?php

/**
 * ����� ������ � �������� data_�urrent ���� ������ DB
 *
 * @uses       Model_DBCommon
 * @package    cli-azot-m5
 * @subpackage Model
 */
class Model_DbTable_CurrentData extends Model_DBCommon {


    /*================ ����������� ==================
     * Constructor
     *
     * @param  array|null $options
     * @return void
     */
    public function __construct() {
        //������� �������
        parent::__construct (array('name'=>"data_current",'adapter'=>'DB'));
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

            case "insert":
                $result = "INSERT INTO `$table` (%s) VALUES (%s)";
                $result = sprintf($result, $aParams[0], $aParams[1]);
                break;
            case "delete":
                $result = "DELETE FROM `$table` WHERE `id`= '%s'";
                $result = sprintf($result, $aParams[0]);
                break;
            case "delete_this":
                $result = "DELETE FROM `$table` WHERE `%s`= '%s'";
                $result = sprintf($result, $aParams[0], $aParams[1]);
                break;
            case "delete_in":
                $result = "DELETE FROM `$table` 
                           WHERE `id`IN(%s)";
                $result = sprintf($result, $aParams[0]);
                break;
            case "delete_in2":
                $result = "DELETE FROM `$table`
                           WHERE `%s`IN(%s)";
                $result = sprintf($result, $aParams[0],$aParams[1]);
                break;
            case "delete_all":
                $result = "DELETE FROM `$table` ";
                break;
            case "update":
                $result = "UPDATE `$table` SET %s WHERE `id`='%s'";
                $result = sprintf($result, $aParams[0], $aParams[1]);
                break;
            case("get_rows_all"):
                $result = "	SELECT * FROM `$table`  ORDER BY %s";
                $result = sprintf($result, $aParams[0]);
                break;
            case("get_rows"):
                $result = "SELECT * FROM `$table` WHERE `%s` = '%s'";
                $result = sprintf($result, $aParams[0], $aParams[1]);
                break;
            case("get_data_for_days"):
                $result = "SELECT *
                           FROM `$table`
                           GROUP BY `date_hist`
                           ORDER BY `date_hist` DESC";
                break;
            default:
                break;
        }
        return $result;
    }
}

?>