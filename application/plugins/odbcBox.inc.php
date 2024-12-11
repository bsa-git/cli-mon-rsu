
<?php
/************ КЛАСС ОБРАБОТКИ ОШИБОК ODBC **********
 * Ошибки ODBC
 * Modul odbcBox.php Copyright @ 2010 Бескоровайный Сергей
 * @uses    Exception
 * @package cli-azot-m5
 */
class odbcException extends Exception {
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

/************ КЛАСС РАБОТА С РЕЗУЛЬТАТОМ ODBC **************
 * Класс работы с результатом полученным из Базы Данных AIM*History  через ODBC
 * Modul odbcBox.php Copyright @ 2010 Бескоровайный Сергей
 * @uses
 * @package cli-azot-m5
 */
class odbcResult {
    var $result; //результат (первоначальный дескриптор)
    //----------------------------------------------------

    /**
     * Конструктор
     *
     * @param  object $aRes         //Ресурс доступа к данным
     * @return void
     */
    function odbcResult($aRes=NULL) {
        $this->result = $aRes;
    }

    /**------------------------------------
     * Получить запись из ресурса данных (в виде асоциативного массива)
     * полученных с помощью запроса к базе данных
     *
     *
     * @return array
     */
    public function Fetch() {
        //----------------------
        //Получим массив данных
        return  odbc_fetch_array($this->result);
    }
}

/************ КЛАСС ДОСТУПА К БАЗЕ ДАННЫХ ЧЕРЕЗ ODBC **************
 * Класс работы с Базой Данных AIM*History  через ODBC
 * Modul odbcBox.php Copyright @ 2010 Бескоровайный Сергей
 * @uses    
 * @package cli-azot-m5
 */
class odbcBox {

    private $link = 0;
    private $res = 0;

    /**------------------------------------
     * Соединение с ODBC драйвером
     *
     * @param  string $aDSN         //Название ресурса доступа к данным
     * @param  string $aServer      //Сервер: 52AW00, 52AW01
     * @param  string $aTypeDB      //Тип базы данных: Sample, Reduction, Message, MDE, or Event
     * @param  string $aUserName    //Имя пользователя
     * @param  string $aPasswd      //Пароль
     *
     * @return resource connect
     */
    public function Connect($aDSN,$aServer,$aDBType,$aDBLogin,$aDBPassword) {
        $strConnect = "DSN=$aDSN;AP=$aServer;DB=$aDBType";
        $debug = myConfig::$arrSystem["debug"];
        //--------------------
        if($debug){
            //sysBox::printTXT("Соединимся с базой данных по ODBC (строка соединения - $strConnect)");
        }
        //Соединимся к базе данных через ODBC
        $this->link = odbc_connect($strConnect,$aDBLogin,$aDBPassword);

        if(!$this->link) {
            $this->errODBC('ERR_CONNECT', array($strConnect,$aDBLogin,$aDBPassword,odbc_errormsg()));
        }
        return $this->link;
    }

    /**------------------------------------
     * Выполнить запрос к базе данных через ODBC драйвер
     *
     * @param  string $aQuerySQL    //Запрос к базе данных
     * 
     * @return array
     */
    public function Query($aQuerySQL) {
        $debug = myConfig::$arrSystem["debug"];
        //--------------------
        if($debug){
            //sysBox::printTXT("Запрос к базе данных: \r\n $aQuerySQL");
        }
        $this->res=odbc_exec($this->link,$aQuerySQL);
        if(!$this->res) {
            $this->errODBC('ERR_EXEC', array(odbc_errormsg()));
        };
        $result = new odbcResult($this->res);
        return $result;
    }



    /**---------------------------------------------------
     * Освободим ресурсы все ресурсы: запроса и соединения
     *
     * @return void
     */
    public function freeResource() {
        //Освободим данные от запроса к базе данных
        if($this->res)
            odbc_free_result($this->res);
        //Освободим соединение к базе данных
        if($this->link)
            odbc_close($this->link);
    }

    /**---------------------------------------------------
     * Освободим ресурс запроса
     *
     * @return void
     */
    public function freeResult() {
        //Освободим данные от запроса к базе данных
        if($this->res)
            odbc_free_result($this->res);
    }

    /**---------------------------------------------------
     * Освободим ресурс соединения
     *
     * @return void
     */
    public function freeConnect() {
        //Освободим соединение к базе данных
        if($this->link)
            odbc_close($this->link);
    }


    /**------------------------------------
     * Вызвать исключение при работе с базой данных через ODBC драйвер
     *
     * @param  string $typeError    //Тип ошибки
     * @param  array $arrParam      //Массив параметров
     *
     * @return void
     */
    private function errODBC($typeError, array $arrParam) {
        $myMsg = "";
        //------------------
        switch ($typeError) {
            case "ERR_CONNECT":
                $myMsg = "ODBC: Ошибка соединения с базой данных: \n
                            dsn = %s;\n
                            user_name = %s\n;
                            passwd = %s;\n
                            err_msg = %s;\n";
                $myMsg = sprintf($myMsg, $arrParam[0],$arrParam[1],$arrParam[2],$arrParam[3]);
                break;
            case "ERR_EXEC":
                $myMsg = "ODBC: Ошибка оиполнения запроса к базе данных:\n%s";
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
        throw new odbcException($typeError, $myMsg);
    }

}

?>
