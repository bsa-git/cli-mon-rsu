<?

##############################################
# Bitrix Site Manager                        #
# Copyright (c) 2002-2007 Bitrix             #
# http://www.bitrixsoft.com                  #
# mailto:admin@bitrixsoft.com                #
##############################################

/* * ***************************************************************
 * 	Классы для работы с базой данных
 * *************************************************************** */

class CAllDatabase {

    var $db_Conn;
    var $debug;
    var $DebugToFile;
    var $ShowSqlStat;
    var $db_Error;
    var $result;
    var $type;

    //Соединяется с базой данных
    function Connect($DBHost, $DBName, $DBLogin, $DBPassword) {
        //переопределяется!
        return false;
    }

    function GetNowFunction() {
        return CDatabase::CurrentTimeFunction();
    }

    function GetNowDate() {
        return CDatabase::CurrentDateFunction();
    }

    function DateToCharFunction($strFieldName, $strType = "FULL") {
        //переопределяется!
    }

    function CharToDateFunction($strValue, $strType = "FULL") {
        //переопределяется!
    }

    function Concat() {
        //переопределяется!
    }

    function IsNull($expression, $result) {
        //переопределяется!
    }

    function Length($field) {
        //переопределяется!
    }

    function ToChar($expr, $len = 0) {
        return "CAST(" . $expr . " AS CHAR" . ($len > 0 ? "(" . $len . ")" : "") . ")";
    }

    // унифицированный формат в PHP формат
    function DateFormatToPHP($f) {
        $f = str_replace("YYYY", "Y", $f); // 1999
        $f = str_replace("MM", "m", $f); // 01 - 12
        $f = str_replace("DD", "d", $f); // 01 - 31
        $f = str_replace("HH", "H", $f); // 00 - 24
        $f = str_replace("MI", "i", $f); // 00 - 59
        return str_replace("SS", "s", $f); // 00 - 59
    }

    function FormatDate($strDate, $format = "DD.MM.YYYY HH:MI:SS", $new_format = "DD.MM.YYYY HH:MI:SS") {
        $strDate = trim($strDate);

        $new_format = str_replace("MI", "I", strtoupper($new_format));
        $new_format = preg_replace("/([DMYIHS])\\1+/is", "\\1", $new_format);
        $arFormat = split('[^0-9A-Za-z]', strtoupper($format));
        $arDate = split('[^0-9]', $strDate);
        $arParsedDate = Array();
        $bound = min(count($arFormat), count($arDate));

        for ($i = 0; $i < $bound; $i++) {
            //if ($intval) $r = IntVal($arDate[$i]); else
            if (ereg("^[0-9]", $arDate[$i]))
                $r = CDatabase::ForSql($arDate[$i], 4);
            else
                $r = IntVal($arDate[$i]);

            $arParsedDate[substr($arFormat[$i], 0, 2)] = $r;
        }

        if (intval($arParsedDate["DD"]) <= 0 || intval($arParsedDate["MM"]) <= 0 || intval($arParsedDate["YY"]) <= 0)
            return false;

        $strResult = "";
        if (intval($arParsedDate["YY"]) > 1970 && intval($arParsedDate["YY"]) < 2038) {
            $ux_time = mktime(
                    intval($arParsedDate["HH"]), intval($arParsedDate["MI"]), intval($arParsedDate["SS"]), intval($arParsedDate["MM"]), intval($arParsedDate["DD"]), intval($arParsedDate["YY"])
            );

            $new_format_len = strlen($new_format);
            for ($i = 0; $i < $new_format_len; $i++) {
                $ch = substr($new_format, $i, 1);
                if ($ch == "D")
                    $strResult .= date("d", $ux_time);
                elseif ($ch == "M")
                    $strResult .= date("m", $ux_time);
                elseif ($ch == "Y")
                    $strResult .= date("Y", $ux_time);
                elseif ($ch == "H")
                    $strResult .= date("H", $ux_time);
                elseif ($ch == "I")
                    $strResult .= date("i", $ux_time);
                elseif ($ch == "S")
                    $strResult .= date("s", $ux_time);
                else
                    $strResult .= $ch;
            }
        }
        else {
            if ($arParsedDate["MM"] < 1 || $arParsedDate["MM"] > 12)
                $arParsedDate["MM"] = 1;
            $new_format_len = strlen($new_format);
            for ($i = 0; $i < $new_format_len; $i++) {
                $ch = substr($new_format, $i, 1);
                if ($ch == "D")
                    $strResult .= str_pad($arParsedDate["DD"], 2, "0", STR_PAD_LEFT);
                elseif ($ch == "M")
                    $strResult .= str_pad($arParsedDate["MM"], 2, "0", STR_PAD_LEFT);
                elseif ($ch == "Y")
                    $strResult .= str_pad($arParsedDate["YY"], 4, "0", STR_PAD_LEFT);
                elseif ($ch == "H")
                    $strResult .= str_pad($arParsedDate["HH"], 2, "0", STR_PAD_LEFT);
                elseif ($ch == "I")
                    $strResult .= str_pad($arParsedDate["MI"], 2, "0", STR_PAD_LEFT);
                elseif ($ch == "S")
                    $strResult .= str_pad($arParsedDate["SS"], 2, "0", STR_PAD_LEFT);
                else
                    $strResult .= $ch;
            }
        }

        return $strResult;
    }

    //Делает запрос к базе данных
    function Query($strSql, $bIgnoreErrors = false) {
        //переопределяется!
    }

    //запрос с записью CLOB
    function QueryBind($strSql, $arBinds, $bIgnoreErrors = false) {
        //переопределяется, где надо
        return $this->Query($strSql, $bIgnoreErrors);
    }

    function ForSql($strValue, $iMaxLength = 0) {
        //переопределяется!
    }

    function PrepareInsert($strTableName, $arFields) {
        //переопределяется!
    }

    function PrepareUpdate($strTableName, $arFields) {
        //переопределяется!
    }

    function ParseSqlBatch($strSql, $bIncremental = False) {
        if (strtolower($this->type) == "mysql")
            $delimiter = ";";
        elseif (strtolower($this->type) == "mssql")
            $delimiter = "\nGO";
        else
            $delimiter = "(?<!\\*)/(?!\\*)";

        $strSql = trim($strSql);

        $ret = array();
        $str = "";

        do/**/ {
            if (preg_match("%^(.*?)(['\"`#]|--|" . $delimiter . ")%is", $strSql, $match)) {
                //Found string start
                if ($match[2] == "\"" || $match[2] == "'" || $match[2] == "`") {
                    $strSql = substr($strSql, strlen($match[0]));
                    $str .= $match[0];
                    //find a qoute not preceeded by \
                    if (preg_match("%^(.*?)(?<!\\\\)" . $match[2] . "%s", $strSql, $string_match)) {
                        $strSql = substr($strSql, strlen($string_match[0]));
                        $str .= $string_match[0];
                    } else {
                        //String falled beyong end of file
                        $str .= $strSql;
                        $strSql = "";
                    }
                }
                //Comment found
                elseif ($match[2] == "#" || $match[2] == "--") {
                    //Take that was before comment as part of sql
                    $strSql = substr($strSql, strlen($match[1]));
                    $str .= $match[1];
                    //And cut the rest
                    $p = strpos($strSql, "\n");
                    if ($p === false) {
                        $p1 = strpos($strSql, "\r");
                        if ($p1 === false)
                            $strSql = "";
                        elseif ($p < $p1)
                            $strSql = substr($strSql, $p);
                        else
                            $strSql = substr($strSql, $p1);
                    }
                    else
                        $strSql = substr($strSql, $p);
                }
                //Delimiter!
                else {
                    //Take that was before delimiter as part of sql
                    $strSql = substr($strSql, strlen($match[0]));
                    $str .= $match[1];
                    //Delimiter must be followed by whitespace
                    if (preg_match("%^[\n\r\t ]%", $strSql)) {
                        $str = trim($str);
                        if (strlen($str)) {
                            if ($bIncremental) {
                                $strSql1 = str_replace("\r\n", "\n", $str);
                                if (!$this->QueryLong($strSql1, true))
                                    $ret[] = $this->db_Error;
                            }
                            else {
                                $ret[] = $str;
                                $str = "";
                            }
                        }
                    }
                    //It was not delimiter!
                    elseif (strlen($strSql)) {
                        $str .= $match[2];
                    }
                }
            } else { //End of file is our delimiter
                $str .= $strSql;
                $strSql = "";
            }
        } while (strlen($strSql));

        $str = trim($str);
        if (strlen($str)) {
            if ($bIncremental) {
                $strSql1 = str_replace("\r\n", "\n", $str);
                if (!$this->QueryLong($strSql1, true))
                    $ret[] = $this->db_Error;
            }
            else {
                $ret[] = $str;
            }
        }
        return $ret;
    }

