<?php

/**
 * ���������� �� ��������� ��� ����������
 *
 *
 * @package    bx-azot
 * @subpackage Controller
 */
class IndexController {

    /**------------------------------------
     * �������� ����������� �� ���������
     *
     * ���������� ����� urls:
     * - /
     * - /index.php
     *
     * @return void
     */
    public function indexAction() {
        $arrMyParams = array();
        //--------------------

        //��������� ������
        $oView = new View_Index();
        $oView->render();

    }
}
?>