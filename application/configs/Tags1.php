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
 * @subpackage Tags
 */
class Tags1 {

    /** Конфигурация суточных позиций
     * @var array
     */
    static $arrDayTags = array(
        //Суточные расходы
        "02PGAZ:02NG_FQD.OUT" => "02PGAZ_FQD",
        "02AMIAK:02JAM1_FQD.OUT" => "02JA1_FQD",
        "02AMIAK:02JAM2_FQD.OUT" => "02JA2_FQD",
        "02VODA_XOB:02UMV_FQD.OUT" => "02XOB_FQD",
        "02AMIAK:02NH3_FQDM.PNT" => "02GA_FQD",
        "02PAR:02PARF1_FQD.OUT" => "02PAR1_TON_FQD",
        "02PAR:02PARG1_FQD.OUT" => "02PAR1_GCAL_FQD",
        "02PAR:02PARF2_FQD.OUT" => "02PAR2_TON_FQD",
        "02PAR:02PARG2_FQD.OUT" => "02PAR2_GCAL_FQD",

        //PGAZ
        "02PGAZ:02PD5.PNT" => "02PGAZ_PD",
        "02PGAZ:02P5.PNT" => "02PGAZ_P",
        "02PGAZ:02T16.PNT" => "02PGAZ_T",
        "02PGAZ:02F5.PNT" => "02PGAZ_F",
        "02PGAZ:02F5_R.PNT" => "02PGAZ_R",
        "02PGAZ:02F5_CO2.PNT" => "02PGAZ_CO2",
        "02PGAZ:02F5_N2.PNT" => "02PGAZ_N2",
        "02VOZD:02P10A.PNT" => "02PBAR",
        "02PGAZ:02F5M.PNT" => "02PGAZ_FM"
    );

