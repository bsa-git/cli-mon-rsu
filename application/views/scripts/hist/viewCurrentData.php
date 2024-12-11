<?php

/**
 * View ��� current_data �������� ����������� hist
 *
 *
 * @package    cli-azot-m5
 * @subpackage View
 */
class View_HistCurrentData {

    private  $arrObjects;

    /**--------------------------------
     * �����������
     *
     * @param  array $aParams   //����� ����������
     * @return IndexView        //������ ������ -> IndexView
     */
    function __construct(array $aParams = null,array $aParams2 = null) {
        $this->arrHistCurrentDataObj = $aParams;
        $this->arrCurrentDataObj = $aParams2;
    }

    /**------------------------------------
     * ���������� ������
     *
     * @return  string
     */
    public function render() {
//        $LFCR = "\r\n";
        $LFCR = PHP_EOL;
        $time = "";
        //--------------------
        //������� ��� ��������� �������
        foreach($this->arrHistCurrentDataObj as $oObject) {
            if($oObject->time != $time){
                $time = $oObject->time;
//                sysBox::printTXT($LFCR."Current data time - '$time'".$LFCR);
                //echo $LFCR."������� ������ �� ����� - '$time'".$LFCR;
            }
            echo $oObject->source." - ".$oObject->value.$LFCR;
        }

        //�������� ���. � ����������� ������� � ���. ����
        $debug = myConfig::$arrSystem["debug"];
        if($debug){

            //������� �������� ���. �����
            $logFile = strBox::getNameLogFileXML("HistCurrentData");

            //������� �������� ������� � ���� ����������� �������
            $arrHistCurrentData = sysBox::ArrObjects2ArrKeysValues($this->arrHistCurrentDataObj);
            $arrCurrentData = sysBox::ArrObjects2ArrKeysValues($this->arrCurrentDataObj);

            //�������� ������ � ���. �����
            $myParams = array(
                "title"=>"�������� ������� ������ �� ������� � ��������� �� � ���� ������",
                "result"=>1,
                "message"=>"OK...������� ������ �������� �� ($time)",
                "template"=>"histdata1.xml",
                "rowdata"=>$arrCurrentData,
                "histdata"=>$arrHistCurrentData,
                "log_file"=>$logFile);
            strBox::saveResultXML2Log($myParams);
        }
        
    }
}
?>
