<?php

/**
 * ���������������� ����
 *
 * @author ������������� ������
 */
/* * =================================================================
 * ����� ��� ������������ ����������
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

    /** ������������ �������� �������
     * @var array
     */
    static $arrDayTags = array();

    /* ������������ ������� �������
     * @var array
     */
    static $arrCurrentTags = array();
    
    /* ������������ ������� �������� �������
     * � �������� �� ������� ��������
     * @var array
     */
    static $arrCurrentTest_Tags = array();
    
    /* ������������ ������� �������
     * ��� ���� ������ � ������� "tags"
     * @var array
     */
    static $arrCurrentDB_Tags = array();

    /** ������������ �������� ��� ������
     * @var array
     */
    static $arrDB = array(
        'dbMySQL' => array(
            //Host
            'host' => 'localhost',
            // ��� ������������
            'username' => 'root',
            // ������ ������������
            'password' => 'admin',
            // ��� ����
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
            // ������
            'server' => '52AW00',
            // ��� ���� ������
            'dbtype' => 'Sample',
            // ��� ����
            'dbname' => 'hist00',
            // ��� ������������
            'username' => '',
            // ������ ������������
            'password' => ''
        ),
        'odbcCurrent' => array(
            // User Data Source Name
            'dsn' => 'rtp_current_hist00',
            // ������
            'server' => '52AW00',
            // ��� ���� ������
            'dbtype' => 'Sample',
            // ��� ����
            'dbname' => 'hist00',
            // ��� ������������
            'username' => '',
            // ������ ������������
            'password' => ''
        ),
        'odbcDay1' => array(
            // User Data Source Name
            'dsn' => 'rtp_day_hist01',
            // ������
            'server' => '52AW01',
            // ��� ���� ������
            'dbtype' => 'Sample',
            // ��� ����
            'dbname' => 'hist01',
            // ��� ������������
            'username' => '',
            // ������ ������������
            'password' => ''
        ),
        'odbcCurrent1' => array(
            // User Data Source Name
            'dsn' => 'rtp_current_hist01',
            // ������
            'server' => '52AW01',
            // ��� ���� ������
            'dbtype' => 'Sample',
            // ��� ����
            'dbname' => 'hist01',
            // ��� ������������
            'username' => '',
            // ������ ������������
            'password' => ''
        ),
        'odbcDay2' => array(
            // User Data Source Name
            'dsn' => 'rtp_day_hist01',
            // ������
            'server' => '51AW01',
            // ��� ���� ������
            'dbtype' => 'Sample',
            // ��� ����
            'dbname' => '51hs01',
            // ��� ������������
            'username' => '',
            // ������ ������������
            'password' => ''
        ),
        'odbcCurrent2' => array(
            // User Data Source Name
            'dsn' => 'rtp_current_hist01',
            // ������
            'server' => '51AW01',
            // ��� ���� ������
            'dbtype' => 'Sample',
            // ��� ����
            'dbname' => '51hs01',
            // ��� ������������
            'username' => '',
            // ������ ������������
            'password' => ''
        )
    );
    

    /** ������������ �������� �������
     * @var array
     */
    static $arrSystem = array(
        "db_type" => "sqlite", //mysql, sqlite
        //����� �������
        "debug" => 1,
        //������ � ��������� ������
        "cmd" => 0,
        //���. ���� ��� ������ � ���� ������
        "maxDayData" => 1,
        "maxCurrentData" => 2,
        // ������� ���������� ������ � ������
        "isSaveToFile" => true,
        // ������� ���������� ������ � DB
        "isSaveToDB" => true,
        // ���. ������ � ����������
        "maxFiles" => 10,
        // ���������� ��� WEB
        "www_dir" => "/www_m5/m5_data",
        "www_dir2" => "/www_m5/m5_data2",
        "www_dir_test" => "/test/upload",
        // ��� ����� ��� ��������� �������
        "name_file_stop" => "stop.txt",
        // ��� ����� �������� ������� �������
        "name_file_start" => "start.txt",
        // ���������� ������ ���������� ���������
        // �� ������ (0-����� �� ������, -1-����������� ����, n-���.������)
        "count_error_cycle" => 3,
        // ���. ��� ������ � ����������
        "maxLogFiles" => 10,
        // ������������ ���. ������ (� ��.), ������������ ��������
        // ��� ����������� ���������� � ���������� ������
        "maxMemoryUsage" => 10,
        // �������� ��������� ������� ������ � �����
        "delay_cycle" => 15, //sec
        "delay_cycle_test" => 10, //sec
        
    );
    
    /** ��������� ��� ��������� � �������
     * @var array
     */
    static $arrArguments = array();
    
    /** 
     * �������� �������� �����
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