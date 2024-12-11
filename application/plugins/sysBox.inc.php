<?php

//================ КЛАСС РАБОТЫ С СИСТЕМОЙ =========================//
/**
 * Выполнение системных задач
 * Modul SysBox.php Copyright @ 2008 BSA
 * @uses
 * @package BX-AZOT
 */
class sysBox {

    //DEBUG or PUBLIC
    static $debug = true;

    //========================= ERRORS ================================//
    //Выход из скрипта по ERROR!!!!
    static function errExit($aErrMsg) {
        //--------------------------
        //Заменим все переводы строки на симол решетка #
        //это нужно для правильной обработки текста ошибки на стороне клиента
        //$ErrMsg = iconv("Windows-1251", "UTF-8", $aErrMsg);
        $ErrMsg = str_replace("\n", "#", $aErrMsg);
        //Выводится признак ошибочной операции и сообщение об ошибке
        echo "result:=0" . "<br>\n" . "result_msg:=" . $ErrMsg . "<br>\n";
        //Выход из скрипта
        exit();
    }

    //=============== ВЫВОД ИНФ ============//

    /*     * Распечатать инф. о ресурсе
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
     * Распечатать текст
     *
     * @param  string $aText
     * @return void
     */

    static function printTXT($aText) {
        $LFCR = PHP_EOL;
        //------------------
        //Определим будем ли выводить сообщения в командрую строку
        //если да, то преобразуем все сообщения в досовсткую русскую кодировку
        $isOutCmd = myConfig::$arrSystem["cmd"];
        if ($isOutCmd) {
            $aText = strBox::getStrEncodingTo_CP866($aText, "windows-1251");
        }
        echo "$aText" . $LFCR;
    }

    /*     * -------------------------------
     * Установить отладочную информацию
     *
     * @param  string $aArrayName   //Название массива в $_SESSION["debugs"],$_SESSION["params"],$_SESSION["results"]
     * @param  array $aValues       //Асоциативный массив ключ=значение
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
     * Получить отладочную информацию
     *
     * @param  string $aArrayName   //Название массива в $_SESSION["debugs"],$_SESSION["params"],$_SESSION["results"]
     *
     * @return array                //Массив с отладочной информацией
     */
    static function getDebugInfo($aArrayName) {

        //------------------
        return $_SESSION[$aArrayName];
    }

    /**
     * Удалить лог файл
     *
     * @param  string $aNameLog   //Название лог файла
     *
     * @return void
     */
    static function deleteLogFile($aNameLog) {

        //Удалим лог файл
        $logFile = strBox::getNameLogFileXML($aNameLog);
        $type = isset(myConfig::$arrArguments["test"]) ? "logs_test" : "logs";
        $dir = htmBox::getProjectPath($type);
        $logFile = $dir . $logFile;
        if (is_file($logFile)) {
            unlink($logFile);
        }
    }

    /**
     * Ограничить кол. файлов
     *
     * @return int //Количество удаленных файлов
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

    //================= ПОЛУЧИТЬ НАЗВАНИЯ СКРИПТА И ФАЙЛА ===================//
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

    //=================== ПОЛУЧИТЬ ДАННЫЕ О ПЕРЕМЕННЫХ РНР ===================//
    //Получить ключи и значения массива $_GET
    static function ShowKeyValue_GET() {
        echo "GET:" . "<br>\n";
        foreach ($_GET as $key => $values) {
            echo $key . "=" . $values . "<br>\n";
        }
    }

    //Получить ключи и значения массива $_POST
    static function ShowKeyValue_POST() {
        echo "POST:" . "<br>\n";
        foreach ($_POST as $key => $values) {
            echo $key . "=" . $values . "<br>\n";
        }
    }

    //Получить ключи и значения массива $_REQUEST
    static function ShowKeyValue_REQUEST() {
        echo "REQUEST:" . "<br>\n";
        foreach ($_REQUEST as $key => $values) {
            echo $key . "=" . $values . "<br>\n";
        }
    }

    //Получить ключи и значения массива $_FILES
    static function ShowKeyValue_FILES() {
        echo "FILES:" . "<br>\n";
        foreach ($_FILES as $key => $values) {
            echo $key . "=" . $values . "<br>\n";
        }
    }

    //Получить ключи и значения массива $_SERVER
    static function ShowKeyValue_SERVER() {
        echo "SERVER:" . "<br>\n";
        foreach ($_SERVER as $key => $values) {
            echo $key . "=" . $values . "<br>\n";
        }
    }

    //----------------- Получить данные POST --------------//
    //Получить ключи и значения в массив из $_POST массива
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

    //Получить XML из POST данных
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

    //=============== РАБОТА С ПАМЯТЬЮ ==========//

    /**
     * Public static method,
     * Вычисление максимально используемой памяти скриптом
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
     * Вычисление используемой памяти скриптом
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

    //=============== РАБОТА С СИСТЕМОЙ ==========//

    /**
     * Создать класс контроллера и выполнить метод контроллера
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

    //=============== РАБОТА С МАССИВАМИ ==========//

    /*     * Получить массив массивов значений в виде (ключ=значение)
     * из массива обьектов
     *
     * @param  array $aArrObjects   //Массив обьектов
     *
     * @return array                //Массив массивов значений
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
     * Отсортировать массив массивов 
     * в соответствии с заданным массивом по ключу
     *
     * @param  array $aArrArr   //Массив массивов
     * @param  array $aSortArr   //Заданный массив для сортировки
     * @param  string $aSortKey  //Заданный ключ сортировки
     * 
     * @return array             //Отсортированный массив массивов
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