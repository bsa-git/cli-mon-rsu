<?php

/**
 * IndexView для Index действия контроллера Index
 *
 *
 * @package    bx-azot
 * @subpackage View
 */
class View_Index {

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
        echo 'c = index a = index';
        
    }
}
?>
