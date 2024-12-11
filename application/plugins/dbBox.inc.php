
<?php
/*=============  ����� ��������� ������ ���� ������ ========//
 * ������ ���� ������
 * Modul DbBox.php Copyright @ 2009 BSA
 * @uses    Zend_Exception
 * @package ZF-BUH1C
*/
class dbException extends Exception {
    private $typeError = "";
    //-------------------------------
    //�����������
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
    //�������� ��� ������
    public function GetTypeError() {
        return $this->typeError;
    }
}

/*============= ����� ������� � ���� ������ ===============//
 * ����� ������ � ����� ������
 * Modul DbBox.php Copyright @ 2009 BSA
 * @uses    
 * @package ZF-BUH1C
*/
class dbBox {

    //������ ��� ���������� �� ����� ������
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

    //���� ������ ��� ������� �������
    private $arrTypeFields =	array("server","client");
    //���� ������ ��� ������� �������
    //�����!!!!!!!!!!!! ���� ������� ������ ���������� � ����� 'id','ts'
    private $arrFields_Server =	array(
            'otgruzka'=>array('id','ts','org','norg_s','kdog','prod','ddm','cena','kol','opl','fakt','plan','sost'));


    //�������� �����, ������� ����� ��������� ��� ������ �������
    private $arrExcludeFields_Server =	array();

    //���� ������ ��� �������
    private $arrFields_Client =	array(
            'predpr'=>array('kdog'=>'�������','prod'=>'�������',
                            'ddm'=>'���� ������','cena'=>'����',
                            'kol'=>'��������','opl'=>'��������',
                            'fakt'=>'����.','plan'=>'� �����',
                            'sost'=>'����.'));

    //��������� ������� � �� ������������� ��� �������
    //�����������: ����=��������, ��� �������� = usluga_group.���=id_group
    //������������� ������� - "usluga" �������� ������� - "usluga_group"
    //����� ����� ��������� ���� "���" �������  "usluga_group" ������� � ����� "id_usluga"
    //������� "usluga"
    private $arrRelationOwner_Client =	array(
            //'els'=>'abonent.���=id_abon',
            'usluga'=>'usluga_group.���=id_group',
            'usluga_units'=>'usluga.���=id_usluga'
    );
    //��������� ������ ����� �������� � ������� ��������� ��� �������
    private $arrRelationLinks_Client =	array(
            'usluga_units'=>'units.���=id_unit.����������������.������������'
    );
    //�������� ����� �� ��������� ��� ������ �������
    private $arrDefaultFields_Client =	array(
            'predpr'=>'��������=������',
            'abonent'=>'�����=������',
            'els'=>'�����=������'
    );
    //�������� �����, ������� ����� ��������� ��� ������ �������
    private $arrExcludeFields_Client =	array(
            'els'=>'id_client1c;actual'
    );

    //------------------------------------------------------------------------
    //�����������
    function __construct($dbName="") {
        if($dbName!="")
            $this->arrConnectDB['dbname'] = $dbName;
    }
    //================= ����������� � ����� ������ MYSQL  ====================//

    //��������� ���������� � ����������� � ���� ������
    public function setInfoConnect($DBHost, $DBLogin, $DBPassword) {
        //-------------------------------------
        $this->arrConnectDB['host'] = $DBHost;
        $this->arrConnectDB['username'] = $DBLogin;
        $this->arrConnectDB['passwd'] = $DBPassword;
    }
    //������� ���������� � ����������� � ���� ������
    public function getInfoConnect() {
        //-------------------------------------
        return $this->arrConnectDB;
    }
    //������� ��� ���� ������
    public function getNameDB() {
        //-------------------------------------
        return $this->arrConnectDB['dbname'];
    }
    //���������� � ����� ������
    public function mysqlConnect() {

        //---------------------
        //���������� � ���� ������
        $this->link = mysql_connect( 	$this->arrConnectDB['host'],
                $this->arrConnectDB['username'],
                $this->arrConnectDB['passwd'],
                $this->arrConnectDB['dbname']);

        if(!$this->link) {
            $this->errDataBase(	'ERR_CONNECT',
                    array("������ ���������� � ���� ������ - ".
                            mysql_error()));
        }
        //������� ���� ������
        if(!mysql_select_db($this->arrConnectDB['dbname'])) {
            $this->errDataBase('ERR_CONNECT', array("������ ������ ���� ������ - ". mysql_error()));
        }

        if(sysBox::$debug)
            echo  "Yes connect to '".$this->arrConnectDB['dbname']."'"."<br \>\n";

        //������� ���������� � ���� ������
        //$this->getInfoDB();

        return $this->link;
    }
    //======================  �������� ������ � ���� ������ ==============================//
    public function getData(array $arrParam) {
        $query = "";

        //----------------------
        //�������� ������
        $query = $this->getQuery($arrParam);
        if(sysBox::$debug)
        //echo  "Do request: ".$query."<br>\n";
            echo  "Do request: ".$query."<br>\n";
        //echo  "Do request: ".iconv("Windows-1251", "UTF-8", $query)."<br>\n";
        //�������� SQL-������
        $this->response = mysql_query($query,$this->link);
        if(!$this->response) {
            $this->errDataBase('ERR_QUERY', array(" : " . mysql_error($this->link)));
        }
        return $this->response;
    }
    //----------------------------
    //������� ������ ������ �� �������
    public function getRow() {
        //----------------------
        //return $this->ConvertLatin1Win( mysql_fetch_array($this->response) ) ;
        return  mysql_fetch_array($this->response);
    }