    function RunSQLBatch($filepath, $bIncremental = False) {
        if (!file_exists($filepath) || !is_file($filepath))
            return Array("File $filepath is not found.");

        $arErr = Array();
        $f = @fopen($filepath, "rb");
        if ($f) {
            $contents = fread($f, filesize($filepath));
            fclose($f);

            $arSql = $this->ParseSqlBatch($contents, $bIncremental);
            //echo "<pre>"; print_r($arSql); echo "</pre>"; die();
            for ($i = 0; $i < count($arSql); $i++) {
                if ($bIncremental) {
                    $arErr[] = $arSql[$i];
                } else {
                    $strSql = str_replace("\r\n", "\n", $arSql[$i]);
                    if (!$this->Query($strSql, true))
                        $arErr[] = "<hr><pre>Query:\n" . $strSql . "\n\nError:\n<font color=red>" . $this->db_Error . "</font></pre>";
                }
            }
        }
        if (count($arErr) > 0)
            return $arErr;

        return false;
    }

    function IsDate($value, $format = false, $lang = false, $format_type = "SHORT") {
        if ($format === false)
            $format = CLang::GetDateFormat($format_type, $lang);
        return CheckDateTime($value, $format);
    }

}

/////////////////////////////////////////////////////
// Класс результата выполнения CDatabase::Query()
/////////////////////////////////////////////////////
class CAllDBResult {

    var $result; //результат (первоначальный дескриптор)
    var $arResult; //результат в виде массива после NavStart
    var $bNavStart = false;
    var $bShowAll = false;
    var $NavNum, $NavPageCount, $NavPageNomer, $NavPageSize, $NavShowAll, $NavRecordCount;
    var $bFirstPrintNav = true;
    var $PAGEN, $SIZEN;
    var $add_anchor = "";
    var $bPostNavigation = false;
    var $bFromArray = false;
    var $bFromLimited = false;
    var $sSessInitAdd = "";
    var $nPageWindow = 11;
    var $nSelectedCount = false;
    var $arGetNextCache = false;
    var $bDescPageNumbering = false;
    var $arUserMultyFields = false;
    var $SqlTraceIndex = false;

    function CAllDBResult($res = NULL) {
        if (is_object($res) && is_subclass_of($res, "CAllDBResult")) {
            $this->result = $res->result;
            $this->nSelectedCount = $res->nSelectedCount;
            $this->arResult = $res->arResult;
            $this->bNavStart = $res->bNavStart;
            $this->NavPageNomer = $res->NavPageNomer;
            $this->bShowAll = $res->bShowAll;
            $this->NavNum = $res->NavNum;
            $this->NavPageCount = $res->NavPageCount;
            $this->NavPageSize = $res->NavPageSize;
            $this->NavShowAll = $res->NavShowAll;
            $this->NavRecordCount = $res->NavRecordCount;
            $this->bFirstPrintNav = $res->bFirstPrintNav;
            $this->PAGEN = $res->PAGEN;
            $this->SIZEN = $res->SIZEN;
            $this->bFromArray = $res->bFromArray;
            $this->bFromLimited = $res->bFromLimited;
            $this->sSessInitAdd = $res->sSessInitAdd;
            $this->nPageWindow = $res->nPageWindow;
            $this->bDescPageNumbering = $res->bDescPageNumbering;
            $this->SqlTraceIndex = $res->SqlTraceIndex;
        } elseif (is_array($res))
            $this->arResult = $res;
        else
            $this->result = $res;
    }

    //После запроса делает выборку значений полей в массив
    function Fetch() {
        
    }

    function SelectedRowsCount() {
        
    }

    function AffectedRowsCount() {
        
    }

    function FieldsCount() {
        
    }

    function FieldName($iCol) {
        
    }

    function IsNavPrint() {
        if ($this->NavRecordCount == 0 || ($this->NavPageCount == 1 && $this->NavShowAll == false))
            return false;

        return true;
    }

    function NavPrint($title, $show_allways = false, $StyleText = "text", $template_path = false) {
        echo $this->GetNavPrint($title, $show_allways, $StyleText, $template_path);
    }

