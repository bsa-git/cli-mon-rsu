<?php

/**
 * View для current_data действия контроллера hist
 *
 *
 * @package    cli-azot-m5
 * @subpackage View
 */
class View_HistCurrentData {

    private  $arrObjects;

    /**--------------------------------
     * Конструктор
     *
     * @param  array $aParams   //Масив параметров
     * @return IndexView        //Обьект класса -> IndexView
     */
    function __construct(array $aParams = null,array $aParams2 = null) {
        $this->arrHistCurrentDataObj = $aParams;
        $this->arrCurrentDataObj = $aParams2;
    }

    /**------------------------------------
     * Отобразить данные
     *
     * @return  string
     */
    public function render() {
//        $LFCR = "\r\n";
        $LFCR = PHP_EOL;
        $time = "";
        //--------------------
        //Получим все параметры запроса
        foreach($this->arrHistCurrentDataObj as $oObject) {
            if($oObject->time != $time){
                $time = $oObject->time;
//                sysBox::printTXT($LFCR."Current data time - '$time'".$LFCR);
                //echo $LFCR."Текущие данные на время - '$time'".$LFCR;
            }
            echo $oObject->source." - ".$oObject->value.$LFCR;
        }

        //Сохраним инф. о результатах запроса в лог. файл
        $debug = myConfig::$arrSystem["debug"];
        if($debug){

            //Получим название лог. файла
            $logFile = strBox::getNameLogFileXML("HistCurrentData");

            //Получим значения обьекта в виде двухмерного массива
            $arrHistCurrentData = sysBox::ArrObjects2ArrKeysValues($this->arrHistCurrentDataObj);
            $arrCurrentData = sysBox::ArrObjects2ArrKeysValues($this->arrCurrentDataObj);

            //Сохраним данные в лог. файле
            $myParams = array(
                "title"=>"Получить текущие данные из истории и сохранить их в базе данных",
                "result"=>1,
                "message"=>"OK...Текущие данные получены за ($time)",
                "template"=>"histdata1.xml",
                "rowdata"=>$arrCurrentData,
                "histdata"=>$arrHistCurrentData,
                "log_file"=>$logFile);
            strBox::saveResultXML2Log($myParams);
        }
        
    }
}
?>
