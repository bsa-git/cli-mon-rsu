<?php

/* =============  КЛАСС ОБРАБОТКИ ОШИБОК ДЛЯ  ПОЛЬЗОВАТЕЛЯ ========//
 * Ошибка пользователя
 *
 * @uses    Exception
 * @package ZF-BUH1C
 */

class userException extends Exception {

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

//================ КЛАСС РАБОТЫ СО СТРОКАМИ =========================//
/**
 * Работа со строками
 *
 * @uses
 * @package ZF-BUH1C
 */
class strBox {

//=========================== HTML ========================================//
// Экранирование служебных символов, что бы не было SQL инекций в запросах к базе данных
//экранирование проходит не зависимо от кодировки
    static function quoteSmart($value) {
        // Else magic_quotes_gpc on - use stripslashes
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        // If variable - a number, that shields its not it is necessary
        // if no - that surround her( quote, and shield
        if (!is_numeric($value)) {
            //$value = "'".mysql_escape_string($value)."'";
            $value = mysql_escape_string($value);
        }
        return $value;
    }

    //-----------------------------------
    // Экранирование служебных символов, что бы не было SQL инекций в запросах к базе данных
    //экранирование проходит зависимо от кодировки
    static function quoteSmartReal($value) {
        // Else magic_quotes_gpc on - use stripslashes
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        // If variable - a number, that shields its not it is necessary
        // if no - that surround her( quote, and shield
        if (!is_numeric($value)) {
            //$value = "'" . mysql_real_escape_string($value) . "'";
            $value = mysql_real_escape_string($value);
        }
        return $value;
    }

    //================== РАБОТА С ФАЙЛАМИ ================//
    //Save HTML File
    static function saveHTMLFile($file) {
        $str_file = file_get_contents($file);
        $search = array("&lt;", "&gt;");
        $replace = array("<", ">");
        $str_file = str_replace($search, $replace, $str_file);
        file_put_contents($file, $str_file);
    }

    /**
     * Получить массив имен файлов отсортированному по убыванию
     *
     * 
     * @param  string $dir //директория, где находится файл
     * @param  string $prefix //префикс (начало файла - "my_")
     *
     * @return array
     *
     * пр. my_20100201.xml;my_20100202.xml;my_20100203.xml -> выберется файл my_20100203.xml
     * или my1.xml;my3.xml;my5.xml -> выберется файл my_5.xml
     */
    static function getNameFilesSortDesc($dir, $prefix = "") {
        $isFile = false;
        $isPrefix = true;
        $arrNameFiles = array();
        $name = "";
        //----------------------
        $dirdata = scandir($dir, 1);
        foreach ($dirdata as $key => $element) {
            $isFile = is_file($dir . $element);
            if ($prefix !== "") {
                $isPrefix = substr_count($element, $prefix);
            }
            if ($isFile AND $isPrefix) {
                $arrNameFiles[] = $element;
            }
        }
        return $arrNameFiles;
    }

    //=========== УПРАВЛЕНИЕ СКРИПТАМИ ==================//

    /**
     * Проверимть условие остановки скрипта,
     * работающего в цикле
     *
     * 
     *
     * @return bool
     */
    static function isStopCycle() {
        $aType = isset(myConfig::$arrArguments["test"]) ? "scripts_test" : "scripts";
        $dir = htmBox::getProjectPath($aType);
        $name_file_stop = $dir . myConfig::$arrSystem["name_file_stop"];
        return is_file($name_file_stop);
    }

    /**
     * Проверимть условие запуска скрипта,
     * работающего в цикле
     *
     * 
     *
     * @return bool
     */
    static function isStartCycle() {
        $aType = isset(myConfig::$arrArguments["test"]) ? "scripts_test" : "scripts";
        $dir = htmBox::getProjectPath($aType);
        $name_file_start = $dir . myConfig::$arrSystem["name_file_start"];
        return is_file($name_file_start);
    }

