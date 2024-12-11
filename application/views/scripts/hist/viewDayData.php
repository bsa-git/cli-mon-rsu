<?php

/**
 * View для day_data действия контроллера Hist
 *
 *
 * @package    cli-azot-m5
 * @subpackage View
 */
class View_HistDayData {

    private  $arrHistDayDataObj;
    private  $arrDayDataObj;
    /**--------------------------------
     * Конструктор
     *
     * @param  array $aParams   //Масив параметров
     * @return IndexView        //Обьект класса -> IndexView
     */
    function __construct(array $aParams = null,array $aParams2 = null) {
        $this->arrHistDayDataObj = $aParams;
        $this->arrDayDataObj = $aParams2;
    }

    /**------------------------------------
     * Отобразить данные
     *
     * @return  string
     */
    public function render() {
        $LFCR = "\r\n";
        $tag = "";
        //--------------------
        //Получим все параметры запроса
        foreach($this->arrHistDayDataObj as $oObject) {
            if($oObject->source != $tag){
                $tag = $oObject->source;
                sysBox::printTXT($LFCR."Daily data for tag - '$tag'".$LFCR);
                //echo $LFCR."Суточные данные для позиции - '$tag'".$LFCR;
            }
            echo $oObject->time." - ".$oObject->value.$LFCR;

        }

        //Сохраним инф. о результатах запроса в лог. файл
        $debug = myConfig::$arrSystem["debug"];
        if($debug){

            //Получим название лог. файла
            $logFile = strBox::getNameLogFileXML("HistDayData");

            //Получим значения обьекта в виде двухмерного массива
            $arrHistDayData = sysBox::ArrObjects2ArrKeysValues($this->arrHistDayDataObj);
            $arrDayData = sysBox::ArrObjects2ArrKeysValues($this->arrDayDataObj);

            //Получим время за которое получены данные
            $arrTime = strBox::getDateTimePeriod("day");
            $time = $arrTime["date_min"];
            
            //Сохраним данные в лог. файле
            $myParams = array(
                "title"=>"Получить суточные данные из истории и сохранить их в базе данных",
                "result"=>1,
                "message"=>"OK...Суточные данные получены за  ($time)",
                "template"=>"histdata1.xml",
                "rowdata"=>$arrDayData,
                "histdata"=>$arrHistDayData,
                "log_file"=>$logFile);
            strBox::saveResultXML2Log($myParams);
        }
    }
}
?>