    /* Конфигурация текущих позиций
     * @var array
     */
    static $arrCurrentTags = array(
        //============ OC =========//
        //NH3
        "02AMIAK:02P4_1.PNT" => "02NH3_P4",
        "02AMIAK:02F4.PNT" => "02NH3_F4",
        "02AMIAK:02T4.PNT" => "02NH3_T4",
        //PGAZ
        "02PGAZ:02P5.PNT" => "02PGAZ_P5",
        "02PGAZ:02T16.PNT" => "02PGAZ_T16",
        "02PGAZ:02F5.PNT" => "02PGAZ_F5",
        "02PGAZ:02F5_R.PNT" => "02PGAZ_R",
        "02PGAZ:02F5_CO2.PNT" => "02PGAZ_CO2",
        "02PGAZ:02F5_N2.PNT" => "02PGAZ_N2",
        //JAM-1
        "02AMIAK:02T21_1.PNT" => "02JAM_T21_1",
        "02AMIAK:02P21_1.PNT" => "02JAM_P21_1",
        "02AMIAK:02F21_1.PNT" => "02JAM_F21_1",
        //JAM-2
        "02AMIAK:02T21_2.PNT" => "02JAM_T21_2",
        "02AMIAK:02P21_2.PNT" => "02JAM_P21_2",
        "02AMIAK:02F21_2.PNT" => "02JAM_F21_2",
        //PAR-1
        "02PAR:02T2_1.PNT" => "02PAR_T2_1",
        "02PAR:02P2_1.PNT" => "02PAR_P2_1",
        "02PAR:02F2_1.PNT" => "02PAR_F2_1",
        //PAR-2
        "02PAR:02T2_2.PNT" => "02PAR_T2_2",
        "02PAR:02P2_2.PNT" => "02PAR_P2_2",
        "02PAR:02F2_2.PNT" => "02PAR_F2_2",
        //PAR-(1+2)
        "02SBS_OC:02PARG_KF2.PNT" => "02PARG_KF2",
        //VODA XOB
        "02VODA_XOB:02T1.PNT" => "02XOB_T1",
        "02VODA_XOB:02P4.PNT" => "02XOB_P4",
        "02VODA_XOB:02F1.PNT" => "02XOB_F1",
        //VODA OB
        "02VODA:02T1_1.PNT" => "02OB_T1_1",
        "02VODA:02T1_2.PNT" => "02OB_T1_2",
        "02VODA:02P5_1.PNT" => "02OB_P5_1",
        //SKLAD
        "02SKLAD:01L26_SUM.PNT" => "02SKLAD_01L26",
        "02SKLAD:02L26_SUM.PNT" => "02SKLAD_02L26",
        "02SKLAD:02L26_CALSUM.RO03" => "02SKLAD_SUM",
	"02SKLAD:02HNO3_R.PNT" => "02HNO3_R",
        //7 AGRs MNG OF HNO3
        "02SBS_OC:02HNO3_7AGR.PNT" => "02HNO3_7AGR",
        //VZ KIP
        "02SBS_OC:02PS10.PNT" => "02PS10",
        //AZVS
        "02AZVS:02P17.PNT" => "02P17",
        //M9
        "02SKLAD:02F20_1.PNT" => "02HNO3_F20_1",
        "02SKLAD:02F20_2.PNT" => "02HNO3_F20_2",
        "02SKLAD:02P20_1.PNT" => "02HNO3_P20_1",
        "02SKLAD:02P20_2.PNT" => "02HNO3_P20_2",
        "02SKLAD:02P22_1.PNT" => "02HNO3_P22_1",
        "02SKLAD:02P22_2.PNT" => "02HNO3_P22_2",
        "02SKLAD:02Q20.PNT" => "02HNO3_Q20",
        "02SKLAD:02T20.PNT" => "02HNO3_T20",
        "02SKLAD:02HNO3_2_FV.PNT" => "02HNO3_F20_2_FV",
	"02SKLAD:02HNO3_1_FV.PNT" => "02HNO3_F20_1_FV",
	"02SKLAD:02HNO3_1_MNG.PNT" => "02HNO3_1_MNG",
	"02SKLAD:02HNO3_2_MNG.PNT" => "02HNO3_2_MNG",
	"02SKLAD:02T1010.PNT" => "02T1010",
	"02SKLAD:02D1010.PNT" => "02D1010",
	"02SKLAD:02Q20_1_M9.PNT" => "02Q20_1_M9",
	"02SKLAD:02T2010.PNT" => "02T2010",
	"02SKLAD:02D2010.PNT" => "02D2010",
	"02SKLAD:02Q20_2_M9.PNT" => "02Q20_2_M9",
        //============ AGR 1/2 =========//
        //PS-180
        "12SBS_AO:12PS180.PNT" => "12VZ_PS180",
        //P181
        "12GTT:12P181.PNT" => "12VZ_P181",
        //P127A
        "12KONV:12P127A.PNT" => "12VZ_P127A",
        //TS174
        "12UKST:12FCC_TS174.PNT" => "12VZ_TS174",
        //TS102
        "12KONV:12TS102PID_T.MEAS" => "12TS102",
        //F102
        "12KONV:12F102.PNT" => "12VZ_F102",
        //F103
        "12ABSOR:12F103.PNT" => "12VZ_F103",
        //F101
        "12KONV:12FC101.PNT" => "12NH3_F101",
        //F106
        "12OXG:12FC106.PNT" => "12NH3_F106",
        //F105
        "12ABSOR:12F105.PNT" => "12HNO3_F105",
        //F171
        "12UKST:12FCC_F171.PNT" => "12NG_F171",
        //EA_RD
        "12RD:12EA_RD.PNT" => "12EA_RD",

        //============ AGR 2/2 =========//
        //PS-180
        "22SBS_AO:22PS180.PNT" => "22VZ_PS180",
        //P181
        "22GTT:22P181.PNT" => "22VZ_P181",
        //P127A
        "22KONV:22P127A.PNT" => "22VZ_P127A",
        //TS174
        "22UKST:22FCC_TS174.PNT" => "22VZ_TS174",
        //TS102
        "22KONV:22TS102PID_T.MEAS" => "22TS102",
        //F102
        "22KONV:22F102.PNT" => "22VZ_F102",
        //F103
        "22ABSOR:22F103.PNT" => "22VZ_F103",
        //F101
        "22KONV:22FC101.PNT" => "22NH3_F101",
        //F106
        "22OXG:22FC106.PNT" => "22NH3_F106",
        //F105
        "22ABSOR:22F105.PNT" => "22HNO3_F105",
        //F171
        "22UKST:22FCC_F171.PNT" => "22NG_F171",
        //EA_RD
        "22RD:22EA_RD.PNT" => "22EA_RD",

        //============ AGR 3/2 =========//
        //PS-180
        "32SBS_AO:32PS180.PNT" => "32VZ_PS180",
        //P181
        "32GTT:32P181.PNT" => "32VZ_P181",
        //P127A
        "32KONV:32P127A.PNT" => "32VZ_P127A",
        //TS174
        "32UKST:32FCC_TS174.PNT" => "32VZ_TS174",
        //TS102
        "32KONV:32TS102PID_T.MEAS" => "32TS102",
        //F102
        "32KONV:32F102.PNT" => "32VZ_F102",
        //F103
        "32ABSOR:32F103.PNT" => "32VZ_F103",
        //F101
        "32KONV:32FC101.PNT" => "32NH3_F101",
        //F106
        "32OXG:32FC106.PNT" => "32NH3_F106",
        //F105
        "32ABSOR:32F105.PNT" => "32HNO3_F105",
        //F171
        "32UKST:32FCC_F171.PNT" => "32NG_F171",
        //EA_RD
        "32RD:32EA_RD.PNT" => "32EA_RD",

        //============ AGR 4/2 =========//
        //PS-180
        "42SBS_AO:42PS180.PNT" => "42VZ_PS180",
        //P181
        "42GTT:42P181.PNT" => "42VZ_P181",
        //P127A
        "42KONV:42P127A.PNT" => "42VZ_P127A",
        //TS174
        "42UKST:42FCC_TS174.PNT" => "42VZ_TS174",
        //TS102
        "42KONV:42TS102PID_T.MEAS" => "42TS102",
        //F102
        "42KONV:42F102.PNT" => "42VZ_F102",
        //F103
        "42ABSOR:42F103.PNT" => "42VZ_F103",
        //F101
        "42KONV:42FC101.PNT" => "42NH3_F101",
        //F106
        "42OXG:42FC106.PNT" => "42NH3_F106",
        //F105
        "42ABSOR:42F105.PNT" => "42HNO3_F105",
        //F171
        "42UKST:42FCC_F171.PNT" => "42NG_F171",
        //EA_RD
        "42RD:42EA_RD.PNT" => "42EA_RD",

        //============ AGR 5/2 =========//
        //PS-180
        "52SBS_AO:52PS180.PNT" => "52VZ_PS180",
        //P181
        "52GTT:52P181.PNT" => "52VZ_P181",
        //P127A
        "52KONV:52P127A.PNT" => "52VZ_P127A",
        //TS174
        "52UKST:52FCC_TS174.PNT" => "52VZ_TS174",
        //TS102
        "52KONV:52TS102PID_T.MEAS" => "52TS102",
        //F102
        "52KONV:52F102.PNT" => "52VZ_F102",
        //F103
        "52ABSOR:52F103.PNT" => "52VZ_F103",
        //F101
        "52KONV:52FC101.PNT" => "52NH3_F101",
        //F106
        "52OXG:52FC106.PNT" => "52NH3_F106",
        //F105
        "52ABSOR:52F105.PNT" => "52HNO3_F105",
        //F171
        "52UKST:52FCC_F171.PNT" => "52NG_F171",
        //EA_RD
        "52RD:52EA_RD.PNT" => "52EA_RD",

        //============ AGR 6/2 =========//
        //PS-180
        "62SBS_AO:62PS180.PNT" => "62VZ_PS180",
        //P181
        "62GTT:62P181.PNT" => "62VZ_P181",
        //P127A
        "62KONV:62P127A.PNT" => "62VZ_P127A",
        //TS174
        "62UKST:62FCC_TS174.PNT" => "62VZ_TS174",
        //TS102
        "62KONV:62TS102PID_T.MEAS" => "62TS102",
        //F102
        "62KONV:62F102.PNT" => "62VZ_F102",
        //F103
        "62ABSOR:62F103.PNT" => "62VZ_F103",
        //F101
        "62KONV:62FC101.PNT" => "62NH3_F101",
        //F106
        "62OXG:62FC106.PNT" => "62NH3_F106",
        //F105
        "62ABSOR:62F105.PNT" => "62HNO3_F105",
        //F171
        "62UKST:62FCC_F171.PNT" => "62NG_F171",
        //EA_RD
        "62RD:62EA_RD.PNT" => "62EA_RD",

        //============ AGR 7/2 =========//
        //PS-180
        "72SBS_AO:72PS180.PNT" => "72VZ_PS180",
        //P181
        "72GTT:72P181.PNT" => "72VZ_P181",
        //P127A
        "72KONV:72P127A.PNT" => "72VZ_P127A",
        //TS174
        "72UKST:72FCC_TS174.PNT" => "72VZ_TS174",
        //TS102
        "72KONV:72TS102PID_T.MEAS" => "72TS102",
        //F102
        "72KONV:72F102.PNT" => "72VZ_F102",
        //F103
        "72ABSOR:72F103.PNT" => "72VZ_F103",
        //F101
        "72KONV:72FC101.PNT" => "72NH3_F101",
        //F106
        "72OXG:72FC106.PNT" => "72NH3_F106",
        //F105
        "72ABSOR:72F105.PNT" => "72HNO3_F105",
        //F171
        "72UKST:72FCC_F171.PNT" => "72NG_F171",
        //EA_RD
        "72RD:72EA_RD.PNT" => "72EA_RD",
    );

