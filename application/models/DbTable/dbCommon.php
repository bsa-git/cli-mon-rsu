<?php

/*
 * ==============  ����� ��������� ������ ���� ������ ============//
 * ������ ���� ������
 * Modul Common.php Copyright @ 2009 BSA
 * @uses    Exception
 * @package bx-azot
 */

class Model_DBException extends Exception {

    private $typeError = "";

    //-------------------------------
    //�����������
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
    //�������� ��� ������
    public function GetTypeError() {
        return $this->typeError;
    }

}

/**
 * =================================================================
 * ������������� ����� ���� ������ ��� ����� �������
 *
 * @package    bx-azot
 * @subpackage Model
 */
class Model_DBCommon {

    /** ��� ������� �������
     * @var string
     */
    protected $_name = '';

    /** ������� ������ � ������� �������
     * @var string
     */
    protected $_query = '';

    /** ������ ��� ������ �����������
     * @var array
     */
    protected $_results = array();

    /** ������� � ���� ������
     * @var string
     */
    protected $_adapter;

    /** ������ ���� ������
     * @var CDatabase //Bitrix
     */
    static $DB;

    /** ��� ���� ������
     * @var string 
     */
    static $DB_TYPE;

    /** ������ ���������� ���� ������ DB2
     * @var array
     */
    static $arrParamsDB = array();

    /** ������ odbc ��� ������ � ����� ������
     * @var odbcBox //����� ��� ������ � ODBC ���������
     */
    static $ODBC;

    /** ������ ���������� ��� ������ � ODBC ���������
     * @var array
     */
    static $arrParamsODBC = array();

    /** ������ odbc ��� ������ � ����� ������
     * @var odbcBox //����� ��� ������ � ODBC ���������
     */
    static $ODBC2;

    /** ������ ���������� ��� ������ � ODBC2 ���������
     * @var array
     */
    static $arrParamsODBC2 = array();

    /*
     * ================ ����������� ==================
     * Constructor
     *
     * @param  array|null $aOptions
     * @return void
     */
    public function __construct(array $aOptions = null) {
        //������� �������
        //$this->_adapter = $this->getAdapter();
        //��������� ���������
        if (is_array($aOptions)) {
            $this->setOptions($aOptions);
        }
    }

    /**
     * =============== �������� ������� ===============
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
     * ��������� ���������� � ����� ������
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
     * ��������� �������� �������� � ���� ������
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
     * ������� ��� �������
     *
     * @return null|string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * -------------------------------------
     * �������� ������ ������� � ���� ������
     *
     * @return null|string
     */
    public function getQuery() {
        return $this->_query;
    }

    /** 
     * -----------------------------------
     * �������� ������ ����������� �������
     *
     * @return array
     */
    public function getResults() {
        return $this->_results;
    }

    /**
     * ---------------------------------------------------
     * �������� �������� SELECT � ���� ������
     *
     * @param  string $aQuery
     * @return array //������ ��������� ����� �� ���� �����
     */
    protected function _selectData($aQuery) {
        $res;
        //----------------------
        // ���������� �������
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
     * INSERT � ���� ������
     *
     * @param  array $aQuery
     * @return int //����� ��������� ������� �� ���� ������
     */
    public function _insertData($aQuery) {
        $count = 0;
        //----------------------
        // ���������� ��������
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
     * UPDATE � ���� ������
     *
     * @param  array $aParams
     * @param  string $aWhere
     * @return int //����� ����������� ������� � ���� ������
     */
    protected function _updateData($aQuery) {
        $count = 0;
        //----------------------
        // ���������� ����������
        //$count = $this->_adapter->update($this->_name, $params, $where);
        // ���������� ��������
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
     * DELETE � ���� ������
     *
     * @param  string $aWhere
     * @return int //����� ��������� ������� �� ���� ������
     */
    protected function _deleteData($aQuery) {

        $count = 0;
        //----------------------
        // ���������� ��������
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
     * ������� ������ ����� ��� ������� � ������ ������� ������
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
     * ������� ������ �������� ��� ������� � ������ ������� ������
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
     * ������� ������ �������� ��� ������� � ������ ���������� ������
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

    //====================== ����������� ������ =============//

    /**
     * �������������� ���� ������ �� ��������� WIN 1251 -> UTF8
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
     * �������������� ���� ������ �� ��������� UTF8 -> WIN 1251
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
     * ================ ��������� ������ ====================
     * ����� ������ ��� ���� ������
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