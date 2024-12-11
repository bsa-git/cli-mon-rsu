<?php

/**
 * View ��� day_data �������� ����������� Hist
 *
 *
 * @package    cli-azot-m5
 * @subpackage View
 */
class View_HistDayData {

    private  $arrHistDayDataObj;
    private  $arrDayDataObj;
    /**--------------------------------
     * �����������
     *
     * @param  array $aParams   //����� ����������
     * @return IndexView        //������ ������ -> IndexView
     */
    function __construct(array $aParams = null,array $aParams2 = null) {
        $this->arrHistDayDataObj = $aParams;
        $this->arrDayDataObj = $aParams2;
    }

    /**------------------------------------
     * ���������� ������
     *
     * @return  string
     */
    public function render() {
        $LFCR = "\r\n";
        $tag = "";
        //--------------------
        //������� ��� ��������� �������
        foreach($this->arrHistDayDataObj as $oObject) {
            if($oObject->source != $tag){
                $tag = $oObject->source;
                sysBox::printTXT($LFCR."Daily data for tag - '$tag'".$LFCR);
                //echo $LFCR."�������� ������ ��� ������� - '$tag'".$LFCR;
            }
            echo $oObject->time." - ".$oObject->value.$LFCR;

        }

        //�������� ���. � ����������� ������� � ���. ����
        $debug = myConfig::$arrSystem["debug"];
        if($debug){

            //������� �������� ���. �����
            $logFile = strBox::getNameLogFileXML("HistDayData");

            //������� �������� ������� � ���� ����������� �������
            $arrHistDayData = sysBox::ArrObjects2ArrKeysValues($this->arrHistDayDataObj);
            $arrDayData = sysBox::ArrObjects2ArrKeysValues($this->arrDayDataObj);

            //������� ����� �� ������� �������� ������
            $arrTime = strBox::getDateTimePeriod("day");
            $time = $arrTime["date_min"];
            
            //�������� ������ � ���. �����
            $myParams = array(
                "title"=>"�������� �������� ������ �� ������� � ��������� �� � ���� ������",
                "result"=>1,
                "message"=>"OK...�������� ������ �������� ��  ($time)",
                "template"=>"histdata1.xml",
                "rowdata"=>$arrDayData,
                "histdata"=>$arrHistDayData,
                "log_file"=>$logFile);
            strBox::saveResultXML2Log($myParams);
        }
    }
}
?>
