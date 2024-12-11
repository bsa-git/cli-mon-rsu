<?php
//================ КЛАСС ДЛЯ РАБОТЫ С HTML  =========================//
/**
 * Построение HTML кода
 * Modul htmbox.inc.php Copyright @ 2010 Бескоровайный Сергей
 * @uses
 * @package BX-AZOT
 */
class htmBox {


//================= РАБОТА СО СТИЛЯМИ CSS ===================//

    /*******************************************************
     *  Получить пути к основным рабочим директориям проекта
     *
     * @param  string $aType //Тип пути для файла
     * @return string
     */
    static function getProjectPath($aType) {
        $patch="";
        //-------------------------
        //Определим путь к DOCUMENT_ROOT
        $rootDocument = realpath(dirname(__FILE__) . '/../../');

        switch ($aType) {
            case "css":
                $patch=$rootDocument."/public/css/";
                break;
            case "application":
                $patch=$rootDocument."/application/";
                break;
            case "inc":
                $patch=$rootDocument."/application/plugins/";
                break;
            case "configs":
                $patch=$rootDocument."/application/configs/";
                break;
            case "controllers":
                $patch=$rootDocument."/application/controllers/";
                break;
            case "controllers_helpers":
                $patch=$rootDocument."/application/controllers/helpers/";
                break;
            case "models":
                $patch=$rootDocument."/application/models/";
                break;
            case "db_table":
                $patch=$rootDocument."/application/models/DbTable/";
                break;
            case "dbbase":
                $patch=$rootDocument."/data/db/";
                break;
            case "views_helpers":
                $patch=$rootDocument."/application/views/helpers/";
                break;
            case "views_error":
                $patch=$rootDocument."/application/views/scripts/error/";
                break;
            case "views_index":
                $patch=$rootDocument."/application/views/scripts/index/";
                break;
            case "views_hist":
                $patch=$rootDocument."/application/views/scripts/hist/";
                break;
            case "views_test":
                $patch=$rootDocument."/application/views/scripts/test/";
                break;
            case "import":
                $patch=$rootDocument."/data/import/";
                break;
            case "export":
                $patch=$rootDocument."/data/export/";
                break;
            case "download":
                $patch=$rootDocument."/data/download/";
                break;
            case "upload":
                $patch=$rootDocument."/data/upload/";
                break;
            case "template":
                $patch=$rootDocument."/data/template/";
                break;
            case "logs":
                $patch=$rootDocument."/data/logs/";
                break;
            case "logs_test":
                $patch=$rootDocument."/test/logs/";
                break;
            case "scripts":
                $patch=$rootDocument."/data/scripts/";
                break;
            case "scripts_test":
                $patch=$rootDocument."/test/scripts/";
                break;
        }
        return $patch;
    }

    /****************************
     *  Получить ссылки на скрипты
     *
     * @param  string $aType //Тип включения
     * @return void
     */
    static function getIncludes($aType) {
        switch ($aType) {
            case "inc":
                //Inc
                require_once(self::getProjectPath('inc')."sysBox.inc.php");
                require_once(self::getProjectPath('inc')."strBox.inc.php");
                require_once(self::getProjectPath('inc')."dataBase.inc.php");
                require_once(self::getProjectPath('inc')."odbcBox.inc.php");
                require_once(self::getProjectPath('inc')."tools.inc.php");
                require_once(self::getProjectPath('inc')."pdo_database.inc.php");

                //configs
                require_once(self::getProjectPath('configs')."Config.php");
                require_once(self::getProjectPath('configs')."Tags1.php");
                require_once(self::getProjectPath('configs')."Tags2.php");

                //bootstrap
                require_once(self::getProjectPath('application')."Bootstrap.php");

                //controllers
                require_once(self::getProjectPath('controllers')."IndexController.php");
                require_once(self::getProjectPath('controllers')."HistController.php");
                require_once(self::getProjectPath('controllers')."TestController.php");

                //controllers_helpers
                require_once(self::getProjectPath('controllers_helpers')."hlpHistController.php");

                //views
                require_once(self::getProjectPath('views_helpers')."hlpViews.php");
                require_once(self::getProjectPath('views_index')."viewIndex.php");
                require_once(self::getProjectPath('views_hist')."viewIndex.php");
                require_once(self::getProjectPath('views_hist')."viewDayData.php");
                require_once(self::getProjectPath('views_hist')."viewCurrentData.php");
                require_once(self::getProjectPath('views_hist')."viewCurrentValues.php");
                require_once(self::getProjectPath('views_test')."viewIndex.php");

                //models
                require_once(self::getProjectPath('db_table')."dbCommon.php");
                require_once(self::getProjectPath('db_table')."dbDayData.php");
                require_once(self::getProjectPath('db_table')."dbCurrentData.php");
                require_once(self::getProjectPath('db_table')."dbCurrentValues.php");
                require_once(self::getProjectPath('db_table')."dbTags.php");
                require_once(self::getProjectPath('db_table')."dbHistDayData.php");
                require_once(self::getProjectPath('db_table')."dbHistCurrentData.php");
                require_once(self::getProjectPath('models')."modCurrentData.php");
                require_once(self::getProjectPath('models')."modCurrentDataMapper.php");
                require_once(self::getProjectPath('models')."modCurrentValues.php");
                require_once(self::getProjectPath('models')."modCurrentValuesMapper.php");
                require_once(self::getProjectPath('models')."modDayData.php");
                require_once(self::getProjectPath('models')."modDayDataMapper.php");
                require_once(self::getProjectPath('models')."modTags.php");
                require_once(self::getProjectPath('models')."modTagsMapper.php");
                require_once(self::getProjectPath('models')."modHistCurrentData.php");
                require_once(self::getProjectPath('models')."modHistCurrentDataMapper.php");
                require_once(self::getProjectPath('models')."modHistDayData.php");
                require_once(self::getProjectPath('models')."modHistDayDataMapper.php");
                break;
            case "inc_http":
                require_once(self::getProjectPath('inc')."httpBox.inc.php");
                break;
        }
    }
    /**************************************
     * Получить стиль CSS
     *
     * @param  string $typeCSS //Тип стиля
     * @return string
     */
    static function getScriptCSS($aTypeCSS) {
        switch ($aTypeCSS) {
            case "mystyle":
                echo "<style type='text/css'>";
                require_once(self::getProjectPath('css')."mystyle.css");
                echo "</style>";
                break;
        }

        return $css;
    }
}

?>