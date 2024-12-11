<?php

/**
 * Класс работы с таблицей data_сurrent базы данных DB
 *
 * @uses       Model_DBCommon
 * @package    cli-azot-m5
 * @subpackage Model
 */
class Model_DbTable_CurrentData extends Model_DBCommon {


    /*================ КОНСТРУКТОР ==================
     * Constructor
     *
     * @param  array|null $options
     * @return void
     */
    public function __construct() {
        //Получим адаптер
        parent::__construct (array('name'=>"data_current",'adapter'=>'DB'));
    }


     /**================= МЕТОДЫ ОБЬЕКТА =================
     * SELECT в базе данных
     *
     * @param  string $aType
     * @param  array $aParams
     * @return array
     */
    public function selectData($aType, array $aParams) {

        //----------------------
        //Получим строку запроса к базе данных
        $query = $this->_getQuery($aType, $aParams);
        //Запомним строку запроса для отладки
        $this->_query = $query;
        // Выполнение запроса
        return $this->_selectData($query);
    }
    /**-------------------------------------
     * INSERT в базе данных
     *
     * @param  array $aParams
     * @return int
     */
    public function insertData(array $aParams) {
        //----------------------
        //Получим строку запроса к базе данных
        $fields = $this->_getQryFieldsInsert($aParams);
        $values = $this->_getQryValuesInsert($aParams);
        $query = $this->_getQuery("insert", array($fields,$values));
        //Запомним строку запроса для отладки
        $this->_query = $query;
        //Вставим данные
        $count = $this->_insertData($query);
        return $count;
    }
    /**-------------------------------------
     * UPDATE в базе данных
     *
     * @param  array $aParams
     * @param  array $aWhere
     * @return int
     */
    public function updateData(array $aParams, array $aWhere) {
        //----------------------
        //Получим значения для обновления
        $values = $this->_getQryValuesUpdate($aParams);
        $arrParams = array_merge(array($values), $aWhere);
        //Получим запрос для отображения
        $query = $this->_getQuery('update', $arrParams);
        //Запомним строку запроса для отладки
        $this->_query = $query;
        // Выполнение обновления
        $count = $this->_updateData($query);
        return $count;
    }
    /**--------------------------------------
     * DELETE в базе данных
     *
     * @param  string $aType
     * @param  array $aWhere
     * @return int
     */
    public function deleteData($aType, array $aParams = null) {

        //----------------------
        //Получим запрос для отображения
        $query = $this->_getQuery($aType, $aParams);
        //Запомним строку запроса для отладки
        $this->_query = $query;
        // Выполнение обновления
        $count = $this->_deleteData($query);
        return $count;
    }
    /*-------------------------------
     * Запрос к базе данных
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