    function GetNavPrint($title, $show_allways = false, $StyleText = "text", $template_path = false, $arDeleteParam = false) {
        $res = '';
        $add_anchor = $this->add_anchor;

        $sBegin = GetMessage("nav_begin");
        $sEnd = GetMessage("nav_end");
        $sNext = GetMessage("nav_next");
        $sPrev = GetMessage("nav_prev");
        $sAll = GetMessage("nav_all");
        $sPaged = GetMessage("nav_paged");

        // окно, которое двигаем по страницам
        $nPageWindow = $this->nPageWindow;

        if (!$show_allways) {
            if ($this->NavRecordCount == 0 || ($this->NavPageCount == 1 && $this->NavShowAll == false))
                return;
        }

        $sUrlPath = GetPagePath();

        //Строка для формирования ссылки на следующие страницы навигации
        $arDel = array("PAGEN_" . $this->NavNum, "SIZEN_" . $this->NavNum, "SHOWALL_" . $this->NavNum, "PHPSESSID");
        if (is_array($arDeleteParam))
            $arDel = array_merge($arDel, $arDeleteParam);
        $strNavQueryString = DeleteParam($arDel);
        if ($strNavQueryString <> "")
            $strNavQueryString = htmlspecialchars("&" . $strNavQueryString);

        if ($template_path !== false && !file_exists($template_path) && file_exists($_SERVER["DOCUMENT_ROOT"] . $template_path))
            $template_path = $_SERVER["DOCUMENT_ROOT"] . $template_path;

        if ($this->bDescPageNumbering === true) {
            if ($this->NavPageNomer + floor($nPageWindow / 2) >= $this->NavPageCount)
                $nStartPage = $this->NavPageCount;
            else {
                if ($this->NavPageNomer + floor($nPageWindow / 2) >= $nPageWindow)
                    $nStartPage = $this->NavPageNomer + floor($nPageWindow / 2);
                else {
                    if ($this->NavPageCount >= $nPageWindow)
                        $nStartPage = $nPageWindow;
                    else
                        $nStartPage = $this->NavPageCount;
                }
            }

            if ($nStartPage - $nPageWindow >= 0)
                $nEndPage = $nStartPage - $nPageWindow + 1;
            else
                $nEndPage = 1;
            //echo "nEndPage = $nEndPage; nStartPage = $nStartPage;";
        }
        else {
            // номер первой страницы в окне
            if ($this->NavPageNomer > floor($nPageWindow / 2) + 1 && $this->NavPageCount > $nPageWindow)
                $nStartPage = $this->NavPageNomer - floor($nPageWindow / 2);
            else
                $nStartPage = 1;

            // номер последней страницы в окне
            if ($this->NavPageNomer <= $this->NavPageCount - floor($nPageWindow / 2) && $nStartPage + $nPageWindow - 1 <= $this->NavPageCount)
                $nEndPage = $nStartPage + $nPageWindow - 1;
            else {
                $nEndPage = $this->NavPageCount;
                if ($nEndPage - $nPageWindow + 1 >= 1)
                    $nStartPage = $nEndPage - $nPageWindow + 1;
            }
        }

        $this->nStartPage = $nStartPage;
        $this->nEndPage = $nEndPage;

        if ($template_path !== false && file_exists($template_path)) {
            /*
              $this->bFirstPrintNav - вызов в первый раз
              $this->NavPageNomer - номер текущей страницы
              $this->NavPageCount - всего страниц
              $this->NavPageSize - размер страницы
              $this->NavRecordCount - количество всего записей
              $this->bShowAll - разрешено ли показывать "все"
              $this->NavShowAll - сейчас показываются все, а не постранично
              $this->NavNum - номер навигации на странице
              $this->bDescPageNumbering - прямая или обратная постраничка

              $this->nStartPage - первая страница в цепочке
              $this->nEndPage - последняя страница в цепочке

              $strNavQueryString - параметры страницы без параметров навигации
              $sUrlPath - урл текущей страницы

              Url for link to the page #PAGE_NUMBER#:
              $sUrlPath.'?PAGEN_'.$this->NavNum.'='.#PAGE_NUMBER#.$strNavQueryString.'#nav_start"'.$add_anchor
             */

            ob_start();
            include($template_path);
            $res = ob_get_contents();
            ob_end_clean();
            $this->bFirstPrintNav = false;
            return $res;
        }

        if ($this->bFirstPrintNav) {
            $res .= '<a name="nav_start' . $add_anchor . '"></a>';
            $this->bFirstPrintNav = false;
        }

        $res .= '<font class="' . $StyleText . '">' . $title . ' ';
        if ($this->bDescPageNumbering === true) {
            $makeweight = ($this->NavRecordCount % $this->NavPageSize);
            $NavFirstRecordShow = 0;
            if ($this->NavPageNomer != $this->NavPageCount)
                $NavFirstRecordShow += $makeweight;

            $NavFirstRecordShow += ($this->NavPageCount - $this->NavPageNomer) * $this->NavPageSize + 1;

            if ($this->NavPageCount == 1)
                $NavLastRecordShow = $this->NavRecordCount;
            else
                $NavLastRecordShow = $makeweight + ($this->NavPageCount - $this->NavPageNomer + 1) * $this->NavPageSize;

            $res .= $NavFirstRecordShow;
            $res .= ' - ' . $NavLastRecordShow;
            $res .= ' ' . GetMessage("nav_of") . ' ';
            $res .= $this->NavRecordCount;
            $res .= "\n<br>\n</font>";

            $res .= '<font class="' . $StyleText . '">';

            if ($this->NavPageNomer < $this->NavPageCount)
                $res .= '<a href="' . $sUrlPath . '?PAGEN_' . $this->NavNum . '=' . $this->NavPageCount . $strNavQueryString . '#nav_start' . $add_anchor . '">' . $sBegin . '</a>&nbsp;|&nbsp;<a href="' . $sUrlPath . '?PAGEN_' . $this->NavNum . '=' . ($this->NavPageNomer + 1) . $strNavQueryString . '#nav_start' . $add_anchor . '">' . $sPrev . '</a>';
            else
                $res .= $sBegin . '&nbsp;|&nbsp;' . $sPrev;

            $res .= '&nbsp;|&nbsp;';

            $NavRecordGroup = $nStartPage;
            while ($NavRecordGroup >= $nEndPage) {
                $NavRecordGroupPrint = $this->NavPageCount - $NavRecordGroup + 1;
                if ($NavRecordGroup == $this->NavPageNomer)
                    $res .= '<b>' . $NavRecordGroupPrint . '</b>&nbsp';
                else
                    $res .= '<a href="' . $sUrlPath . '?PAGEN_' . $this->NavNum . '=' . $NavRecordGroup . $strNavQueryString . '#nav_start' . $add_anchor . '">' . $NavRecordGroupPrint . '</a>&nbsp;';
                $NavRecordGroup--;
            }
            $res .= '|&nbsp;';
            if ($this->NavPageNomer > 1)
                $res .= '<a href="' . $sUrlPath . '?PAGEN_' . $this->NavNum . '=' . ($this->NavPageNomer - 1) . $strNavQueryString . '#nav_start' . $add_anchor . '">' . $sNext . '</a>&nbsp;|&nbsp;<a href="' . $sUrlPath . '?PAGEN_' . $this->NavNum . '=1' . $strNavQueryString . '#nav_start' . $add_anchor . '">' . $sEnd . '</a>&nbsp;';
            else
                $res .= $sNext . '&nbsp;|&nbsp;' . $sEnd . '&nbsp;';
        }
        else {
            $res .= ($this->NavPageNomer - 1) * $this->NavPageSize + 1;
            $res .= ' - ';
            if ($this->NavPageNomer != $this->NavPageCount)
                $res .= $this->NavPageNomer * $this->NavPageSize;
            else
                $res .= $this->NavRecordCount;
            $res .= ' ' . GetMessage("nav_of") . ' ';
            $res .= $this->NavRecordCount;
            $res .= "\n<br>\n</font>";

            $res .= '<font class="' . $StyleText . '">';

            if ($this->NavPageNomer > 1)
                $res .= '<a href="' . $sUrlPath . '?PAGEN_' . $this->NavNum . '=1' . $strNavQueryString . '#nav_start' . $add_anchor . '">' . $sBegin . '</a>&nbsp;|&nbsp;<a href="' . $sUrlPath . '?PAGEN_' . $this->NavNum . '=' . ($this->NavPageNomer - 1) . $strNavQueryString . '#nav_start' . $add_anchor . '">' . $sPrev . '</a>';
            else
                $res .= $sBegin . '&nbsp;|&nbsp;' . $sPrev;

            $res .= '&nbsp;|&nbsp;';

            $NavRecordGroup = $nStartPage;
            while ($NavRecordGroup <= $nEndPage) {
                if ($NavRecordGroup == $this->NavPageNomer)
                    $res .= '<b>' . $NavRecordGroup . '</b>&nbsp';
                else
                    $res .= '<a href="' . $sUrlPath . '?PAGEN_' . $this->NavNum . '=' . $NavRecordGroup . $strNavQueryString . '#nav_start' . $add_anchor . '">' . $NavRecordGroup . '</a>&nbsp;';
                $NavRecordGroup++;
            }
            $res .= '|&nbsp;';
            if ($this->NavPageNomer < $this->NavPageCount)
                $res .= '<a href="' . $sUrlPath . '?PAGEN_' . $this->NavNum . '=' . ($this->NavPageNomer + 1) . $strNavQueryString . '#nav_start' . $add_anchor . '">' . $sNext . '</a>&nbsp;|&nbsp;<a href="' . $sUrlPath . '?PAGEN_' . $this->NavNum . '=' . $this->NavPageCount . $strNavQueryString . '#nav_start' . $add_anchor . '">' . $sEnd . '</a>&nbsp;';
            else
                $res .= $sNext . '&nbsp;|&nbsp;' . $sEnd . '&nbsp;';
        }

        if ($this->bShowAll)
            $res .= $this->NavShowAll ? '|&nbsp;<a href="' . $sUrlPath . '?SHOWALL_' . $this->NavNum . '=0' . $strNavQueryString . '#nav_start' . $add_anchor . '">' . $sPaged . '</a>&nbsp;' : '|&nbsp;<a href="' . $sUrlPath . '?SHOWALL_' . $this->NavNum . '=1' . $strNavQueryString . '#nav_start' . $add_anchor . '">' . $sAll . '</a>&nbsp;';

        $res .= '</font>';
        return $res;
    }

    function ExtractFields($strPrefix = "str_", $bDoEncode = true) {
        return $this->NavNext(true, $strPrefix, $bDoEncode);
    }

    function ExtractEditFields($strPrefix = "str_") {
        return $this->NavNext(true, $strPrefix, true, false);
    }

    function GetNext($bTextHtmlAuto = true, $use_tilda = true) {
        if ($arRes = $this->Fetch()) {
            if ($this->arGetNextCache == false) {
                $this->arGetNextCache = array();
                foreach ($arRes as $FName => $arFValue)
                    $this->arGetNextCache[$FName] = array_key_exists($FName . "_TYPE", $arRes);
            }
            if ($use_tilda) {
                $arTilda = array();
                foreach ($arRes as $FName => $arFValue) {
                    if ($this->arGetNextCache[$FName] && $bTextHtmlAuto)
                        $arTilda[$FName] = FormatText($arFValue, $arRes[$FName . "_TYPE"]);
                    elseif (is_array($arFValue))
                        $arTilda[$FName] = htmlspecialcharsEx($arFValue);
                    elseif (preg_match("/[;&<>\"]/", $arFValue))
                        $arTilda[$FName] = htmlspecialcharsEx($arFValue);
                    else
                        $arTilda[$FName] = $arFValue;
                    $arTilda["~" . $FName] = $arFValue;
                }
                return $arTilda;
            }
            else {
                foreach ($arRes as $FName => $arFValue) {
                    if ($this->arGetNextCache[$FName] && $bTextHtmlAuto)
                        $arRes[$FName] = FormatText($arFValue, $arRes[$FName . "_TYPE"]);
                    elseif (is_array($arFValue))
                        $arRes[$FName] = htmlspecialcharsEx($arFValue);
                    elseif (preg_match("/[;&<>\"]/", $arFValue))
                        $arRes[$FName] = htmlspecialcharsEx($arFValue);
                }
            }
        }
        return $arRes;
    }

