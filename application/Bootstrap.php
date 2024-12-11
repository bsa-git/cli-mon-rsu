<?php

/**
 * Application bootstrap
 *
 * @uses    Bootstrap
 * @package zf-azot
 */
class Bootstrap {

    /** Массив параметров
     * @var array
     */
    protected $_arrParams;

    /*
     * Constructor
     *
     * @param  array|null $options
     * @return void
     */

    public function __construct(array $params = null) {
        if (is_array($params)) {
            $this->_arrParams = $params;
        }
    }

    /**
     * Bootstrap autoloader for application resources
     *
     * @return Zend_Application_Module_Autoloader
     */
    public function init() {
        //Установим временную зону по умолчанию
        date_default_timezone_set("GMT");

        if (isset(myConfig::$arrArguments["hist"])) {
            // Установим хост данных
            $this->setDataHost();
            //Выполним инициализацию DB
            $this->initDB();
            //Вставить/Обновить записи в таблицу "Tags"
            Model_Tags::insertRowsToTagsTable();
        }
    }

    /**
     * Инициализация Базы данных
     *
     * @return void
     */
    public function initDB() {

        //Получим номер истории
        $odbcHistN = myConfig::$arrArguments["hist"];

        //Запомним информацию по ODBC драйверам
        if ($odbcHistN == 2) {
            // Set tags for myConfig
            myConfig::$arrDayTags = Tags2::$arrDayTags;
            myConfig::$arrCurrentTags = Tags2::$arrCurrentTags;
            myConfig::$arrCurrentTest_Tags = Tags2::$arrCurrentTest_Tags;
            myConfig::$arrCurrentDB_Tags = Tags2::$arrCurrentDB_Tags;

            // Set "ODBC" params
            $ODBC = new odbcBox();
            Model_DBCommon::$ODBC = $ODBC;
            Model_DBCommon::$arrParamsODBC['DSN'] = myConfig::$arrDB['odbcDay2']['dsn'];
            Model_DBCommon::$arrParamsODBC['SERVER'] = myConfig::$arrDB['odbcDay2']['server'];
            Model_DBCommon::$arrParamsODBC['DBType'] = myConfig::$arrDB['odbcDay2']['dbtype'];
            Model_DBCommon::$arrParamsODBC['DBName'] = myConfig::$arrDB['odbcDay2']['dbname'];
            Model_DBCommon::$arrParamsODBC['DBLogin'] = myConfig::$arrDB['odbcDay2']['username'];
            Model_DBCommon::$arrParamsODBC['DBPassword'] = myConfig::$arrDB['odbcDay2']['password'];

            $ODBC2 = new odbcBox();
            Model_DBCommon::$ODBC2 = $ODBC2;
            Model_DBCommon::$arrParamsODBC2['DSN'] = myConfig::$arrDB['odbcCurrent2']['dsn'];
            Model_DBCommon::$arrParamsODBC2['SERVER'] = myConfig::$arrDB['odbcCurrent2']['server'];
            Model_DBCommon::$arrParamsODBC2['DBType'] = myConfig::$arrDB['odbcCurrent2']['dbtype'];
            Model_DBCommon::$arrParamsODBC2['DBName'] = myConfig::$arrDB['odbcCurrent2']['dbname'];
            Model_DBCommon::$arrParamsODBC2['DBLogin'] = myConfig::$arrDB['odbcCurrent2']['username'];
            Model_DBCommon::$arrParamsODBC2['DBPassword'] = myConfig::$arrDB['odbcCurrent2']['password'];
        } elseif ($odbcHistN == 1) {
            // Set tags for myConfig
            myConfig::$arrDayTags = Tags1::$arrDayTags;
            myConfig::$arrCurrentTags = Tags1::$arrCurrentTags;
            myConfig::$arrCurrentTest_Tags = Tags1::$arrCurrentTest_Tags;
            myConfig::$arrCurrentDB_Tags = Tags1::$arrCurrentDB_Tags;

            // Set "ODBC" params
            $ODBC = new odbcBox();
            Model_DBCommon::$ODBC = $ODBC;
            Model_DBCommon::$arrParamsODBC['DSN'] = myConfig::$arrDB['odbcDay1']['dsn'];
            Model_DBCommon::$arrParamsODBC['SERVER'] = myConfig::$arrDB['odbcDay1']['server'];
            Model_DBCommon::$arrParamsODBC['DBType'] = myConfig::$arrDB['odbcDay1']['dbtype'];
            Model_DBCommon::$arrParamsODBC['DBName'] = myConfig::$arrDB['odbcDay1']['dbname'];
            Model_DBCommon::$arrParamsODBC['DBLogin'] = myConfig::$arrDB['odbcDay1']['username'];
            Model_DBCommon::$arrParamsODBC['DBPassword'] = myConfig::$arrDB['odbcDay1']['password'];

            $ODBC2 = new odbcBox();
            Model_DBCommon::$ODBC2 = $ODBC2;
            Model_DBCommon::$arrParamsODBC2['DSN'] = myConfig::$arrDB['odbcCurrent1']['dsn'];
            Model_DBCommon::$arrParamsODBC2['SERVER'] = myConfig::$arrDB['odbcCurrent1']['server'];
            Model_DBCommon::$arrParamsODBC2['DBType'] = myConfig::$arrDB['odbcCurrent1']['dbtype'];
            Model_DBCommon::$arrParamsODBC2['DBName'] = myConfig::$arrDB['odbcCurrent1']['dbname'];
            Model_DBCommon::$arrParamsODBC2['DBLogin'] = myConfig::$arrDB['odbcCurrent1']['username'];
            Model_DBCommon::$arrParamsODBC2['DBPassword'] = myConfig::$arrDB['odbcCurrent1']['password'];
        } else {
            // Set tags for myConfig
            $isHistAll = $odbcHistN === 'all';
            $isTest = myConfig::$arrArguments["test"];
            if ($isTest && $isHistAll) {
                myConfig::$arrDayTags = array_merge(Tags1::$arrDayTags, Tags2::$arrDayTags);
                myConfig::$arrCurrentTags = array_merge(Tags1::$arrCurrentTags, Tags2::$arrCurrentTags);
                myConfig::$arrCurrentTest_Tags = array_merge(Tags1::$arrCurrentTest_Tags, Tags2::$arrCurrentTest_Tags);
                myConfig::$arrCurrentDB_Tags = array_merge(Tags1::$arrCurrentDB_Tags, Tags2::$arrCurrentDB_Tags);
            } else {
                myConfig::$arrDayTags = Tags1::$arrDayTags;
                myConfig::$arrCurrentTags = Tags1::$arrCurrentTags;
                myConfig::$arrCurrentTest_Tags = Tags1::$arrCurrentTest_Tags;
                myConfig::$arrCurrentDB_Tags = Tags1::$arrCurrentDB_Tags;
            }

            // Set "ODBC" params
            $ODBC = new odbcBox();
            Model_DBCommon::$ODBC = $ODBC;
            Model_DBCommon::$arrParamsODBC['DSN'] = myConfig::$arrDB['odbcDay']['dsn'];
            Model_DBCommon::$arrParamsODBC['SERVER'] = myConfig::$arrDB['odbcDay']['server'];
            Model_DBCommon::$arrParamsODBC['DBType'] = myConfig::$arrDB['odbcDay']['dbtype'];
            Model_DBCommon::$arrParamsODBC['DBName'] = myConfig::$arrDB['odbcDay']['dbname'];
            Model_DBCommon::$arrParamsODBC['DBLogin'] = myConfig::$arrDB['odbcDay']['username'];
            Model_DBCommon::$arrParamsODBC['DBPassword'] = myConfig::$arrDB['odbcDay']['password'];

            $ODBC2 = new odbcBox();
            Model_DBCommon::$ODBC2 = $ODBC2;
            Model_DBCommon::$arrParamsODBC2['DSN'] = myConfig::$arrDB['odbcCurrent']['dsn'];
            Model_DBCommon::$arrParamsODBC2['SERVER'] = myConfig::$arrDB['odbcCurrent']['server'];
            Model_DBCommon::$arrParamsODBC2['DBType'] = myConfig::$arrDB['odbcCurrent']['dbtype'];
            Model_DBCommon::$arrParamsODBC2['DBName'] = myConfig::$arrDB['odbcCurrent']['dbname'];
            Model_DBCommon::$arrParamsODBC2['DBLogin'] = myConfig::$arrDB['odbcCurrent']['username'];
            Model_DBCommon::$arrParamsODBC2['DBPassword'] = myConfig::$arrDB['odbcCurrent']['password'];
        }


        // Определим базу данных DB
        $isSaveToDB = sysBox::isSaveToDB();
        if(! $isSaveToDB){ return; }
        
        $db_type = myConfig::$arrSystem["db_type"];
        Model_DBCommon::$DB_TYPE = $db_type;
        if ($db_type == "mysql") {
            //Запомним информацию по базам данных
            $DBHost = myConfig::$arrDB['dbMySQL']['host'];
            $DBName = myConfig::$arrDB['dbMySQL']['dbname'];
            $DBLogin = myConfig::$arrDB['dbMySQL']['username'];
            $DBPassword = myConfig::$arrDB['dbMySQL']['password'];

            $DB = new CDatabase();

            //Соединимся с базой данных MySQL
            $strConnect = "DBHost=$DBHost;DBName=$DBName;DBLogin=$DBLogin;DBPassword=$DBPassword";
            sysBox::setDebugInfo("debugs", array(
                "action" => "Connect to MySQL",
                "Host" => $DBHost,
                "Name" => $DBName,
                "Login" => $DBLogin,
                "Password" => $DBPassword));

            $DB->Connect($DBHost, $DBName, $DBLogin, $DBPassword);


            //Установим для базы данных кодировку cp1251
            $DB->Query("SET NAMES 'cp1251'");

            sysBox::setDebugInfo("debugs", array(
                "action" => "Set names",
                "Query" => "SET NAMES 'cp1251'"));

            Model_DBCommon::$DB = $DB;
            Model_DBCommon::$arrParamsDB['DBHost'] = $DBHost;
            Model_DBCommon::$arrParamsDB['DBName'] = $DBName;
            Model_DBCommon::$arrParamsDB['DBLogin'] = $DBLogin;
            Model_DBCommon::$arrParamsDB['DBPassword'] = $DBPassword;
        } elseif ($db_type == "sqlite") {

            if (isset(myConfig::$arrArguments["test"])) {
                $DBHost = ROOT_DOCUMENT . myConfig::$arrDB['dbSQLite']['host_test'];
            } else {
                if($odbcHistN == 2){
                    $DBHost = myConfig::$dataHost . myConfig::$arrDB['dbSQLite']['host2'];
                } else {
                    $DBHost = myConfig::$dataHost . myConfig::$arrDB['dbSQLite']['host'];
                }
            }

            $DB = new wArLeY_DBMS("sqlite2", $DBHost, "", "", "", "");

            // Connect to database.
            $dbCN = $DB->Cnxn();
            if ($dbCN == false) {
                $message = "Cant connect to database(DBHost={$DBHost})";
                throw new Exception($message);
            }

            Model_DBCommon::$DB = $DB;
        }
    }

