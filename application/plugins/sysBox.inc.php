<?php

//================ ����� ������ � �������� =========================//
/**
 * ���������� ��������� �����
 * Modul SysBox.php Copyright @ 2008 BSA
 * @uses
 * @package BX-AZOT
 */
class sysBox {

    //DEBUG or PUBLIC
    static $debug = true;

    //========================= ERRORS ================================//
    //����� �� ������� �� ERROR!!!!
    static function errExit($aErrMsg) {
        //--------------------------
        //������� ��� �������� ������ �� ����� ������� #
        //��� ����� ��� ���������� ��������� ������ ������ �� ������� �������
        //$ErrMsg = iconv("Windows-1251", "UTF-8", $aErrMsg);
        $ErrMsg = str_replace("\n", "#", $aErrMsg);
        //��������� ������� ��������� �������� � ��������� �� ������
        echo "result:=0" . "<br>\n" . "result_msg:=" . $ErrMsg . "<br>\n";
        //����� �� �������
        exit();
    }

    //=============== ����� ��� ============//

    /*     * ����������� ���. � �������
     *
     * @param  resource $source
     * @return void
     */
    static function printR($source) {
//        echo '<pre>';
        print_r($source);
//        echo '</pre>'.'<br>';
    }

    /*     * -----------------------------
     * ����������� �����
     *
     * @param  string $aText
     * @return void
     */

    static function printTXT($aText) {
        $LFCR = PHP_EOL;
        //------------------
        //��������� ����� �� �������� ��������� � ��������� ������
        //���� ��, �� ����������� ��� ��������� � ���������� ������� ���������
        $isOutCmd = myConfig::$arrSystem["cmd"];
        if ($isOutCmd) {
            $aText = strBox::getStrEncodingTo_CP866($aText, "windows-1251");
        }
        echo "$aText" . $LFCR;
    }

    /*     * -------------------------------
     * ���������� ���������� ����������
     *
     * @param  string $aArrayName   //�������� ������� � $_SESSION["debugs"],$_SESSION["params"],$_SESSION["results"]
     * @param  array $aValues       //������������ ������ ����=��������
     *
     * @return void
     */

    static function setDebugInfo($aArrayName, array $aValues) {
        $format = "H:i:s";
        $debug = myConfig::$arrSystem["debug"];
        //------------------
        switch ($aArrayName) {
            case "results":
                foreach ($aValues as $key => $value) {
                    $_SESSION[$aArrayName][$key] = $value;
                }
                break;
            case "debugs":
                if (!$debug) {
                    break;
                }
                $arrValues = array();
                $time = date($format);
                $arrValues["time"] = $time;
                foreach ($aValues as $key => $value) {
                    $arrValues[$key] = $value;
                }
                $_SESSION["debugs"][] = $arrValues;
                break;
            case "warnings":
                if (!$debug) {
                    break;
                }
                $arrValues = array();
                $time = date($format);
                $arrValues["time"] = $time;
                foreach ($aValues as $key => $value) {
                    $arrValues[$key] = $value;
                }
                $_SESSION["warnings"][] = $arrValues;
                break;
            case "rowdata":
                if (!$debug) {
                    break;
                }
                $_SESSION["rowdata"][] = $aValues;
                break;
            case "rowhist":
                if (!$debug) {
                    break;
                }
                $_SESSION["rowhist"][] = $aValues;
                break;
            default:
                if (!$debug) {
                    break;
                }
                foreach ($aValues as $key => $value) {
                    $_SESSION[$aArrayName][$key] = $value;
                }
                break;
        }
    }

    /**
     * �������� ���������� ����������
     *
     * @param  string $aArrayName   //�������� ������� � $_SESSION["debugs"],$_SESSION["params"],$_SESSION["results"]
     *
     * @return array                //������ � ���������� �����������
     */
    static function getDebugInfo($aArrayName) {

        //------------------
        return $_SESSION[$aArrayName];
    }

