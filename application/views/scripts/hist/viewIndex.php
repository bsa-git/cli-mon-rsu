<?php

/**
 * View ��� Index �������� ����������� Hist
 *
 *
 * @package    cli-azot-m5
 * @subpackage View
 */
class View_HistIndex {

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
        echo 'c = hist a = index';
        
    }
}
?>
