<?php

/**
 * IndexView ��� Index �������� ����������� Index
 *
 *
 * @package    bx-azot
 * @subpackage View
 */
class View_Index {

    private  $_arrParams;

    /**--------------------------------
     * �����������
     *
     * @param  array $aParams   //����� ����������
     * @return IndexView        //������ ������ -> IndexView
     */
    function __construct(array $aParams = null) {
        $this->_arrParams = $aParams;
        //return $this;
    }

    /**------------------------------------
     * ���������� ������
     *
     * @return  string
     */
    public function render() {
        //--------------------
        //������� ��� ��������� �������
        echo 'c = index a = index';
        
    }
}
?>