    /**
     * ������� ��� ����
     *
     * @param  string $aNameLog   //�������� ��� �����
     *
     * @return void
     */
    static function deleteLogFile($aNameLog) {

        //������ ��� ����
        $logFile = strBox::getNameLogFileXML($aNameLog);
        $type = isset(myConfig::$arrArguments["test"]) ? "logs_test" : "logs";
        $dir = htmBox::getProjectPath($type);
        $logFile = $dir . $logFile;
        if (is_file($logFile)) {
            unlink($logFile);
        }
    }

    /**
     * ���������� ���. ������
     *
     * @return int //���������� ��������� ������
     */
    static function restrictLogFiles() {
        $maxFiles = (int) myConfig::$arrSystem['maxLogFiles'];
        $count = 0;
        $delCount = 0;
        //--------------------------

        if (isset(myConfig::$arrArguments["test"])) {
            $dir = htmBox::getProjectPath('logs_test') . 'Errors/';
        } else {
            $dir = htmBox::getProjectPath('logs') . 'Errors/';
        }

        $arrNameFiles = strBox::getNameFilesSortDesc($dir);
        if (count($arrNameFiles) > $maxFiles) {
            foreach ($arrNameFiles as $fileName) {
                $fileName = strtolower($fileName);
                $count++;
                if ($count <= $maxFiles) {
                    continue;
                }
                if (unlink($dir . $fileName)) {
                    $delCount++;
                }
            }
        }
        return $delCount;
    }

    //================= �������� �������� ������� � ����� ===================//
    //Get name my script
    static function getNameScript() {
        $arr = array();
        $str = $_SERVER['PHP_SELF'];
        $arr = explode("/", $str);
        return $arr[count($arr) - 1];
    }

    //Get name file
    static function getNameFile($patch) {
        $arr = array();
        $arr = explode("/", $patch);
        return $arr[count($arr) - 1];
    }

    //=================== �������� ������ � ���������� ��� ===================//
    //�������� ����� � �������� ������� $_GET
    static function ShowKeyValue_GET() {
        echo "GET:" . "<br>\n";
        foreach ($_GET as $key => $values) {
            echo $key . "=" . $values . "<br>\n";
        }
    }

    //�������� ����� � �������� ������� $_POST
    static function ShowKeyValue_POST() {
        echo "POST:" . "<br>\n";
        foreach ($_POST as $key => $values) {
            echo $key . "=" . $values . "<br>\n";
        }
    }

    //�������� ����� � �������� ������� $_REQUEST
    static function ShowKeyValue_REQUEST() {
        echo "REQUEST:" . "<br>\n";
        foreach ($_REQUEST as $key => $values) {
            echo $key . "=" . $values . "<br>\n";
        }
    }

    //�������� ����� � �������� ������� $_FILES
    static function ShowKeyValue_FILES() {
        echo "FILES:" . "<br>\n";
        foreach ($_FILES as $key => $values) {
            echo $key . "=" . $values . "<br>\n";
        }
    }

    //�������� ����� � �������� ������� $_SERVER
    static function ShowKeyValue_SERVER() {
        echo "SERVER:" . "<br>\n";
        foreach ($_SERVER as $key => $values) {
            echo $key . "=" . $values . "<br>\n";
        }
    }

    //----------------- �������� ������ POST --------------//
    //�������� ����� � �������� � ������ �� $_POST �������
    static function getArr_PostData() {
        $arr = array();
        //$key_arr = "";
        //$value_arr = "";
        $count = 0;
        //---------------------------------
        foreach ($_POST as $key => $values) {
            //$key_arr = "post_data";
            //$value_arr = $values;
            $arr[$count] = $values;
            $count++;
        }
        //echo "Count post_data: ".$count."<br>\n";
        return $arr;
    }

    //�������� XML �� POST ������
    static function getXML_PostData($patch) {
        $arrRequest = Default_Plugin_SysBox::getArr_PostData();
        //$arrRequest = getArr_PostData();
        if (isset($arrRequest[0])) {
            $postData = $arrRequest[0];
            $postData = Default_Plugin_StrBox::getXML_FromUploadData_1C($postData);
            //$xmlPostData = simplexml_load_string($postData);
            return simplexml_load_string($postData);
        }
        else
            Default_Plugin_StrBox::errUser('ERR_GET_PARAM', array($patch));
        //return $xmlPostData;
    }

