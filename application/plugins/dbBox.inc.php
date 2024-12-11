
<?php
/*=============  КЛАСС ОБРАБОТКИ ОШИБОК БАЗЫ ДАННЫХ ========//
 * Ошибки Базы Данных
 * Modul DbBox.php Copyright @ 2009 BSA
 * @uses    Zend_Exception
 * @package ZF-BUH1C
*/
class dbException extends Exception {
    private $typeError = "";
    //-------------------------------
    //Конструктор
    public function __construct($typeError,$message,$code=0) {
        parent::__construct($message,$code);
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

/*============= КЛАСС ДОСТУПА К БАЗЕ ДАННЫХ ===============//
 * Класс работы с Базой Данных
 * Modul DbBox.php Copyright @ 2009 BSA
 * @uses    
 * @package ZF-BUH1C
*/
class dbBox {

    //Запись для соединения за базой данных
    private $arrConnectDB = array(
            'host' => 'localhost',
            //'host' => '192.168.0.140',
            //'host' => '192.168.0.10',
            'username' => 'root',
            //'username' => 'bsa',
            'passwd' => 'admin',
            //'dbname' => 'info10');
            'dbname' => 'bx_azot1');
    private $link = 0;
    private $response = 0;

    //Поля таблиц для клиента сервера
    private $arrTypeFields =	array("server","client");
    //Поля таблиц для клиента сервера
    //ВАЖНО!!!!!!!!!!!! Поля таблицы должны начинаться с полей 'id','ts'
    private $arrFields_Server =	array(
            'otgruzka'=>array('id','ts','org','norg_s','kdog','prod','ddm','cena','kol','opl','fakt','plan','sost'));


    //Значения полей, которые нужно исключить для таблиц сервера
    private $arrExcludeFields_Server =	array();

    //Поля таблиц для клиента
    private $arrFields_Client =	array(
            'predpr'=>array('kdog'=>'Договор','prod'=>'Продукт',
                            'ddm'=>'Дата заявки','cena'=>'Цена',
                            'kol'=>'Заявлено','opl'=>'Оплачено',
                            'fakt'=>'Отгр.','plan'=>'В плане',
                            'sost'=>'Сост.'));

    //Отношение таблицы и ее собственников для клиента
    //Организация: Ключ=Значение, где Значение = usluga_group.код=id_group
    //Собственником таблицы - "usluga" является таблица - "usluga_group"
    //связь между таблицами поле "код" таблицы  "usluga_group" связано с полем "id_usluga"
    //таблицы "usluga"
    private $arrRelationOwner_Client =	array(
            //'els'=>'abonent.код=id_abon',
            'usluga'=>'usluga_group.код=id_group',
            'usluga_units'=>'usluga.код=id_usluga'
    );
    //Отношение связей между таблицей и другими таблицами для клиента
    private $arrRelationLinks_Client =	array(
            'usluga_units'=>'units.код=id_unit.ЕдиницаИзмерения.наименование'
    );
    //Значения полей по умолчанию для таблиц клиента
    private $arrDefaultFields_Client =	array(
            'predpr'=>'выгрузка=истина',
            'abonent'=>'выбор=истина',
            'els'=>'выбор=истина'
    );
    //Значения полей, которые нужно исключить для таблиц клиента
    private $arrExcludeFields_Client =	array(
            'els'=>'id_client1c;actual'
    );

    //------------------------------------------------------------------------
    //Конструктор
    function __construct($dbName="") {
        if($dbName!="")
            $this->arrConnectDB['dbname'] = $dbName;
    }
    //================= СОЕДИНИТЬСЯ С БАЗОЙ ДАННЫХ MYSQL  ====================//

    //Установим информацию о подключении к базе данных
    public function setInfoConnect($DBHost, $DBLogin, $DBPassword) {
        //-------------------------------------
        $this->arrConnectDB['host'] = $DBHost;
        $this->arrConnectDB['username'] = $DBLogin;
        $this->arrConnectDB['passwd'] = $DBPassword;
    }
    //Получим информацию о подключении к базе данных
    public function getInfoConnect() {
        //-------------------------------------
        return $this->arrConnectDB;
    }
    //Получим имя базы данных
    public function getNameDB() {
        //-------------------------------------
        return $this->arrConnectDB['dbname'];
    }
    //Соединения с базой данных
    public function mysqlConnect() {

        //---------------------
        //Соединимся к базе данных
        $this->link = mysql_connect( 	$this->arrConnectDB['host'],
                $this->arrConnectDB['username'],
                $this->arrConnectDB['passwd'],
                $this->arrConnectDB['dbname']);

        if(!$this->link) {
            $this->errDataBase(	'ERR_CONNECT',
                    array("ошибка соединения к базе данных - ".
                            mysql_error()));
        }
        //Выберем базу данных
        if(!mysql_select_db($this->arrConnectDB['dbname'])) {
            $this->errDataBase('ERR_CONNECT', array("Ошибка выбора базы данных - ". mysql_error()));
        }

        if(sysBox::$debug)
            echo  "Yes connect to '".$this->arrConnectDB['dbname']."'"."<br \>\n";

        //Получим информацию о базе данных
        //$this->getInfoDB();

        return $this->link;
    }
    //======================  ПОЛУЧИТЬ ДАННЫЕ С БАЗЫ ДАННЫХ ==============================//
    public function getData(array $arrParam) {
        $query = "";

        //----------------------
        //Получить запрос
        $query = $this->getQuery($arrParam);
        if(sysBox::$debug)
        //echo  "Do request: ".$query."<br>\n";
            echo  "Do request: ".$query."<br>\n";
        //echo  "Do request: ".iconv("Windows-1251", "UTF-8", $query)."<br>\n";
        //Выполним SQL-запрос
        $this->response = mysql_query($query,$this->link);
        if(!$this->response) {
            $this->errDataBase('ERR_QUERY', array(" : " . mysql_error($this->link)));
        }
        return $this->response;
    }
    //----------------------------
    //Получим запись данных из запроса
    public function getRow() {
        //----------------------
        //return $this->ConvertLatin1Win( mysql_fetch_array($this->response) ) ;
        return  mysql_fetch_array($this->response);
    }

    //----------------------------
    //Установим кодировку для базы данных
    public function setNameCoding($coding) {
        //----------------------
        $this->response = mysql_query("SET NAMES '$coding'",$this->link);
        if(!$this->response) {
            $this->errDataBase('ERR_QUERY', array(" : " . mysql_error($this->link)));
        }
        /*
        $DB->Query("SET NAMES 'cp1251'");
        $DB->Query("SET CHARACTER SET 'cp1251'");

        $DB->Query("SET collation_connection=cp1251_general_ci");
        $DB->Query("SET character_set_results=cp1251");
        $DB->Query("SET character_set_client=cp1251");
        $DB->Query("SET collation_database=cp1251_general_ci"); 
     */
    }
    //======================  ВСТАВИТЬ ДАННЫЕ В БАЗУ ДАННЫХ ==============================//

    //Получить уникальный ключ (ID) для последней вставленной записи в таблицу
    public function GetLastInsertRow_id() {
        return mysql_insert_id($this->link);
    }

    //----------------------------
    //Добавить записи в базу данных.
    //Порядок элементов массива:
    //1 - название таблицы
    //2 - название запроса к таблице
    //3 - массив значений для новой записи
    public function insertData(array $arrParam) {
        $query = "";
        $fields = "";
        $values = "";
        //oplati_update
        //----------------------
        $fields = $this->getQryFieldsInsert($arrParam[0]);
        $values = $this->getQryValuesInsert($arrParam);
        //Получить запрос
        $arrQueryParam = array($arrParam[0],$arrParam[1],$fields,$values);
        $query = $this->getQuery($arrQueryParam);
        if(sysBox::$debug)
        //echo  "Do request: $query "."<br>\n";
            echo  "Do request: ".iconv("Windows-1251", "UTF-8", $query)."<br>\n";
        //Отключим autocommit
        mysqli_autocommit($this->link, FALSE);
        //Выполним SQL-запрос
        $Result = mysqli_query($this->link,$query);
        if(!$Result) {
            $errMsg = mysqli_error($this->link);
            mysqli_rollback($this->link);
            $this->errDataBase('ERR_INSERT_DATA', array($arrParam[0],$query,$errMsg));
        }
    }

    //-------------------------------------------------------
    //Получим список полей для таблицы в режиме вставки записи
    private function getQryFieldsInsert($NameTable) {
        $qryFields = "";
        //-------------------------
        $arrFields = $this->getFieldsArray('server',$NameTable);
        foreach($arrFields as $field) {
            if($field=='id') {
                continue;
            }
            if ($qryFields == "") {
                $qryFields = "`" . $field . "`";
            }
            else {
                $qryFields = $qryFields . "," . "`" . $field . "`";
            }
        }
        return $qryFields;
    }
    //----------------------------------------------------------
    //Получим список значений для таблицы в режиме вставки записи
    private function getQryValuesInsert(array $arrValues) {
        $qryValues = "";
        //-------------------------
        for($i=2; $i<count($arrValues); $i++) {
            if ($qryValues == "") {
                if($arrValues[$i]==null)
                    $qryValues = 'NULL';
                else
                    $qryValues = "'" . $arrValues[$i] . "'";
            }
            else {
                if($arrValues[$i]==null)
                    $qryValues = $qryValues . "," .  'NULL';
                else
                    $qryValues = $qryValues . "," . "'" . $arrValues[$i] . "'";
            }
        }
        return $qryValues;
    }
    //------------------------------
    //Добавить записи в базу данных.
    //Порядок параметров функции:
    //1 - название таблицы
    //2 - название запроса к таблице
    //3 - массив значений для новой записи
    public function insertData_1($aTable,$aTypeReq,array $arrValues) {
        $query = "";
        $fields = "";
        $values = "";
        //oplati_update
        //----------------------
        $fields = $this->getQryFieldsInsert_1($arrValues);
        $values = $this->getQryValuesInsert_1($arrValues);
        //Получить запрос
        $arrQueryParam = array($aTable,$aTypeReq,$fields,$values);
        $query = $this->getQuery($arrQueryParam);
        if(sysBox::$debug)
        //echo  "Do request: $query "."<br>\n";
            echo  "Do request: ".iconv("Windows-1251", "UTF-8", $query)."<br>\n";
        //Отключим autocommit
        mysqli_autocommit($this->link, FALSE);
        //Выполним SQL-запрос
        $Result = mysqli_query($this->link,$query);
        if(!$Result) {
            $errMsg = mysqli_error($this->link);
            mysqli_rollback($this->link);
            $this->errDataBase('ERR_INSERT_DATA', array($aTable,$query,$errMsg));
        }
    }

    //-------------------------------------------------------
    //Получим список полей для таблицы в режиме вставки записи
    private function getQryFieldsInsert_1(array $arrValues) {
        $qryFields = "";
        //-------------------------
        //$arrFields = $this->getFieldsArray('server',$NameTable);
        foreach($arrValues as $key => $value) {
            if ($qryFields == "") {
                $qryFields = "`" . $key . "`";
            }
            else {
                $qryFields = $qryFields . "," . "`" . $key . "`";
            }
        }
        return $qryFields;
    }

    //----------------------------------------------------------
    //Получим список значений для таблицы в режиме вставки записи
    private function getQryValuesInsert_1(array $arrValues) {
        $qryValues = "";
        //-------------------------
        foreach($arrValues as $key => $value) {
            if ($qryValues == "") {
                if($value==null)
                    $qryValues = 'NULL';
                else
                    $qryValues = "'" . $value . "'";

            }
            else {
                if($value == null)
                    $qryValues = $qryValues . "," .  'NULL';
                else
                    $qryValues = $qryValues . "," . "'" . $value . "'";
            }
        }
        return $qryValues;
    }
    //---------------------------------------
    //Вставить записи из ХМЛ выгрузки
    //выдается массив - $arrResult[].
    //Где  $arrResult[0] = кол.вставленных записей
    // $arrResult[1] = результат операции ($aTypeOperation) над данными поля ($aNameField)
    public function insertDataFromUploadXML($aXML,$aNameTable,$aTypeOperation="",$aNameField="",$aIdParam="") {
        $arrResult = array();
        $arrValues = array();
        $arrParam = array();
        $fieldName = "";
        $fieldType = "";
        $fieldValue = "";
        //$myIndex = 0;
        //-------------------
        //$arrParam[] = $aNameTable;
        //$arrParam[] = "insert";
        //Получим массив полей
        $metaData=$aXML->METADATA;
        $Fields=$metaData->FIELDS;
        $rowData=$aXML->ROWDATA;
        //Получим данные
        $row_n = 1;
        $row = "row".$row_n.":=";
        foreach($rowData->ROW  as $row_data) {
            //Если есть индекс параметра, то выделим группы в ROWDATA
            //соответсвующие этому индексу параметра
            if($aIdParam != "") {
                if($aIdParam != (string)$row_data['id_row']) {
                    continue;
                }
            }
            foreach($Fields->FIELD as $field) {
                //Получим имя поля
                $fieldName = (string)$field['FieldName'];
                $fieldType = (string)$field['FieldType'];
                $fieldType = strtolower($fieldType);
                //Получим значение поля
                $fieldValue = (string)$row_data[$fieldName];
                //Преобразуем значения для некоторых типов данных
                switch($fieldType) {
                    case "integer":
                    //Уберем пробелы
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "decimal":
                    //Уберем пробелы
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "float":
                    //Уберем пробелы
                        $fieldValue = str_replace(" ","",$fieldValue);
                        //Уберем не разрывные пробелы
                        //$fieldValue = str_replace("&nbsp;","",$fieldValue);
                        break;
                    case "string":
                    //Заменим одинарный апостроф на двойной
                        $fieldValue = str_replace("'","''",$fieldValue);
                        //Уберем не разрывные пробелы
                        //$fieldValue = str_replace("&nbsp;","",$fieldValue);
                        break;
                }
                //Сформируем строку с данными
                $row = $row.$fieldName."=".$fieldValue.";";
                //Добавим в массив параметров значение поля
                if(strtolower($fieldValue) == "null")
                    $arrParam[$fieldName] = null;
                else
                    $arrParam[$fieldName] = iconv("UTF-8", "Windows-1251", $fieldValue);
                //Добавим в массив значений значение поля, если имя поля совпадает с параметром
                if($aNameField == $fieldName)
                    $arrValues[] = $fieldValue;
            }
            //Определим, есть ли $aNameField в полях переданной записи
            if(($aNameField<>"")AND(count($arrValues)==0))
                $this->errDataBase("ERR_PARAM", array("insertDataFromUploadXML","$aNameField"));

            //Добавим записи в базу данных
            $this->insertData_1($aNameTable,'insert',$arrParam);
            //Отобразим добавленную запись
            if(sysBox::$debug)
                echo $row."<br>\n";
            $row_n++;
            $row = "row".$row_n.":=";
        }
        //Получим кол. добавленных записей
        $arrResult[] = $row_n-1;
        //Выполним операцию над полем
        if(($aTypeOperation<>"")AND(count($arrValues)>0))
            $arrResult[] = MathBox::doOperation($aTypeOperation,$arrValues);

        return  $arrResult;
    }

    /** Подготовить записи для добавления в базу данных из ХМЛ выгрузки
     *
     * @param  XML $aXML
     * @param  string $aTypeOperation
     * @param  string $aNameField
     * @param  int $aIdParam
     * @return array
     * $arrResult[0] = кол.вставленных записей
     * $arrResult[1] = результат операции ($aTypeOperation) над данными поля ($aNameField)
     * $arrResult[2] = массив в котором находяться массивы всех записей из ХМЛ
     * $arrResult[3] = массив в котором находяться строки всех записей из ХМЛ
     */
    public function prepDataFromUploadXML($aXML,$aTypeOperation="",$aNameField="",$aIdParam="") {
        $arrResult = array();
        $arrValues = array();
        $arrParam = array();
        $arrParams = array();
        $arrRows = array();
        $fieldName = "";
        $fieldType = "";
        $fieldValue = "";
        //-------------------
        //Получим массив полей
        $metaData=$aXML->METADATA;
        $Fields=$metaData->FIELDS;
        $rowData=$aXML->ROWDATA;
        //Получим данные
        $row_n = 1;
        $row = "row".$row_n.":=";
        foreach($rowData->ROW  as $row_data) {
            //Если есть индекс параметра, то выделим группы в ROWDATA
            //соответсвующие этому индексу параметра
            if($aIdParam != "") {
                if($aIdParam != (string)$row_data['id_row']) {
                    continue;
                }
            }
            foreach($Fields->FIELD as $field) {
                //Получим имя поля
                $fieldName = (string)$field['FieldName'];
                $fieldType = (string)$field['FieldType'];
                $fieldType = strtolower($fieldType);
                //Получим значение поля
                $fieldValue = (string)$row_data[$fieldName];
                //Преобразуем значения для некоторых типов данных
                switch($fieldType) {
                    case "integer":
                    //Уберем пробелы
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "decimal":
                    //Уберем пробелы
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "float":
                    //Уберем пробелы
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "string":
                    //Заменим одинарный апостроф на двойной
                        $fieldValue = str_replace("'","''",$fieldValue);
                        break;
                }
                //Сформируем строку с данными
                $row = $row.$fieldName."=".$fieldValue.";";
                //Добавим в массив параметров значение поля
                if(strtolower($fieldValue) == "null")
                    $arrParam[$fieldName] = null;
                else
                    $arrParam[$fieldName] = $fieldValue;
                //Добавим в массив значений значение поля, если имя поля совпадает с параметром
                if($aNameField == $fieldName)
                    $arrValues[] = $fieldValue;
            }
            //Определим, есть ли $aNameField в полях переданной записи
            if(($aNameField<>"")AND(count($arrValues)==0))
                $this->errDataBase("ERR_PARAM", array("prepDataFromUploadXML","$aNameField"));
            //Добавим данных в массив параметров
            $arrParams[] = $arrParam;
            //Отобразим добавленную запись
            $arrRows[] = $row;
            $row_n++;
            $row = "row".$row_n.":=";
        }
        //Получим кол. добавленных записей
        $arrResult[] = $row_n-1;
        //Выполним операцию над полем
        if(($aTypeOperation<>"")AND(count($arrValues)>0))
            $arrResult[] = Default_Plugin_MathBox::doOperation($aTypeOperation,$arrValues);
        else
            $arrResult[] = null;
        //Получим массив всех параметров
        $arrResult[] = $arrParams;
        //Получим массив всех строк записей из ХМЛ
        $arrResult[] = $arrRows;

        return  $arrResult;
    }

    /** Подготовить записи для добавления в базу данных из ХМЛ выгрузки
     *
     * @param  XML $aXML
     * @return array
     * $arrResult[0] = кол.вставленных записей
     * $arrResult[1] = массив в котором находяться массивы всех записей из ХМЛ
     */
    public function prepDataFromUploadXML2($aXML) {
        $arrResult = array();
        $arrValues = array();
        $arrParam = array();
        $arrParams = array();
        $fieldName = "";
        $fieldType = "";
        $fieldValue = "";
        //-------------------
        //Получим массив полей
        $metaData=$aXML->METADATA;
        $Fields=$metaData->FIELDS;
        $rowData=$aXML->ROWDATA;
        //Получим данные
        $row_n = 1;
        foreach($rowData->ROW  as $row_data) {
            foreach($Fields->FIELD as $field) {
                //Получим имя поля
                $fieldName = (string)$field['FieldName'];
                $fieldType = (string)$field['FieldType'];
                $fieldType = strtolower($fieldType);
                //Получим значение поля
                $fieldValue = (string)$row_data[$fieldName];
                $fieldValue = iconv("UTF-8", "Windows-1251", $fieldValue);
                //Преобразуем значения для некоторых типов данных
                switch($fieldType) {
                    case "integer":
                    //Уберем пробелы
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "decimal":
                    //Уберем пробелы
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "float":
                    //Уберем пробелы
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "string":
                    //Заменим одинарный апостроф на двойной
                        $fieldValue = str_replace("'","''",$fieldValue);
                        break;
                }
                //Добавим в массив параметров значение поля
                if(strtolower($fieldValue) == "null")
                    $arrParam[$fieldName] = null;
                else
                    $arrParam[$fieldName] = $fieldValue;
            }
            //Добавим данных в массив параметров
            $arrParams[] = $arrParam;
            $row_n++;
        }
        //Получим кол. добавленных записей
        $arrResult[] = $row_n-1;
        //Получим массив всех параметров
        $arrResult[] = $arrParams;
        return  $arrResult;
    }
    /** Получить запрос на вставку данных в таблицу
     *
     * @param  string $aTable   //Название таблицы
     * @param  string $aTypeReq //Тип запроса
     * @param  array $arrValues //Массив ключ значение
     *
     * @return string
     */
    public function getQueryForInsertData($aTable, $aTypeReq, array $arrValues) {
        $query = "";
        $fields = "";
        $values = "";
        //oplati_update
        //----------------------
        $fields = $this->getQryFieldsInsert_1($arrValues);
        $values = $this->getQryValuesInsert_1($arrValues);
        //Получить запрос
        $arrQueryParam = array($aTable,$aTypeReq,$fields,$values);
        $query = $this->getQuery($arrQueryParam);
        return $query;
    }
    //======================  ОБНОВИТЬ ДАННЫЕ В БАЗЕ ДАННЫХ ==============================//
    //Обновить записи в базе данных.
    //Порядок элементов массива:
    //1 - название таблицы
    //2 - название запроса к таблице
    //3 - массив значений для изменения в виде ключ=значение
    //4... - значения для организации запроса
    public function updateData(array $arrParam) {
        $query = "";
        $values = "";
        $arrQueryParam = array();
        //----------------------
        //Получим параметр запроса для обновления данных
        //в виде: `field`='value' or `field`=NULL
        $arrValues = (array)$arrParam[2];
        $values = $this->getQryValuesUpdate($arrValues);
        //Получим параметр запроса для условия запроса и др. параметров
        $arrQueryParam = array($arrParam[0],$arrParam[1],$values);
        if(count($arrParam)>3) {
            for($i=3;$i<count($arrParam);$i++) {
                $arrQueryParam[]=$arrParam[$i];
            }
        }
        //Получим сам запрос к базе данных
        $query = $this->getQuery($arrQueryParam);
        if(sysBox::$debug)
        //echo  "Do request: $query "."<br>\n";
            echo  "Do request: ".iconv("Windows-1251", "UTF-8", $query)."<br>\n";
        //Отключим autocommit
        mysqli_autocommit($this->link, FALSE);
        //Выполним SQL-запрос
        $Result = mysqli_query($this->link,$query);
        if(!$Result) {
            $errMsg = mysqli_error($this->link);
            mysqli_rollback($this->link);
            $this->errDataBase('ERR_UPDATE_DATA', array($arrParam[0],$query,$errMsg));
        }
    }

    //----------------------------------------------------------
    //Получим список значений для таблицы в режиме вставки записи
    private function getQryValuesUpdate(array $arrValues) {
        $qryValues = "";
        //-------------------------
        foreach($arrValues as $key=>$value) {
            if ($qryValues == "") {
                if($value==null)
                    $qryValues = "`".$key."`"."=".'NULL';
                else
                    $qryValues = "`".$key."`"."="."'".$value."'";
            }
            else {
                if($value==null)
                    $qryValues = $qryValues.","."`".$key."`"."=".'NULL';
                else
                    $qryValues = $qryValues.","."`".$key."`"."="."'".$value."'";
            }
        }
        return $qryValues;
    }

    //======================  УДАЛИТЬ ДАННЫЕ ИЗ БАЗЫ ДАННЫХ ==============================//
    //Удалить записи из базы данных.
    public function deleteData(array $arrParam) {
        $query = "";
        //----------------------
        $query = $this->getQuery($arrParam);
        if(sysBox::$debug)
        //echo  "Do request: $query "."<br>\n";
            echo  "Do request: ".iconv("Windows-1251", "UTF-8", $query)."<br>\n";
        //Отключим autocommit
        mysqli_autocommit($this->link, FALSE);
        //Выполним SQL-запрос
        $Result = mysqli_query($this->link,$query);
        if(!$Result) {
            $errMsg = mysqli_error($this->link);
            mysqli_rollback($this->link);
            $this->errDataBase('ERR_DELETE_DATA', array($arrParam[0],$query,$errMsg));
        }
    }



    //=================== РАБОТА С ОТНОШЕНИЯМИ МЕЖДУ ТАБЛИЦАМИ ======================//
    //Получить отношение владельцев к таблице $NameTable
    //Результат - выдается строка в виде:
    public function getRelationsOwner($NameTable) {
        if(array_key_exists($NameTable,$this->arrRelationOwner_Client))
            return $this->arrRelationOwner_Client[$NameTable];
        else
            return "";
    }
    //--------------------------------------------
    //Получить отношения связей между  таблицей $NameTable и другими таблицами
    //Результат - выдается строка в виде:
    //LinkTable1.linktableField=nametableField_1.nametableNewField_1.наименование;
    //LinkTable2.linktableField=nametableField_2.nametableNewField_2
    public function getRelationsLinks($NameTable) {
        if(array_key_exists($NameTable,$this->arrRelationLinks_Client))
            return $this->arrRelationLinks_Client[$NameTable];
        else
            return "";
    }
    //Получить значения полей по умолчанию для таблиц 1Сv.8
    public function getDefaultValues($NameTable) {
        if(array_key_exists($NameTable,$this->arrDefaultFields_Client))
            return $this->arrDefaultFields_Client[$NameTable];
        else
            return "";
    }


    //=================== РАБОТА С ПОЛЯМИ ТАБЛИЦЫ ======================//
    //Получить список полей таблицы
    public function getFieldsStr($source,$NameTable) {
        $arrExcludeFields = array();
        $source_ = strtolower($source);
        //----------------------
        //Получим массив полей
        $arrExcludeFields = $this->getArrExcludeFields($source,$NameTable);
        $arrFields = $this->getArrayFieldsSource($source_);
        $fields = "";
        foreach($arrFields[$NameTable] as $field) {
            if(!in_array($field,$arrExcludeFields))
                $fields = $fields.$field.";";
        }
        return $fields;
    }
    //----------------------------
    //Получить массив полей таблицы
    public function getFieldsArray($source,$NameTable) {
        //Получим массив полей
        $arrFields = $this->getArrayFieldsSource($source);
        return  $arrFields[$NameTable];
    }
    //----------------------------
    //Получить массив полей таблицы
    private function getArrayFieldsSource($source) {
        //Проверим правильность задания параметров
        $source_ = strtolower($source);
        if(!in_array($source_,$this->arrTypeFields)) {
            $this->errDataBase('ERR_PARAM',array('getFieldsArray',$source) );
        }
        switch($source_) {
            case "server":
                $arrFields = $this->arrFields_Server;
                break;
            case "client":
                $arrFields = $this->arrFields_Client;
                break;
        }
        return $arrFields;
    }

    //Получить список исключенных полей таблиц
    public function getArrExcludeFields($source,$NameTable) {
        $arrExcludeFields = array();
        $source_ = strtolower($source);
        //----------------------
        //Получим массив полей
        switch($source_) {
            case "server":
                if(array_key_exists($NameTable,$this->arrExcludeFields_Server))
                    $arrExcludeFields = explode(";",$this->arrExcludeFields_Server[$NameTable]);
                break;
            case "client":
                if(array_key_exists($NameTable,$this->arrExcludeFields_Client))
                    $arrExcludeFields = explode(";",$this->arrExcludeFields_Client[$NameTable]);
                break;
        }

        return $arrExcludeFields;
    }
    //====================== ВЫВЕСТИ ДАННЫЕ В HTML СТРАНИЦУ =============//
    //Вывести названия полей и данные таблицы в HTML для одной таблицы
    public function outputFieldsAndDataToHTML($aClient,array $arrParam) {
        $table = $arrParam[0];
        //------------------
        //Выведем название таблиы
        echo "table:=".$table."<br>\n";
        //Выведем строку с полями таблицы
        $fields = "fields:=".$this->getFieldsStr($aClient,$table);
        echo $fields."<br>\n";

        //Выведем строки полученного запроса
        $row_n = 1;
        $row = "row".$row_n.":=";
        $value = "";
        //Получим массив полей обновляемой таблицы
        $arrFields = $this->getFieldsArray($aClient,$table);
        //Запрос к данным к таблице
        if(sysBox::$debug)
            echo "====== Получим данные с таблицы - '$table' ========="."<br>\n";
        //Выполняем SQL-запрос
        $this->getData($arrParam);
        while($myrow = $this->getRow()) {
            foreach($arrFields as $field) {
                if($myrow[$field]==null)
                    $value = 'null';
                else
                    $value = $myrow[$field];
                $row = $row.iconv("Windows-1251", "UTF-8", $value).";";
            }
            echo $row."<br>\n";
            $row_n++;
            $row = "row".$row_n.":=";
        }
        return $row_n;
    }
    //---------------------------------------------------------------
    //Вывести названия полей и данные таблицы в HTML для разных таблиц
    //Можно вывести данные с разных таблицы Пр.table1:=oplati ... table2:=els
    //Параметры:
    //$aTableN - порядковый номер таблицы и ее данных
    //$aField - по какому полю в таблице получать массив значений, на выходе ф-ии
    //$aTable - алиас названия таблицы (название таблицы которое передается клиенту)
    //Выход ф-ии:
    //массив значений, определяемый параметром ->  $aField
    public function outputFieldsAndDataToHTML2($aClient,array $arrParam, $aTableN="",$aField="",$aTable="") {
        $table = $arrParam[0];
        $arrValue = array();
        //------------------
        //Выведем название таблиы
        if($aTable=="")
            echo "table".$aTableN.":=".$table."<br>\n";
        else
            echo "table".$aTableN.":=".$aTable."<br>\n";
        //Выведем строку с полями таблицы
        $fields = "fields".$aTableN.":=".$this->getFieldsStr($aClient,$table);
        echo $fields."<br>\n";

        //Выведем строки полученного запроса
        $row_n = 1;
        $row = "row".$aTableN.$row_n.":=";
        $value = "";
        //Получим массив полей обновляемой таблицы
        $arrFields = $this->getFieldsArray($aClient,$table);
        //Запрос к данным к таблице
        if(sysBox::$debug)
            echo "====== Получим данные с таблицы - '$table' ========="."<br>\n";
        //Выполняем SQL-запрос
        $this->getData($arrParam);
        while($myrow = $this->getRow()) {
            foreach($arrFields as $field) {
                if($myrow[$field]==null)
                    $value = 'null';
                else
                    $value = $myrow[$field];
                $row = $row.iconv("Windows-1251", "UTF-8", $value).";";
                //Получим выходной массив данных из соответствующего поля
                if($field == $aField) {
                    if(!in_array($value, $arrValue)) {
                        $arrValue[]=  $value;
                    }
                }
            }
            echo $row."<br>\n";
            $row_n++;
            $row = "row".$aTableN.$row_n.":=";
        }
        return $arrValue;
    }

    //------------------------------------------------------------------------
    //Вывести значения результата и результирующее сообщение
    public static function outputResultAndMessageToHTML($aResult,$aResultMsg) {
        echo "result:=".$aResult ."<br>\n";
        echo "result_msg:=".$aResultMsg ."<br>\n";
    }

    /**Вывести названия полей и данные таблицы в HTML для одной таблицы
     *
     * @param  string $client
     * @param  array $rows
     * @return int
     */
    public function outputFieldsAndDataForDic($client,$language,array $rows) {
        $table = $this->_name;
        //------------------
        //Выведем название таблиы
        $this->_results[] = "table:=".$table;
        //Выведем строку с полями таблицы
        $fields = "fields:=".$this->getFieldsStr($client,$table);
        $this->_results[] =  $fields;

        //Выведем строки полученного запроса
        $row_n = 1;
        $row = "row".$row_n.":=";
        $value = "";
        //Получим массив полей обновляемой таблицы
        $arrFields = $this->getFieldsArray('server',$table);
        //Запрос к данным к таблице
        $this->_results[] = "====== Получим данные с таблицы - '$table' =========";
        //Выполняем SQL-запрос
        foreach($rows as $myrow) {
            //Конвертируем кодировку
            $myrow = $this->ConvertWinUtf($myrow);
            //Получим поля для исключения из списка полей
            $arrExcludeFields = $this->getArrExcludeFields($client,$table);
            foreach($arrFields as $field) {
                if(!in_array($field,$arrExcludeFields)) {
                    //Пропустим не нужное значение (не тот язык) в поле
                    if(substr_count($field,"_".$language)>0)
                        continue;
                    if($myrow[$field]==null)
                        $value = 'null';
                    else {
                        $value = $myrow[$field];
                        //Уберем символ ';'
                        $value = str_replace(";","",$value);
                    }
                    $row = $row.$value.";";
                }
            }
            $this->_results[] = $row;
            $row_n++;
            $row = "row".$row_n.":=";
        }
        return $row_n;
    }

    //====================== ПРИКЛАДНЫЕ ОПЕРАЦИИ С БАЗОЙ ДАННЫХ =============//
    //Получить список полей таблицы
    public function getIsRegistryInfo($aNameTable) {
        //----------------------
        return in_array($aNameTable,$arrRegistryInfo_1C);
    }

    /**----------------------------
     * Конвертировать поля записи из кодировки WIN 1251 -> UTF8
     *
     * @param   void
     * @return void
     */
    public function getInfoDB() {
        //Определим кодировку соединения
        $charset = mysql_client_encoding($this->link);
        printf ("current character set is %s<br \>\n", $charset);

        //Получим данные о MySQL-клиенте
        printf ("MySQL client info: %s<br \>\n", mysql_get_client_info());

        //Получим информацию о соединении с MySQL
        printf ("MySQL host info: %s<br \>\n", mysql_get_host_info());

        //Получим информацию о протоколе MySQL
        printf ("MySQL protocol version: %s<br \>\n", mysql_get_proto_info());

        //Получим информацию о сервере MySQL
        printf ("MySQL server version: %s<br \>\n", mysql_get_server_info());


    }

    /**----------------------------
     * Конвертировать поля записи из кодировки WIN 1251 -> UTF8
     *
     * @param  array $rec
     * @return array
     */
    public function ConvertWinUtf( $rec ) {
        if($rec == null) return $rec;
        foreach($rec as $key=>$value) {
            if (is_string($value)) {
                $rec[$key]= iconv("Windows-1251", "UTF-8", $rec[$key]);
            }
        }
        return $rec;
    }

    /**----------------------------
     * Конвертировать поля записи из кодировки UTF8 -> WIN 1251
     *
     * @param  array $rec
     * @return array
     */
    public function ConvertUtfWin( $rec ) {
        if($rec == null) return $rec;
        foreach($rec as $key=>$value) {
            if (is_string($value)) {
                $rec[$key]= iconv("UTF-8","Windows-1251", $rec[$key]);
            }
        }
        return $rec;
    }

    /**----------------------------
     * Конвертировать поля записи из кодировки latin1 -> UTF8
     *
     * @param  array $rec
     * @return array
     */
    public function ConvertLatin1Utf( $rec ) {
        if($rec == null) return $rec;
        foreach($rec as $key=>$value) {
            $rec[$key]= iconv("ISO-8859-1", "UTF-8", $rec[$key]);
        }
        return $rec;
    }

    /**----------------------------
     * Конвертировать поля записи из кодировки latin1 -> WIN 1251
     *
     * @param  array $rec
     * @return array
     */
    public function ConvertLatin1Win( $rec ) {
        if($rec == null) return $rec;
        foreach($rec as $key=>$value) {
            $rec[$key]= iconv("ISO-8859-1","Windows-1251", $rec[$key]);
        }
        return $rec;
    }
    //================== ОСВОБОЖДЕНИЕ РЕСУРСОВ В БАЗЕ ДАННЫХ ===============//
    //Освободим ресурсы все ресурсы: запроса и соединения
    public function freeResource() {
        //Освободим данные от запроса к базе данных
        if($this->response)
            mysql_free_result($this->response);
        //Освободим соединение к базе данных
        if($this->link)
            mysql_close($this->link);
    }
    //----------------------------
    //Освободим ресурс запроса
    public function freeResponse() {
        //Освободим данные от запроса к базе данных
        if($this->response)
            mysql_free_result($this->response);
    }
    //----------------------------
    //Освободим ресурс соединения
    public function freeConnect() {
        //Освободим соединение к базе данных
        if($this->link)
            mysql_close($this->link);
    }
    //====================== ПОЛУЧИТЬ ЗАПРОС С БАЗЫ ДАННЫХ =============//
    public function getQuery(array $arrParam) {
        $table = $arrParam[0];
        $query = $arrParam[1];
        $result = "";
        //---------------------------
        switch($query) {
            case "insert":
                $result = "INSERT INTO `$table` (%s) VALUES (%s)";
                $result = sprintf($result, $arrParam[2], $arrParam[3]);
                break;
            case "delete":
                $result = "DELETE FROM `$table` WHERE `id`= '%s'";
                $result = sprintf($result, $arrParam[2]);
                break;
            case "delete_this":
                $result = "DELETE FROM `$table` WHERE `%s`= '%s'";
                $result = sprintf($result, $arrParam[2],$arrParam[3]);
                break;
            case "delete_all":
                $result = "DELETE FROM `$table`";
                break;
            case "update":
                $result = "UPDATE `$table` SET %s WHERE `id`='%s'";
                $result = sprintf($result, $arrParam[2], $arrParam[3]);
                break;
            case "replace_all":
                $result = "UPDATE `$table` SET %s=REPLACE(%s,'%s','%s')";
                $result = sprintf($result, $arrParam[2], $arrParam[3], $arrParam[4], $arrParam[5]);
                break;
            case("get_rows"):
                $result = "	SELECT * FROM `$table` WHERE `%s` = '%s'";
                $result = sprintf($result, $arrParam[2],$arrParam[3]);
                break;
            case("get_rows_all"):
                $result = "	SELECT * FROM `$table`  ORDER BY %s";
                $result = sprintf($result, $arrParam[2]);
                break;
            case("get_rows_in"):
                $result = " SELECT t.*
                            FROM `$table` t
                            WHERE t.`%s`IN(%s)";
                $result = sprintf($result, $arrParam[2],$arrParam[3]);
                break;
            case("get_new_rows"):
                $result = " SELECT * FROM `$table` t
                            WHERE (t.`%s` = '%s')AND(t.`ts`>'%s')";
                $result = sprintf($result, $arrParam[2],$arrParam[3],$arrParam[4]);
                break;

            default:
                break;
        }
        return $result;
    }

    //====================  ВЫЗОВ ОШИБКИ ДЛЯ БАЗЫ ДАННЫХ   ==================//
    private function errDataBase($typeError, array $arrParam) {
        $myMsg = "";
        //------------------
        switch ($typeError) {
            case "ERR_CONNECT":
                $myMsg = "WEB: Ошибка соединения с базой данных: \n%s";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_SELECT_DB":
                $myMsg = "WEB: Ошибка выбора базы данных: \n%s";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_QUERY":
                $myMsg = "WEB: Ошибка запроса к базе данных: \n%s";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_INSERT_DATA":
                $myMsg = "WEB: Ошибка добавления записей в таблицу данных - '%s'!\nЗапрос на добавление записей в базу данных:\n%s\n.Ошибка запроса: \n%s";
                $myMsg = sprintf($myMsg, $arrParam[0],$arrParam[1],$arrParam[2]);
                break;
            case "ERR_DELETE_DATA":
                $myMsg = "WEB: Ошибка удаления записей из таблицы данных - '%s'!\nЗапрос на удаление записей из базы данных:\n%s\n.Ошибка запроса: \n%s";
                $myMsg = sprintf($myMsg, $arrParam[0],$arrParam[1],$arrParam[2]);
                break;
            case "ERR_UPDATE_DATA":
                $myMsg = "WEB: Ошибка обновления записей в таблице данных - '%s'!\nЗапрос на обновление записей в базе данных:\n  %s\n.Ошибка запроса: \n%s";
                $myMsg = sprintf($myMsg, $arrParam[0],$arrParam[1],$arrParam[2]);
                break;
            case "ERR_PARAM":
                $myMsg = "WEB: Ошибка задания параметра: функция -  '%s'; ошибочный параметр - '%s'!";
                $myMsg = sprintf($myMsg, $arrParam[0],$arrParam[1]);
                break;
        }
        throw new dbException($typeError, $myMsg);
    }

}

?>