    /* Конфигурация текущих тестовых позиций
     * и диапазон их рабочих значений
     * @var array
     */
    static $arrCurrentTest_Tags = array(
        //============ OC =========//
        //NH3
        "02NH3_T4" => array("value_unit" => "град.С", "scale_min" => 70, "scale_max" => 90),
        "02NH3_P4" => array("value_unit" => "кг/см2", "scale_min" => 2, "scale_max" => 3),
        "02NH3_F4" => array("value_unit" => "м3/ч", "scale_min" => 3000, "scale_max" => 10000),
        //PGAZ
        "02PGAZ_T16" => array("value_unit" => "град.С", "scale_min" => -5, "scale_max" => 10),
        "02PGAZ_P5" => array("value_unit" => "кг/см2", "scale_min" => 8, "scale_max" => 10),
        "02PGAZ_F5" => array("value_unit" => "м3/ч", "scale_min" => 3000, "scale_max" => 6000),
        "02PGAZ_R" => array("value_unit" => "кг/м3", "scale_min" => 0.65, "scale_max" => 1),
        "02PGAZ_CO2" => array("value_unit" => "%", "scale_min" => 0, "scale_max" => 1),
        "02PGAZ_N2" => array("value_unit" => "%", "scale_min" => 0, "scale_max" => 1),
        //JAM-1
        "02JAM_T21_1" => array("value_unit" => "град.С", "scale_min" => 0, "scale_max" => 10),
        "02JAM_P21_1" => array("value_unit" => "кг/см2", "scale_min" => 10, "scale_max" => 15), //10..15
        "02JAM_F21_1" => array("value_unit" => "т/ч", "scale_min" => 5, "scale_max" => 15),
        //JAM-2
        "02JAM_T21_2" => array("value_unit" => "град.С", "scale_min" => 0, "scale_max" => 10),
        "02JAM_P21_2" => array("value_unit" => "кг/см2", "scale_min" => 10, "scale_max" => 15),
        "02JAM_F21_2" => array("value_unit" => "т/ч", "scale_min" => 5, "scale_max" => 15),
        //PAR-1
        "02PAR_T2_1" => array("value_unit" => "град.С", "scale_min" => 200, "scale_max" => 250),
        "02PAR_P2_1" => array("value_unit" => "кг/см2", "scale_min" => 0, "scale_max" => 25),
        "02PAR_F2_1" => array("value_unit" => "т/ч", "scale_min" => 20, "scale_max" => 30),
        //PAR-2
        "02PAR_T2_2" => array("value_unit" => "град.С", "scale_min" => 200, "scale_max" => 250),
        "02PAR_P2_2" => array("value_unit" => "кг/см2", "scale_min" => 0, "scale_max" => 25),
        "02PAR_F2_2" => array("value_unit" => "т/ч", "scale_min" => 20, "scale_max" => 30),
        //PAR-(1+2)
        "02PARG_KF2" => array("value_unit" => "гкал/т", "scale_min" => 0.5, "scale_max" => 2),
        //SKLAD
        "02SKLAD_01L26" => array("value_unit" => "м3", "scale_min" => 500, "scale_max" => 800),
        "02SKLAD_02L26" => array("value_unit" => "м3", "scale_min" => 1000, "scale_max" => 1500),
        "02SKLAD_SUM" => array("value_unit" => "м3", "scale_min" => 1500, "scale_max" => 2300),
	"02HNO3_R" => array("value_unit" => "т/м3", "scale_min" => 1.25, "scale_max" => 1.35),
        //7 AGRs MNG OF HNO3
        "02HNO3_7AGR" => array("value_unit" => "т.мнг/ч", "scale_min" => 12, "scale_max" => 100),
        //VODA XOB
        "02XOB_T1" => array("value_unit" => "град.С", "scale_min" => 70, "scale_max" => 90),
        "02XOB_P4" => array("value_unit" => "кг/см2", "scale_min" => 5, "scale_max" => 8),
        "02XOB_F1" => array("value_unit" => "м3/ч", "scale_min" => 150, "scale_max" => 200),
        //VODA OB
        "02OB_T1_1" => array("value_unit" => "град.С", "scale_min" => 20, "scale_max" => 30),
        "02OB_T1_2" => array("value_unit" => "град.С", "scale_min" => 10, "scale_max" => 40),
        "02OB_P5_1" => array("value_unit" => "кг/см2", "scale_min" => 2, "scale_max" => 8),
        //VZ KIP
        "02PS10" => array("value_unit" => "кг/см2", "scale_min" => 4, "scale_max" => 10),
        //AZVS
        "02P17" => array("value_unit" => "кг/см2", "scale_min" => 4, "scale_max" => 40),
        //M9
        "02HNO3_F20_1" => array("value_unit" => "т/ч", "scale_min" => 40, "scale_max" => 70),
        "02HNO3_F20_2" => array("value_unit" => "т/ч", "scale_min" => 40, "scale_max" => 70),
        "02HNO3_P20_1" => array("value_unit" => "кг/см2", "scale_min" => 5, "scale_max" => 15),
        "02HNO3_P20_2" => array("value_unit" => "кг/см2", "scale_min" => 5, "scale_max" => 15),
        "02HNO3_P22_1" => array("value_unit" => "кг/см2", "scale_min" => 5, "scale_max" => 12),
        "02HNO3_P22_2" => array("value_unit" => "кг/см2", "scale_min" => 5, "scale_max" => 12),
        "02HNO3_Q20" => array("value_unit" => "%", "scale_min" => 55, "scale_max" => 57),
        "02HNO3_T20" => array("value_unit" => "град.С", "scale_min" => 40, "scale_max" => 47),
        "02HNO3_F20_2_FV" => array("value_unit" => "м3/ч", "scale_min" => 50, "scale_max" => 80),
	"02HNO3_F20_1_FV" => array("value_unit" => "м3/ч", "scale_min" => 50, "scale_max" => 80),
	"02HNO3_1_MNG" => array("value_unit" => "т.мнг/ч", "scale_min" => 40, "scale_max" => 80),
	"02HNO3_2_MNG" => array("value_unit" => "т.мнг/ч", "scale_min" => 40, "scale_max" => 80),
	"02T1010" => array("value_unit" => "град.С", "scale_min" => 20, "scale_max" => 50),
	"02D1010" => array("value_unit" => "т/м3", "scale_min" => 1.3, "scale_max" => 1.4),
	"02Q20_1_M9" => array("value_unit" => "%", "scale_min" => 50, "scale_max" => 58),
	"02T2010" => array("value_unit" => "град.С", "scale_min" => 20, "scale_max" => 50),
	"02D2010" => array("value_unit" => "т/м3", "scale_min" => 1.3, "scale_max" => 1.4),
	"02Q20_2_M9" => array("value_unit" => "%", "scale_min" => 50, "scale_max" => 58),
        //============ AGR 1/2 =========//
        //PS-180
        "12VZ_PS180" => array("value_unit" => "кг/см2", "scale_min" => 2, "scale_max" => 3),
        //P181
        "12VZ_P181" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //P127A
        "12VZ_P127A" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //TS174
        "12VZ_TS174" => array("value_unit" => "град.С", "scale_min" => 400, "scale_max" => 600),
        //TS102
        "12TS102" => array("value_unit" => "град.С", "scale_min" => 800, "scale_max" => 1000),
        //F102
        "12VZ_F102" => array("value_unit" => "м3/ч", "scale_min" => 40000, "scale_max" => 60000),
        //F103
        "12VZ_F103" => array("value_unit" => "м3/ч", "scale_min" => 10000, "scale_max" => 18000),
        //F101
        "12NH3_F101" => array("value_unit" => "м3/ч", "scale_min" => 5000, "scale_max" => 7000),
        //F106
        "12NH3_F106" => array("value_unit" => "м3/ч", "scale_min" => 100, "scale_max" => 140),
        //F105
        "12HNO3_F105" => array("value_unit" => "м3/ч", "scale_min" => 15, "scale_max" => 25),
        //F171
        "12NG_F171" => array("value_unit" => "м3/ч", "scale_min" => 800, "scale_max" => 1000),
        //EA_RD
        "12EA_RD" => array("value_unit" => "кВт", "scale_min" => 400, "scale_max" => 500),

        //============ AGR 2/2 =========//
        //PS-180
        "22VZ_PS180" => array("value_unit" => "кг/см2", "scale_min" => 2, "scale_max" => 3),
        //P181
        "22VZ_P181" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //P127A
        "22VZ_P127A" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //TS174
        "22VZ_TS174" => array("value_unit" => "град.С", "scale_min" => 400, "scale_max" => 600),
        //TS102
        "22TS102" => array("value_unit" => "град.С", "scale_min" => 800, "scale_max" => 1000),
        //F102
        "22VZ_F102" => array("value_unit" => "м3/ч", "scale_min" => 40000, "scale_max" => 60000),
        //F103
        "22VZ_F103" => array("value_unit" => "м3/ч", "scale_min" => 10000, "scale_max" => 18000),
        //F101
        "22NH3_F101" => array("value_unit" => "м3/ч", "scale_min" => 5000, "scale_max" => 7000),
        //F106
        "22NH3_F106" => array("value_unit" => "м3/ч", "scale_min" => 100, "scale_max" => 140),
        //F105
        "22HNO3_F105" => array("value_unit" => "м3/ч", "scale_min" => 15, "scale_max" => 25),
        //F171
        "22NG_F171" => array("value_unit" => "м3/ч", "scale_min" => 800, "scale_max" => 1000),
        //EA_RD
        "22EA_RD" => array("value_unit" => "кВт", "scale_min" => 400, "scale_max" => 500),

        //============ AGR 3/2 =========//
        //PS-180
        "32VZ_PS180" => array("value_unit" => "кг/см2", "scale_min" => 2, "scale_max" => 3),
        //P181
        "32VZ_P181" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //P127A
        "32VZ_P127A" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //TS174
        "32VZ_TS174" => array("value_unit" => "град.С", "scale_min" => 400, "scale_max" => 600),
        //TS102
        "32TS102" => array("value_unit" => "град.С", "scale_min" => 800, "scale_max" => 1000),
        //F102
        "32VZ_F102" => array("value_unit" => "м3/ч", "scale_min" => 40000, "scale_max" => 60000),
        //F103
        "32VZ_F103" => array("value_unit" => "м3/ч", "scale_min" => 10000, "scale_max" => 18000),
        //F101
        "32NH3_F101" => array("value_unit" => "м3/ч", "scale_min" => 5000, "scale_max" => 7000),
        //F106
        "32NH3_F106" => array("value_unit" => "м3/ч", "scale_min" => 100, "scale_max" => 140),
        //F105
        "32HNO3_F105" => array("value_unit" => "м3/ч", "scale_min" => 15, "scale_max" => 25),
        //F171
        "32NG_F171" => array("value_unit" => "м3/ч", "scale_min" => 800, "scale_max" => 1000),
        //EA_RD
        "32EA_RD" => array("value_unit" => "кВт", "scale_min" => 400, "scale_max" => 500),

        //============ AGR 4/2 =========//
        //PS-180
        "42VZ_PS180" => array("value_unit" => "кг/см2", "scale_min" => 2, "scale_max" => 3),
        //P181
        "42VZ_P181" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //P127A
        "42VZ_P127A" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //TS174
        "42VZ_TS174" => array("value_unit" => "град.С", "scale_min" => 400, "scale_max" => 600),
        //TS102
        "42TS102" => array("value_unit" => "град.С", "scale_min" => 800, "scale_max" => 1000),
        //F102
        "42VZ_F102" => array("value_unit" => "м3/ч", "scale_min" => 40000, "scale_max" => 60000),
        //F103
        "42VZ_F103" => array("value_unit" => "м3/ч", "scale_min" => 10000, "scale_max" => 18000),
        //F101
        "42NH3_F101" => array("value_unit" => "м3/ч", "scale_min" => 5000, "scale_max" => 7000),
        //F106
        "42NH3_F106" => array("value_unit" => "м3/ч", "scale_min" => 100, "scale_max" => 140),
        //F105
        "42HNO3_F105" => array("value_unit" => "м3/ч", "scale_min" => 15, "scale_max" => 25),
        //F171
        "42NG_F171" => array("value_unit" => "м3/ч", "scale_min" => 800, "scale_max" => 1000),
        //EA_RD
        "42EA_RD" => array("value_unit" => "кВт", "scale_min" => 400, "scale_max" => 500),

        //============ AGR 5/2 =========//
        //PS-180
        "52VZ_PS180" => array("value_unit" => "кг/см2", "scale_min" => 2, "scale_max" => 3),
        //P181
        "52VZ_P181" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //P127A
        "52VZ_P127A" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //TS174
        "52VZ_TS174" => array("value_unit" => "град.С", "scale_min" => 400, "scale_max" => 600),
        //TS102
        "52TS102" => array("value_unit" => "град.С", "scale_min" => 800, "scale_max" => 1000),
        //F102
        "52VZ_F102" => array("value_unit" => "м3/ч", "scale_min" => 40000, "scale_max" => 60000),
        //F103
        "52VZ_F103" => array("value_unit" => "м3/ч", "scale_min" => 10000, "scale_max" => 18000),
        //F101
        "52NH3_F101" => array("value_unit" => "м3/ч", "scale_min" => 5000, "scale_max" => 7000),
        //F106
        "52NH3_F106" => array("value_unit" => "м3/ч", "scale_min" => 100, "scale_max" => 140),
        //F105
        "52HNO3_F105" => array("value_unit" => "м3/ч", "scale_min" => 15, "scale_max" => 25),
        //F171
        "52NG_F171" => array("value_unit" => "м3/ч", "scale_min" => 800, "scale_max" => 1000),
        //EA_RD
        "52EA_RD" => array("value_unit" => "кВт", "scale_min" => 400, "scale_max" => 500),

        //============ AGR 6/2 =========//
        //PS-180
        "62VZ_PS180" => array("value_unit" => "кг/см2", "scale_min" => 2, "scale_max" => 3),
        //P181
        "62VZ_P181" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //P127A
        "62VZ_P127A" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //TS174
        "62VZ_TS174" => array("value_unit" => "град.С", "scale_min" => 400, "scale_max" => 600),
        //TS102
        "62TS102" => array("value_unit" => "град.С", "scale_min" => 800, "scale_max" => 1000),
        //F102
        "62VZ_F102" => array("value_unit" => "м3/ч", "scale_min" => 40000, "scale_max" => 60000),
        //F103
        "62VZ_F103" => array("value_unit" => "м3/ч", "scale_min" => 10000, "scale_max" => 18000),
        //F101
        "62NH3_F101" => array("value_unit" => "м3/ч", "scale_min" => 5000, "scale_max" => 7000),
        //F106
        "62NH3_F106" => array("value_unit" => "м3/ч", "scale_min" => 100, "scale_max" => 140),
        //F105
        "62HNO3_F105" => array("value_unit" => "м3/ч", "scale_min" => 15, "scale_max" => 25),
        //F171
        "62NG_F171" => array("value_unit" => "м3/ч", "scale_min" => 800, "scale_max" => 1000),
        //EA_RD
        "62EA_RD" => array("value_unit" => "кВт", "scale_min" => 400, "scale_max" => 500),

        //============ AGR 7/2 =========//
        //PS-180
        "72VZ_PS180" => array("value_unit" => "кг/см2", "scale_min" => 2, "scale_max" => 3),
        //P181
        "72VZ_P181" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //P127A
        "72VZ_P127A" => array("value_unit" => "кг/см2", "scale_min" => 3, "scale_max" => 7),
        //TS174
        "72VZ_TS174" => array("value_unit" => "град.С", "scale_min" => 400, "scale_max" => 600),
        //TS102
        "72TS102" => array("value_unit" => "град.С", "scale_min" => 800, "scale_max" => 1000),
        //F102
        "72VZ_F102" => array("value_unit" => "м3/ч", "scale_min" => 40000, "scale_max" => 60000),
        //F103
        "72VZ_F103" => array("value_unit" => "м3/ч", "scale_min" => 10000, "scale_max" => 18000),
        //F101
        "72NH3_F101" => array("value_unit" => "м3/ч", "scale_min" => 5000, "scale_max" => 7000),
        //F106
        "72NH3_F106" => array("value_unit" => "м3/ч", "scale_min" => 100, "scale_max" => 140),
        //F105
        "72HNO3_F105" => array("value_unit" => "м3/ч", "scale_min" => 15, "scale_max" => 25),
        //F171
        "72NG_F171" => array("value_unit" => "м3/ч", "scale_min" => 800, "scale_max" => 1000),
        //EA_RD
        "72EA_RD" => array("value_unit" => "кВт", "scale_min" => 400, "scale_max" => 500),
    );
    