    function NavStringForCache($nPageSize = 0, $bShowAll = true, $iNumPage = false) {
        $NavParams = CDBResult::GetNavParams($nPageSize, $bShowAll, $iNumPage);
        return "|" . ($NavParams["SHOW_ALL"] ? "" : $NavParams["PAGEN"]) . "|" . $NavParams["SHOW_ALL"] . "|";
    }

    function GetNavParams($nPageSize = 0, $bShowAll = true, $iNumPage = false) {
        global $NavNum;

        if (is_array($nPageSize))
            extract($nPageSize);

        $nPageSize = IntVal($nPageSize);
        $NavNum = IntVal($NavNum);

        $PAGEN_NAME = "PAGEN_" . ($NavNum + 1);
        $SHOWALL_NAME = "SHOWALL_" . ($NavNum + 1);

        global $$PAGEN_NAME, $$SHOWALL_NAME, $APPLICATION;
        $md5Path = md5((isset($sNavID) ? $sNavID : $APPLICATION->GetCurPage()) . (is_object($this) ? $this->sSessInitAdd : ""));

        if ($iNumPage === false)
            $PAGEN = $$PAGEN_NAME;
        else
            $PAGEN = $iNumPage;

        $SHOWALL = $$SHOWALL_NAME;

        $SESS_PAGEN = $md5Path . "SESS_PAGEN_" . ($NavNum + 1);
        $SESS_ALL = $md5Path . "SESS_ALL_" . ($NavNum + 1);
        if (IntVal($PAGEN) <= 0) {
            if (CPageOption::GetOptionString("main", "nav_page_in_session", "Y") == "Y" && IntVal($_SESSION[$SESS_PAGEN]) > 0)
                $PAGEN = $_SESSION[$SESS_PAGEN];
            elseif ($bDescPageNumbering === true)
                $PAGEN = 0;
            else
                $PAGEN = 1;
        }

        //Число записей для отображения на странице
        $SIZEN = $nPageSize;
        if (IntVal($SIZEN) < 1)
            $SIZEN = 10;

        //Показывать все записи
        $SHOW_ALL = ($bShowAll ? (isset($SHOWALL) ? ($SHOWALL == 1) : (CPageOption::GetOptionString("main", "nav_page_in_session", "Y") == "Y" && $_SESSION[$SESS_ALL] == 1)) : false);

        $res = Array(
            "PAGEN" => $PAGEN,
            "SIZEN" => $SIZEN,
            "SHOW_ALL" => $SHOW_ALL
        );
        if (CPageOption::GetOptionString("main", "nav_page_in_session", "Y") == "Y") {
            $_SESSION[$SESS_PAGEN] = $PAGEN;
            $_SESSION[$SESS_ALL] = $SHOW_ALL;
            $res["SESS_PAGEN"] = $SESS_PAGEN;
            $res["SESS_ALL"] = $SESS_ALL;
        }

        return $res;
    }

    function InitNavStartVars($nPageSize = 0, $bShowAll = true, $iNumPage = false) {
        if (is_array($nPageSize) && is_set($nPageSize, "bShowAll"))
            $this->bShowAll = $nPageSize["bShowAll"];
        else
            $this->bShowAll = $bShowAll;

        $this->bNavStart = true;

        $arParams = $this->GetNavParams($nPageSize, $bShowAll, $iNumPage);

        $this->PAGEN = $arParams["PAGEN"];
        $this->SIZEN = $arParams["SIZEN"];
        $this->NavShowAll = $arParams["SHOW_ALL"];
        $this->NavPageSize = $arParams["SIZEN"];
        $this->SESS_SIZEN = $arParams["SESS_SIZEN"];
        $this->SESS_PAGEN = $arParams["SESS_PAGEN"];
        $this->SESS_ALL = $arParams["SESS_ALL"];

        //global $NavShowAllLabel;
        global /* $NavFirstRecordShow, $NavLastRecordShow, */$NavNum;

        $NavNum++;
        $this->NavNum = $NavNum;

        if ($this->NavNum > 1)
            $add_anchor = "_" . $this->NavNum;
        else
            $add_anchor = "";

        $this->add_anchor = $add_anchor;

        /*
          if (!$bShowAll)
          $NavShowAllLabel = false;
         */
    }

    function NavStart($nPageSize = 0, $bShowAll = true, $iNumPage = false) {
        global $NavNum;
        if ($this->bFromLimited)
            return;

        if (is_array($nPageSize))
            $this->InitNavStartVars($nPageSize);
        else
            $this->InitNavStartVars(IntVal($nPageSize), $bShowAll, $iNumPage);

        if ($this->bFromArray) {
            //общее количество записей
            $this->NavRecordCount = count($this->arResult);
            if ($this->NavRecordCount < 1)
                return;

            if ($this->NavShowAll)
                $this->NavPageSize = $this->NavRecordCount;

            //Определяю число страниц при указанном размере страниц. Счет начиная с 1
            $this->NavPageCount = floor($this->NavRecordCount / $this->NavPageSize);
            if ($this->NavRecordCount % $this->NavPageSize > 0)
                $this->NavPageCount++;

            //Номер страницы для отображения. Отсчет начинается с 1
            $this->NavPageNomer =
                    ($this->PAGEN < 1 || $this->PAGEN > $this->NavPageCount ?
                            (CPageOption::GetOptionString("main", "nav_page_in_session", "Y") != "Y"
                            || $_SESSION[$this->SESS_PAGEN] < 1
                            || $_SESSION[$this->SESS_PAGEN] > $this->NavPageCount ?
                                    1 :
                                    $_SESSION[$this->SESS_PAGEN]
                            ) :
                            $this->PAGEN
                    );

            //Смещение от начала RecordSet
            $NavFirstRecordShow = $this->NavPageSize * ($this->NavPageNomer - 1);
            $NavLastRecordShow = $this->NavPageSize * $this->NavPageNomer;

            $this->arResult = array_slice($this->arResult, $NavFirstRecordShow, $NavLastRecordShow - $NavFirstRecordShow);
        }
        else
            $this->DBNavStart();
    }

    function InitFromArray($arr) {
        $this->arResult = $arr;
        $this->nSelectedCount = count($arr);
        $this->bFromArray = true;
    }

    function NavNext($bSetGlobalVars = true, $strPrefix = "str_", $bDoEncode = true, $bSkipEntities = true) {
        $arr = $this->Fetch();
        if ($arr && $bSetGlobalVars) {
            foreach ($arr as $key => $val) {
                $varname = $strPrefix . $key;
                global $$varname;

                if ($bDoEncode && !is_array($$varname) && !is_object($$varname)) {
                    if ($bSkipEntities)
                        $$varname = htmlspecialcharsEx($val);
                    else
                        $$varname = htmlspecialchars($val);
                }
                else {
                    $$varname = $val;
                }
            }
        }
        return $arr;
    }

    function GetPageNavString($navigationTitle, $templateName = "", $showAlways = false) {
        return $this->GetPageNavStringEx($dummy, $navigationTitle, $templateName, $showAlways);
    }

    function GetPageNavStringEx(&$navComponentObject, $navigationTitle, $templateName = "", $showAlways = false) {
        $result = "";

        ob_start();

        $navComponentObject = $GLOBALS["APPLICATION"]->IncludeComponent(
                "bitrix:system.pagenavigation", $templateName, Array(
            "NAV_TITLE" => $navigationTitle,
            "NAV_RESULT" => $this,
            "SHOW_ALWAYS" => $showAlways
                ), null, array(
            "HIDE_ICONS" => "Y"
                )
        );

        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    }

    function SetUserFields($arUserFields) {
        $this->arUserMultyFields = array();
        if (is_array($arUserFields))
            foreach ($arUserFields as $FIELD_NAME => $arUserField)
                if ($arUserField["MULTIPLE"] == "Y")
                    $this->arUserMultyFields[$FIELD_NAME] = true;
        if (count($this->arUserMultyFields) < 1)
            $this->arUserMultyFields = false;
    }

}

/* * ******************************************************************
 * 	Класс для работы с MySQL
 * ****************************************************************** */

class CDatabase extends CAllDatabase {

    var $DBName;
    var $version;
    var $DBHost;
    var $DBLogin;
    var $DBPassword;
    var $bConnected;
    var $cntQuery;
    var $timeQuery;
    var $arQueryDebug;