    /**
     * Установим значение хоста данных 
     */
    public function setDataHost() {

        if (isset(myConfig::$arrArguments["test"])) {
            return;
        }
        
        // Установим хост для разных историй
        if ($odbcHistN == 4) {
            myConfig::$dataHost = '\\\\192.168.3.5';
        } elseif ($odbcHistN == 3) {
            myConfig::$dataHost = '\\\\192.168.3.5';
        }

        // Set dataHost
        if (myConfig::$dataHost) {
            $this->checkAccessToDataHost();
        } else {

            if ($this->isDataHost(myConfig::$dataHost1)) {
                myConfig::$dataHost = myConfig::$dataHost1;
                return;
            }

            if ($this->isDataHost(myConfig::$dataHost2)) {
                myConfig::$dataHost = myConfig::$dataHost2;
                return;
            }
            $dataHost1 = myConfig::$dataHost1;
            $dataHost2 = myConfig::$dataHost2;
            throw new Exception("Error set dataHost. This hosts '{$dataHost1}' and '{$dataHost2}' does not exist.");
        }
    }

    /**
     * Проверка доступа к данным хоста.
     * Если к хосту нет доступа, то сменим на другой хост 
     * и повторно инициализируем базу данных
     * 
     * return bool
     */
    public function checkAccessToDataHost() {

        if (isset(myConfig::$arrArguments["test"])) {
            return TRUE;
        }

        if ($this->isDataHost(myConfig::$dataHost)) {
            return TRUE;
        }

        if (myConfig::$dataHost !== myConfig::$dataHost1 && $this->isDataHost(myConfig::$dataHost1)) {
            myConfig::$dataHost = myConfig::$dataHost1;
            $this->initDB();
            return TRUE;
        }

        if (myConfig::$dataHost !== myConfig::$dataHost2 && $this->isDataHost(myConfig::$dataHost2)) {
            myConfig::$dataHost = myConfig::$dataHost2;
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Проверка наличия хоста данных 
     * 
     * @param string $aHost Host name
     * return bool 
     */
    public function isDataHost($aHost) {
        $DBHost = $aHost . myConfig::$arrDB['dbSQLite']['host'];
        $fileDir = $aHost . myConfig::$arrSystem['www_dir'] . '\\';
        return (is_file($DBHost) && is_dir($fileDir));
    }

    //================ TESTING ===============//

    /**
     * тестирование Базы данных
     *
     * @return void
     */
    protected function _testDB_ODBC() {
        $arrObjects = array();
        //--------------------------------
        $dayDSN = Model_DBCommon::$arrParamsODBC['DSN'];
        $daySERVER = Model_DBCommon::$arrParamsODBC['SERVER'];
        $dayDBType = Model_DBCommon::$arrParamsODBC['DBType'];
        $dayDBName = Model_DBCommon::$arrParamsODBC['DBName'];
        $dayDBLogin = Model_DBCommon::$arrParamsODBC['DBLogin'];
        $dayDBPassword = Model_DBCommon::$arrParamsODBC['DBPassword'];

        $currentDSN = Model_DBCommon::$arrParamsODBC2['DSN'];
        $currentSERVER = Model_DBCommon::$arrParamsODBC2['SERVER'];
        $currentDBType = Model_DBCommon::$arrParamsODBC2['DBType'];
        $currentDBName = Model_DBCommon::$arrParamsODBC2['DBName'];
        $currentDBLogin = Model_DBCommon::$arrParamsODBC2['DBLogin'];
        $currentDBPassword = Model_DBCommon::$arrParamsODBC2['DBPassword'];
        //--------------------------
        //Получим массив позиций
        $arrCurrentTags = array_keys(myConfig::$arrCurrentTags);

        $arrAlias = array_values(myConfig::$arrCurrentTags);

        //Создадим обьект Model_Tags
        $oTag = new Model_Tags();

        // Получим доступные теги
        $arrInversCurrentTags = array_flip(myConfig::$arrCurrentTags);
        $oTags = $oTag->fetchTags($arrAlias);
        foreach ($oTags as $oTag) {
            $alias = $oTag->alias;
            $tag = $arrInversCurrentTags[$alias];
            $arrValues[$tag] = 'Source';
        }

        // Получим строку запроса
        $strValues = strBox::getParamFor_OR($arrValues);
//        $strValues .=  " OR (Source = '')";
//        exit();
        //Получить текущие данные
        $odbc = new odbcBox();
        $odbc->Connect($currentDSN, $currentSERVER, $currentDBType, $currentDBLogin, $currentDBPassword);

        $count = 1;
        for ($index = 0; $index < $count; $index++) {
            $arrDates = strBox::getDateTimePeriod("current_sec");
            $ts = $arrDates["date_min"];
            //$ts = "2010-04-12 09:06:00";
//            $res = $odbc->Query("SELECT Source, Time, Value FROM Sample/hist00.Current
//         		   WHERE    (Source = '02AMIAK:02T4.PNT' OR Source = '02AMIAK:02F4.PNT') OR 
//                                    (Source = '02AMIAK:02P4_1.PNT' OR Source = '02PGAZ:02F5.PNT') OR
//                                    (Source = '02PGAZ:02T16.PNT' OR Source = '02PGAZ:02P5.PNT') OR
//                                    (Source = '02AMIAK:02T21_1.PNT' OR Source = '')
//                                    AND  Time = {ts '$ts'}");

            $res = $odbc->Query("SELECT Source, Time, Value FROM Sample/hist00.Current
         		   WHERE {$strValues} AND  Time = {ts '$ts'}");

            while ($arrResult = $res->Fetch()) {
                //Скорректируем дату-время
                $time = $arrResult['Time']; //2006-10-16 1:00:00.00
                $time = substr($time, 0, -3); //$my_time = 2006-10-16 1:00:00
                $arrResult['Time'] = $time;
                $source = $arrResult['Source'];
                $value = $arrResult['Value'];

                // Создадим обьект данных 
                $oObject = new Model_HistCurrentData($arrResult);
                $arrObjects[] = $oObject;

                sysBox::printTXT("OK...Obtained. Time = {$time}; Source = {$source}; Value = {$value};  ");
            }

            sleep(10);
        }

        exit();
    }

    /**
     * тестирование Базы данных
     *
     * @return void
     */
    protected function _testDB_SQLite() {
        $DBHost = myConfig::$dataHost . myConfig::$arrDB['dbSQLite']['host'];
        $db = new wArLeY_DBMS("sqlite2", $DBHost, "", "", "", "");

        ///3.- Connect to database.
        $dbCN = $db->Cnxn();
        if ($dbCN == false) {
            $message = "Cant connect to database(DBHost={$DBHost})";
            throw new Exception($message);
        }

        $rs = $db->query("SELECT * FROM TAGS");
        foreach ($rs as $row) {
            $ts = $row["ts"];
            $topic = $row["topic"];
            echo "The user $tmp_name lives in: $tmp_address<br/>";
        }
    }

}

?>