    /**
     * Создаем файл для управления циклом
     * управление - старт или стоп
     * соответственно создаются файлы - start.txt or stop.txt
     *
     * 
     * @param string $type // Тип управления: stop, start
     * @return bool
     */
    static function createCycleControl($type) {
        $result = FALSE;
        //-------------
        $aType = isset(myConfig::$arrArguments["test"]) ? "scripts_test" : "scripts";
        $dir = htmBox::getProjectPath($aType);
        $name_file = "name_file_{$type}";
        $name_file = $dir . myConfig::$arrSystem[$name_file];
        if (!is_file($name_file)) {
            file_put_contents($name_file, "");
            $result = TRUE;
        }
        return $result;
    }

    /**
     * Удалим файл для управления циклом
     * управление - старт или стоп
     * соответственно удаляются файлы - start.txt or stop.txt
     *
     * 
     * @param string $type // Тип управления: stop, start
     * @return bool
     */
    static function deleteCycleControl($type) {
        $result = FALSE;
        //-------------
        $aType = isset(myConfig::$arrArguments["test"]) ? "scripts_test" : "scripts";
        $dir = htmBox::getProjectPath($aType);
        $name_file = "name_file_{$type}";
        $name_file = $dir . myConfig::$arrSystem[$name_file];
        if (is_file($name_file)) {
            unlink($name_file);
            $result = TRUE;
        }
        return $result;
    }

    //=========== ВЫВЕСТИ ОТВЕТ НА ЗАПРОС ИЗ МАССИВА ==================//
    static function outResponseFromArray($prefix, array $arrData) {
        foreach ($arrData as $key => $value) {
            echo $prefix . "$key:=" . $value . "<br>\n";
        }
    }

    //============ РАБОТА С ХМЛ ================//

    /**
     * Преобразовать текст из файла в кодировку UTF-8
     *
     * @param  string $aFilename    //Путь к текстовому файлу в неизвестной кодировке (windows-1251 или UTF-8)
     * @return string               //Текст преобразованный в кодировку UTF-8
     *
     */
    static function getXmlFileEncodingUTF8($aFilename) {

        //----------------------
        $content = file_get_contents($aFilename);
        $isWinCoding = substr_count($content, "encoding=\"windows-1251\"");
        if ($isWinCoding) {
            $content = str_replace("encoding=\"windows-1251\"", "encoding=\"utf-8\"", $content);
            return iconv("Windows-1251", "UTF-8", $content);
        } else {
            return $content;
        }
    }

    /**
     * Преобразовать строку в досовскую русскую кодировку
     *
     * @param  string $aSource      //Входная строка
     * @param  string $aEncoding    //Кодировка (windows-1251 или UTF-8)
     *
     * @return string               //Преобразованная строка
     *
     */
    static function getStrEncodingTo_CP866($aSource, $aEncoding) {

        //----------------------
        //Заменим украинские буквы на английские или русские
        //Это необходимо, чтобы досовская русская кодировка (cp866)
        //отображалась правильно
        $aSource = str_replace("і", "i", $aSource);
        $aSource = str_replace("І", "I", $aSource);
        $aSource = str_replace("ї", "i", $aSource);
        $aSource = str_replace("Ї", "I", $aSource);
        $aSource = str_replace("є", "э", $aSource);
        $aSource = str_replace("Є", "Э", $aSource);
        $aSource = iconv($aEncoding, "cp866", $aSource);

        return $aSource;
    }

    /**
     * Добавим перевод строки к концу закрывающихся тегов
     *
     * @param  string $aXML    //XML строка
     * @return string          //XML строка с переводами строки
     *
     */
    static function LFCR_Add_XmlFile($aXML) {
        //----------------------
        $aXML = str_replace("\n", "", $aXML);
        $aXML = str_replace("\r", "", $aXML);
        $aXML = str_replace(">", ">\n", $aXML);
        return $aXML;
    }

    /**
     * Преобразовать XML строку в соответствующую кодировку
     *
     * @param  string $aXML         //XML строка
     * @param  string $aEncoding    //Кодировка (windows-1251 или UTF-8)
     *
     * @return string               //XML строка в заданной кодировке
     *
     */
    static function getXmlStrEncoding($aXML, $aEncoding) {

        //----------------------
        //Определим фактическую кодировку XML
        $isWinCoding = substr_count($aXML, "encoding=\"windows-1251\"");

        //Получим xml в соответстующей кодировке
        $aEncoding = strtolower($aEncoding);
        if ($aEncoding == 'windows-1251') {
            if (!$isWinCoding) {
                $aXML = str_replace("encoding=\"utf-8\"", "encoding=\"windows-1251\"", $aXML);
                $aXML = iconv("utf-8", "windows-1251", $aXML);
            }
//            $context = strBox::getXmlFileEncodingUTF8($aSourcePath);
        } elseif ($aEncoding == 'utf-8') {
            if ($isWinCoding) {
                $aXML = str_replace("encoding=\"windows-1251\"", "encoding=\"utf-8\"", $aXML);
                $aXML = iconv("windows-1251", "utf-8", $aXML);
            }
        }
        return $aXML;
    }

