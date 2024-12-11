<?php

/**
 * ���������� �� ��������� ��� ����������
 *
 *
 * @package    bx-azot
 * @subpackage Controller
 */
class TestController {

    /**------------------------------------
     * �������� ����������� �� ���������
     *
     * ���������� ����� urls:
     * - c=test&a=index
     *
     * @return void
     */
    public function indexAction() {

        //--------------------
        $LFCR = "\r\n";
        echo "���������� � ����� ������ �� ODBC".$LFCR;
        $link = odbc_connect("DSN=rtp_day_hist00;AP=52AW00;DB=Sample","","");
        if(!$link) {
            echo "������ ���������� ODBC".$LFCR;
            exit();
        }
        $query = "
SELECT Source, Time, Value
FROM Sample/hist00.Current
WHERE ((Source='02PGAZ:02NG_FQD.OUT') AND (Time BETWEEN {ts '2010-03-24 01:00:00'} AND {ts '2010-03-25 00:00:00'}))";
        echo "������� ������ � ���� ������ �� ODBC".$LFCR;
        echo "������ � ���� ������:".$LFCR.$query.$LFCR;
        $res=odbc_exec($link,$query);
        if(!$res) {
            echo "������ ��������� ������ ODBC".$LFCR;
            exit();
        }
        echo "������ ����������:".$LFCR;
        while($arrResult = odbc_fetch_array($res)) {
            $Source = $arrResult['Source'];
            $Time = $arrResult['Time'];
            $Value = $arrResult['Value'];
            echo "$Source  $Time  $Value".$LFCR;
        }
        echo "����� ������ ������!".$LFCR;

    }
}
?>