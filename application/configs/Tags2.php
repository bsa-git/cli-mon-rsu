<?php

/**
 * Конфигурационный файл
 *
 * @author Бескоровайный Сергей
 */
/* * =================================================================
 * Класс Tags2 для позиций в истории
 *
 * @package    cli-azot-m5
 * @subpackage Tags2
 */
class Tags2 {

    /** Конфигурация суточных позиций
     * @var array
     */
    static $arrDayTags = array(
        //Суточные расходы
        "01PGAZ:01NG_FQD.OUT" => "01PGAZ_FQD",
        "01AMIAK:01JAM1_FQD.OUT" => "01JA1_FQD",
        "01AMIAK:01JAM2_FQD.OUT" => "01JA2_FQD",
        "01VODA_XOB:01UMV_FQD.OUT" => "01XOB_FQD",
        "01AMIAK:01NH3_FQDM.PNT" => "01GA_FQD",
        "01PAR:01PARF1_FQD.OUT" => "01PAR1_TON_FQD",
        "01PAR:01PARG1_FQD.OUT" => "01PAR1_GCAL_FQD",
        "01PAR:01PARF2_FQD.OUT" => "01PAR2_TON_FQD",
        "01PAR:01PARG2_FQD.OUT" => "01PAR2_GCAL_FQD",
        //PGAZ
        "01PGAZ:01PD5.PNT" => "01PGAZ_PD",
        "01PGAZ:01P5.PNT" => "01PGAZ_P",
        "01PGAZ:01T16.PNT" => "01PGAZ_T",
        "01PGAZ:01F5.PNT" => "01PGAZ_F",
        "01PGAZ:01F5_R.PNT" => "01PGAZ_R",
        "01PGAZ:01F5_CO2.PNT" => "01PGAZ_CO2",
        "01PGAZ:01F5_N2.PNT" => "01PGAZ_N2",
        "01VOZD:01P10A.PNT" => "01PBAR",
        "01PGAZ:01F5M.PNT" => "01PGAZ_FM"
    );