    /**
     * Преобразовать значение для базы данных
     *
     * @param  string $aFieldType   //Тип значения
     * @param  string $aValue       //Значение
     *
     * @return string               //Значение преобразованное
     *
     */
    static function prepValueForDataBase($aFieldType, $aValue) {
        $fieldType = $aFieldType;
        $value = $aValue;
        //----------------------
        //Преобразуем значения для некоторых типов данных
        switch ($fieldType) {
            case "integer":
                //Уберем пробелы
                $value = str_replace(" ", "", $value);
                break;
            case "decimal":
                //Уберем пробелы
                $value = str_replace(" ", "", $value);
                //Разделитель десятичных должна быть точка (.)
                $value = str_replace(",", ".", $value);
                break;
            case "float":
                //Уберем пробелы
                $value = str_replace(" ", "", $value);
                //Разделитель десятичных должна быть точка (.)
                $value = str_replace(",", ".", $value);
                break;
            case "string":
                //Уберем пробелы спереди и сзади строки
                $value = trim($value);
                break;
            case "datetime":
                //Уберем пробелы спереди и сзади строки
                $value = str_replace(" ", "T", $value);
                break;
        }
        return $value;
    }

    /**
     * Подготовить записи для добавления в базу данных из ХМЛ выгрузки
     *
     * @param  XML $aXML
     * @return array
     * $arrResult[0] = кол.вставленных записей
     * $arrResult[1] = массив в котором находяться массивы всех записей из ХМЛ
     */
    static function prepDataFromUploadXML($aXML) {
        $arrResult = array();
        $arrValues = array();
        $arrParam = array();
        $arrParams = array();
        $fieldName = "";
        $fieldType = "";
        $fieldValue = "";
        //-------------------
        //Получим массив полей
        $metaData = $aXML->METADATA;
        $Fields = $metaData->FIELDS;
        $rowData = $aXML->ROWDATA;
        //Получим данные
        $row_n = 1;
        foreach ($rowData->ROW as $row_data) {
            foreach ($Fields->FIELD as $field) {
                //Получим имя поля
                $fieldName = (string) $field['FieldName'];
                $fieldType = (string) $field['FieldType'];
                $fieldType = strtolower($fieldType);
                //Получим значение поля
                $fieldValue = (string) $row_data[$fieldName];
                $fieldValue = iconv("UTF-8", "Windows-1251", $fieldValue);
                //Преобразуем значения для некоторых типов данных
                switch ($fieldType) {
                    case "integer":
                        //Уберем пробелы
                        $fieldValue = str_replace(" ", "", $fieldValue);
                        break;
                    case "decimal":
                        //Уберем пробелы
                        $fieldValue = str_replace(" ", "", $fieldValue);
                        break;
                    case "float":
                        //Уберем пробелы
                        $fieldValue = str_replace(" ", "", $fieldValue);
                        break;
                    case "string":
                        //Заменим одинарный апостроф на двойной
                        $fieldValue = str_replace("'", "''", $fieldValue);
                        break;
                }
                //Добавим в массив параметров значение поля
                if (strtolower($fieldValue) == "null")
                    $arrParam[$fieldName] = null;
                else
                    $arrParam[$fieldName] = $fieldValue;
            }
            //Добавим данных в массив параметров
            $arrParams[] = $arrParam;
            $row_n++;
        }
        //Получим кол. добавленных записей
        $arrResult[] = $row_n - 1;
        //Получим массив всех параметров
        $arrResult[] = $arrParams;
        return $arrResult;
    }

