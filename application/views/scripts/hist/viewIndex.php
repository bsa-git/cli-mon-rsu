<?php

/**
 * View для Index действия контроллера Hist
 *
 *
 * @package    cli-azot-m5
 * @subpackage View
 */
class View_HistIndex {

    private  $_arrParams;

    /**--------------------------------
     * Конструктор
     *
     * @param  array $aParams   //Масив параметров
     * @return IndexView        //Обьект класса -> IndexView
     */
    function __construct(array $aParams = null) {
        $this->_arrParams = $aParams;
        //return $this;
    }

    /**------------------------------------
     * Отобразить данные
     *
     * @return  string
     */
    public function render() {
        //--------------------
        //Получим все параметры запроса
        echo 'c = hist a = index';
        
    }
}
?>
