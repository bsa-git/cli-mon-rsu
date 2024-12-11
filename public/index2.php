<?
try {
    //Определим путь к DOCUMENT_ROOT
    $rootDocument = realpath(dirname(__FILE__) . '/../');

    defined('ROOT_DOCUMENT')
            || define('ROOT_DOCUMENT', $rootDocument);

    //Вставим модуль htmbox.inc.php
    require_once($rootDocument . "/application/plugins/htmBox.inc.php");

    //Установим require_once
    htmBox::getIncludes('inc');
    myConfig::$arrSystem["cmd"] = 1;

    //==== Get params =========
    //Получим массив входных параметров
    $strParams = $_SERVER['argv'][1];
    $arrParams = array();
    parse_str($strParams, $arrParams);
    // Установим аргументы обращения к скрипту
    myConfig::$arrArguments = $arrParams;

    //Действия при загрузке
    $bootstrap = new Bootstrap();
    $bootstrap->init();
    
    // Сохраним ссылку на обьект класса Bootstrap
    myConfig::$Bootstrap = $bootstrap;

    //Определим входные параметры
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

    //Установим GET параметры для действия контроллера
    sysBox::setDebugInfo("params", $arrParams);
    
    //Ввыполним действие контроллера
    sysBox::runControllMetod($controller, $action);
    
} catch (Exception $ex) {
    
    // Сохраним ошибку в логе
    strBox::saveErr2Log($ex->getMessage());
    
    // Удалим файлы управления циклом
    strBox::deleteCycleControl("stop");
    strBox::deleteCycleControl("start");
}
?>