    /**
     * Подготовить ХМЛ файл для обмена данными
     *
     * @param  string $aTemplatePath    //Путь к шаблону XML файла
     * @param  array $aRowsData         //Массив с данными для базы данных
     * @param  array $aRowsHist         //Массив с данными из истории
     * @param  string $aEncoding        //Вид кодировки в XML файле: (windows-1251) или (utf-8)
     *
     * @return string                   //ХМЛ файл в виде строки
     */
    static function prepDataToLogXML($aTemplatePath, array $aRowsData, array $aRowsHist, $aEncoding) {

        $context = "";
        $isWinEncoding = false;

        //-------------------
        //Получим xml обьект из текстового файла в кодировке UTF-8
        $aEncoding = strtolower($aEncoding);
        $isWinEncoding = ($aEncoding == 'windows-1251');
        if ($isWinEncoding) {
            $context = strBox::getXmlFileEncodingUTF8($aTemplatePath);
        } else {
            $content = file_get_contents($aTemplatePath);
        }
        $oXML = simplexml_load_string($context);

        //Получим узлы из ХМЛ файла
        $metaData = $oXML->METADATA;
        $Fields = $metaData->FIELDS;
        $rowData = $oXML->ROWDATA;
        $rowHist = $oXML->ROWHIST;
        $debugData = $oXML->DEBUGS;
        $paramData = $oXML->PARAMS;
        $resultData = $oXML->RESULTS;
        $warningMessages = $oXML->WARNINGS;

        //Установим параметры
        $arrParams = sysBox::getDebugInfo("params");
        foreach ($arrParams as $key => $value) {
            $value = iconv("windows-1251", "utf-8", $value);
            $paramData->addAttribute($key, $value);
        }

        //Установим результаты запроса
        $arrResults = sysBox::getDebugInfo("results");
        foreach ($arrResults as $key => $value) {
            $key = strtoupper($key);
            //$result = $resultData->addChild($key);
            $value = iconv("windows-1251", "utf-8", $value);
            $resultData->addChild($key, $value);
        }

        //Установим информацию о предупреждениях
        $arrWarnings = sysBox::getDebugInfo("warnings");
        $count = count($arrWarnings);
        for ($i = 0; $i < $count; $i++) {
            $arrWarning = $arrWarnings[$i];
            $rowWarning = $warningMessages->addChild('WARNING');
            foreach ($arrWarning as $key => $value) {
                $value = iconv("windows-1251", "utf-8", $value);
                $rowWarning->addAttribute($key, $value);
            }
        }

        //Установим отладочную информацию
        $arrDebugs = sysBox::getDebugInfo("debugs");
        $count = count($arrDebugs);
        for ($i = 0; $i < $count; $i++) {
            $arrDebug = $arrDebugs[$i];
            $rowDebug = $debugData->addChild('DEBUG');
            foreach ($arrDebug as $key => $value) {
                $value = iconv("windows-1251", "utf-8", $value);
                $rowDebug->addAttribute($key, $value);
            }
        }

        //Вставим данные базы данных в ХМЛ файл из массива данных
        $count = count($aRowsData);
        for ($i = 0; $i < $count; $i++) {
            $arrValues = $aRowsData[$i];
            $row = $rowData->addChild('ROW');
            //Перебираем данные в массиве данных
            foreach ($arrValues as $key => $value) {
                //Переведем в кодировку "utf-8"
                //для правильной работы с обьектом $oXML (т.к. он воспринимает только работу в UTF-8)
                if ($isWinEncoding) {
                    $value = iconv("windows-1251", "utf-8", $value);
                }
                //Если эти данные есть в шаблоне, то добавим их в результирующий
                //ХМЛ файл
                foreach ($Fields->FIELD as $field) {
                    $fieldClass = (string) $field['FieldClass'];
                    if ($fieldClass == "THist") {
                        continue;
                    }
                    $FieldName = (string) $field['FieldName'];
                    $fieldType = (string) $field['FieldType'];
                    $fieldType = strtolower($fieldType);

                    if ($FieldName == $key) {
                        $value = self::prepValueForDataBase($fieldType, $value);
                        $row->addAttribute($key, $value);
                    }
                }
            }
        }

        //Вставим данные из истории в ХМЛ файл из массива данных
        $count = count($aRowsHist);
        for ($i = 0; $i < $count; $i++) {
            $arrValues = $aRowsHist[$i];
            $row = $rowHist->addChild('ROW');
            //Перебираем данные в массиве данных
            foreach ($arrValues as $key => $value) {
                //Переведем в кодировку "utf-8"
                //для правильной работы с обьектом $oXML (т.к. он воспринимает только работу в UTF-8)
                if ($isWinEncoding) {
                    $value = iconv("windows-1251", "utf-8", $value);
                }
                //Если эти данные есть в шаблоне, то добавим их в результирующий
                //ХМЛ файл
                foreach ($Fields->FIELD as $field) {
                    $fieldClass = (string) $field['FieldClass'];
                    if ($fieldClass == "TDataBase") {
                        continue;
                    }
                    $FieldName = (string) $field['FieldName'];
                    $fieldType = (string) $field['FieldType'];
                    $fieldType = strtolower($fieldType);

                    if ($FieldName == $key) {
                        $value = self::prepValueForDataBase($fieldType, $value);
                        $row->addAttribute($key, $value);
                    }
                }
            }
        }
        //Получим ХМЛ в виде строки
        $strXML = $oXML->asXML();
        //Добавим переводы строк
        $strXML = self::LFCR_Add_XmlFile($strXML);
        //Запомним файл в нужной кодировке
        $strXML = self::getXmlStrEncoding($strXML, $aEncoding);
        return $strXML;
    }

