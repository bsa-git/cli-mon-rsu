<?php

/**
 * Конфигурационный файл
 *
 * @author Бескоровайный Сергей
 */
/* * =================================================================
 * Класс для конфигурации приложения
 *
 * @package    cli-azot-m5
 * @subpackage Config
 */
class myConfig {
    
    /** Bootstrap object
     * @var Bootstrap
     */
    static $Bootstrap = NULL;
    
    
    /** Data HOST
     * @var string
     */
    static $dataHost = '\\\\192.168.3.5';
    
    /** Data HOST1
     * @var string
     */
    static $dataHost1 = '\\\\192.168.3.6';
    
    /** Data HOST2
     * @var string
     */
    static $dataHost2 = '\\\\192.168.3.5';

    /** Конфигурация суточных позиций
     * @var array
     */
    static $arrDayTags = array();

    /* Конфигурация текущих позиций
     * @var array
     */
    static $arrCurrentTags = array();
    
    /* Конфигурация текущих тестовых позиций
     * и диапазон их рабочих значений
     * @var array
     */
    static $arrCurrentTest_Tags = array();
    
    /* Конфигурация текущих позиций
     * для базы данных в таблице "tags"
     * @var array
     */
    static $arrCurrentDB_Tags = array();

    /** Конфигурация настроек баз данных
     * @var array
     */
    static $arrDB = array(
        'dbMySQL' => array(
            //Host
            'host' => 'localhost',
            // Имя пользователя
            'username' => 'root',
            // Пароль пользователя
            'password' => 'admin',
            // Имя базы
            'dbname' => 'hist_m5'
        ),
        'dbSQLite' => array(
            //Host
            'host' => "/www_m5/db_data/hist_m5.db",
            'host2' => "/www_m5/db_data2/hist_m5.db",
            'host_test' => "/test/db/hist_m5.db",
        ),
        'odbcDay' => array(
            // User Data Source Name
            'dsn' => 'rtp_day_hist00',
            // Сервер
            'server' => '52AW00',
            // Тип базы данных
            'dbtype' => 'Sample',
            // Имя базы
            'dbname' => 'hist00',
            // Имя пользователя
            'username' => '',
            // Пароль пользователя
            'password' => ''
        ),
        'odbcCurrent' => array(
            // User Data Source Name
            'dsn' => 'rtp_current_hist00',
            // Сервер
            'server' => '52AW00',
            // Тип базы данных
            'dbtype' => 'Sample',
            // Имя базы
            'dbname' => 'hist00',
            // Имя пользователя
            'username' => '',
            // Пароль пользователя
            'password' => ''
        ),
        'odbcDay1' => array(
            // User Data Source Name
            'dsn' => 'rtp_day_hist01',
            // Сервер
            'server' => '52AW01',
            // Тип базы данных
            'dbtype' => 'Sample',
            // Имя базы
            'dbname' => 'hist01',
            // Имя пользователя
            'username' => '',
            // Пароль пользователя
            'password' => ''
        ),
        'odbcCurrent1' => array(
            // User Data Source Name
            'dsn' => 'rtp_current_hist01',
            // Сервер
            'server' => '52AW01',
            // Тип базы данных
            'dbtype' => 'Sample',
            // Имя базы
            'dbname' => 'hist01',
            // Имя пользователя
            'username' => '',
            // Пароль пользователя
            'password' => ''
        ),
        'odbcDay2' => array(
            // User Data Source Name
            'dsn' => 'rtp_day_hist01',
            // Сервер
            'server' => '51AW01',
            // Тип базы данных
            'dbtype' => 'Sample',
            // Имя базы
            'dbname' => '51hs01',
            // Имя пользователя
            'username' => '',
            // Пароль пользователя
            'password' => ''
        ),
        'odbcCurrent2' => array(
            // User Data Source Name
            'dsn' => 'rtp_current_hist01',
            // Сервер
            'server' => '51AW01',
            // Тип базы данных
            'dbtype' => 'Sample',
            // Имя базы
            'dbname' => '51hs01',
            // Имя пользователя
            'username' => '',
            // Пароль пользователя
            'password' => ''
        )
    );
    

    /** Конфигурация настроек системы
     * @var array
     */
    static $arrSystem = array(
        "db_type" => "sqlite", //mysql, sqlite
        //Режим отладки
        "debug" => 1,
        //Работа в командной строке
        "cmd" => 0,
        //Кол. дней для данных в базе данных
        "maxDayData" => 1,
        "maxCurrentData" => 2,
        // Признак сохранения данных в файлах
        "isSaveToFile" => true,
        // Признак сохранения данных в DB
        "isSaveToDB" => true,
        // Кол. файлов в директории
        "maxFiles" => 10,
        // Директория для WEB
        "www_dir" => "/www_m5/m5_data",
        "www_dir2" => "/www_m5/m5_data2",
        "www_dir_test" => "/test/upload",
        // Имя файла для остановки скрипта
        "name_file_stop" => "stop.txt",
        // Имя файла признака запуска скрипта
        "name_file_start" => "start.txt",
        // Количество циклов выполнения программы
        // по ошибке (0-выход по ошибке, -1-бесконечный цикл, n-кол.циклов)
        "count_error_cycle" => 3,
        // Кол. лог файлов в директории
        "maxLogFiles" => 10,
        // Максимальное кол. памяти (в Мб.), используемое скриптом
        // при циклическом повторении в результате ошибки
        "maxMemoryUsage" => 10,
        // Задержка получения текущих данных в цикле
        "delay_cycle" => 15, //sec
        "delay_cycle_test" => 10, //sec
        
    );
    
    /** Аргументы при обращении к скрипту
     * @var array
     */
    static $arrArguments = array();
    
    /** 
     * Получить задержку цикла
     * @var int
     */
    static function getDelayCycle() {
        if(myConfig::$arrArguments["test"]){
            return myConfig::$arrSystem["delay_cycle_test"];
        } else {
            return myConfig::$arrSystem["delay_cycle"];
        }
    }
        

}

?>