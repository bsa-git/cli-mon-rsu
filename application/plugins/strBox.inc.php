<?php

/* =============  ����� ��������� ������ ���  ������������ ========//
 * ������ ������������
 *
 * @uses    Exception
 * @package ZF-BUH1C
 */

class userException extends Exception {

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

//================ ����� ������ �� �������� =========================//
/**
 * ������ �� ��������
 *
 * @uses
 * @package ZF-BUH1C
 */
class strBox {

//=========================== HTML ========================================//
// ������������� ��������� ��������, ��� �� �� ���� SQL ������� � �������� � ���� ������
//������������� �������� �� �������� �� ���������
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
    // ������������� ��������� ��������, ��� �� �� ���� SQL ������� � �������� � ���� ������
    //������������� �������� �������� �� ���������
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

    //================== ������ � ������� ================//
    //Save HTML File
    static function saveHTMLFile($file) {
        $str_file = file_get_contents($file);
        $search = array("&lt;", "&gt;");
        $replace = array("<", ">");
        $str_file = str_replace($search, $replace, $str_file);
        file_put_contents($file, $str_file);
    }

    /**
     * �������� ������ ���� ������ ���������������� �� ��������
     *
     * 
     * @param  string $dir //����������, ��� ��������� ����
     * @param  string $prefix //������� (������ ����� - "my_")
     *
     * @return array
     *
     * ��. my_20100201.xml;my_20100202.xml;my_20100203.xml -> ��������� ���� my_20100203.xml
     * ��� my1.xml;my3.xml;my5.xml -> ��������� ���� my_5.xml
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

    //=========== ���������� ��������� ==================//

    /**
     * ���������� ������� ��������� �������,
     * ����������� � �����
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
     * ���������� ������� ������� �������,
     * ����������� � �����
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
     * ������� ���� ��� ���������� ������
     * ���������� - ����� ��� ����
     * �������������� ��������� ����� - start.txt or stop.txt
     *
     * 
     * @param string $type // ��� ����������: stop, start
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
     * ������ ���� ��� ���������� ������
     * ���������� - ����� ��� ����
     * �������������� ��������� ����� - start.txt or stop.txt
     *
     * 
     * @param string $type // ��� ����������: stop, start
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

    //=========== ������� ����� �� ������ �� ������� ==================//
    static function outResponseFromArray($prefix, array $arrData) {
        foreach ($arrData as $key => $value) {
            echo $prefix . "$key:=" . $value . "<br>\n";
        }
    }

    //============ ������ � ��� ================//

    /**
     * ������������� ����� �� ����� � ��������� UTF-8
     *
     * @param  string $aFilename    //���� � ���������� ����� � ����������� ��������� (windows-1251 ��� UTF-8)
     * @return string               //����� ��������������� � ��������� UTF-8
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
     * ������������� ������ � ��������� ������� ���������
     *
     * @param  string $aSource      //������� ������
     * @param  string $aEncoding    //��������� (windows-1251 ��� UTF-8)
     *
     * @return string               //��������������� ������
     *
     */
    static function getStrEncodingTo_CP866($aSource, $aEncoding) {

        //----------------------
        //������� ���������� ����� �� ���������� ��� �������
        //��� ����������, ����� ��������� ������� ��������� (cp866)
        //������������ ���������
        $aSource = str_replace("�", "i", $aSource);
        $aSource = str_replace("�", "I", $aSource);
        $aSource = str_replace("�", "i", $aSource);
        $aSource = str_replace("�", "I", $aSource);
        $aSource = str_replace("�", "�", $aSource);
        $aSource = str_replace("�", "�", $aSource);
        $aSource = iconv($aEncoding, "cp866", $aSource);

        return $aSource;
    }