    /**
     * Получить имя лог ХМЛ файла
     *
     * @param  string $aName //Имя файла в виде Имени контроллера и Имени действия
     * пр. TendersIndex
     * @return string       //Имя файла в виде: HistDayData_20100426T09_39_25.xml
     *
     */
    static function getNameLogFileXML($aName) {
        $logFile = "";
        $time = self::getCurrentDateTime();
        $time = self::getFormatDateTime($time, "Ymd_H_i_s");
        //----------------------
        //$logFile = $aName."_".$time.".xml";
        $logFile = $aName . ".xml";
        return $logFile;
    }

    /**
     * Получить имя XML файла
     *
     * @param  string $aName //Имя файла в виде Имени контроллера и Имени действия
     * пр. TendersIndex
     * @return string       //Имя файла в виде: HistDayData_20100426T09_39_25.txt
     *
     */
    static function getNameFile($aName) {
        $errFile = "";
        $time = self::getCurrentDateTime();
        $time = self::getFormatDateTime($time, "Ymd_His");
        //----------------------
        $errFile = $aName . "_" . $time . ".xml";
        return $errFile;
    }

    /**
     * Сохранить результирующий ХМЛ файл выполнения запроса
     * как лог. файл в виде userAdmin_TendersIndex.xml
     *
     * @param  array $aParams //массив параметров
     * @return void
     *
     */
    static function saveResultXML2Log(array $aParams) {
        //Установить результат выполнения операции запроса
        sysBox::setDebugInfo("results", array(
            "title" => $aParams["title"],
            "result" => $aParams["result"],
            "message" => $aParams["message"]));

        //Получим ХМЛ файл с данными
        $dir = htmBox::getProjectPath("template");
        $template = $dir . $aParams["template"];
        $strXML = strBox::prepDataToLogXML($template, $aParams["rowdata"], $aParams["histdata"], 'windows-1251');
        //Сохраним результат в лог файле
        $type = isset(myConfig::$arrArguments["test"]) ? "logs_test" : "logs";
        $dir = htmBox::getProjectPath($type);

        if (is_dir($dir)) {
            $logFile = $dir . $aParams["log_file"];
            file_put_contents($logFile, $strXML);
        } else {
            throw new Exception("Error writing file. A dir name {$dir} does not exist");
        }
    }

    /**
     * Сохранить ERROR ХМЛ файл выполнения запроса
     * как лог. файл в виде ErrScript.xml
     *
     * @param  array $aParams //массив параметров
     * @return void
     *
     */
    static function saveErrXML2Log(array $aParams) {


        $xmlScriptErr = self::Array2Xml($aParams);

        //Запомним файл в нужной кодировке
        $xmlScriptErr = self::getXmlStrEncoding($xmlScriptErr, "windows-1251");

        $type = isset(myConfig::$arrArguments["test"]) ? "logs_test" : "logs";
        $dir = htmBox::getProjectPath($type);

        // Сохраним лог файл ошибки
        $errFile = self::getNameLogFileXML("ErrScript");
        $errFile = $dir . $errFile;
        file_put_contents($errFile, $xmlScriptErr);

        // Сохраним исторический лог файл ошибки
        $errFile = self::getNameFile("ErrScript");
        $errFile = $dir . 'Errors/' . $errFile;
        file_put_contents($errFile, $xmlScriptErr);
    }

