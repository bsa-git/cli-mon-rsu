<?php

/*
 * ==============  КЛАСС ОБРАБОТКИ ОШИБОК БАЗЫ ДАННЫХ ============//
 * Ошибки Базы Данных
 * Modul Common.php Copyright @ 2009 BSA
 * @uses    Exception
 * @package bx-azot
 */

class Model_DBException extends Exception {

    private $typeError = "";

    //-------------------------------
    //Конструктор
    public function __construct($typeError, $message, $code = 0) {
        parent::__construct($message, $code);
        $this->typeError = $typeError;
    }

    //------------
    //toString()
    public function __toString() {
        return "$this->message\n";
    }

    //-------------------
    //Получить тип ошибки
    public function GetTypeError() {
        return $this->typeError;
    }

}

/**
 * =================================================================
 * Промежуточный класс базы данных для общих функций
 *
 * @package    bx-azot
 * @subpackage Model
 */
class Model_DBCommon {

    /** Имя текущей таблицы
     * @var string
     */
    protected $_name = '';

    /** Текущий запрос к текущей таблице
     * @var string
     */
    protected $_query = '';

    /** Данные для вывода результатов
     * @var array
     */
    protected $_results = array();

    /** Адаптер к базе данных
     * @var string
     */
    protected $_adapter;

    /** Обьект базы данных
     * @var CDatabase //Bitrix
     */
    static $DB;

    /** Тип базы данных
     * @var string 
     */
    static $DB_TYPE;

    /** Массив параметров базы данных DB2
     * @var array
     */
    static $arrParamsDB = array();

    /** Обьект odbc для работы с базой данных
     * @var odbcBox //Класс для работы с ODBC драйвером
     */
    static $ODBC;

    /** Массив параметров для работы с ODBC драйвером
     * @var array
     */
    static $arrParamsODBC = array();

    /** Обьект odbc для работы с базой данных
     * @var odbcBox //Класс для работы с ODBC драйвером
     */
    static $ODBC2;

    /** Массив параметров для работы с ODBC2 драйвером
     * @var array
     */
    static $arrParamsODBC2 = array();

    /*
     * ================ КОНСТРУКТОР ==================
     * Constructor
     *
     * @param  array|null $aOptions
     * @return void
     */
    public function __construct(array $aOptions = null) {
        //Получим адаптер
        //$this->_adapter = $this->getAdapter();
        //Установим параметры
        if (is_array($aOptions)) {
            $this->setOptions($aOptions);
        }
    }

    /**
     * =============== СВОЙСТВА ОБЬЕКТА ===============
     * Overloading: allow property access
     *
     * @param  string $aName
     * @param  mixed $aValue
     * @return void
     */
    public function __set($aName, $aValue) {
        $method = 'set' . $aName;
        if (!method_exists($this, $method)) {
            errDataBase("ERR_PARAM", array($aName, $aValue));
        }
        $this->$method($aValue);
    }

    /**
     * -----------------------------------
     * Overloading: allow property access
     *
     * @param  string $aName
     * @return mixed
     */
    public function __get($aName) {
        $method = 'get' . $aName;
        if (!method_exists($this, $method)) {
            errDataBase("ERR_PARAM", array($aName, "NO"));
        }
        return $this->$method();
    }

