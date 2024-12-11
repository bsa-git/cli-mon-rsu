<?
try {
    //��������� ���� � DOCUMENT_ROOT
    $rootDocument = realpath(dirname(__FILE__) . '/../');

    defined('ROOT_DOCUMENT')
            || define('ROOT_DOCUMENT', $rootDocument);

    //������� ������ htmbox.inc.php
    require_once($rootDocument . "/application/plugins/htmBox.inc.php");

    //��������� require_once
    htmBox::getIncludes('inc');
    myConfig::$arrSystem["cmd"] = 1;

    //==== Get params =========
    //������� ������ ������� ����������
    $strParams = $_SERVER['argv'][1];
    $arrParams = array();
    parse_str($strParams, $arrParams);
    // ��������� ��������� ��������� � �������
    myConfig::$arrArguments = $arrParams;

    //�������� ��� ��������
    $bootstrap = new Bootstrap();
    $bootstrap->init();
    
    // �������� ������ �� ������ ������ Bootstrap
    myConfig::$Bootstrap = $bootstrap;

    //��������� ������� ���������
    if (array_key_exists("c", $arrParams)) {
        $controller = $arrParams["c"];
    } else {
        $controller = 'index';
    }
    if (array_key_exists("a", $arrParams)) {
        $action = $arrParams["a"];
    } else {
        $action = 'index';
    }

    //��������� GET ��������� ��� �������� �����������
    sysBox::setDebugInfo("params", $arrParams);
    
    //��������� �������� �����������
    sysBox::runControllMetod($controller, $action);
    
} catch (Exception $ex) {
    
    // �������� ������ � ����
    strBox::saveErr2Log($ex->getMessage());
    
    // ������ ����� ���������� ������
    strBox::deleteCycleControl("stop");
    strBox::deleteCycleControl("start");
}
?>