    /**
     * Сохранить ошибку в логе
     *
     * @param string $errMessage
     * @return void
     */
    public static function saveErr2Log($errMessage) {
        $params = myConfig::$arrArguments;
        $result = "ERR";
        $message = self::msgUser('ERR_SYS', array($errMessage));
        $memoryUsage = "Memory used by the script: " . sysBox::showMemoryUsage('mb') . " mb.";

        $arrScriptErr = array(
            "Params" => $params,
            "Result" => $result,
            "Message" => $message,
            "MemoryUsage" => $memoryUsage
        );

        // Сохраним лог файл
        self::saveErrXML2Log($arrScriptErr);
        sysBox::restrictLogFiles();

        // Выведем инф. об ошибке на экран
        sysBox::printTXT("ERR... Arguments Script:");
        sysBox::printR($params);
        sysBox::printTXT($memoryUsage);
        sysBox::printTXT($message);
    }

    /**
     * The main function for converting to an XML document.
     * Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
     *
     * @param array $data
     * @param string $rootNodeName - what you want the root node to be - defaultsto data.
     * @param SimpleXMLElement $xml - should only be used recursively
     * @return string XML
     */
    public static function Array2Xml($data, $rootNodeName = 'data', $xml = null) {
        // turn off compatibility mode as simple xml throws a wobbly if you don't.
        if (ini_get('zend.ze1_compatibility_mode') == 1) {
            ini_set('zend.ze1_compatibility_mode', 0);
        }

        if ($xml == null) {
            $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
        }

        // loop through the data passed in.
        foreach ($data as $key => $value) {
            // no numeric keys in our xml please!
            if (is_numeric($key)) {
                // make string key...
                $key = "unknownNode_" . (string) $key;
            }

            // replace anything not alpha numeric
            $key = preg_replace('/[^a-z_0-9]/i', '', $key);

            // if there is another array found recrusively call this function
            if (is_array($value)) {
                $node = $xml->addChild($key);
                // recrusive call.
                self::Array2Xml($value, $rootNodeName, $node);
            } else {
                // add single node. htmlspecialchars()
                // $value = htmlentities($value);
                $value = htmlspecialchars($value);
                $xml->addChild($key, $value);
            }
        }
        // pass back as string. or simple xml object if you want!
        return $xml->asXML();
    }

    //=========== РАБОТА С ДАТОЙ ВРЕМЕНЕМ ==================//

    /* Получить текущую дату-время в формате - Y-m-d H:i:s
     *
     * @param  int $aTimeStamp      //Дата TimeStamp - целое число
     *
     * @return string               //Отформатированая дата-время (2010-02-05 12:10:23)
     *
     */
    static function getCurrentDateTime($aTimeStamp = 0) {

        $format = "Y-m-d H:i:s";
        //----------------
        if ($aTimeStamp == 0)
            return date($format);
        else
            return date($format, $aTimeStamp);
    }

    /*
     * Получить текущую дату-время в формате - Y-m-dTH:i:s
     *
     * @param  int $aTimeStamp      //Дата TimeStamp - целое число
     *
     * @return string               //Отформатированая дата-время (2010-02-05T12:10:23)
     *
     */

    static function getCurrentDateTime2($aTimeStamp = 0) {

        $format = "Y-m-dTH:i:s";
        //----------------
        if ($aTimeStamp == 0)
            return date($format);
        else
            return date($format, $aTimeStamp);
    }

    /**
     * Получить массив имен файлов отсортированному по убыванию
     *
     * @param  string aStrDateTime  //Дата время в виде строки (2010-02-05 12:10:23)
     * @param  string $aFormat      //Формат даты например в виде строки (d.m.Y)
     * @return string               //Отформатированая дата или время (05.02.2010)
     *
     */
    static function getFormatDateTime($aStrDateTime, $aFormat) {
        $TimeStamp = strtotime($aStrDateTime);
        //----------------
        return date($aFormat, $TimeStamp);
    }