    //=============== ������ � ������� ==========//

    /**
     * Public static method,
     * ���������� ����������� ������������ ������ ��������
     * @static
     * @param String $string you should choose the format you want, 'mb'/'kb'/'bytes' default if bytes!
     * @param bool $isFormat 
     * @param integer $round set how much numbers you want after Zero, default is 3
     * @return double amount of memory your script consume
     */
    public static function showPeakMemoryUsage($string = 'bytes', $isFormat = true, $round = 3) {
        $result = null;
        switch ($string) {
            case 'mb': $result = round(memory_get_peak_usage() / 1048576, $round);
                if ($isFormat) {
                    $result = number_format($result, $round, '.', ' ');
                }
                break;
            case 'kb': $result = round(memory_get_peak_usage() / 1024, $round);
                if ($isFormat) {
                    $result = number_format($result, $round, '.', ' ');
                }
                break;
            default: $result = memory_get_peak_usage();
                break;
        }
        return $result;
    }

    /**
     * Public static method,
     * ���������� ������������ ������ ��������
     * @static
     * @param String $string you should choose the format you want, 'mb'/'kb'/'bytes' default if bytes!
     * @param bool $isFormat 
     * @param integer $round set how much numbers you want after Zero, default is 3
     * @return double amount of memory your script consume
     */
    public static function showMemoryUsage($string = 'bytes', $isFormat = true, $round = 3) {
        $result = null;
        switch ($string) {
            case 'mb': $result = round(memory_get_usage() / 1048576, $round);
                if ($isFormat) {
                    $result = number_format($result, $round, '.', ' ');
                }
                break;
            case 'kb': $result = round(memory_get_usage() / 1024, $round);
                if ($isFormat) {
                    $result = number_format($result, $round, '.', ' ');
                }
                break;
            default: $result = memory_get_usage();
                break;
        }
        return $result;
    }

    //=============== ������ � �������� ==========//

    /**
     * ������� ����� ����������� � ��������� ����� �����������
     *
     * @param  string $class
     * @param  string $metod
     * @return void
     */
    static function runControllMetod($class, $metod) {
        $my_class = ucfirst($class) . "Controller";
        $my_object = new $my_class();
        $my_metod = $metod . "Action";
        $methods = get_class_methods($my_object);
        if (in_array($my_metod, $methods)) {
            $my_object->$my_metod();
        } else {
            strBox::errUser("ERR_NOT_THIS_METOD", array($my_class, $my_metod));
        }
    }

    //=============== ������ � ��������� ==========//

    /*     * �������� ������ �������� �������� � ���� (����=��������)
     * �� ������� ��������
     *
     * @param  array $aArrObjects   //������ ��������
     *
     * @return array                //������ �������� ��������
     */
    static function ArrObjects2ArrKeysValues($aArrObjects) {
        $arrParams = array();
        //--------------------------
        foreach ($aArrObjects as $oObject) {
            $arrParams[] = $oObject->values;
        }
        return $arrParams;
    }

    /** 
     * ������������� ������ �������� 
     * � ������������ � �������� �������� �� �����
     *
     * @param  array $aArrArr   //������ ��������
     * @param  array $aSortArr   //�������� ������ ��� ����������
     * @param  string $aSortKey  //�������� ���� ����������
     * 
     * @return array             //��������������� ������ ��������
     */

    static function SortArrArr($aArrArr, $aSortArr, $aSortKey) {
        $arrSort = array();
        //--------------------------
        foreach ($aSortArr as $value) {
            foreach ($aArrArr as $arr) {
                $value_ = $arr[$aSortKey];
                if($value_ == $value){
                    $arrSort[] = $arr;
                    break;
                }
            }
        }
        return $arrSort;
    }
    
    /**
     * isSaveToDB
     * @return boolean
     */
    static function isSaveToDB() {
        $configIsSaveToDB = myConfig::$arrArguments["isSaveToDB"];
        $isArgSaveToDB = $configIsSaveToDB !== NULL;
        $isSaveToDB = $isArgSaveToDB? !!$configIsSaveToDB : myConfig::$arrSystem['isSaveToDB'];
        return $isSaveToDB;
    }

}

?>