    /**
     * -------------------------------------
     * Set object state
     *
     * @param  array $aOptions
     * @return Model_DBCommon
     */
    public function setOptions(array $aOptions) {
        $methods = get_class_methods($this);
        foreach ($aOptions as $key => $value) {
            $key = strtolower($key);
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    /**
     * --------------------------------
     * Установим соединение с базой данных
     *
     * @return Model_DBCommon
     */
    public function _connect() {
        $arrParams = array();
        $datetime = date("Y-m-d H:i:s");
        //----------------------
        switch ($this->_adapter) {
            case "DB":
                break;
            case "ODBC":
                $DSN = self::$arrParamsODBC['DSN'];
                $SERVER = self::$arrParamsODBC['SERVER'];
                $DBType = self::$arrParamsODBC['DBType'];
                $DBLogin = self::$arrParamsODBC['DBLogin'];
                $DBPassword = self::$arrParamsODBC['DBPassword'];
                $strConnect = "DSN=$DSN;AP=$SERVER;DB=$DBType";
                sysBox::setDebugInfo("debugs", array(
                    "action" => "Connect to Hist",
                    "DSN" => $DSN,
                    "Server" => $SERVER,
                    "DBType" => $DBType,
                    "Login" => $DBLogin,
                    "Password" => $DBPassword));
                sysBox::printTXT("Connect ODBC to DB (time - $datetime)(string of connect - $strConnect)");

                if (!isset(myConfig::$arrArguments["test"])) {
                    self::$ODBC->Connect($DSN, $SERVER, $DBType, $DBLogin, $DBPassword);
                }

                $datetime = date("Y-m-d H:i:s");
                sysBox::printTXT("OK... (time of connect - $datetime)");
                break;
            case "ODBC2":
                $DSN = self::$arrParamsODBC2['DSN'];
                $SERVER = self::$arrParamsODBC2['SERVER'];
                $DBType = self::$arrParamsODBC2['DBType'];
                $DBLogin = self::$arrParamsODBC2['DBLogin'];
                $DBPassword = self::$arrParamsODBC2['DBPassword'];
                $strConnect = "DSN=$DSN;AP=$SERVER;DB=$DBType";
                sysBox::setDebugInfo("debugs", array(
                    "action" => "Connect to Hist",
                    "DSN" => $DSN,
                    "Server" => $SERVER,
                    "DBType" => $DBType,
                    "Login" => $DBLogin,
                    "Password" => $DBPassword));
                sysBox::printTXT("Connect ODBC to DB (time - $datetime)(string of connect - $strConnect)");
                if (!isset(myConfig::$arrArguments["test"])) {
                    self::$ODBC2->Connect($DSN, $SERVER, $DBType, $DBLogin, $DBPassword);
                }

                $datetime = date("Y-m-d H:i:s");
                sysBox::printTXT("OK... (time of connect - $datetime)");
                break;
        }
        return $this;
    }

    /**
     * --------------------------------
     * Set name table
     *
     * @param  string $aName
     *
     * @return Model_DBCommon
     */
    public function setName($aName) {
        $this->_name = (string) $aName;
        return $this;
    }

    /**
     * -----------------------------------------
     * Установим название адаптера к базе данных
     *
     * @param  string $aAdapter
     *
     * @return Model_DBCommon
     */
    public function setAdapter($aAdapter) {
        $this->_adapter = (string) $aAdapter;
        $this->_connect();
        return $this;
    }

    /**
     * -------------------------
     * Получим имя таблицы
     *
     * @return null|string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * -------------------------------------
     * Получить строку запроса к базе данных
     *
     * @return null|string
     */
    public function getQuery() {
        return $this->_query;
    }

    /** 
     * -----------------------------------
     * Получить данные результатов запроса
     *
     * @return array
     */
    public function getResults() {
        return $this->_results;
    }

    /**
     * ---------------------------------------------------
     * Выполним операцию SELECT в базе данных
     *
     * @param  string $aQuery
     * @return array //Массив выбранных строк из базы даных
     */
    protected function _selectData($aQuery) {
        $res;
        //----------------------
        // Выполнение запроса
        switch ($this->_adapter) {
            case "DB":
                $res = self::$DB->Query($aQuery);
                break;
            case "ODBC":
                $res = self::$ODBC->Query($aQuery);
                break;
            case "ODBC2":
                $res = self::$ODBC2->Query($aQuery);
                break;
        }
        sysBox::setDebugInfo("debugs", array(
            "action" => "Select",
            "Query" => $aQuery));
        if (!$res) {
            $this->errDataBase('ERR_SELECT_DB', array($this->_name, $aQuery));
        };
        return $res;
    }

    /**
     * -----------------------------------------------------
     * INSERT в базе данных
     *
     * @param  array $aQuery
     * @return int //Число удаленных записей из базы данных
     */
    public function _insertData($aQuery) {
        $count = 0;
        //----------------------
        // Выполнение удаление
        switch ($this->_adapter) {
            case "DB":
                $res = self::$DB->Query($aQuery);
                break;
        }
        sysBox::setDebugInfo("debugs", array(
            "action" => "Insert",
            "Query" => $aQuery));
        if (!$res) {
            $this->errDataBase('ERR_INSERT_DATA', array($this->_name, $aQuery));
        };


        if (self::$DB_TYPE == "mysql") {
            $count = $res->AffectedRowsCount();
        } elseif (self::$DB_TYPE == "sqlite") {
            $count = count($res);
        }

        return $count;
    }

    /**
     * ----------------------------------------------------
     * UPDATE в базе данных
     *
     * @param  array $aParams
     * @param  string $aWhere
     * @return int //Число обновленных записей в базе данных
     */
    protected function _updateData($aQuery) {
        $count = 0;
        //----------------------
        // Выполнение обновления
        //$count = $this->_adapter->update($this->_name, $params, $where);
        // Выполнение удаление
        switch ($this->_adapter) {
            case "DB":
                $res = self::$DB->Query($aQuery);
                break;
        }
        sysBox::setDebugInfo("debugs", array(
            "action" => "Update",
            "Query" => $aQuery));
        if (!$res) {
            $this->errDataBase('ERR_UPDATE_DATA', array($this->_name, $aQuery));
        };

        if (self::$DB_TYPE == "mysql") {
            $count = $res->AffectedRowsCount();
        } elseif (self::$DB_TYPE == "sqlite") {
            $count = count($res);
        }

        return $count;
    }

    /**
     * ----------------------------------------------------
     * DELETE в базе данных
     *
     * @param  string $aWhere
     * @return int //Число удаленных записей из базы данных
     */
    protected function _deleteData($aQuery) {

        $count = 0;
        //----------------------
        // Выполнение удаление
        switch ($this->_adapter) {
            case "DB":
                $res = self::$DB->Query($aQuery);
                break;
        }
        sysBox::setDebugInfo("debugs", array(
            "action" => "Delete",
            "Query" => $aQuery));
        if (!$res) {
            $this->errDataBase('ERR_DELETE_DATA', array($this->_name, $aQuery));
        };

        if (self::$DB_TYPE == "mysql") {
            $count = $res->AffectedRowsCount();
        } elseif (self::$DB_TYPE == "sqlite") {
            $count = count($res);
        }

        return $count;
    }

    /**
     * -------------------------------------------------------
     * Получим список полей для таблицы в режиме вставки записи
     *
     * @param  array $aArrValues
     * @return string
     */
    protected function _getQryFieldsInsert(array $aArrValues) {
        $qryFields = "";
        //-------------------------
        //$arrFields = $this->getFieldsArray('server',$NameTable);
        foreach ($aArrValues as $key => $value) {
            if ($qryFields == "") {
                $qryFields = "`" . $key . "`";
            } else {
                $qryFields = $qryFields . "," . "`" . $key . "`";
            }
        }
        return $qryFields;
    }

    /**
     * ------------------------------------------------------------
     * Получим список значений для таблицы в режиме вставки записи
     *
     * @param  array $aArrValues
     * @return string
     */
    protected function _getQryValuesInsert(array $aArrValues) {
        $qryValues = "";
        //-------------------------
        foreach ($aArrValues as $key => $value) {
            $value = str_replace("'", "''", $value);
            if ($qryValues == "") {
                if ($value === null)
                    $qryValues = 'NULL';
                else
                    $qryValues = "'" . $value . "'";
            }
            else {
                if ($value === null)
                    $qryValues = $qryValues . "," . 'NULL';
                else
                    $qryValues = $qryValues . "," . "'" . $value . "'";
            }
        }
        return $qryValues;
    }

    /**
     * -------------------------------------------------------------
     * Получим список значений для таблицы в режиме обновления записи
     *
     * @param  array $aArrValues
     * @return string
     */
    protected function _getQryValuesUpdate(array $aArrValues) {
        $qryValues = "";
        //-------------------------
        foreach ($aArrValues as $key => $value) {
            $value = str_replace("'", "''", $value);
            if ($qryValues == "") {
                if ($value === null)
                    $qryValues = "`" . $key . "`" . "=" . 'NULL';
                else
                    $qryValues = "`" . $key . "`" . "=" . "'" . $value . "'";
            }
            else {
                if ($value === null)
                    $qryValues = $qryValues . "," . "`" . $key . "`" . "=" . 'NULL';
                else
                    $qryValues = $qryValues . "," . "`" . $key . "`" . "=" . "'" . $value . "'";
            }
        }
        return $qryValues;
    }

    //====================== КОНВЕРТАЦИЯ ДАННЫХ =============//

    /**
     * Конвертировать поля записи из кодировки WIN 1251 -> UTF8
     *
     * @param  array $aRec
     * @return array
     */
    static function ConvertWinUtf($aRec) {
        if ($aRec == null)
            return $aRec;
        foreach ($aRec as $key => $value) {
            if (is_string($value)) {
                $aRec[$key] = iconv("Windows-1251", "UTF-8", $aRec[$key]);
            }
        }
        return $aRec;
    }

    /**
     * ----------------------------------------------------------
     * Конвертировать поля записи из кодировки UTF8 -> WIN 1251
     *
     * @param  array $aRec
     * @return array
     */
    static function ConvertUtfWin($aRec) {
        if ($aRec == null)
            return $aRec;
        foreach ($aRec as $key => $value) {
            if (is_string($value)) {
                $aRec[$key] = iconv("UTF-8", "Windows-1251", $aRec[$key]);
            }
        }
        return $aRec;
    }

    /**
     * ================ ОБРАБОТКА ОШИБОК ====================
     * Вызов ошибки для базы данных
     *
     * @param  string $aTypeError
     * @param  array $aArrParam
     * @return void
     */
    public function errDataBase($aTypeError, array $aArrParam) {
        $myMsg = "";
        //------------------
        switch ($aTypeError) {
            case "ERR_CONNECT":
                $myMsg = "Error the connect to DB: \n%s";
                $myMsg = sprintf($myMsg, $aArrParam[0]);
                break;
            case "ERR_SELECT_DB":
                $myMsg = "Error the select of records from DB - '%s'!\nRequest select the records from DB:\n%s\n";
                $myMsg = sprintf($myMsg, $aArrParam[0], $aArrParam[1]);
                break;
            case "ERR_QUERY":
                $myMsg = "Error the request to DB: \n%s";
                $myMsg = sprintf($myMsg, $aArrParam[0]);
                break;
            case "ERR_INSERT_DATA":
                $myMsg = "Error add records to table DB - '%s'!\nRequest add records to DB:\n%s\n.";
                $myMsg = sprintf($myMsg, $aArrParam[0], $aArrParam[1]);
                break;
            case "ERR_DELETE_DATA":
                $myMsg = "Error delete of records from table DB - '%s'!\nRequest delete records from DB:\n%s\n.";
                $myMsg = sprintf($myMsg, $aArrParam[0], $aArrParam[1]);
                break;
            case "ERR_UPDATE_DATA":
                $myMsg = "Error update of records from table DB - '%s'!\nRequest update records to DB:\n  %s\n.";
                $myMsg = sprintf($myMsg, $aArrParam[0], $aArrParam[1]);
                break;
            case "ERR_PARAM":
                $myMsg = "Error set parameters: for function -  '%s'; invalid parameter - '%s'!";
                $myMsg = sprintf($myMsg, $aArrParam[0], $aArrParam[1]);
                break;
        }
        throw new Model_DBException($aTypeError, $myMsg);
    }

}

?>