    /* Конфигурация текущих позиций
     * @var array
     */
    static $arrCurrentTags = array(
        //============ OC =========//
        //NH3
        "01AMIAK:01P4_1.PNT" => "01NH3_P4",
        "01AMIAK:01F4.PNT" => "01NH3_F4",
        "01AMIAK:01T4.PNT" => "01NH3_T4",
        //PGAZ
        "01PGAZ:01P5.PNT" => "01PGAZ_P5",
        "01PGAZ:01T16.PNT" => "01PGAZ_T16",
        "01PGAZ:01F5.PNT" => "01PGAZ_F5",
        //JAM-1
        "01AMIAK:01T21_1.PNT" => "01JAM_T21_1",
        "01AMIAK:01P21_1.PNT" => "01JAM_P21_1",
        "01AMIAK:01F21_1.PNT" => "01JAM_F21_1",
        //PAR-1
        "01PAR:01T2_1.PNT" => "01PAR_T2_1",
        "01PAR:01P2_1.PNT" => "01PAR_P2_1",
        "01PAR:01F2_1.PNT" => "01PAR_F2_1",
        //PAR-2
        "01PAR:01T2_2.PNT" => "01PAR_T2_2",
        "01PAR:01P2_2.PNT" => "01PAR_P2_2",
        "01PAR:01F2_2.PNT" => "01PAR_F2_2",
        //SKLAD
        "01SKLAD:01L26_SUM.PNT" => "01SKLAD_01L26",
        //VODA XOB
        "01VODA_XOB:01T1.PNT" => "01XOB_T1",
        "01VODA_XOB:01P4.PNT" => "01XOB_P4",
        "01VODA_XOB:01F1.PNT" => "01XOB_F1",
        //VODA OB
        "01VODA:01T1_1.PNT" => "01OB_T1_1",
        "01VODA:01T1_2.PNT" => "01OB_T1_2",
        "01VODA:01P5_1.PNT" => "01OB_P5_1",
        //VZ KIP
        "01SBS_OC:01PS10.PNT" => "01PS10",

        //============ AGR 2/1 =========//
        //PS-180
        "21SBS_AO:21PS180.PNT" => "21VZ_PS180",
        //P181
        "21GTT:21P181.PNT" => "21VZ_P181",
        //P127A
        "21KONV:21P127A.PNT" => "21VZ_P127A",
        //TS174
        "21UKST:21FCC_TS174.PNT" => "21VZ_TS174",
        //TS102
        "21KONV:21TS102PID_T.MEAS" => "21TS102",
        //F102
        "21KONV:21F102.PNT" => "21VZ_F102",
        //F103
        "21ABSOR:21F103.PNT" => "21VZ_F103",
        //F101
        "21KONV:21FC101.PNT" => "21NH3_F101",
        //F106
        "21OXG:21FC106.PNT" => "21NH3_F106",
        //F105
        "21ABSOR:21F105.PNT" => "21HNO3_F105",
        //F171
        "21UKST:21FCC_F171.PNT" => "21NG_F171",
        //EA_RD
        "21RD:21EA_RD.PNT" => "21EA_RD",

        //============ AGR 3/1 =========//
        //PS-180
        "31SBS_AO:31PS180.PNT" => "31VZ_PS180",
        //P181
        "31GTT:31P181.PNT" => "31VZ_P181",
        //P127A
        "31KONV:31P127A.PNT" => "31VZ_P127A",
        //TS174
        "31UKST:31FCC_TS174.PNT" => "31VZ_TS174",
        //TS102
        "31KONV:31TS102PID_T.MEAS" => "31TS102",
        //F102
        "31KONV:31F102.PNT" => "31VZ_F102",
        //F103
        "31ABSOR:31F103.PNT" => "31VZ_F103",
        //F101
        "31KONV:31FC101.PNT" => "31NH3_F101",
        //F106
        "31OXG:31FC106.PNT" => "31NH3_F106",
        //F105
        "31ABSOR:31F105.PNT" => "31HNO3_F105",
        //F171
        "31UKST:31FCC_F171.PNT" => "31NG_F171",
        //EA_RD
        "31RD:31EA_RD.PNT" => "31EA_RD",
    );