    /**
     * Получить интервал (период) дат для запроса к истории
     *
     * @param  string $aType    //Тип периода
     *
     * @return array           //Массив из 2х элементов (minDate,maxDate)
     *
     */
    static function getDateTimePeriod($aType) {
        $arrDates = array();
        //----------------
        $aType = strtolower($aType);
        switch ($aType) {
            case "day":
                //Current date
                $arrDates["date_max"] = date("Y-m-d");
                //Yesterday date
                $arrDates["date_min"] = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
                break;
            case "current_sec":
                //Current date/time
                $arrDates["date_max"] = date("Y-m-d H:i:s");
                //Yesterday date/time
                $arrDates["date_min"] = date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s") - 1, date("m"), date("d"), date("Y")));
                break;
            case "current_minute":
                //Current date/time
                $arrDates["date_max"] = date("Y-m-d H:i:s");
                //Yesterday date/time
                $arrDates["date_min"] = date("Y-m-d H:i:s", mktime(date("H"), date("i"), 0, date("m"), date("d"), date("Y")));
                break;
        }
        return $arrDates;
    }

    /**
     * Получить предыдущую дату относительно текущей даты
     *
     * @param  string $aCurrentDate     //Текущая дата
     *
     * @return string                   //Предыдущая дата
     *
     */
    static function getPreviousDate($aCurrentDate) {
        $arr_date = array();
        $previous_date = "";
        //Corrent date
        $arr_date = explode("-", $aCurrentDate);
        //Yesterday date
        $previous_date = date("Y-m-d", mktime(0, 0, 0, $arr_date[1], $arr_date[2] - 1, $arr_date[0]));
        return $previous_date;
    }
    
    /**
     * Получить время в формате - 01.23min или 12sec
     * 
     * @param int $TimeDuration     // Продолжительность времени
     * @return string 
     */
    static function getTimeDuration($TimeDuration = 0) {
        if ($TimeDuration / 60 > 1) {
            $scriptTime = $TimeDuration / 60;
            $scriptTime = number_format($scriptTime, 2, '.', ' ') . 'min';
        } else {
            $scriptTime = $TimeDuration;
            $scriptTime = number_format($scriptTime, 2, '.', ' ') . 'sec';
        }
        return $scriptTime;
    }

    //=========== ПОДГОТОВКА ПАРАМЕТРОВ ДЛЯ ЗАПРОСА ==================//

    /*     * Получим строку параметров для запроса SQL
     * IN('val_1','val_2')
     *
     * @param  array $arrParam          //Массив параметров
     *
     * @return string                   //Строка запроса
     *
     */
    static function getParamFor_IN(array $arrParam) {

        $strParam = "";
        //----------------
        foreach ($arrParam as $param) {
            if ($strParam == "")
                $strParam = "'" . $param . "'";
            else
                $strParam = $strParam . ",'" . $param . "'";
        }

        return $strParam;
    }

    /**
     * Получим строку параметров для запроса SQL
     * (val_1='key_1' OR val_2='key_2')
     *
     * @param  array $arrParams //Массив параметров
     *
     * @return string           //Строка запроса
     *
     *  (Source = '02AMIAK:02T4.PNT' OR Source = '02AMIAK:02F4.PNT') OR 
      (Source = '02AMIAK:02P4_1.PNT' OR Source = '02PGAZ:02F5.PNT') OR
      (Source = '02PGAZ:02T16.PNT' OR Source = '02PGAZ:02P5.PNT') OR
      (Source = '02AMIAK:02T21_1.PNT' OR Source = '')
     * 
     */
    static function getParamFor_OR(array $arrParams) {
        $arrKeyValue = array();
        $strReq = "";
        $isEven = true; // Проверка на четность числа
        $isOdd = false; // Проверка на нечетность числа
        //------------------------
        foreach ($arrParams as $key => $value) {
            $isEven = !$isEven;
            $isOdd = !$isOdd;
            // Сформируем массив со значениями условий
            $arrKeyValue[] = "{$value}='{$key}'";
        }
        if ($isOdd) {
            $arrKeyValue[] = "Source = ''";
        }
        $isEven = true;
        $isOdd = false;
        foreach ($arrKeyValue as $value) {
            $isEven = !$isEven;
            $isOdd = !$isOdd;

            if ($isOdd) {
                $strReq .= '(' . $value . ' OR ';
            } else {
                $strReq .= $value . ') OR ';
            }
        }
        
        $strReq .= " (Source = '')"; 
        
//        $strReq = rtrim($strReq, ' OR');
        
        return $strReq;
    }