    //----------------------------
    //��������� ��������� ��� ���� ������
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
    //======================  �������� ������ � ���� ������ ==============================//

    //�������� ���������� ���� (ID) ��� ��������� ����������� ������ � �������
    public function GetLastInsertRow_id() {
        return mysql_insert_id($this->link);
    }

    //----------------------------
    //�������� ������ � ���� ������.
    //������� ��������� �������:
    //1 - �������� �������
    //2 - �������� ������� � �������
    //3 - ������ �������� ��� ����� ������
    public function insertData(array $arrParam) {
        $query = "";
        $fields = "";
        $values = "";
        //oplati_update
        //----------------------
        $fields = $this->getQryFieldsInsert($arrParam[0]);
        $values = $this->getQryValuesInsert($arrParam);
        //�������� ������
        $arrQueryParam = array($arrParam[0],$arrParam[1],$fields,$values);
        $query = $this->getQuery($arrQueryParam);
        if(sysBox::$debug)
        //echo  "Do request: $query "."<br>\n";
            echo  "Do request: ".iconv("Windows-1251", "UTF-8", $query)."<br>\n";
        //�������� autocommit
        mysqli_autocommit($this->link, FALSE);
        //�������� SQL-������
        $Result = mysqli_query($this->link,$query);
        if(!$Result) {
            $errMsg = mysqli_error($this->link);
            mysqli_rollback($this->link);
            $this->errDataBase('ERR_INSERT_DATA', array($arrParam[0],$query,$errMsg));
        }
    }

    //-------------------------------------------------------
    //������� ������ ����� ��� ������� � ������ ������� ������
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
    //������� ������ �������� ��� ������� � ������ ������� ������
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
    //�������� ������ � ���� ������.
    //������� ���������� �������:
    //1 - �������� �������
    //2 - �������� ������� � �������
    //3 - ������ �������� ��� ����� ������
    public function insertData_1($aTable,$aTypeReq,array $arrValues) {
        $query = "";
        $fields = "";
        $values = "";
        //oplati_update
        //----------------------
        $fields = $this->getQryFieldsInsert_1($arrValues);
        $values = $this->getQryValuesInsert_1($arrValues);
        //�������� ������
        $arrQueryParam = array($aTable,$aTypeReq,$fields,$values);
        $query = $this->getQuery($arrQueryParam);
        if(sysBox::$debug)
        //echo  "Do request: $query "."<br>\n";
            echo  "Do request: ".iconv("Windows-1251", "UTF-8", $query)."<br>\n";
        //�������� autocommit
        mysqli_autocommit($this->link, FALSE);
        //�������� SQL-������
        $Result = mysqli_query($this->link,$query);
        if(!$Result) {
            $errMsg = mysqli_error($this->link);
            mysqli_rollback($this->link);
            $this->errDataBase('ERR_INSERT_DATA', array($aTable,$query,$errMsg));
        }
    }