    /* Конфигурация текущих тестовых позиций
     * и диапазон их рабочих значений
     * @var array
     */
    static $arrCurrentTest_Tags = array(
        //============ OC =========//
        //NH3
        "01NH3_T4" => array("value_unit" => "град.С", "scale_min" => 70, "scale_max" => 90),
        "01NH3_P4" => array("value_unit" => "кг/см2", "scale_min" => 2, "scale_max" => 3),
        "01NH3_F4" => array("value_unit" => "м3/ч", "scale_min" => 1300, "scale_max" => 1500),
        //PGAZ
        "01PGAZ_T16" => array("value_unit" => "град.С", "scale_min" => -5, "scale_max" => 10),
        "01PGAZ_P5" => array("value_unit" => "кг/см2", "scale_min" => 8, "scale_max" => 10),
        "01PGAZ_F5" => array("value_unit" => "м3/ч", "scale_min" => 2500, "scale_max" => 3000),
        //JAM-1
        "01JAM_T21_1" => array("value_unit" => "град.С", "scale_min" => 0, "scale_max" => 10),
        "01JAM_P21_1" => array("value_unit" => "кг/см2", "scale_min" => 10, "scale_max" => 15), //10..15
        "01JAM_F21_1" => array("value_unit" => "т/ч", "scale_min" => 5, "scale_max" => 15),
        //PAR-1
        "01PAR_T2_1" => array("value_unit" => "град.С", "scale_min" => 200, "scale_max" => 250),
        "01PAR_P2_1" => array("value_unit" => "кг/см2", "scale_min" => 15, "scale_max" => 20),
        "01PAR_F2_1" => array("value_unit" => "т/ч", "scale_min" => 10, "scale_max" => 15),
        //PAR-2
        "01PAR_T2_2" => array("value_unit" => "град.С", "scale_min" => 200, "scale_max" => 250),
        "01PAR_P2_2" => array("value_unit" => "кг/см2", "scale_min" => 15, "scale_max" => 20),
        "01PAR_F2_2" => array("value_unit" => "т/ч", "scale_min" => 10, "scale_max" => 15),
        //SKLAD
        "01SKLAD_01L26" => array("value_unit" => "м3", "scale_min" => 500, "scale_max" => 800),
        //VODA XOB
        "01XOB_T1" => array("value_unit" => "град.С", "scale_min" => 70, "scale_max" => 90),
        "01XOB_P4" => array("value_unit" => "кг/см2", "scale_min" => 5, "scale_max" => 8),
        "01XOB_F1" => array("value_unit" => "м3/ч", "scale_min" => 50, "scale_max" => 80),
        //VODA OB
        "01OB_T1_1" => array("value_unit" => "град.С", "scale_min" => 20, "scale_max" => 30),
        "01OB_T1_2" => array("value_unit" => "град.С", "scale_min" => 10, "scale_max" => 40),
        "01OB_P5_1" => array("value_unit" => "кг/см2", "scale_min" => 5, "scale_max" => 8),
        //VZ KIP
        "01PS10" => array("value_unit" => "кг/см2", "scale_min" => 6, "scale_max" => 9),

        //============ AGR 2/1 =========//
        //PS-180
        "21VZ_PS180" => array("value_unit" => "кг/см2", "scale_min" => 2, "scale_max" => 3),
        //P181
        "21VZ_P181" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //P127A
        "21VZ_P127A" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //TS174
        "21VZ_TS174" => array("value_unit" => "град.С", "scale_min" => 400, "scale_max" => 600),
        //TS102
        "21TS102" => array("value_unit" => "град.С", "scale_min" => 800, "scale_max" => 1000),
        //F102
        "21VZ_F102" => array("value_unit" => "м3/ч", "scale_min" => 40000, "scale_max" => 60000),
        //F103
        "21VZ_F103" => array("value_unit" => "м3/ч", "scale_min" => 10000, "scale_max" => 18000),
        //F101
        "21NH3_F101" => array("value_unit" => "м3/ч", "scale_min" => 5000, "scale_max" => 7000),
        //F106
        "21NH3_F106" => array("value_unit" => "м3/ч", "scale_min" => 100, "scale_max" => 140),
        //F105
        "21HNO3_F105" => array("value_unit" => "м3/ч", "scale_min" => 15, "scale_max" => 25),
        //F171
        "21NG_F171" => array("value_unit" => "м3/ч", "scale_min" => 800, "scale_max" => 1000),
        //EA_RD
        "21EA_RD" => array("value_unit" => "кВт", "scale_min" => 400, "scale_max" => 500),

        //============ AGR 3/1 =========//
        //PS-180
        "31VZ_PS180" => array("value_unit" => "кг/см2", "scale_min" => 2, "scale_max" => 3),
        //P181
        "31VZ_P181" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //P127A
        "31VZ_P127A" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //TS174
        "31VZ_TS174" => array("value_unit" => "град.С", "scale_min" => 400, "scale_max" => 600),
        //TS102
        "31TS102" => array("value_unit" => "град.С", "scale_min" => 800, "scale_max" => 1000),
        //F102
        "31VZ_F102" => array("value_unit" => "м3/ч", "scale_min" => 40000, "scale_max" => 60000),
        //F103
        "31VZ_F103" => array("value_unit" => "м3/ч", "scale_min" => 10000, "scale_max" => 18000),
        //F101
        "31NH3_F101" => array("value_unit" => "м3/ч", "scale_min" => 5000, "scale_max" => 7000),
        //F106
        "31NH3_F106" => array("value_unit" => "м3/ч", "scale_min" => 100, "scale_max" => 140),
        //F105
        "31HNO3_F105" => array("value_unit" => "м3/ч", "scale_min" => 15, "scale_max" => 25),
        //F171
        "31NG_F171" => array("value_unit" => "м3/ч", "scale_min" => 800, "scale_max" => 1000),
        //EA_RD
        "31EA_RD" => array("value_unit" => "кВт", "scale_min" => 400, "scale_max" => 500),
    );
    
