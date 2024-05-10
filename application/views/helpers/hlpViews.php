<?php
/**
 * Помошник создания элементов кода HTML
 *
 * @author bsa
 */
class ViewHelper_MyHtml {
    private  $_view;
    private  $_arrParams;

    /**--------------------------------
     * Конструктор
     * 
     * @param  array $aParams       //Масив параметров
     * @return ViewHelper_MyHtml    //Обьект класса -> ViewHelper_MyHtml
     */
    function __construct(array $aParams = null) {
        $this->_arrParams = $aParams;
        return $this;
    }

    /**--------------------------------
     * Создание списка со ссылками
     * @param  string $aType //Тип включения
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
            //Получим ссылку на статью
            $url = $this->_view->url( array(   'controller' => 'content',
                    'action'     => 'index'),'default',true);
            $url .= "?view=article&layout=text&id=".$id;
            //Получим элемент ссылки
            $strAList .= "<li><a href='$url' title='$link'>$link</a></li>";
        }
        $strAList .= "</ul>";
        return $strAList;
    }

    /**--------------------------------
     * Создание простого списка
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
            //Получим элемент ссылки
            $strList .= "<li><a href='' title='$link'>$link</a></li>";
        }
        $strList .= "</ul>";
        return $strList;
    }

    /**---------------------------------------------
     * Получить заголовки таблицы
     *
     * @param  string $aType //Тип заголовок таблицы
     * @param  string $aParams //Значения заголовков
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
                $table .= "<tr><th width='250'></th><th align='right'>Данные</th></tr>";
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