    //-------------------------------------------------------
    //������� ������ ����� ��� ������� � ������ ������� ������
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
    //������� ������ �������� ��� ������� � ������ ������� ������
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
    //�������� ������ �� ��� ��������
    //�������� ������ - $arrResult[].
    //���  $arrResult[0] = ���.����������� �������
    // $arrResult[1] = ��������� �������� ($aTypeOperation) ��� ������� ���� ($aNameField)
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
        //������� ������ �����
        $metaData=$aXML->METADATA;
        $Fields=$metaData->FIELDS;
        $rowData=$aXML->ROWDATA;
        //������� ������
        $row_n = 1;
        $row = "row".$row_n.":=";
        foreach($rowData->ROW  as $row_data) {
            //���� ���� ������ ���������, �� ������� ������ � ROWDATA
            //�������������� ����� ������� ���������
            if($aIdParam != "") {
                if($aIdParam != (string)$row_data['id_row']) {
                    continue;
                }
            }
            foreach($Fields->FIELD as $field) {
                //������� ��� ����
                $fieldName = (string)$field['FieldName'];
                $fieldType = (string)$field['FieldType'];
                $fieldType = strtolower($fieldType);
                //������� �������� ����
                $fieldValue = (string)$row_data[$fieldName];
                //����������� �������� ��� ��������� ����� ������
                switch($fieldType) {
                    case "integer":
                    //������ �������
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "decimal":
                    //������ �������
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "float":
                    //������ �������
                        $fieldValue = str_replace(" ","",$fieldValue);
                        //������ �� ��������� �������
                        //$fieldValue = str_replace("&nbsp;","",$fieldValue);
                        break;
                    case "string":
                    //������� ��������� �������� �� �������
                        $fieldValue = str_replace("'","''",$fieldValue);
                        //������ �� ��������� �������
                        //$fieldValue = str_replace("&nbsp;","",$fieldValue);
                        break;
                }
                //���������� ������ � �������
                $row = $row.$fieldName."=".$fieldValue.";";
                //������� � ������ ���������� �������� ����
                if(strtolower($fieldValue) == "null")
                    $arrParam[$fieldName] = null;
                else
                    $arrParam[$fieldName] = iconv("UTF-8", "Windows-1251", $fieldValue);
                //������� � ������ �������� �������� ����, ���� ��� ���� ��������� � ����������
                if($aNameField == $fieldName)
                    $arrValues[] = $fieldValue;
            }
            //���������, ���� �� $aNameField � ����� ���������� ������
            if(($aNameField<>"")AND(count($arrValues)==0))
                $this->errDataBase("ERR_PARAM", array("insertDataFromUploadXML","$aNameField"));

            //������� ������ � ���� ������
            $this->insertData_1($aNameTable,'insert',$arrParam);
            //��������� ����������� ������
            if(sysBox::$debug)
                echo $row."<br>\n";
            $row_n++;
            $row = "row".$row_n.":=";
        }
        //������� ���. ����������� �������
        $arrResult[] = $row_n-1;
        //�������� �������� ��� �����
        if(($aTypeOperation<>"")AND(count($arrValues)>0))
            $arrResult[] = MathBox::doOperation($aTypeOperation,$arrValues);