    /* Конфигурация текущих позиций
     * для базы данных в таблице "tags"
     * @var array
     */
    static $arrCurrentDB_Tags = array(
        //============ OC =========//
        //NH3
        "01NH3_T4" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01NH3_T4", "name_alias" => "T NH3", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 200, "comment" => "Температура газ. NH3"),
        "01NH3_P4" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01NH3_P4", "name_alias" => "P NH3", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление газ. NH3"),
        "01NH3_F4" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01NH3_F4", "name_alias" => "F NH3", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20000, "comment" => "Расход газ. NH3"),
        //PGAZ
        "01PGAZ_T16" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01PGAZ_T16", "name_alias" => "T PGAZ", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => -50, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 50, "comment" => "Температура природного газа"),
        "01PGAZ_P5" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01PGAZ_P5", "name_alias" => "P PGAZ", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 16, "comment" => "Давление природного газа"),
        "01PGAZ_F5" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01PGAZ_F5", "name_alias" => "F PGAZ", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 3200, "comment" => "Расход природного газа"),
        //JAM-1
        "01JAM_T21_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01JAM_T21_1", "name_alias" => "T JAM-1", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => -50, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 50, "comment" => "Температура ЖА-1"),
        "01JAM_P21_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01JAM_P21_1", "name_alias" => "P JAM-1", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Давление ЖА-1"),
        "01JAM_F21_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01JAM_F21_1", "name_alias" => "F JAM-1", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "т/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 16, "comment" => "Расход ЖА-1"),
        //PAR-1
        "01PAR_T2_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01PAR_T2_1", "name_alias" => "T PAR-1", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 400, "comment" => "Температура ПАР16-1"),
        "01PAR_P2_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01PAR_P2_1", "name_alias" => "P PAR-1", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Давление ПАР16-1"),
        "01PAR_F2_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01PAR_F2_1", "name_alias" => "F PAR-1", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "т/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20, "comment" => "Расход ПАР16-1"),
        //PAR-2
        "01PAR_T2_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01PAR_T2_2", "name_alias" => "T PAR-2", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 400, "comment" => "Температура ПАР16-2"),
        "01PAR_P2_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01PAR_P2_2", "name_alias" => "P PAR-2", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Давление ПАР16-2"),
        "01PAR_F2_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01PAR_F2_2", "name_alias" => "F PAR-2", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "т/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20, "comment" => "Расход ПАР16-2"),
        //SKLAD
        "01SKLAD_01L26" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01SKLAD_01L26", "name_alias" => "L SKLAD-1", "tag_param" => "L", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1000, "comment" => "Уровень HNO3 склад 1 отд."),
        //VODA XOB
        "01XOB_T1" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01XOB_T1", "name_alias" => "T XOB", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 100, "comment" => "Температура хим.очищенной воды"),
        "01XOB_P4" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01XOB_P4", "name_alias" => "P XOB", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление хим.очищенной воды"),
        "01XOB_F1" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01XOB_F1", "name_alias" => "F XOB", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 100, "comment" => "Расход хим.очищенной воды"),
        //VODA OB
        "01OB_T1_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01OB_T1_1", "name_alias" => "T OB-1", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => -50, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 50, "comment" => "Температура оборотной воды 1"),
        "01OB_T1_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01OB_T1_2", "name_alias" => "T OB-2", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => -50, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 50, "comment" => "Температура Ооборотной воды 2"),
        "01OB_P5_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01OB_P5_1", "name_alias" => "P OB", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление оборотной воды"),
        //VZ KIP
        "01PS10" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "01PS10", "name_alias" => "P VZ-KIP", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха КИП"),
        
        //============ AGR 2/1 =========//
        //PS-180
        "21VZ_PS180" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "21VZ_PS180", "name_alias" => "P VZ KOMR", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 3, "comment" => "Давление воздуха из компрессора"),
        //P181
        "21VZ_P181" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "21VZ_P181", "name_alias" => "P VZ NAGN", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха за нагнетателем"),
        //P127A
        "21VZ_P127A" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "21VZ_P127A", "name_alias" => "P VZ SMES", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха в смеситель"),
        //TS174
        "21VZ_TS174" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "21VZ_TS174", "name_alias" => "T VZ TURB", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура воздуха перед турбиной"),
        //TS102
        "21TS102" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "21TS102", "name_alias" => "T SETKY", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура под сетками в КА"),
        //F102
        "21VZ_F102" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "21VZ_F102", "name_alias" => "F VZ SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 60000, "comment" => "Расход воздуха в смеситель"),
        //F103
        "21VZ_F103" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "21VZ_F103", "name_alias" => "F VZ DOB", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20000, "comment" => "Расход добавочного воздуха"),
        //F101
        "21NH3_F101" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "21NH3_F101", "name_alias" => "F NH3 SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 8000, "comment" => "Расход NH3 в смеситель"),
        //F106
        "21NH3_F106" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "21NH3_F106", "name_alias" => "F NH3 PCO", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 160, "comment" => "Расход NH3 в РСО"),
        //F105
        "21HNO3_F105" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "21HNO3_F105", "name_alias" => "F HNO3", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Расход кислоты с агрегата"),
        //F171
        "21NG_F171" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "21NG_F171", "name_alias" => "F NG UKST", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 2000, "comment" => "Расход ПГ в УКСТ"),
        //EA_RD
        "21EA_RD" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "21EA_RD", "name_alias" => "VT EA RD", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "кВт", "scale_min" => -1500, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1500, "comment" => "Мощность РД"),
        
        //============ AGR 3/1 =========//
        //PS-180
        "31VZ_PS180" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "31VZ_PS180", "name_alias" => "P VZ KOMR", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 3, "comment" => "Давление воздуха из компрессора"),
        //P181
        "31VZ_P181" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "31VZ_P181", "name_alias" => "P VZ NAGN", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха за нагнетателем"),
        //P127A
        "31VZ_P127A" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "31VZ_P127A", "name_alias" => "P VZ SMES", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха в смеситель"),
        //TS174
        "31VZ_TS174" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "31VZ_TS174", "name_alias" => "T VZ TURB", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура воздуха перед турбиной"),
        //TS102
        "31TS102" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "31TS102", "name_alias" => "T SETKY", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура под сетками в КА"),
        //F102
        "31VZ_F102" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "31VZ_F102", "name_alias" => "F VZ SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 60000, "comment" => "Расход воздуха в смеситель"),
        //F103
        "31VZ_F103" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "31VZ_F103", "name_alias" => "F VZ DOB", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20000, "comment" => "Расход добавочного воздуха"),
        //F101
        "31NH3_F101" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "31NH3_F101", "name_alias" => "F NH3 SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 8000, "comment" => "Расход NH3 в смеситель"),
        //F106
        "31NH3_F106" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "31NH3_F106", "name_alias" => "F NH3 PCO", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 160, "comment" => "Расход NH3 в РСО"),
        //F105
        "31HNO3_F105" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "31HNO3_F105", "name_alias" => "F HNO3", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Расход кислоты с агрегата"),
        //F171
        "31NG_F171" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "31NG_F171", "name_alias" => "F NG UKST", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 2000, "comment" => "Расход ПГ в УКСТ"),
        //EA_RD
        "31EA_RD" => array("topic" => "m5", "name_topic" => "Цех М-5 (I-отд.)", "alias" => "31EA_RD", "name_alias" => "VT EA RD", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "кВт", "scale_min" => -1500, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1500, "comment" => "Мощность РД"),
    );

}

?>