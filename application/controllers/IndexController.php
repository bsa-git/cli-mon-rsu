<?php

/**
 * Контроллер по умолчанию для приложения
 *
 *
 * @package    bx-azot
 * @subpackage Controller
 */
class IndexController {

    /**------------------------------------
     * Действие контроллера по умолчанию
     *
     * Вызывается через urls:
     * - /
     * - /index.php
     *
     * @return void
     */
    public function indexAction() {
        $arrMyParams = array();
        //--------------------

        //Отобразим данные
        $oView = new View_Index();
        $oView->render();

    }
}
?>