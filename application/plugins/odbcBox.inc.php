
<?php
/************ ����� ��������� ������ ODBC **********
 * ������ ODBC
 * Modul odbcBox.php Copyright @ 2010 ������������� ������
 * @uses    Exception
 * @package cli-azot-m5
 */
class odbcException extends Exception {
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

/************ ����� ������ � ����������� ODBC **************
 * ����� ������ � ����������� ���������� �� ���� ������ AIM*History  ����� ODBC
 * Modul odbcBox.php Copyright @ 2010 ������������� ������
 * @uses
 * @package cli-azot-m5
 */
class odbcResult {
    var $result; //��������� (�������������� ����������)
    //----------------------------------------------------

    /**
     * �����������
     *
     * @param  object $aRes         //������ ������� � ������
     * @return void
     */
    function odbcResult($aRes=NULL) {
        $this->result = $aRes;
    }

    /**------------------------------------
     * �������� ������ �� ������� ������ (� ���� ������������� �������)
     * ���������� � ������� ������� � ���� ������
     *
     *
     * @return array
     */
    public function Fetch() {
        //----------------------
        //������� ������ ������
        return  odbc_fetch_array($this->result);
    }
}

/************ ����� ������� � ���� ������ ����� ODBC **************
 * ����� ������ � ����� ������ AIM*History  ����� ODBC
 * Modul odbcBox.php Copyright @ 2010 ������������� ������
 * @uses    
 * @package cli-azot-m5
 */
class odbcBox {

    private $link = 0;
    private $res = 0;

    /**------------------------------------
     * ���������� � ODBC ���������
     *
     * @param  string $aDSN         //�������� ������� ������� � ������
     * @param  string $aServer      //������: 52AW00, 52AW01
     * @param  string $aTypeDB      //��� ���� ������: Sample, Reduction, Message, MDE, or Event
     * @param  string $aUserName    //��� ������������
     * @param  string $aPasswd      //������
     *
     * @return resource connect
     */
    public function Connect($aDSN,$aServer,$aDBType,$aDBLogin,$aDBPassword) {
        $strConnect = "DSN=$aDSN;AP=$aServer;DB=$aDBType";
        $debug = myConfig::$arrSystem["debug"];
        //--------------------
        if($debug){
            //sysBox::printTXT("���������� � ����� ������ �� ODBC (������ ���������� - $strConnect)");
        }
        //���������� � ���� ������ ����� ODBC
        $this->link = odbc_connect($strConnect,$aDBLogin,$aDBPassword);

        if(!$this->link) {
            $this->errODBC('ERR_CONNECT', array($strConnect,$aDBLogin,$aDBPassword,odbc_errormsg()));
        }
        return $this->link;
    }

    /**------------------------------------
     * ��������� ������ � ���� ������ ����� ODBC �������
     *
     * @param  string $aQuerySQL    //������ � ���� ������
     * 
     * @return array
     */
    public function Query($aQuerySQL) {
        $debug = myConfig::$arrSystem["debug"];
        //--------------------
        if($debug){
            //sysBox::printTXT("������ � ���� ������: \r\n $aQuerySQL");
        }
        $this->res=odbc_exec($this->link,$aQuerySQL);
        if(!$this->res) {
            $this->errODBC('ERR_EXEC', array(odbc_errormsg()));
        };
        $result = new odbcResult($this->res);
        return $result;
    }



    /**---------------------------------------------------
     * ��������� ������� ��� �������: ������� � ����������
     *
     * @return void
     */
    public function freeResource() {
        //��������� ������ �� ������� � ���� ������
        if($this->res)
            odbc_free_result($this->res);
        //��������� ���������� � ���� ������
        if($this->link)
            odbc_close($this->link);
    }

    /**---------------------------------------------------
     * ��������� ������ �������
     *
     * @return void
     */
    public function freeResult() {
        //��������� ������ �� ������� � ���� ������
        if($this->res)
            odbc_free_result($this->res);
    }

    /**---------------------------------------------------
     * ��������� ������ ����������
     *
     * @return void
     */
    public function freeConnect() {
        //��������� ���������� � ���� ������
        if($this->link)
            odbc_close($this->link);
    }


    /**------------------------------------
     * ������� ���������� ��� ������ � ����� ������ ����� ODBC �������
     *
     * @param  string $typeError    //��� ������
     * @param  array $arrParam      //������ ����������
     *
     * @return void
     */
    private function errODBC($typeError, array $arrParam) {
        $myMsg = "";
        //------------------
        switch ($typeError) {
            case "ERR_CONNECT":
                $myMsg = "ODBC: ������ ���������� � ����� ������: \n
                            dsn = %s;\n
                            user_name = %s\n;
                            passwd = %s;\n
                            err_msg = %s;\n";
                $myMsg = sprintf($myMsg, $arrParam[0],$arrParam[1],$arrParam[2],$arrParam[3]);
                break;
            case "ERR_EXEC":
                $myMsg = "ODBC: ������ ���������� ������� � ���� ������:\n%s";
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
        throw new odbcException($typeError, $myMsg);
    }

}

?>
