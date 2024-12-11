<?php
/**
 * �������� �������� ��������� ���� HTML
 *
 * @author bsa
 */
class ViewHelper_MyHtml {
    private  $_view;
    private  $_arrParams;

    /**--------------------------------
     * �����������
     * 
     * @param  array $aParams       //����� ����������
     * @return ViewHelper_MyHtml    //������ ������ -> ViewHelper_MyHtml
     */
    function __construct(array $aParams = null) {
        $this->_arrParams = $aParams;
        return $this;
    }

    /**--------------------------------
     * �������� ������ �� ��������
     * @param  string $aType //��� ���������
     * @return string
     */
    public function getAList($aTitle,array $aLinks,array $aIndexes) {
        $strAList = "";
        //--------------------
        $strAList = "<h3>".$aTitle."</h3>";
        $strAList .=  "<ul>";
        $count = count($aLinks);
        for ($i = 0; $i <= $count-1; $i++) {
            $link = $aLinks[$i];
            $id = $aIndexes[$i];
            //������� ������ �� ������
            $url = $this->_view->url( array(   'controller' => 'content',
                    'action'     => 'index'),'default',true);
            $url .= "?view=article&layout=text&id=".$id;
            //������� ������� ������
            $strAList .= "<li><a href='$url' title='$link'>$link</a></li>";
        }
        $strAList .= "</ul>";
        return $strAList;
    }

    /**--------------------------------
     * �������� �������� ������
     *
     * @return string
     */
    public function getList($aTitle,array $aLinks) {
        $strList = "";
        //--------------------
        $strList = "<h3>".$aTitle."</h3>";
        $strList .=  "<ul>";
        $count = count($aLinks);
        for ($i = 0; $i <= $count-1; $i++) {
            $link = $aLinks[$i];
            //������� ������� ������
            $strList .= "<li><a href='' title='$link'>$link</a></li>";
        }
        $strList .= "</ul>";
        return $strList;
    }

    /**---------------------------------------------
     * �������� ��������� �������
     *
     * @param  string $aType //��� ��������� �������
     * @param  string $aParams //�������� ����������
     * @return string
     */
    public function getTableHeader($aType, array $aParams) {
        //-----------------
        switch ($aType) {
            case "th1":
                $table = "<table width='100%' cellspacing='0' border='1'><tr>";
                foreach($aParams as $param) {
                    $table .= "<th>$param</th>";
                }
                $table .= "</tr>";
                break;
            case "th2":
                $table = "<table width='100%' cellspacing='0' border='1'>";
                $table .= "<tr><th width='250'></th><th align='right'>������</th></tr>";
                foreach($aParams as $key=>$value) {
                    $table .= '<tr>';
                    $table .= "<th width='250'>$key</th>";
                    $table .= "<td>$value</td>";
                    $table .= "</tr>";
                }

                break;

        }

        return $table;
    }

}