    /* Конфигурация текущих позиций
     * для базы данных в таблице "tags"
     * @var array
     */
    static $arrCurrentDB_Tags = array(
        //============ OC =========//
        //NH3
        "02NH3_T4" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02NH3_T4", "name_alias" => "T NH3", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 200, "comment" => "Температура газ. NH3"),
        "02NH3_P4" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02NH3_P4", "name_alias" => "P NH3", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление газ. NH3"),
        "02NH3_F4" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02NH3_F4", "name_alias" => "F NH3", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20000, "comment" => "Расход газ. NH3"),
        //PGAZ
        "02PGAZ_T16" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02PGAZ_T16", "name_alias" => "T PGAZ", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => -50, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 50, "comment" => "Температура природного газа"),
        "02PGAZ_P5" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02PGAZ_P5", "name_alias" => "P PGAZ", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 16, "comment" => "Давление природного газа"),
        "02PGAZ_F5" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02PGAZ_F5", "name_alias" => "F PGAZ", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 12500, "comment" => "Расход природного газа"),
        //JAM-1
        "02JAM_T21_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02JAM_T21_1", "name_alias" => "T JAM-1", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => -50, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 50, "comment" => "Температура ЖА-1"),
        "02JAM_P21_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02JAM_P21_1", "name_alias" => "P JAM-1", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Давление ЖА-1"),
        "02JAM_F21_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02JAM_F21_1", "name_alias" => "F JAM-1", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "т/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Расход ЖА-1"),
        //JAM-2
        "02JAM_T21_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02JAM_T21_2", "name_alias" => "T JAM-1", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => -50, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 50, "comment" => "Температура ЖА-1"),
        "02JAM_P21_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02JAM_P21_2", "name_alias" => "P JAM-1", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Давление ЖА-1"),
        "02JAM_F21_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02JAM_F21_2", "name_alias" => "F JAM-1", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "т/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Расход ЖА-1"),
        //PAR-1
        "02PAR_T2_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02PAR_T2_1", "name_alias" => "T PAR-1", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 400, "comment" => "Температура ПАР16-1"),
        "02PAR_P2_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02PAR_P2_1", "name_alias" => "P PAR-1", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Давление ПАР16-1"),
        "02PAR_F2_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02PAR_F2_1", "name_alias" => "F PAR-1", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "т/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 80, "comment" => "Расход ПАР16-1"),
        //PAR-2
        "02PAR_T2_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02PAR_T2_2", "name_alias" => "T PAR-2", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 400, "comment" => "Температура ПАР16-2"),
        "02PAR_P2_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02PAR_P2_2", "name_alias" => "P PAR-2", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Давление ПАР16-2"),
        "02PAR_F2_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02PAR_F2_2", "name_alias" => "F PAR-2", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "т/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 80, "comment" => "Расход ПАР16-2"),
        //PAR-(1+2)
        "02PARG_KF2" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02PARG_KF2", "name_alias" => "KF PAR-1+2", "tag_param" => "KF", "name_param" => "Расход.коэф", "value_type" => "CURRENT", "value_unit" => "гкал/т", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 3, "comment" => "Расход.коэф ПАР16"),
        //SKLAD
        "02SKLAD_01L26" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02SKLAD_01L26", "name_alias" => "L SKLAD-1", "tag_param" => "L", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1000, "comment" => "Уровень HNO3 склад 1 отд."),
        "02SKLAD_02L26" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02SKLAD_02L26", "name_alias" => "L SKLAD-1", "tag_param" => "L", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1800, "comment" => "Уровень HNO3 склад 2 отд."),
        "02SKLAD_SUM" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02SKLAD_SUM", "name_alias" => "L SKLAD-1", "tag_param" => "L", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 2800, "comment" => "Уровень HNO3 склад 1,2 отд."),
	"02SKLAD_HNO3_R" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02SKLAD_HNO3_R", "name_alias" => "R HNO3", "tag_param" => "L", "name_param" => "Плотность", "value_type" => "CURRENT", "value_unit" => "т/м3", "scale_min" => 1.2, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1.4, "comment" => "Плотность HNO3 склад 2 отд."),
        //7 AGRs MNG OF HNO3
        "02HNO3_7AGR" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02HNO3_7AGR", "name_alias" => "F HNO3 1-7", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "т.мнг/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 126, "comment" => "Расход HNO3 (мнг.) 1...7 агр "),
        //M9(Кислота в цех М9)
        "02HNO3_Q20" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02HNO3_Q20", "name_alias" => "Q HNO3", "tag_param" => "Q", "name_param" => "Концентрация", "value_type" => "CURRENT", "value_unit" => "%", "scale_min" => 45, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 60, "comment" => "Концентрация HNO3 в хранилище"),
        "02HNO3_T20" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02HNO3_T20", "name_alias" => "T HNO3", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => -50, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 60, "comment" => "Температура HNO3 в хранилище"),
        "02HNO3_P20_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02HNO3_P20_1", "name_alias" => "P HNO3 20/1", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20, "comment" => "Давление HNO3 в 1 кол."),
        "02HNO3_P20_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02HNO3_P20_2", "name_alias" => "P HNO3 20/2", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20, "comment" => "Давление HNO3 в 2 кол."),
        "02HNO3_P22_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02HNO3_P22_1", "name_alias" => "P HNO3 22/1", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 16, "comment" => "Давление HNO3 в 1 кол. М9"),
        "02HNO3_P22_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02HNO3_P22_2", "name_alias" => "P HNO3 22/2", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 16, "comment" => "Давление HNO3 в 2 кол. М9"),
        "02HNO3_F20_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02HNO3_F20_1", "name_alias" => "F HNO3 20/1", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "т/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 100, "comment" => "Расход HNO3 в 1 кол."),
        "02HNO3_F20_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02HNO3_F20_2", "name_alias" => "F HNO3 20/2", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "т/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 100, "comment" => "Расход HNO3 в 2 кол."),
        "02HNO3_F20_2_FV" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02HNO3_F20_2_FV", "name_alias" => "F HNO3 20/2_V", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 100, "comment" => "Расход HNO3 в 2 кол."),
        "02HNO3_F20_1_FV" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02HNO3_F20_1_FV", "name_alias" => "F HNO3 20/1_V", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 100, "comment" => "Расход HNO3 в 1 кол."),
	"02HNO3_1_MNG" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02HNO3_1_MNG", "name_alias" => "F HNO3 20/1_MNG", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "т.мнг/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 125, "comment" => "Расход HNO3 в 1 кол."),
	"02HNO3_2_MNG" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02HNO3_2_MNG", "name_alias" => "F HNO3 20/2_MNG", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "т.мнг/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 125, "comment" => "Расход HNO3 в 2 кол."),
	"02T1010" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02T1010", "name_alias" => "T HNO3 1010", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 100, "comment" => "Температура HNO3 в 1 кол."),
	"02D1010" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02D1010", "name_alias" => "D HNO3 1010", "tag_param" => "D", "name_param" => "Плотность", "value_type" => "CURRENT", "value_unit" => "т/м3", "scale_min" => 1.3, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1.4, "comment" => "Плотность HNO3 в 1 кол."),
	"02Q20_1_M9" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02Q20_1_M9", "name_alias" => "Q HNO3 20/1", "tag_param" => "Q", "name_param" => "Концентрация", "value_type" => "CURRENT", "value_unit" => "%", "scale_min" => 45, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 60, "comment" => "Концентрация HNO3 в 1 кол."),
	"02T2010" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02T2010", "name_alias" => "T HNO3 2010", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 100, "comment" => "Температура HNO3 в 2 кол."),
	"02D2010" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02D2010", "name_alias" => "D HNO3 2010", "tag_param" => "D", "name_param" => "Плотность", "value_type" => "CURRENT", "value_unit" => "т/м3", "scale_min" => 1.3, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1.4, "comment" => "Плотность HNO3 в 2 кол."),
	"02Q20_2_M9" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02Q20_2_M9", "name_alias" => "Q HNO3 20/2", "tag_param" => "Q", "name_param" => "Концентрация", "value_type" => "CURRENT", "value_unit" => "%", "scale_min" => 45, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 60, "comment" => "Концентрация HNO3 в 2 кол."),	
	//VODA XOB
        "02XOB_T1" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02XOB_T1", "name_alias" => "T XOB", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 100, "comment" => "Температура хим.очищенной воды"),
        "02XOB_P4" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02XOB_P4", "name_alias" => "P XOB", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление хим.очищенной воды"),
        "02XOB_F1" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02XOB_F1", "name_alias" => "F XOB", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 260, "comment" => "Расход хим.очищенной воды"),
        //VODA OB
        "02OB_T1_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02OB_T1_1", "name_alias" => "T OB-1", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => -50, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 50, "comment" => "Температура оборотной воды 1"),
        "02OB_T1_2" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02OB_T1_2", "name_alias" => "T OB-2", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => -50, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 50, "comment" => "Температура Ооборотной воды 2"),
        "02OB_P5_1" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02OB_P5_1", "name_alias" => "P OB", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление оборотной воды"),
        //VZ KIP
        "02PS10" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02PS10", "name_alias" => "P VZ-KIP", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха КИП"),
        //AZVS(Азото водородная смесь в цех)
        "02P17" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "02P17", "name_alias" => "P AZVS", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 40, "comment" => "Азото водородная смесь в цех"),
        
        //============ AGR 1/2 =========//
        //PS-180
        "12VZ_PS180" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "12VZ_PS180", "name_alias" => "P VZ KOMR", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 3, "comment" => "Давление воздуха из компрессора"),
        //P181
        "12VZ_P181" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "12VZ_P181", "name_alias" => "P VZ NAGN", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха за нагнетателем"),
        //P127A
        "12VZ_P127A" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "12VZ_P127A", "name_alias" => "P VZ SMES", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха в смеситель"),
        //TS174
        "12VZ_TS174" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "12VZ_TS174", "name_alias" => "T VZ TURB", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура воздуха перед турбиной"),
        //TS102
        "12TS102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "12TS102", "name_alias" => "T SETKY", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура под сетками в КА"),
        //F102
        "12VZ_F102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "12VZ_F102", "name_alias" => "F VZ SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 60000, "comment" => "Расход воздуха в смеситель"),
        //F103
        "12VZ_F103" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "12VZ_F103", "name_alias" => "F VZ DOB", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20000, "comment" => "Расход добавочного воздуха"),
        //F101
        "12NH3_F101" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "12NH3_F101", "name_alias" => "F NH3 SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 8000, "comment" => "Расход NH3 в смеситель"),
        //F106
        "12NH3_F106" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "12NH3_F106", "name_alias" => "F NH3 PCO", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 160, "comment" => "Расход NH3 в РСО"),
        //F105
        "12HNO3_F105" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "12HNO3_F105", "name_alias" => "F HNO3", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Расход кислоты с агрегата"),
        //F171
        "12NG_F171" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "12NG_F171", "name_alias" => "F NG UKST", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 2000, "comment" => "Расход ПГ в УКСТ"),
        //EA_RD
        "12EA_RD" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "12EA_RD", "name_alias" => "VT EA RD", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "кВт", "scale_min" => -1500, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1500, "comment" => "Мощность РД"),
        
        //============ AGR 2/2 =========//
        //PS-180
        "22VZ_PS180" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "22VZ_PS180", "name_alias" => "P VZ KOMR", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 3, "comment" => "Давление воздуха из компрессора"),
        //P181
        "22VZ_P181" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "22VZ_P181", "name_alias" => "P VZ NAGN", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха за нагнетателем"),
        //P127A
        "22VZ_P127A" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "22VZ_P127A", "name_alias" => "P VZ SMES", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха в смеситель"),
        //TS174
        "22VZ_TS174" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "22VZ_TS174", "name_alias" => "T VZ TURB", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура воздуха перед турбиной"),
        //TS102
        "22TS102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "22TS102", "name_alias" => "T SETKY", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура под сетками в КА"),
        //F102
        "22VZ_F102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "22VZ_F102", "name_alias" => "F VZ SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 60000, "comment" => "Расход воздуха в смеситель"),
        //F103
        "22VZ_F103" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "22VZ_F103", "name_alias" => "F VZ DOB", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20000, "comment" => "Расход добавочного воздуха"),
        //F101
        "22NH3_F101" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "22NH3_F101", "name_alias" => "F NH3 SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 8000, "comment" => "Расход NH3 в смеситель"),
        //F106
        "22NH3_F106" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "22NH3_F106", "name_alias" => "F NH3 PCO", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 160, "comment" => "Расход NH3 в РСО"),
        //F105
        "22HNO3_F105" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "22HNO3_F105", "name_alias" => "F HNO3", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Расход кислоты с агрегата"),
        //F171
        "22NG_F171" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "22NG_F171", "name_alias" => "F NG UKST", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 2000, "comment" => "Расход ПГ в УКСТ"),
        //EA_RD
        "22EA_RD" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "22EA_RD", "name_alias" => "VT EA RD", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "кВт", "scale_min" => -1500, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1500, "comment" => "Мощность РД"),
        
        //============ AGR 3/2 =========//
        //PS-180
        "32VZ_PS180" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "32VZ_PS180", "name_alias" => "P VZ KOMR", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 3, "comment" => "Давление воздуха из компрессора"),
        //P181
        "32VZ_P181" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "32VZ_P181", "name_alias" => "P VZ NAGN", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха за нагнетателем"),
        //P127A
        "32VZ_P127A" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "32VZ_P127A", "name_alias" => "P VZ SMES", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха в смеситель"),
        //TS174
        "32VZ_TS174" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "32VZ_TS174", "name_alias" => "T VZ TURB", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура воздуха перед турбиной"),
        //TS102
        "32TS102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "32TS102", "name_alias" => "T SETKY", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура под сетками в КА"),
        //F102
        "32VZ_F102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "32VZ_F102", "name_alias" => "F VZ SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 60000, "comment" => "Расход воздуха в смеситель"),
        //F103
        "32VZ_F103" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "32VZ_F103", "name_alias" => "F VZ DOB", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20000, "comment" => "Расход добавочного воздуха"),
        //F101
        "32NH3_F101" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "32NH3_F101", "name_alias" => "F NH3 SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 8000, "comment" => "Расход NH3 в смеситель"),
        //F106
        "32NH3_F106" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "32NH3_F106", "name_alias" => "F NH3 PCO", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 160, "comment" => "Расход NH3 в РСО"),
        //F105
        "32HNO3_F105" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "32HNO3_F105", "name_alias" => "F HNO3", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Расход кислоты с агрегата"),
        //F171
        "32NG_F171" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "32NG_F171", "name_alias" => "F NG UKST", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 2000, "comment" => "Расход ПГ в УКСТ"),
        //EA_RD
        "32EA_RD" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "32EA_RD", "name_alias" => "VT EA RD", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "кВт", "scale_min" => -1500, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1500, "comment" => "Мощность РД"),
        
        //============ AGR 4/2 =========//
        //PS-180
        "42VZ_PS180" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "42VZ_PS180", "name_alias" => "P VZ KOMR", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 3, "comment" => "Давление воздуха из компрессора"),
        //P181
        "42VZ_P181" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "42VZ_P181", "name_alias" => "P VZ NAGN", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха за нагнетателем"),
        //P127A
        "42VZ_P127A" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "42VZ_P127A", "name_alias" => "P VZ SMES", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха в смеситель"),
        //TS174
        "42VZ_TS174" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "42VZ_TS174", "name_alias" => "T VZ TURB", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура воздуха перед турбиной"),
        //TS102
        "42TS102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "42TS102", "name_alias" => "T SETKY", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура под сетками в КА"),
        //F102
        "42VZ_F102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "42VZ_F102", "name_alias" => "F VZ SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 60000, "comment" => "Расход воздуха в смеситель"),
        //F103
        "42VZ_F103" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "42VZ_F103", "name_alias" => "F VZ DOB", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20000, "comment" => "Расход добавочного воздуха"),
        //F101
        "42NH3_F101" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "42NH3_F101", "name_alias" => "F NH3 SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 8000, "comment" => "Расход NH3 в смеситель"),
        //F106
        "42NH3_F106" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "42NH3_F106", "name_alias" => "F NH3 PCO", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 160, "comment" => "Расход NH3 в РСО"),
        //F105
        "42HNO3_F105" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "42HNO3_F105", "name_alias" => "F HNO3", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Расход кислоты с агрегата"),
        //F171
        "42NG_F171" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "42NG_F171", "name_alias" => "F NG UKST", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 2000, "comment" => "Расход ПГ в УКСТ"),
        //EA_RD
        "42EA_RD" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "42EA_RD", "name_alias" => "VT EA RD", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "кВт", "scale_min" => -1500, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1500, "comment" => "Мощность РД"),
        
        //============ AGR 5/2 =========//
        //PS-180
        "52VZ_PS180" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "52VZ_PS180", "name_alias" => "P VZ KOMR", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 3, "comment" => "Давление воздуха из компрессора"),
        //P181
        "52VZ_P181" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "52VZ_P181", "name_alias" => "P VZ NAGN", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха за нагнетателем"),
        //P127A
        "52VZ_P127A" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "52VZ_P127A", "name_alias" => "P VZ SMES", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха в смеситель"),
        //TS174
        "52VZ_TS174" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "52VZ_TS174", "name_alias" => "T VZ TURB", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура воздуха перед турбиной"),
        //TS102
        "52TS102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "52TS102", "name_alias" => "T SETKY", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура под сетками в КА"),
        //F102
        "52VZ_F102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "52VZ_F102", "name_alias" => "F VZ SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 60000, "comment" => "Расход воздуха в смеситель"),
        //F103
        "52VZ_F103" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "52VZ_F103", "name_alias" => "F VZ DOB", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20000, "comment" => "Расход добавочного воздуха"),
        //F101
        "52NH3_F101" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "52NH3_F101", "name_alias" => "F NH3 SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 8000, "comment" => "Расход NH3 в смеситель"),
        //F106
        "52NH3_F106" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "52NH3_F106", "name_alias" => "F NH3 PCO", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 160, "comment" => "Расход NH3 в РСО"),
        //F105
        "52HNO3_F105" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "52HNO3_F105", "name_alias" => "F HNO3", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Расход кислоты с агрегата"),
        //F171
        "52NG_F171" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "52NG_F171", "name_alias" => "F NG UKST", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 2000, "comment" => "Расход ПГ в УКСТ"),
        //EA_RD
        "52EA_RD" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "52EA_RD", "name_alias" => "VT EA RD", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "кВт", "scale_min" => -1500, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1500, "comment" => "Мощность РД"),
        
        //============ AGR 6/2 =========//
        //PS-180
        "62VZ_PS180" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "62VZ_PS180", "name_alias" => "P VZ KOMR", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 3, "comment" => "Давление воздуха из компрессора"),
        //P181
        "62VZ_P181" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "62VZ_P181", "name_alias" => "P VZ NAGN", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха за нагнетателем"),
        //P127A
        "62VZ_P127A" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "62VZ_P127A", "name_alias" => "P VZ SMES", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха в смеситель"),
        //TS174
        "62VZ_TS174" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "62VZ_TS174", "name_alias" => "T VZ TURB", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура воздуха перед турбиной"),
        //TS102
        "62TS102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "62TS102", "name_alias" => "T SETKY", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура под сетками в КА"),
        //F102
        "62VZ_F102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "62VZ_F102", "name_alias" => "F VZ SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 60000, "comment" => "Расход воздуха в смеситель"),
        //F103
        "62VZ_F103" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "62VZ_F103", "name_alias" => "F VZ DOB", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20000, "comment" => "Расход добавочного воздуха"),
        //F101
        "62NH3_F101" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "62NH3_F101", "name_alias" => "F NH3 SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 8000, "comment" => "Расход NH3 в смеситель"),
        //F106
        "62NH3_F106" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "62NH3_F106", "name_alias" => "F NH3 PCO", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 160, "comment" => "Расход NH3 в РСО"),
        //F105
        "62HNO3_F105" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "62HNO3_F105", "name_alias" => "F HNO3", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Расход кислоты с агрегата"),
        //F171
        "62NG_F171" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "62NG_F171", "name_alias" => "F NG UKST", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 2000, "comment" => "Расход ПГ в УКСТ"),
        //EA_RD
        "62EA_RD" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "62EA_RD", "name_alias" => "VT EA RD", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "кВт", "scale_min" => -1500, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1500, "comment" => "Мощность РД"),
        
        //============ AGR 7/2 =========//
        //PS-180
        "72VZ_PS180" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "72VZ_PS180", "name_alias" => "P VZ KOMR", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 3, "comment" => "Давление воздуха из компрессора"),
        //P181
        "72VZ_P181" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "72VZ_P181", "name_alias" => "P VZ NAGN", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха за нагнетателем"),
        //P127A
        "72VZ_P127A" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "72VZ_P127A", "name_alias" => "P VZ SMES", "tag_param" => "P", "name_param" => "Давление", "value_type" => "CURRENT", "value_unit" => "кг/см2", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 10, "comment" => "Давление воздуха в смеситель"),
        //TS174
        "72VZ_TS174" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "72VZ_TS174", "name_alias" => "T VZ TURB", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура воздуха перед турбиной"),
        //TS102
        "72TS102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "72TS102", "name_alias" => "T SETKY", "tag_param" => "T", "name_param" => "Температура", "value_type" => "CURRENT", "value_unit" => "град.С", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1100, "comment" => "Температура под сетками в КА"),
        //F102
        "72VZ_F102" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "72VZ_F102", "name_alias" => "F VZ SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 60000, "comment" => "Расход воздуха в смеситель"),
        //F103
        "72VZ_F103" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "72VZ_F103", "name_alias" => "F VZ DOB", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 20000, "comment" => "Расход добавочного воздуха"),
        //F101
        "72NH3_F101" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "72NH3_F101", "name_alias" => "F NH3 SMES", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 8000, "comment" => "Расход NH3 в смеситель"),
        //F106
        "72NH3_F106" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "72NH3_F106", "name_alias" => "F NH3 PCO", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 160, "comment" => "Расход NH3 в РСО"),
        //F105
        "72HNO3_F105" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "72HNO3_F105", "name_alias" => "F HNO3", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 25, "comment" => "Расход кислоты с агрегата"),
        //F171
        "72NG_F171" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "72NG_F171", "name_alias" => "F NG UKST", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "м3/ч", "scale_min" => 0, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 2000, "comment" => "Расход ПГ в УКСТ"),
        //EA_RD
        "72EA_RD" => array("topic" => "m5", "name_topic" => "Цех М-5 (II-отд.)", "alias" => "72EA_RD", "name_alias" => "VT EA RD", "tag_param" => "F", "name_param" => "Расход", "value_type" => "CURRENT", "value_unit" => "кВт", "scale_min" => -1500, "blocking_min" => NULL, "signal_min" => NULL, "signal_max" => NULL, "blocking_max" => NULL, "scale_max" => 1500, "comment" => "Мощность РД"),
    );

}

?>