    function GetVersion() {
        if ($this->version)
            return $this->version;

        $rs = $this->Query("SELECT VERSION() as R", false, "FILE: " . __FILE__ . "<br> LINE: " . __LINE__);
        if ($ar = $rs->Fetch()) {
            $version = trim($ar["R"]);
            preg_match("#[0-9]+\.[0-9]+\.[0-9]+#", $version, $arr);
            $version = $arr[0];
            $this->version = $version;
            return $version;
        }
        return false;
    }

    function StartTransaction() {
        $this->Query("START TRANSACTION");
    }

    function Commit() {
        $this->Query("COMMIT", true);
    }

    function Rollback() {
        $this->Query("ROLLBACK", true);
    }

    //Соединяется с базой данных
    function Connect($DBHost, $DBName, $DBLogin, $DBPassword) {
        $this->type = "MYSQL";
        $this->DBHost = $DBHost;
        $this->DBName = $DBName;
        $this->DBLogin = $DBLogin;
        $this->DBPassword = $DBPassword;
        $this->bConnected = false;
        if (defined("DELAY_DB_CONNECT") && DELAY_DB_CONNECT === true)
            return true;
        else
            return $this->DoConnect();
    }

    function DoConnect() {
        if ($this->bConnected)
            return;
        $this->bConnected = true;

        if (!defined("DBPersistent"))
            define("DBPersistent", true);

        if (DBPersistent)
            $this->db_Conn = @mysql_pconnect($this->DBHost, $this->DBLogin, $this->DBPassword);
        else
            $this->db_Conn = @mysql_connect($this->DBHost, $this->DBLogin, $this->DBPassword);

        if (!($this->db_Conn)) {
            $s = (DBPersistent ? "mysql_pconnect" : "mysql_connect");
            if ($this->debug || (@session_start() && $_SESSION["SESS_AUTH"]["ADMIN"]))
                echo "<br><font color=#ff0000>Error! " . $s . "('-', '-', '-')</font><br>" . mysql_error() . "<br>";

            SendError("Error! " . $s . "('-', '-', '-')\n" . mysql_error() . "\n");
            return false;
        }

        if (!mysql_select_db($this->DBName, $this->db_Conn)) {
            if ($this->debug || (@session_start() && $_SESSION["SESS_AUTH"]["ADMIN"]))
                echo "<br><font color=#ff0000>Error! mysql_select_db(" . $this->DBName . ")</font><br>" . mysql_error($this->db_Conn) . "<br>";

            SendError("Error! mysql_select_db(" . $this->DBName . ")\n" . mysql_error($this->db_Conn) . "\n");
            return false;
        }

        $this->cntQuery = 0;
        $this->timeQuery = 0;
        $this->arQueryDebug = array();

        global $DB, $USER, $APPLICATION;
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . BX_PERSONAL_ROOT . "/php_interface/after_connect.php"))
            include($_SERVER["DOCUMENT_ROOT"] . BX_PERSONAL_ROOT . "/php_interface/after_connect.php");

        return true;
    }

    //Делает запрос к базе данных
    function Query($strSql, $bIgnoreErrors = false, $error_position = "") {
        $this->DoConnect();
        $this->db_Error = "";

        if ($this->DebugToFile || $this->ShowSqlStat) {
            list($usec, $sec) = explode(" ", microtime());
            $start_time = ((float) $usec + (float) $sec);
        }

        $result = @mysql_query($strSql, $this->db_Conn);

        if ($this->DebugToFile || $this->ShowSqlStat) {
            list($usec, $sec) = explode(" ", microtime());
            $end_time = ((float) $usec + (float) $sec);
            $exec_time = round($end_time - $start_time, 10);

            if ($this->ShowSqlStat) {
                $this->cntQuery++;
                $this->timeQuery+=$exec_time;
                $this->arQueryDebug[] = array(
                    "QUERY" => $strSql,
                    "TIME" => $exec_time,
                    "TRACE" => (function_exists("debug_backtrace") ? debug_backtrace() : false),
                    "BX_STATE" => $GLOBALS["BX_STATE"],
                );
            }

            if ($this->DebugToFile) {
                $fp = fopen($_SERVER["DOCUMENT_ROOT"] . "/mysql_debug.sql", "ab+");
                $str = "TIME: " . $exec_time . " SESSION: " . session_id() . " \n";
                $str .= $strSql . "\n\n";
                $str .= "----------------------------------------------------\n\n";
                fputs($fp, $str);
                @fclose($fp);
            }
        }

        if (!$result) {
            $this->db_Error = mysql_error();
            if (!$bIgnoreErrors) {
                AddMessage2Log($error_position . " MySql Query Error: " . $strSql . " [" . $this->db_Error . "]", "main");
                if ($this->DebugToFile) {
                    $fp = fopen($_SERVER["DOCUMENT_ROOT"] . "/mysql_debug.sql", "ab+");
                    fputs($fp, "SESSION: " . session_id() . " ERROR: " . $this->db_Error . "\n\n----------------------------------------------------\n\n");
                    @fclose($fp);
                }

                if ($this->debug || (@session_start() && $_SESSION["SESS_AUTH"]["ADMIN"]))
                    echo $error_position . "<br><font color=#ff0000>MySQL Query Error: " . htmlspecialchars($strSql) . "</font>[" . htmlspecialchars($this->db_Error) . "]<br>";

                $error_position = eregi_replace("<br>", "\n", $error_position);
                SendError($error_position . "\nMySQL Query Error:\n" . $strSql . " \n [" . $this->db_Error . "]\n---------------\n\n");

                if (file_exists($_SERVER["DOCUMENT_ROOT"] . BX_PERSONAL_ROOT . "/php_interface/dbquery_error.php"))
                    include($_SERVER["DOCUMENT_ROOT"] . BX_PERSONAL_ROOT . "/php_interface/dbquery_error.php");
                elseif (file_exists($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/dbquery_error.php"))
                    include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/dbquery_error.php");
                else
                    die("MySQL Query Error!");

                die();
            }
            return false;
        }

        $res = new CDBResult($result);
        if ($this->ShowSqlStat)
            $res->SqlTraceIndex = count($this->arQueryDebug);
        return $res;
    }

    //Делает запрос к базе данных. Для MySql больше ничего ;-)
    function QueryLong($strSql, $bIgnoreErrors = false) {
        return $this->Query($strSql, $bIgnoreErrors);
    }

    function CurrentTimeFunction() {
        return "now()";
    }

    function CurrentDateFunction() {
        return "CURRENT_DATE";
    }

    function DateFormatToDB($format, $field = false) {
        static $search = array("YYYY", "MM", "DD", "HH", "MI", "SS");
        static $replace = array("%Y", "%m", "%d", "%H", "%i", "%s");
        $format = str_replace($search, $replace, $format);
        if ($field === false) {
            return $format;
        } else {
            return "DATE_FORMAT(" . $field . ", '" . $format . "')";
        }
    }

    function DateToCharFunction($strFieldName, $strType = "FULL", $lang = false, $bSearchInSitesOnly = false) {
        static $CACHE = array();
        $id = $strType . "," . $lang . "," . $bSearchInSitesOnly;
        if (!array_key_exists($id, $CACHE))
            $CACHE[$id] = $this->DateFormatToDB(CLang::GetDateFormat($strType, $lang, $bSearchInSitesOnly));
        return "DATE_FORMAT(" . $strFieldName . ", '" . $CACHE[$id] . "')";
    }

    function CharToDateFunction($strValue, $strType = "FULL", $lang = false) {
        return "'" . CDatabase::FormatDate($strValue, CLang::GetDateFormat($strType, $lang), ($strType == "SHORT" ? "Y-M-D" : "Y-M-D H:I:S")) . "'";
    }

    //	1		если date1 > date2
    //	0		если date1 = date2
    //	-1		если date1 < date2
    function CompareDates($date1, $date2) {
        $s_date1 = $this->CharToDateFunction($date1);
        $s_date2 = $this->CharToDateFunction($date2);
        $strSql = "
			SELECT
				if($s_date1 > $s_date2, 1,
					if ($s_date1 < $s_date2, -1,
						if ($s_date1 = $s_date2, 0, 'x')
				)) as RES
			";
        $z = $this->Query($strSql, false, "FILE: " . __FILE__ . "<br> LINE: " . __LINE__);
        $zr = $z->Fetch();
        return $zr["RES"];
    }

    function LastID() {
        $this->DoConnect();
        return mysql_insert_id($this->db_Conn);
    }

    //Отсоединяется от БД
    function Disconnect() {
        if (!DBPersistent && $this->bConnected) {
            $this->bConnected = false;
            mysql_close($this->db_Conn);
        }
    }

    function PrepareFields($strTableName, $strPrefix = "str_", $strSuffix = "") {
        $this->DoConnect();
        //$db_result = $this->Query("SHOW COLUMNS FROM ".$strTableName);

        $db_result = mysql_list_fields($this->DBName, $strTableName, $this->db_Conn);
        if ($db_result > 0) {
            $intNumFields = mysql_num_fields($db_result);
            while (--$intNumFields >= 0) {
                $strFieldName = mysql_field_name($db_result, $intNumFields);
                global $$strFieldName;
                $strVarName = $strPrefix . $strFieldName . $strSuffix;
                global $$strVarName;
                switch (mysql_field_type($db_result, $intNumFields)) {
                    case "int":
                        $$strVarName = IntVal($$strFieldName);
                        break;
                    case "real":
                        $$strVarName = DoubleVal($$strFieldName);
                        break;
                    default:
                        $$strVarName = $this->ForSql($$strFieldName);
                }
            }
        }
    }

    function PrepareInsert($strTableName, $arFields, $strFileDir = "", $lang = false) {
        $this->DoConnect();
        $strInsert1 = "";
        $strInsert2 = "";

        $db_result = mysql_list_fields($this->DBName, $strTableName, $this->db_Conn);
        if ($db_result > 0) {
            $intNumFields = mysql_num_fields($db_result);
            while (--$intNumFields >= 0) {
                $strColumnName = mysql_field_name($db_result, $intNumFields);
                $value = $arFields[$strColumnName];
                if (isset($value)) {
                    /*
                      //массив может быть при сохранении файлов, тогда мы пропускаем - файлы требуют индивидуальной обработки
                      if(is_array($value))
                      {
                      if(strlen($value["name"])>0 || strlen($value["del"])>0 || strlen($value["description"])>0)
                      {
                      $res = CFile::SaveFile($value, $strFileDir);
                      if($res!==false && strlen($strFileDir)>0)
                      {
                      $strInsert1 .= ", ".$strColumnName;
                      $strInsert2 .= ",  ".$res;
                      }
                      }
                      }

                      else
                     */
                    if ($value === false) {
                        $strInsert1 .= ", " . $strColumnName;
                        $strInsert2 .= ",  " . "NULL ";
                    } else {
                        $strInsert1 .= ", " . $strColumnName;
                        if (mysql_field_type($db_result, $intNumFields) == "datetime") {
                            if (strlen($value) <= 0)
                                $strInsert2 .= ", NULL ";
                            else
                                $strInsert2 .= ", '" . $this->FormatDate($value, CLang::GetDateFormat("FULL", $lang), "Y-M-D H:I:S") . "'";
                        }
                        elseif (mysql_field_type($db_result, $intNumFields) == "date") {
                            if (strlen($value) <= 0)
                                $strInsert2 .= ", NULL ";
                            else
                                $strInsert2 .= ", '" . $this->FormatDate($value, CLang::GetDateFormat("SHORT", $lang), "Y-M-D") . "'";
                        }
                        else {
                            switch (mysql_field_type($db_result, $intNumFields)) {
                                case "int":
                                    $value = IntVal($value);
                                    break;
                                case "real":
                                    $value = DoubleVal($value);
                                    break;
                                default:
                                    $value = $this->ForSql($value);
                            }
                            $strInsert2 .= ", '" . $value . "'";
                        }
                    }
                } elseif (is_set($arFields, "~" . $strColumnName)) {
                    $strInsert1 .= ", " . $strColumnName;
                    $strInsert2 .= ", " . $arFields["~" . $strColumnName];
                }
            }
        }

        if ($strInsert1 != "") {
            $strInsert1 = substr($strInsert1, 2);
            $strInsert2 = substr($strInsert2, 2);
        }
        return array($strInsert1, $strInsert2);
    }

    function PrepareUpdate($strTableName, $arFields, $strFileDir = "", $lang = false) {
        return $this->PrepareUpdateBind($strTableName, $arFields, $strFileDir, $lang, $arBinds);
    }

    function PrepareUpdateBind($strTableName, $arFields, $strFileDir, $lang, &$arBinds) {
        $this->DoConnect();
        $arBinds = array();
        $strUpdate = "";

        $db_result = mysql_list_fields($this->DBName, $strTableName, $this->db_Conn);
        if ($db_result > 0) {
            $intNumFields = mysql_num_fields($db_result);
            while (--$intNumFields >= 0) {
                $strColumnName = mysql_field_name($db_result, $intNumFields);
                $value = $arFields[$strColumnName];
                if (isset($value)) {
                    /*
                      //массив может быть при сохранении файлов, тогда мы пропускаем - файлы требуют индивидуальной обработки
                      if(is_array($value))
                      {
                      if(strlen($value["name"])>0 || strlen($value["del"])>0 || is_set($value, "description"))
                      {
                      $res = CFile::SaveFile($value, $strFileDir);
                      if($res!==false && strlen($strFileDir)>0)
                      $strUpdate .= ", ".$strColumnName." = ".$res;
                      }
                      }
                      else
                     */
                    if ($value === false) {
                        $strUpdate .= ", " . $strColumnName . " = NULL";
                    } else {
                        switch (mysql_field_type($db_result, $intNumFields)) {
                            case "int":
                                $value = IntVal($value);
                                break;
                            case "real":
                                $value = DoubleVal($value);
                                break;
                            case "datetime":
                                if (strlen($value) <= 0)
                                    $value = "NULL";
                                else
                                    $value = "'" . $this->FormatDate($value, CLang::GetDateFormat("FULL", $lang), "Y-M-D H:I:S") . "'";
                                break;
                            case "date":
                                if (strlen($value) <= 0)
                                    $value = "NULL";
                                else
                                    $value = "'" . $this->FormatDate($value, CLang::GetDateFormat("SHORT", $lang), "Y-M-D") . "'";
                                break;
                            default:
                                $value = "'" . $this->ForSql($value) . "'";
                        }
                        $strUpdate .= ", " . $strColumnName . " = " . $value;
                    }
                }
                elseif (is_set($arFields, "~" . $strColumnName)) {
                    $strUpdate .= ", " . $strColumnName . " = " . $arFields["~" . $strColumnName];
                }
            }

            if ($strUpdate != "")
                $strUpdate = substr($strUpdate, 2);
        }

        return $strUpdate;
    }

    function Insert($table, $arFields, $error_position = "", $DEBUG = false, $EXIST_ID = "", $ignore_errors = false) {
        if (is_array($arFields)) {
            $str1 = "";
            $str2 = "";
            foreach ($arFields as $field => $value) {
                $str1 .= $field . ", ";
                if (strlen($value) <= 0)
                    $str2 .= "'" . $value . "', ";
                else
                    $str2 .= $value . ", ";
            }
            $str1 = TrimEx($str1, ",");
            $str2 = TrimEx($str2, ",");
            if (strlen($EXIST_ID) > 0) {
                $strSql = "INSERT INTO " . $table . "(ID," . $str1 . ") VALUES ('" . $this->ForSql($EXIST_ID) . "'," . $str2 . ")";
            } else {
                $strSql = "INSERT INTO " . $table . "(" . $str1 . ") VALUES (" . $str2 . ")";
            }
            if ($DEBUG)
                echo "<br>" . $strSql . "<br>";
            $this->Query($strSql, $ignore_errors, $error_position);
            if (strlen($EXIST_ID) > 0) {
                $ID = $EXIST_ID;
            } else {
                $ID = $this->LastID();
            }
            return $ID;
        }
        else
            return false;
    }

    function Update($table, $arFields, $WHERE = "", $error_position = "", $DEBUG = false, $ignore_errors = false, $additional_check = true) {
        $rows = 0;
        if (is_array($arFields)) {
            $str = "";
            foreach ($arFields as $field => $value) {
                if (strlen($value) <= 0)
                    $str .= $field . " = '', ";
                else
                    $str .= $field . " = " . $value . ", ";
            }
            $str = TrimEx($str, ",");
            $strSql = "UPDATE " . $table . " SET " . $str . " " . $WHERE;
            if ($DEBUG)
                echo "<br>" . $strSql . "<br>";
            $w = $this->Query($strSql, $ignore_errors, $error_position);
            $rows = $w->AffectedRowsCount();
            if ($DEBUG)
                echo "affected_rows = " . $rows . "<br>";
            if (intval($rows) <= 0 && $additional_check) {
                $w = $this->Query("SELECT 'x' FROM " . $table . " " . $WHERE, $ignore_errors, $error_position);
                if ($w->Fetch())
                    $rows = $w->SelectedRowsCount();
                if ($DEBUG)
                    echo "num_rows = " . $rows . "<br>";
            }
        }
        return $rows;
    }

    function Add($tablename, $arFields, $arCLOBFields = Array(), $strFileDir = "", $ignore_errors = false, $error_position = "") {
        global $DB;
        $arInsert = $DB->PrepareInsert($tablename, $arFields, $strFileDir);
        $strSql =
                "INSERT INTO " . $tablename . "(" . $arInsert[0] . ") " .
                "VALUES(" . $arInsert[1] . ")";
        //echo $strSql."<hr>";
        //die();
        $DB->Query($strSql, $ignore_errors, $error_position);
        return $DB->LastID();
    }

    function ForSql($strValue, $iMaxLength = 0) {
        if (!defined("BX_USE_ESCAPE_FUNC")) {
            if (function_exists("mysql_real_escape_string"))
                define("BX_USE_ESCAPE_FUNC", 1);
            else
                define("BX_USE_ESCAPE_FUNC", 2);
        }

        if ($iMaxLength > 0)
            $strValue = substr($strValue, 0, $iMaxLength);

        if (BX_USE_ESCAPE_FUNC == 1) {
            if (!is_object($this) || !$this->db_Conn) {
                global $DB;
                $DB->DoConnect();
                return mysql_real_escape_string($strValue, $DB->db_Conn);
            } else {
                $this->DoConnect();
                return mysql_real_escape_string($strValue, $this->db_Conn);
            }
        } elseif (BX_USE_ESCAPE_FUNC == 2)
            return mysql_escape_string($strValue);

        //unreachable
        return str_replace("'", "\'", str_replace("\\", "\\\\", $strValue));
    }

    function ForSqlLike($strValue, $iMaxLength = 0) {
        if (!defined("BX_USE_ESCAPE_FUNC")) {
            if (function_exists("mysql_real_escape_string"))
                define("BX_USE_ESCAPE_FUNC", 1);
            elseif (BX_USE_ESCAPE_FUNC == 2)
                define("BX_USE_ESCAPE_FUNC", 2);
        }

        if ($iMaxLength > 0)
            $strValue = substr($strValue, 0, $iMaxLength);

        if (BX_USE_ESCAPE_FUNC == 1) {
            if (!is_object($this) || !$this->db_Conn) {
                global $DB;
                $DB->DoConnect();
                return mysql_real_escape_string(str_replace("\\", "\\\\", $strValue), $DB->db_Conn);
            } else {
                $this->DoConnect();
                return mysql_real_escape_string(str_replace("\\", "\\\\", $strValue), $this->db_Conn);
            }
        }
        else
            return mysql_escape_string(str_replace("\\", "\\\\", $strValue));

        //unreachable
        return str_replace("'", "\'", str_replace("\\", "\\\\\\\\", $strValue));
    }

    function InitTableVarsForEdit($tablename, $strIdentFrom = "str_", $strIdentTo = "str_", $strSuffixFrom = "", $bAlways = false) {
        $this->DoConnect();
        $db_result = mysql_list_fields($this->DBName, $tablename, $this->db_Conn);
        if ($db_result > 0) {
            $intNumFields = mysql_num_fields($db_result);
            while (--$intNumFields >= 0) {
                $strColumnName = mysql_field_name($db_result, $intNumFields);

                $varnameFrom = $strIdentFrom . $strColumnName . $strSuffixFrom;
                $varnameTo = $strIdentTo . $strColumnName;
                global $$varnameFrom, $$varnameTo;
                if ((isset($$varnameFrom) || $bAlways)) {
                    if (is_array($$varnameFrom)) {
                        $$varnameTo = array();
                        foreach ($$varnameFrom as $k => $v)
                            $$varnameTo[$k] = htmlspecialchars($v);
                    }
                    else
                        $$varnameTo = htmlspecialchars($$varnameFrom);
                }
            }
        }
    }

    function &GetTableFieldsList($tablename) {
        $this->DoConnect();
        $arRes = array();

        $db_result = mysql_list_fields($this->DBName, $tablename, $this->db_Conn);
        if ($db_result > 0) {
            $intNumFields = mysql_num_fields($db_result);
            while (--$intNumFields >= 0) {
                $arRes[] = mysql_field_name($db_result, $intNumFields);
            }
        }

        return $arRes;
    }

    function LockTables($str) {
        register_shutdown_function(array(&$this, "UnLockTables"));
        $this->Query("LOCK TABLE " . $str);
    }

    function UnLockTables() {
        $this->Query("UNLOCK TABLES", true);
    }

    function Concat() {
        $str = "";
        $ar = func_get_args();
        if (is_array($ar))
            $str .= implode(" , ", $ar);
        if (strlen($str) > 0)
            $str = "concat(" . $str . ")";
        return $str;
    }

    function IsNull($expression, $result) {
        return "ifnull(" . $expression . ", " . $result . ")";
    }

    function Length($field) {
        return "length($field)";
    }

    function ToChar($expr, $len = 0) {
        return $expr;
    }

    function TableExists($tableName) {
        $tableName = preg_replace("/[^A-Za-z0-9%_]+/i", "", $tableName);
        $tableName = Trim($tableName);

        if (strlen($tableName) <= 0)
            return False;

        $dbResult = $this->Query("SHOW TABLES LIKE '" . $this->ForSql($tableName) . "'");
        if ($arResult = $dbResult->Fetch())
            return True;
        else
            return False;
    }

    function IndexExists($tableName, $arColumns) {
        if (!is_array($arColumns) || count($arColumns) <= 0)
            return false;

        $rs = $this->Query("SHOW INDEX FROM `" . $this->ForSql($tableName) . "`", true);
        if (!$rs)
            return false;

        $arIndexes = array();
        while ($ar = $rs->Fetch())
            $arIndexes[$ar["Key_name"]][$ar["Seq_in_index"] - 1] = $ar["Column_name"];

        $strColumns = implode(",", $arColumns);
        foreach ($arIndexes as $Key_name => $arKeyColumns) {
            ksort($arKeyColumns);
            $strKeyColumns = implode(",", $arKeyColumns);
            if (substr($strKeyColumns, 0, strlen($strColumns)) === $strColumns)
                return true;
        }

        return false;
        //echo "<pre>",htmlspecialchars(print_r($arIndexes, true)),"</pre><hR>";
    }

}

class CDBResult extends CAllDBResult {

    function CDBResult($res = NULL) {
        parent::CAllDBResult($res);
    }

    //После запроса делает выборку значений полей в массив
    function Fetch() {
        if ($this->bNavStart || $this->bFromArray) {
            if (!is_array($this->arResult))
                $res = false;
            elseif ($res = current($this->arResult))
                next($this->arResult);
        }
        elseif ($this->SqlTraceIndex) {
            list($usec, $sec) = explode(" ", microtime());
            $start_time = ((float) $usec + (float) $sec);

            if (!$this->arUserMultyFields) {
                $res = mysql_fetch_array($this->result, MYSQL_ASSOC);
            } else {
                $res = mysql_fetch_array($this->result, MYSQL_ASSOC);
                if ($res)
                    foreach ($this->arUserMultyFields as $FIELD_NAME => $flag)
                        if ($res[$FIELD_NAME])
                            $res[$FIELD_NAME] = unserialize($res[$FIELD_NAME]);
            }

            list($usec, $sec) = explode(" ", microtime());
            $end_time = ((float) $usec + (float) $sec);
            $exec_time = round($end_time - $start_time, 10);
            $GLOBALS["DB"]->arQueryDebug[$this->SqlTraceIndex - 1]["TIME"] += $exec_time;
            $GLOBALS["DB"]->timeQuery += $exec_time;
        }
        else {
            if (!$this->arUserMultyFields) {
                $res = mysql_fetch_array($this->result, MYSQL_ASSOC);
            } else {
                $res = mysql_fetch_array($this->result, MYSQL_ASSOC);
                if ($res)
                    foreach ($this->arUserMultyFields as $FIELD_NAME => $flag)
                        if ($res[$FIELD_NAME])
                            $res[$FIELD_NAME] = unserialize($res[$FIELD_NAME]);
            }
        }

        return $res;
    }

    function SelectedRowsCount() {
        if ($this->nSelectedCount !== false)
            return $this->nSelectedCount;

        return mysql_num_rows($this->result);
    }

    function AffectedRowsCount() {
        //global $DB;
        //$DB->DoConnect();
        //return mysql_affected_rows($DB->db_Conn);
        return mysql_affected_rows();
    }

    function AffectedRowsCountEx() {
        if (intval(@mysql_num_rows($this->result)) > 0)
            return 0; else
            return mysql_affected_rows();
    }

    function FieldsCount() {
        return mysql_num_fields($this->result);
    }

    function FieldName($iCol) {
        return mysql_field_name($this->result, $iCol);
    }

    function DBNavStart() {
        //общее количество записей
        $this->NavRecordCount = mysql_num_rows($this->result);
        if ($this->NavRecordCount < 1)
            return;

        if ($this->NavShowAll)
            $this->NavPageSize = $this->NavRecordCount;

        //Определяем число страниц при указанном размере страниц. Счет начиная с 1
        $this->NavPageCount = floor($this->NavRecordCount / $this->NavPageSize);
        if ($this->NavRecordCount % $this->NavPageSize > 0)
            $this->NavPageCount++;

        //Номер страницы для отображения. Отсчет начинается с 1
        $this->NavPageNomer = ($this->PAGEN < 1 || $this->PAGEN > $this->NavPageCount ? ($_SESSION[$this->SESS_PAGEN] < 1 || $_SESSION[$this->SESS_PAGEN] > $this->NavPageCount ? 1 : $_SESSION[$this->SESS_PAGEN]) : $this->PAGEN);

        //Смещение от начала RecordSet
        $NavFirstRecordShow = $this->NavPageSize * ($this->NavPageNomer - 1);
        $NavLastRecordShow = $this->NavPageSize * $this->NavPageNomer;

        if ($this->SqlTraceIndex) {
            list($usec, $sec) = explode(" ", microtime());
            $start_time = ((float) $usec + (float) $sec);
        }

        mysql_data_seek($this->result, $NavFirstRecordShow);
        $temp_arrray = array();
        for ($i = $NavFirstRecordShow; $i < $NavLastRecordShow; $i++) {
            if (($res = mysql_fetch_array($this->result, MYSQL_ASSOC))) {
                if ($this->arUserMultyFields)
                    foreach ($this->arUserMultyFields as $FIELD_NAME => $flag)
                        if ($res[$FIELD_NAME])
                            $res[$FIELD_NAME] = unserialize($res[$FIELD_NAME]);
                $temp_arrray[] = $res;
            }
            else {
                break;
            }
        }

        if ($this->SqlTraceIndex) {
            list($usec, $sec) = explode(" ", microtime());
            $end_time = ((float) $usec + (float) $sec);
            $exec_time = round($end_time - $start_time, 10);
            $GLOBALS["DB"]->arQueryDebug[$this->SqlTraceIndex - 1]["TIME"] += $exec_time;
            $GLOBALS["DB"]->timeQuery += $exec_time;
        }

        $this->arResult = $temp_arrray;
//		print_r($temp_arrray);
    }

    function NavQuery($strSql, $cnt, $arNavStartParams) {
        if (is_set($arNavStartParams, "SubstitutionFunction")) {
            $arNavStartParams["SubstitutionFunction"]($this, $strSql, $cnt, $arNavStartParams);
            return;
        }
        if (is_set($arNavStartParams, "bShowAll"))
            $bShowAll = $arNavStartParams["bShowAll"];
        else
            $bShowAll = true;

        if (is_set($arNavStartParams, "iNumPage"))
            $iNumPage = $arNavStartParams["iNumPage"];
        else
            $iNumPage = false;

        if (is_set($arNavStartParams, "bDescPageNumbering"))
            $bDescPageNumbering = $arNavStartParams["bDescPageNumbering"];
        else
            $bDescPageNumbering = false;

        $this->InitNavStartVars($arNavStartParams);
        $this->NavRecordCount = $cnt;

        if ($this->NavShowAll)
            $this->NavPageSize = $this->NavRecordCount;

        //Определяем число страниц при указанном размере страниц. Счет начиная с 1
        $this->NavPageCount = ($this->NavPageSize > 0 ? floor($this->NavRecordCount / $this->NavPageSize) : 0);
        if ($bDescPageNumbering) {
            $makeweight = ($this->NavRecordCount % $this->NavPageSize);
            if ($this->NavPageCount == 0 && $makeweight > 0)
                $this->NavPageCount = 1;

            //Номер страницы для отображения.
            //if($iNumPage===false)
            //	$this->PAGEN = $this->NavPageCount;
            $this->NavPageNomer =
                    (
                    $this->PAGEN < 1 || $this->PAGEN > $this->NavPageCount ?
                            ($_SESSION[$this->SESS_PAGEN] < 1 || $_SESSION[$this->SESS_PAGEN] > $this->NavPageCount ?
                                    $this->NavPageCount :
                                    $_SESSION[$this->SESS_PAGEN]
                            ) :
                            $this->PAGEN
                    );

            //Смещение от начала RecordSet
            $NavFirstRecordShow = 0;
            if ($this->NavPageNomer != $this->NavPageCount)
                $NavFirstRecordShow += $makeweight;

            $NavFirstRecordShow += ($this->NavPageCount - $this->NavPageNomer) * $this->NavPageSize;
            $NavLastRecordShow = $makeweight + ($this->NavPageCount - $this->NavPageNomer + 1) * $this->NavPageSize;
        }
        else {
            if ($this->NavPageSize && ($this->NavRecordCount % $this->NavPageSize > 0))
                $this->NavPageCount++;

            //Номер страницы для отображения. Отсчет начинается с 1
            $this->NavPageNomer = ($this->PAGEN < 1 || $this->PAGEN > $this->NavPageCount ? ($_SESSION[$this->SESS_PAGEN] < 1 || $_SESSION[$this->SESS_PAGEN] > $this->NavPageCount ? 1 : $_SESSION[$this->SESS_PAGEN]) : $this->PAGEN);

            //Смещение от начала RecordSet
            $NavFirstRecordShow = $this->NavPageSize * ($this->NavPageNomer - 1);
            $NavLastRecordShow = $this->NavPageSize * $this->NavPageNomer;
        }

        if (!$this->NavShowAll)
            $strSql .= " LIMIT " . $NavFirstRecordShow . ", " . ($NavLastRecordShow - $NavFirstRecordShow);

        global $DB;
        $res_tmp = $DB->Query($strSql);
        /*
          for($i=$NavFirstRecordShow; $i<$NavLastRecordShow; $i++)
          $temp_arrray[] = mysql_fetch_array($res_tmp->result, MYSQL_ASSOC);
         */

        if ($this->SqlTraceIndex) {
            list($usec, $sec) = explode(" ", microtime());
            $start_time = ((float) $usec + (float) $sec);
        }

        $temp_arrray = array();
        while ($ar = mysql_fetch_array($res_tmp->result, MYSQL_ASSOC)) {
            if ($this->arUserMultyFields)
                foreach ($this->arUserMultyFields as $FIELD_NAME => $flag)
                    if ($ar[$FIELD_NAME])
                        $ar[$FIELD_NAME] = unserialize($ar[$FIELD_NAME]);
            $temp_arrray[] = $ar;
        }

        if ($this->SqlTraceIndex) {
            list($usec, $sec) = explode(" ", microtime());
            $end_time = ((float) $usec + (float) $sec);
            $exec_time = round($end_time - $start_time, 10);
            $GLOBALS["DB"]->arQueryDebug[$this->SqlTraceIndex - 1]["TIME"] += $exec_time;
            $GLOBALS["DB"]->timeQuery += $exec_time;
        }

        $this->result = $res_tmp->result; // added for FieldsCount and other compartibility
        $this->arResult = count($temp_arrray) ? $temp_arrray : false;
        $this->nSelectedCount = $cnt;
        $this->bDescPageNumbering = $bDescPageNumbering;
        $this->bFromLimited = true;
    }

}

?>
