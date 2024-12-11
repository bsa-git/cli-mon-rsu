<?php

/**
 * Класс работы с таблицей Sample/hist00.Current базы данных ODBC
 *
 * @uses       Model_DBCommon
 * @package    bx-azot
 * @subpackage Model
 */
class Model_DbTable_HistDayData extends Model_DBCommon {


    /*================ КОНСТРУКТОР ==================
     * Constructor
     *
     * @param  array|null $options
     * @return void
    */
    public function __construct() {
        $dbName =  parent::$arrParamsODBC['DBName'];
        //Получим адаптер
        parent::__construct (array('name'=>"Sample/$dbName.Current",'adapter'=>'ODBC'));
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