        return  $arrResult;
    }

    /** ����������� ������ ��� ���������� � ���� ������ �� ��� ��������
     *
     * @param  XML $aXML
     * @param  string $aTypeOperation
     * @param  string $aNameField
     * @param  int $aIdParam
     * @return array
     * $arrResult[0] = ���.����������� �������
     * $arrResult[1] = ��������� �������� ($aTypeOperation) ��� ������� ���� ($aNameField)
     * $arrResult[2] = ������ � ������� ���������� ������� ���� ������� �� ���
     * $arrResult[3] = ������ � ������� ���������� ������ ���� ������� �� ���
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
        //������� ������ �����
        $metaData=$aXML->METADATA;
        $Fields=$metaData->FIELDS;
        $rowData=$aXML->ROWDATA;
        //������� ������
        $row_n = 1;
        $row = "row".$row_n.":=";
        foreach($rowData->ROW  as $row_data) {
            //���� ���� ������ ���������, �� ������� ������ � ROWDATA
            //�������������� ����� ������� ���������
            if($aIdParam != "") {
                if($aIdParam != (string)$row_data['id_row']) {
                    continue;
                }
            }
            foreach($Fields->FIELD as $field) {
                //������� ��� ����
                $fieldName = (string)$field['FieldName'];
                $fieldType = (string)$field['FieldType'];
                $fieldType = strtolower($fieldType);
                //������� �������� ����
                $fieldValue = (string)$row_data[$fieldName];
                //����������� �������� ��� ��������� ����� ������
                switch($fieldType) {
                    case "integer":
                    //������ �������
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "decimal":
                    //������ �������
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "float":
                    //������ �������
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "string":
                    //������� ��������� �������� �� �������
                        $fieldValue = str_replace("'","''",$fieldValue);
                        break;
                }
                //���������� ������ � �������
                $row = $row.$fieldName."=".$fieldValue.";";
                //������� � ������ ���������� �������� ����
                if(strtolower($fieldValue) == "null")
                    $arrParam[$fieldName] = null;
                else
                    $arrParam[$fieldName] = $fieldValue;
                //������� � ������ �������� �������� ����, ���� ��� ���� ��������� � ����������
                if($aNameField == $fieldName)
                    $arrValues[] = $fieldValue;
            }
            //���������, ���� �� $aNameField � ����� ���������� ������
            if(($aNameField<>"")AND(count($arrValues)==0))
                $this->errDataBase("ERR_PARAM", array("prepDataFromUploadXML","$aNameField"));
            //������� ������ � ������ ����������
            $arrParams[] = $arrParam;
            //��������� ����������� ������
            $arrRows[] = $row;
            $row_n++;
            $row = "row".$row_n.":=";
        }
        //������� ���. ����������� �������
        $arrResult[] = $row_n-1;
        //�������� �������� ��� �����
        if(($aTypeOperation<>"")AND(count($arrValues)>0))
            $arrResult[] = Default_Plugin_MathBox::doOperation($aTypeOperation,$arrValues);
        else
            $arrResult[] = null;
        //������� ������ ���� ����������
        $arrResult[] = $arrParams;
        //������� ������ ���� ����� ������� �� ���
        $arrResult[] = $arrRows;

        return  $arrResult;
    }

    /** ����������� ������ ��� ���������� � ���� ������ �� ��� ��������
     *
     * @param  XML $aXML
     * @return array
     * $arrResult[0] = ���.����������� �������
     * $arrResult[1] = ������ � ������� ���������� ������� ���� ������� �� ���
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
        //������� ������ �����
        $metaData=$aXML->METADATA;
        $Fields=$metaData->FIELDS;
        $rowData=$aXML->ROWDATA;
        //������� ������
        $row_n = 1;
        foreach($rowData->ROW  as $row_data) {
            foreach($Fields->FIELD as $field) {
                //������� ��� ����
                $fieldName = (string)$field['FieldName'];
                $fieldType = (string)$field['FieldType'];
                $fieldType = strtolower($fieldType);
                //������� �������� ����
                $fieldValue = (string)$row_data[$fieldName];
                $fieldValue = iconv("UTF-8", "Windows-1251", $fieldValue);
                //����������� �������� ��� ��������� ����� ������
                switch($fieldType) {
                    case "integer":
                    //������ �������
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "decimal":
                    //������ �������
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "float":
                    //������ �������
                        $fieldValue = str_replace(" ","",$fieldValue);
                        break;
                    case "string":
                    //������� ��������� �������� �� �������
                        $fieldValue = str_replace("'","''",$fieldValue);
                        break;
                }
                //������� � ������ ���������� �������� ����
                if(strtolower($fieldValue) == "null")
                    $arrParam[$fieldName] = null;
                else
                    $arrParam[$fieldName] = $fieldValue;
            }
            //������� ������ � ������ ����������
            $arrParams[] = $arrParam;
            $row_n++;
        }
        //������� ���. ����������� �������
        $arrResult[] = $row_n-1;
        //������� ������ ���� ����������
        $arrResult[] = $arrParams;
        return  $arrResult;
    }
    /** �������� ������ �� ������� ������ � �������
     *
     * @param  string $aTable   //�������� �������
     * @param  string $aTypeReq //��� �������
     * @param  array $arrValues //������ ���� ��������
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
        //�������� ������
        $arrQueryParam = array($aTable,$aTypeReq,$fields,$values);
        $query = $this->getQuery($arrQueryParam);
        return $query;
    }
    //======================  �������� ������ � ���� ������ ==============================//
    //�������� ������ � ���� ������.
    //������� ��������� �������:
    //1 - �������� �������
    //2 - �������� ������� � �������
    //3 - ������ �������� ��� ��������� � ���� ����=��������
    //4... - �������� ��� ����������� �������
    public function updateData(array $arrParam) {
        $query = "";
        $values = "";
        $arrQueryParam = array();
        //----------------------
        //������� �������� ������� ��� ���������� ������
        //� ����: `field`='value' or `field`=NULL
        $arrValues = (array)$arrParam[2];
        $values = $this->getQryValuesUpdate($arrValues);
        //������� �������� ������� ��� ������� ������� � ��. ����������
        $arrQueryParam = array($arrParam[0],$arrParam[1],$values);
        if(count($arrParam)>3) {
            for($i=3;$i<count($arrParam);$i++) {
                $arrQueryParam[]=$arrParam[$i];
            }
        }
        //������� ��� ������ � ���� ������
        $query = $this->getQuery($arrQueryParam);
        if(sysBox::$debug)
        //echo  "Do request: $query "."<br>\n";
            echo  "Do request: ".iconv("Windows-1251", "UTF-8", $query)."<br>\n";
        //�������� autocommit
        mysqli_autocommit($this->link, FALSE);
        //�������� SQL-������
        $Result = mysqli_query($this->link,$query);
        if(!$Result) {
            $errMsg = mysqli_error($this->link);
            mysqli_rollback($this->link);
            $this->errDataBase('ERR_UPDATE_DATA', array($arrParam[0],$query,$errMsg));
        }
    }

    //----------------------------------------------------------
    //������� ������ �������� ��� ������� � ������ ������� ������
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

    //======================  ������� ������ �� ���� ������ ==============================//
    //������� ������ �� ���� ������.
    public function deleteData(array $arrParam) {
        $query = "";
        //----------------------
        $query = $this->getQuery($arrParam);
        if(sysBox::$debug)
        //echo  "Do request: $query "."<br>\n";
            echo  "Do request: ".iconv("Windows-1251", "UTF-8", $query)."<br>\n";
        //�������� autocommit
        mysqli_autocommit($this->link, FALSE);
        //�������� SQL-������
        $Result = mysqli_query($this->link,$query);
        if(!$Result) {
            $errMsg = mysqli_error($this->link);
            mysqli_rollback($this->link);
            $this->errDataBase('ERR_DELETE_DATA', array($arrParam[0],$query,$errMsg));
        }
    }



    //=================== ������ � ����������� ����� ��������� ======================//
    //�������� ��������� ���������� � ������� $NameTable
    //��������� - �������� ������ � ����:
    public function getRelationsOwner($NameTable) {
        if(array_key_exists($NameTable,$this->arrRelationOwner_Client))
            return $this->arrRelationOwner_Client[$NameTable];
        else
            return "";
    }
    //--------------------------------------------
    //�������� ��������� ������ �����  �������� $NameTable � ������� ���������
    //��������� - �������� ������ � ����:
    //LinkTable1.linktableField=nametableField_1.nametableNewField_1.������������;
    //LinkTable2.linktableField=nametableField_2.nametableNewField_2
    public function getRelationsLinks($NameTable) {
        if(array_key_exists($NameTable,$this->arrRelationLinks_Client))
            return $this->arrRelationLinks_Client[$NameTable];
        else
            return "";
    }
    //�������� �������� ����� �� ��������� ��� ������ 1�v.8
    public function getDefaultValues($NameTable) {
        if(array_key_exists($NameTable,$this->arrDefaultFields_Client))
            return $this->arrDefaultFields_Client[$NameTable];
        else
            return "";
    }


    //=================== ������ � ������ ������� ======================//
    //�������� ������ ����� �������
    public function getFieldsStr($source,$NameTable) {
        $arrExcludeFields = array();
        $source_ = strtolower($source);
        //----------------------
        //������� ������ �����
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
    //�������� ������ ����� �������
    public function getFieldsArray($source,$NameTable) {
        //������� ������ �����
        $arrFields = $this->getArrayFieldsSource($source);
        return  $arrFields[$NameTable];
    }
    //----------------------------
    //�������� ������ ����� �������
    private function getArrayFieldsSource($source) {
        //�������� ������������ ������� ����������
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

    //�������� ������ ����������� ����� ������
    public function getArrExcludeFields($source,$NameTable) {
        $arrExcludeFields = array();
        $source_ = strtolower($source);
        //----------------------
        //������� ������ �����
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
    //====================== ������� ������ � HTML �������� =============//
    //������� �������� ����� � ������ ������� � HTML ��� ����� �������
    public function outputFieldsAndDataToHTML($aClient,array $arrParam) {
        $table = $arrParam[0];
        //------------------
        //������� �������� ������
        echo "table:=".$table."<br>\n";
        //������� ������ � ������ �������
        $fields = "fields:=".$this->getFieldsStr($aClient,$table);
        echo $fields."<br>\n";

        //������� ������ ����������� �������
        $row_n = 1;
        $row = "row".$row_n.":=";
        $value = "";
        //������� ������ ����� ����������� �������
        $arrFields = $this->getFieldsArray($aClient,$table);
        //������ � ������ � �������
        if(sysBox::$debug)
            echo "====== ������� ������ � ������� - '$table' ========="."<br>\n";
        //��������� SQL-������
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
    //������� �������� ����� � ������ ������� � HTML ��� ������ ������
    //����� ������� ������ � ������ ������� ��.table1:=oplati ... table2:=els
    //���������:
    //$aTableN - ���������� ����� ������� � �� ������
    //$aField - �� ������ ���� � ������� �������� ������ ��������, �� ������ �-��
    //$aTable - ����� �������� ������� (�������� ������� ������� ���������� �������)
    //����� �-��:
    //������ ��������, ������������ ���������� ->  $aField
    public function outputFieldsAndDataToHTML2($aClient,array $arrParam, $aTableN="",$aField="",$aTable="") {
        $table = $arrParam[0];
        $arrValue = array();
        //------------------
        //������� �������� ������
        if($aTable=="")
            echo "table".$aTableN.":=".$table."<br>\n";
        else
            echo "table".$aTableN.":=".$aTable."<br>\n";
        //������� ������ � ������ �������
        $fields = "fields".$aTableN.":=".$this->getFieldsStr($aClient,$table);
        echo $fields."<br>\n";

        //������� ������ ����������� �������
        $row_n = 1;
        $row = "row".$aTableN.$row_n.":=";
        $value = "";
        //������� ������ ����� ����������� �������
        $arrFields = $this->getFieldsArray($aClient,$table);
        //������ � ������ � �������
        if(sysBox::$debug)
            echo "====== ������� ������ � ������� - '$table' ========="."<br>\n";
        //��������� SQL-������
        $this->getData($arrParam);
        while($myrow = $this->getRow()) {
            foreach($arrFields as $field) {
                if($myrow[$field]==null)
                    $value = 'null';
                else
                    $value = $myrow[$field];
                $row = $row.iconv("Windows-1251", "UTF-8", $value).";";
                //������� �������� ������ ������ �� ���������������� ����
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
    //������� �������� ���������� � �������������� ���������
    public static function outputResultAndMessageToHTML($aResult,$aResultMsg) {
        echo "result:=".$aResult ."<br>\n";
        echo "result_msg:=".$aResultMsg ."<br>\n";
    }

    /**������� �������� ����� � ������ ������� � HTML ��� ����� �������
     *
     * @param  string $client
     * @param  array $rows
     * @return int
     */
    public function outputFieldsAndDataForDic($client,$language,array $rows) {
        $table = $this->_name;
        //------------------
        //������� �������� ������
        $this->_results[] = "table:=".$table;
        //������� ������ � ������ �������
        $fields = "fields:=".$this->getFieldsStr($client,$table);
        $this->_results[] =  $fields;

        //������� ������ ����������� �������
        $row_n = 1;
        $row = "row".$row_n.":=";
        $value = "";
        //������� ������ ����� ����������� �������
        $arrFields = $this->getFieldsArray('server',$table);
        //������ � ������ � �������
        $this->_results[] = "====== ������� ������ � ������� - '$table' =========";
        //��������� SQL-������
        foreach($rows as $myrow) {
            //������������ ���������
            $myrow = $this->ConvertWinUtf($myrow);
            //������� ���� ��� ���������� �� ������ �����
            $arrExcludeFields = $this->getArrExcludeFields($client,$table);
            foreach($arrFields as $field) {
                if(!in_array($field,$arrExcludeFields)) {
                    //��������� �� ������ �������� (�� ��� ����) � ����
                    if(substr_count($field,"_".$language)>0)
                        continue;
                    if($myrow[$field]==null)
                        $value = 'null';
                    else {
                        $value = $myrow[$field];
                        //������ ������ ';'
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

    //====================== ���������� �������� � ����� ������ =============//
    //�������� ������ ����� �������
    public function getIsRegistryInfo($aNameTable) {
        //----------------------
        return in_array($aNameTable,$arrRegistryInfo_1C);
    }

    /**----------------------------
     * �������������� ���� ������ �� ��������� WIN 1251 -> UTF8
     *
     * @param   void
     * @return void
     */
    public function getInfoDB() {
        //��������� ��������� ����������
        $charset = mysql_client_encoding($this->link);
        printf ("current character set is %s<br \>\n", $charset);

        //������� ������ � MySQL-�������
        printf ("MySQL client info: %s<br \>\n", mysql_get_client_info());

        //������� ���������� � ���������� � MySQL
        printf ("MySQL host info: %s<br \>\n", mysql_get_host_info());

        //������� ���������� � ��������� MySQL
        printf ("MySQL protocol version: %s<br \>\n", mysql_get_proto_info());

        //������� ���������� � ������� MySQL
        printf ("MySQL server version: %s<br \>\n", mysql_get_server_info());


    }

    /**----------------------------
     * �������������� ���� ������ �� ��������� WIN 1251 -> UTF8
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
     * �������������� ���� ������ �� ��������� UTF8 -> WIN 1251
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
     * �������������� ���� ������ �� ��������� latin1 -> UTF8
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
     * �������������� ���� ������ �� ��������� latin1 -> WIN 1251
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
    //================== ������������ �������� � ���� ������ ===============//
    //��������� ������� ��� �������: ������� � ����������
    public function freeResource() {
        //��������� ������ �� ������� � ���� ������
        if($this->response)
            mysql_free_result($this->response);
        //��������� ���������� � ���� ������
        if($this->link)
            mysql_close($this->link);
    }
    //----------------------------
    //��������� ������ �������
    public function freeResponse() {
        //��������� ������ �� ������� � ���� ������
        if($this->response)
            mysql_free_result($this->response);
    }
    //----------------------------
    //��������� ������ ����������
    public function freeConnect() {
        //��������� ���������� � ���� ������
        if($this->link)
            mysql_close($this->link);
    }
    //====================== �������� ������ � ���� ������ =============//
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

    //====================  ����� ������ ��� ���� ������   ==================//
    private function errDataBase($typeError, array $arrParam) {
        $myMsg = "";
        //------------------
        switch ($typeError) {
            case "ERR_CONNECT":
                $myMsg = "WEB: ������ ���������� � ����� ������: \n%s";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_SELECT_DB":
                $myMsg = "WEB: ������ ������ ���� ������: \n%s";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_QUERY":
                $myMsg = "WEB: ������ ������� � ���� ������: \n%s";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_INSERT_DATA":
                $myMsg = "WEB: ������ ���������� ������� � ������� ������ - '%s'!\n������ �� ���������� ������� � ���� ������:\n%s\n.������ �������: \n%s";
                $myMsg = sprintf($myMsg, $arrParam[0],$arrParam[1],$arrParam[2]);
                break;
            case "ERR_DELETE_DATA":
                $myMsg = "WEB: ������ �������� ������� �� ������� ������ - '%s'!\n������ �� �������� ������� �� ���� ������:\n%s\n.������ �������: \n%s";
                $myMsg = sprintf($myMsg, $arrParam[0],$arrParam[1],$arrParam[2]);
                break;
            case "ERR_UPDATE_DATA":
                $myMsg = "WEB: ������ ���������� ������� � ������� ������ - '%s'!\n������ �� ���������� ������� � ���� ������:\n  %s\n.������ �������: \n%s";
                $myMsg = sprintf($myMsg, $arrParam[0],$arrParam[1],$arrParam[2]);
                break;
            case "ERR_PARAM":
                $myMsg = "WEB: ������ ������� ���������: ������� -  '%s'; ��������� �������� - '%s'!";
                $myMsg = sprintf($myMsg, $arrParam[0],$arrParam[1]);
                break;
        }
        throw new dbException($typeError, $myMsg);
    }

}

?>