    /**
     * Получим строку параметров для запроса SQL
     * (key_1='val_1' AND key_2='val_2')
     *
     * @param  array $arrParams //Массив параметров
     *
     * @return string           //Строка запроса
     *
     */
    static function getParamFor_AND(array $arrParams) {
        $strReq = "";
        //------------------------
        foreach ($arrParams as $key => $value) {
            if ($strReq == "")
                $strReq = "$key='$value'";
            else
                $strReq .= " AND $key='$value'";
        }
        return $strReq;
    }

    //==================== ВЫЗОВ ПОЛЬЗОВАТЕЛЬСКОГО СООБЩЕНИЯ  ==================//
    static function msgUser($typeMessage, array $arrParam = null) {
        $myMsg = "";
        //------------------
        switch ($typeMessage) {
            case "TABLE_LOAD_OK":
                $myMsg = "Таблица '%s' загружена.";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "REG_CLIENT_OK":
                $myMsg = "Авторизация пользователя '%s' прошла успешно!";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "REG_PPP_OK":
                $myMsg = "Регистрация программы прошла успешно!";
                break;
            case "REG_CLIENT_NO":
                $myMsg = "Не верно задан код ЕДРПОУ предприятия -'%s', код регистрации программного продукта - '%s', или логин пользователя - '%s'.";
                $myMsg = sprintf($myMsg, $arrParam[0], $arrParam[1], $arrParam[2]);
                break;
            case "REG_PPP_NO":
                $myMsg = "Не верно задан код ЕДРПОУ предприятия -'%s',или login пользователя - '%s', или код регистрации программного продукта - '%s', или номер лицензии - '%s'.";
                $myMsg = sprintf($myMsg, $arrParam[0], $arrParam[1], $arrParam[2], $arrParam[3]);
                break;
            case "REG_OPERATOR_NO":
                $myMsg = "Не верно задан логин оператора - '%s' или пароль оператора - '%s'.";
                $myMsg = sprintf($myMsg, $arrParam[0], $arrParam[1]);
                break;
            case "REG_USER_NO":
                $myMsg = "Пользователь не зарегистрирован! Вы не можете выполнить данную операцию.";
                break;
            case "NO_ROW_FOR_TAG":
                $myMsg = "WARNING: Запись позиции '%s' в базе данных отсутствует!";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_SYS":
                $myMsg = "MSG: {$arrParam[0]}";
                break;
        }
        $myMsg = str_replace("\n", "#", $myMsg);
        return $myMsg;
    }

    //==================== ВЫЗОВ ПОЛЬЗОВАТЕЛЬСКОЙ ОШИБКИ  ==================//
    static function errUser($typeError, array $arrParam) {
        $myMsg = "";
        //------------------
        switch ($typeError) {
            case "ERR_SYS":
                $myMsg = "%s";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_GET_PARAM":
                $myMsg = "Ошибка обращения к контроллеру: '%s' - неверно заданы параметры.";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_REG_IP_ADDRESS_CLIENT":
                $myMsg = "MAC адрес пользователя '%s' не соответствует зарегистрированному MAC адресу.";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_LOGIN_CLIENT":
                $myMsg = "Ошибка запроса: код регистрации клиента '%s' задан не верно!";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_NOT_CLIENT":
                $myMsg = "Ошибка запроса: клиент c уникальным кодом - '%s' отсутствует!";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_NOT_THIS_METOD":
                $myMsg = "Ошибка вызова метода класса: в классе - '%s' отсутствует метод - '%s'.";
                $myMsg = sprintf($myMsg, $arrParam[0], $arrParam[1]);
                break;
            case "PROPOSITIONS_NO":
                $myMsg = "Заявки на тендор № %s не получены!";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
        }
        throw new userException($typeError, $myMsg);
    }

}

?>