    /**
     * ������� ������� ������ � ����� ������������� �����
     *
     * @param  string $aXML    //XML ������
     * @return string          //XML ������ � ���������� ������
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
     * ������������� XML ������ � ��������������� ���������
     *
     * @param  string $aXML         //XML ������
     * @param  string $aEncoding    //��������� (windows-1251 ��� UTF-8)
     *
     * @return string               //XML ������ � �������� ���������
     *
     */
    static function getXmlStrEncoding($aXML, $aEncoding) {

        //----------------------
        //��������� ����������� ��������� XML
        $isWinCoding = substr_count($aXML, "encoding=\"windows-1251\"");

        //������� xml � �������������� ���������
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
     * ������������� �������� ��� ���� ������
     *
     * @param  string $aFieldType   //��� ��������
     * @param  string $aValue       //��������
     *
     * @return string               //�������� ���������������
     *
     */
    static function prepValueForDataBase($aFieldType, $aValue) {
        $fieldType = $aFieldType;
        $value = $aValue;
        //----------------------
        //����������� �������� ��� ��������� ����� ������
        switch ($fieldType) {
            case "integer":
                //������ �������
                $value = str_replace(" ", "", $value);
                break;
            case "decimal":
                //������ �������
                $value = str_replace(" ", "", $value);
                //����������� ���������� ������ ���� ����� (.)
                $value = str_replace(",", ".", $value);
                break;
            case "float":
                //������ �������
                $value = str_replace(" ", "", $value);
                //����������� ���������� ������ ���� ����� (.)
                $value = str_replace(",", ".", $value);
                break;
            case "string":
                //������ ������� ������� � ����� ������
                $value = trim($value);
                break;
            case "datetime":
                //������ ������� ������� � ����� ������
                $value = str_replace(" ", "T", $value);
                break;
        }
        return $value;
    }

    /**
     * ����������� ������ ��� ���������� � ���� ������ �� ��� ��������
     *
     * @param  XML $aXML
     * @return array
     * $arrResult[0] = ���.����������� �������
     * $arrResult[1] = ������ � ������� ���������� ������� ���� ������� �� ���
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
        //������� ������ �����
        $metaData = $aXML->METADATA;
        $Fields = $metaData->FIELDS;
        $rowData = $aXML->ROWDATA;
        //������� ������
        $row_n = 1;
        foreach ($rowData->ROW as $row_data) {
            foreach ($Fields->FIELD as $field) {
                //������� ��� ����
                $fieldName = (string) $field['FieldName'];
                $fieldType = (string) $field['FieldType'];
                $fieldType = strtolower($fieldType);
                //������� �������� ����
                $fieldValue = (string) $row_data[$fieldName];
                $fieldValue = iconv("UTF-8", "Windows-1251", $fieldValue);
                //����������� �������� ��� ��������� ����� ������
                switch ($fieldType) {
                    case "integer":
                        //������ �������
                        $fieldValue = str_replace(" ", "", $fieldValue);
                        break;
                    case "decimal":
                        //������ �������
                        $fieldValue = str_replace(" ", "", $fieldValue);
                        break;
                    case "float":
                        //������ �������
                        $fieldValue = str_replace(" ", "", $fieldValue);
                        break;
                    case "string":
                        //������� ��������� �������� �� �������
                        $fieldValue = str_replace("'", "''", $fieldValue);
                        break;
                }
                //������� � ������ ���������� �������� ����
                if (strtolower($fieldValue) == "null")
                    $arrParam[$fieldName] = null;
                else
                    $arrParam[$fieldName] = $fieldValue;
            }
            //������� ������ � ������ ����������
            $arrParams[] = $arrParam;
            $row_n++;
        }
        //������� ���. ����������� �������
        $arrResult[] = $row_n - 1;
        //������� ������ ���� ����������
        $arrResult[] = $arrParams;
        return $arrResult;
    }

    /**
     * ����������� ��� ���� ��� ������ �������
     *
     * @param  string $aTemplatePath    //���� � ������� XML �����
     * @param  array $aRowsData         //������ � ������� ��� ���� ������
     * @param  array $aRowsHist         //������ � ������� �� �������
     * @param  string $aEncoding        //��� ��������� � XML �����: (windows-1251) ��� (utf-8)
     *
     * @return string                   //��� ���� � ���� ������
     */
    static function prepDataToLogXML($aTemplatePath, array $aRowsData, array $aRowsHist, $aEncoding) {

        $context = "";
        $isWinEncoding = false;

        //-------------------
        //������� xml ������ �� ���������� ����� � ��������� UTF-8
        $aEncoding = strtolower($aEncoding);
        $isWinEncoding = ($aEncoding == 'windows-1251');
        if ($isWinEncoding) {
            $context = strBox::getXmlFileEncodingUTF8($aTemplatePath);
        } else {
            $content = file_get_contents($aTemplatePath);
        }
        $oXML = simplexml_load_string($context);

        //������� ���� �� ��� �����
        $metaData = $oXML->METADATA;
        $Fields = $metaData->FIELDS;
        $rowData = $oXML->ROWDATA;
        $rowHist = $oXML->ROWHIST;
        $debugData = $oXML->DEBUGS;
        $paramData = $oXML->PARAMS;
        $resultData = $oXML->RESULTS;
        $warningMessages = $oXML->WARNINGS;

        //��������� ���������
        $arrParams = sysBox::getDebugInfo("params");
        foreach ($arrParams as $key => $value) {
            $value = iconv("windows-1251", "utf-8", $value);
            $paramData->addAttribute($key, $value);
        }

        //��������� ���������� �������
        $arrResults = sysBox::getDebugInfo("results");
        foreach ($arrResults as $key => $value) {
            $key = strtoupper($key);
            //$result = $resultData->addChild($key);
            $value = iconv("windows-1251", "utf-8", $value);
            $resultData->addChild($key, $value);
        }

        //��������� ���������� � ���������������
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

        //��������� ���������� ����������
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

        //������� ������ ���� ������ � ��� ���� �� ������� ������
        $count = count($aRowsData);
        for ($i = 0; $i < $count; $i++) {
            $arrValues = $aRowsData[$i];
            $row = $rowData->addChild('ROW');
            //���������� ������ � ������� ������
            foreach ($arrValues as $key => $value) {
                //��������� � ��������� "utf-8"
                //��� ���������� ������ � �������� $oXML (�.�. �� ������������ ������ ������ � UTF-8)
                if ($isWinEncoding) {
                    $value = iconv("windows-1251", "utf-8", $value);
                }
                //���� ��� ������ ���� � �������, �� ������� �� � ��������������
                //��� ����
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

        //������� ������ �� ������� � ��� ���� �� ������� ������
        $count = count($aRowsHist);
        for ($i = 0; $i < $count; $i++) {
            $arrValues = $aRowsHist[$i];
            $row = $rowHist->addChild('ROW');
            //���������� ������ � ������� ������
            foreach ($arrValues as $key => $value) {
                //��������� � ��������� "utf-8"
                //��� ���������� ������ � �������� $oXML (�.�. �� ������������ ������ ������ � UTF-8)
                if ($isWinEncoding) {
                    $value = iconv("windows-1251", "utf-8", $value);
                }
                //���� ��� ������ ���� � �������, �� ������� �� � ��������������
                //��� ����
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
        //������� ��� � ���� ������
        $strXML = $oXML->asXML();
        //������� �������� �����
        $strXML = self::LFCR_Add_XmlFile($strXML);
        //�������� ���� � ������ ���������
        $strXML = self::getXmlStrEncoding($strXML, $aEncoding);
        return $strXML;
    }

    /**
     * �������� ��� ��� ��� �����
     *
     * @param  string $aName //��� ����� � ���� ����� ����������� � ����� ��������
     * ��. TendersIndex
     * @return string       //��� ����� � ����: HistDayData_20100426T09_39_25.xml
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
     * �������� ��� XML �����
     *
     * @param  string $aName //��� ����� � ���� ����� ����������� � ����� ��������
     * ��. TendersIndex
     * @return string       //��� ����� � ����: HistDayData_20100426T09_39_25.txt
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
     * ��������� �������������� ��� ���� ���������� �������
     * ��� ���. ���� � ���� userAdmin_TendersIndex.xml
     *
     * @param  array $aParams //������ ����������
     * @return void
     *
     */
    static function saveResultXML2Log(array $aParams) {
        //���������� ��������� ���������� �������� �������
        sysBox::setDebugInfo("results", array(
            "title" => $aParams["title"],
            "result" => $aParams["result"],
            "message" => $aParams["message"]));

        //������� ��� ���� � �������
        $dir = htmBox::getProjectPath("template");
        $template = $dir . $aParams["template"];
        $strXML = strBox::prepDataToLogXML($template, $aParams["rowdata"], $aParams["histdata"], 'windows-1251');
        //�������� ��������� � ��� �����
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
     * ��������� ERROR ��� ���� ���������� �������
     * ��� ���. ���� � ���� ErrScript.xml
     *
     * @param  array $aParams //������ ����������
     * @return void
     *
     */
    static function saveErrXML2Log(array $aParams) {


        $xmlScriptErr = self::Array2Xml($aParams);

        //�������� ���� � ������ ���������
        $xmlScriptErr = self::getXmlStrEncoding($xmlScriptErr, "windows-1251");

        $type = isset(myConfig::$arrArguments["test"]) ? "logs_test" : "logs";
        $dir = htmBox::getProjectPath($type);

        // �������� ��� ���� ������
        $errFile = self::getNameLogFileXML("ErrScript");
        $errFile = $dir . $errFile;
        file_put_contents($errFile, $xmlScriptErr);

        // �������� ������������ ��� ���� ������
        $errFile = self::getNameFile("ErrScript");
        $errFile = $dir . 'Errors/' . $errFile;
        file_put_contents($errFile, $xmlScriptErr);
    }

    /**
     * ��������� ������ � ����
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

        // �������� ��� ����
        self::saveErrXML2Log($arrScriptErr);
        sysBox::restrictLogFiles();

        // ������� ���. �� ������ �� �����
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

    //=========== ������ � ����� �������� ==================//

    /* �������� ������� ����-����� � ������� - Y-m-d H:i:s
     *
     * @param  int $aTimeStamp      //���� TimeStamp - ����� �����
     *
     * @return string               //���������������� ����-����� (2010-02-05 12:10:23)
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
     * �������� ������� ����-����� � ������� - Y-m-dTH:i:s
     *
     * @param  int $aTimeStamp      //���� TimeStamp - ����� �����
     *
     * @return string               //���������������� ����-����� (2010-02-05T12:10:23)
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
     * �������� ������ ���� ������ ���������������� �� ��������
     *
     * @param  string aStrDateTime  //���� ����� � ���� ������ (2010-02-05 12:10:23)
     * @param  string $aFormat      //������ ���� �������� � ���� ������ (d.m.Y)
     * @return string               //���������������� ���� ��� ����� (05.02.2010)
     *
     */
    static function getFormatDateTime($aStrDateTime, $aFormat) {
        $TimeStamp = strtotime($aStrDateTime);
        //----------------
        return date($aFormat, $TimeStamp);
    }

    /**
     * �������� �������� (������) ��� ��� ������� � �������
     *
     * @param  string $aType    //��� �������
     *
     * @return array           //������ �� 2� ��������� (minDate,maxDate)
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
     * �������� ���������� ���� ������������ ������� ����
     *
     * @param  string $aCurrentDate     //������� ����
     *
     * @return string                   //���������� ����
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
     * �������� ����� � ������� - 01.23min ��� 12sec
     * 
     * @param int $TimeDuration     // ����������������� �������
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

    //=========== ���������� ���������� ��� ������� ==================//

    /*     * ������� ������ ���������� ��� ������� SQL
     * IN('val_1','val_2')
     *
     * @param  array $arrParam          //������ ����������
     *
     * @return string                   //������ �������
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
     * ������� ������ ���������� ��� ������� SQL
     * (val_1='key_1' OR val_2='key_2')
     *
     * @param  array $arrParams //������ ����������
     *
     * @return string           //������ �������
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
        $isEven = true; // �������� �� �������� �����
        $isOdd = false; // �������� �� ���������� �����
        //------------------------
        foreach ($arrParams as $key => $value) {
            $isEven = !$isEven;
            $isOdd = !$isOdd;
            // ���������� ������ �� ���������� �������
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
     * ������� ������ ���������� ��� ������� SQL
     * (key_1='val_1' AND key_2='val_2')
     *
     * @param  array $arrParams //������ ����������
     *
     * @return string           //������ �������
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

    //==================== ����� ����������������� ���������  ==================//
    static function msgUser($typeMessage, array $arrParam = null) {
        $myMsg = "";
        //------------------
        switch ($typeMessage) {
            case "TABLE_LOAD_OK":
                $myMsg = "������� '%s' ���������.";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "REG_CLIENT_OK":
                $myMsg = "����������� ������������ '%s' ������ �������!";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "REG_PPP_OK":
                $myMsg = "����������� ��������� ������ �������!";
                break;
            case "REG_CLIENT_NO":
                $myMsg = "�� ����� ����� ��� ������ ����������� -'%s', ��� ����������� ������������ �������� - '%s', ��� ����� ������������ - '%s'.";
                $myMsg = sprintf($myMsg, $arrParam[0], $arrParam[1], $arrParam[2]);
                break;
            case "REG_PPP_NO":
                $myMsg = "�� ����� ����� ��� ������ ����������� -'%s',��� login ������������ - '%s', ��� ��� ����������� ������������ �������� - '%s', ��� ����� �������� - '%s'.";
                $myMsg = sprintf($myMsg, $arrParam[0], $arrParam[1], $arrParam[2], $arrParam[3]);
                break;
            case "REG_OPERATOR_NO":
                $myMsg = "�� ����� ����� ����� ��������� - '%s' ��� ������ ��������� - '%s'.";
                $myMsg = sprintf($myMsg, $arrParam[0], $arrParam[1]);
                break;
            case "REG_USER_NO":
                $myMsg = "������������ �� ���������������! �� �� ������ ��������� ������ ��������.";
                break;
            case "NO_ROW_FOR_TAG":
                $myMsg = "WARNING: ������ ������� '%s' � ���� ������ �����������!";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_SYS":
                $myMsg = "MSG: {$arrParam[0]}";
                break;
        }
        $myMsg = str_replace("\n", "#", $myMsg);
        return $myMsg;
    }

    //==================== ����� ���������������� ������  ==================//
    static function errUser($typeError, array $arrParam) {
        $myMsg = "";
        //------------------
        switch ($typeError) {
            case "ERR_SYS":
                $myMsg = "%s";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_GET_PARAM":
                $myMsg = "������ ��������� � �����������: '%s' - ������� ������ ���������.";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_REG_IP_ADDRESS_CLIENT":
                $myMsg = "MAC ����� ������������ '%s' �� ������������� ������������������� MAC ������.";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_LOGIN_CLIENT":
                $myMsg = "������ �������: ��� ����������� ������� '%s' ����� �� �����!";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_NOT_CLIENT":
                $myMsg = "������ �������: ������ c ���������� ����� - '%s' �����������!";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
            case "ERR_NOT_THIS_METOD":
                $myMsg = "������ ������ ������ ������: � ������ - '%s' ����������� ����� - '%s'.";
                $myMsg = sprintf($myMsg, $arrParam[0], $arrParam[1]);
                break;
            case "PROPOSITIONS_NO":
                $myMsg = "������ �� ������ � %s �� ��������!";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
        }
        throw new userException($typeError, $myMsg);
    }

}

?>