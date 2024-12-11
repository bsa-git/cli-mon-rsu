<?php

/**
 * ���������� ��� ��������� ������
 * �� ������� (AIM HISTORY)
 *
 *
 * @package    cli-azot-m5
 * @subpackage Controller
 */
class HistController {

    /**
     * 
     * ���. �������� ��� ������
     * @var int 
     */
    private $errorCycle = 0;

    /**
     * �������� ����������� �� ���������
     *
     * ���������� ����� urls:
     * - c=hist
     * - c=hist&a=index
     *
     * @return void
     */
    public function indexAction() {
        
    }

    /**
     * �������� ����������� �� ���������
     * �������� ������
     *
     * ���������� ����� urls:
     * - c=hist
     * - c=hist&a=day_data
     *
     * @return void
     */
    public function day_dataAction() {
        $arrObjects = array();
        //--------------------
        $datetime = date("Y-m-d H:i:s");
        sysBox::printTXT("We get daily data (time - $datetime)");

        //������ ��� ����
        sysBox::deleteLogFile("HistDayData");
        sysBox::deleteLogFile("ErrScript");

        //������� �������� ������
        $oHistDayData = new Model_HistDayData();
        $arrHistDayData = $oHistDayData->fetchTags();

        //�������� ������ � ���� ������
        $helperHistController = new Helper_HistController();
        sysBox::printTXT("Obtain data to write to DB...");
        $arrDayData = $helperHistController->getDayDataObjects($arrHistDayData);
        $count = count($arrDayData);
        sysBox::printTXT("OK... Obtained  $count records from history");

        $isSaveToFile = myConfig::$arrSystem['isSaveToFile'];

        //������ ������������� ������ � ���� ������
        $helperHistController->deleteDoubleRows_DayData($arrDayData);

        //�������� ������ � ���� ������
        sysBox::printTXT("We write the data to DB...");
        $count = 0;
        foreach ($arrDayData as $oDayData) {
            $oDayData->save();
            $count++;
        }
        sysBox::printTXT("OK... It was written $count entries to the DB");

        //��������� ���. ������� � ���� ������
        sysBox::printTXT("Limit the number records for DB...");
        $oDayData = new Model_DayData();
        $count = $oDayData->restrictRows();
        sysBox::printTXT("OK...Deleted records - $count");

        //��������� ������, ���������� � �������
        $oView = new View_HistDayData($arrHistDayData, $arrDayData);
        $oView->render();

        $datetime = date("Y-m-d H:i:s");
        sysBox::printTXT("Daily data were obtained - OK... (time - $datetime)");
    }

    /**
     * �������� ����������� �� ���������
     * ������� ������
     *
     * ���������� ����� urls:
     * - c=hist
     * - c=hist&a=current_data
     *
     * @return void
     */
    public function current_dataAction() {
        $arrObjects = array();
        //--------------------
        $datetime = date("Y-m-d H:i:s");
        sysBox::printTXT("Get current data (time - $datetime)");

        //������ ��� ����
        sysBox::deleteLogFile("HistCurrentData");
        sysBox::deleteLogFile("ErrScript");

        //������� ������� ������ �� �������
        $oHistCurrentData = new Model_HistCurrentData();
        $arrHistCurrentData = $oHistCurrentData->fetchTags();

        $helperHistController = new Helper_HistController();
        sysBox::printTXT("Obtain data to write to DB...");
        $arrCurrentData = $helperHistController->getCurrentDataObjects($arrHistCurrentData);
        $count = count($arrCurrentData);
        sysBox::printTXT("OK...Obtained  $count records from history");

        // ������� ������ � ����
        $isSaveToFile = myConfig::$arrSystem['isSaveToFile'];
        if ($isSaveToFile) {
            $filePath = Model_CurrentData::saveFile($arrCurrentData);
            sysBox::printTXT("OK...It was written $count entries to the file - '$filePath'");

            //��������� ���. ������
            $count = Model_CurrentData::restrictFiles();
            sysBox::printTXT("OK...Deleted files - $count");
        }


        $isSaveToDB = sysBox::isSaveToDB();
        if ($isSaveToDB) {
            // ������� ������ � ���� ������
            sysBox::printTXT("We write the data to DB...");
            $count = count($arrCurrentData);
            foreach ($arrCurrentData as $oCurrentData) {
                $oCurrentData->save();
            }
            sysBox::printTXT("OK...It was written $count entries to the DB");

            //��������� ���. ������� � ���� ������
            sysBox::printTXT("Limit the number records of DB...");
            $oCurrentData = new Model_CurrentData();
            $count = $oCurrentData->restrictRows();
            sysBox::printTXT("OK...Deleted records - $count");
        }

        //��������� ������
        $oView = new View_HistCurrentData($arrHistCurrentData, $arrCurrentData);
        $oView->render();

        $datetime = date("Y-m-d H:i:s");
        sysBox::printTXT("Current data were obtained - OK... (time - $datetime)");
    }

    /**
     * �������� ����������� �� ���������
     * ������� ������ � �����
     *
     * ���������� ����� urls:
     * - c=hist
     * - c=hist&a=current_data_cycle
     *
     * @return void
     */
    public function current_data_cycleAction() {
        //--------------------
//        $delay_cycle = myConfig::$arrSystem['delay_cycle'];
        $delay_cycle = myConfig::getDelayCycle();
        try {
            // ��������� ������� �� ������
            // ���� ��� �������, �� ������ �� �����
            if (strBox::isStartCycle()) {
                sysBox::printTXT("Error running the script. Unable to run two scripts simultaneously");
                return;
            } else {
                strBox::createCycleControl("start");
                strBox::deleteCycleControl("stop");
            }

            // �������� �������
            $helperHistController = new Helper_HistController();
            $oHistCurrentData = new Model_HistCurrentData();
            sysBox::printTXT("");

            while (!strBox::isStopCycle()) {
                // ������ �����
                $startTimeCycle = microtime(1);

                $datetime = date("Y-m-d H:i:s");
                sysBox::printTXT("---------------------------------------------");
                sysBox::printTXT("BEGIN GET DATA (time - $datetime)");
                sysBox::printTXT("");

                //������ ��� ����
                sysBox::deleteLogFile("HistCurrentData");
                sysBox::deleteLogFile("ErrScript");

                //������� ������� ������ �� ������� 
                if (isset(myConfig::$arrArguments["test"])) {
                    $arrHistCurrentData = $oHistCurrentData->fetchTestTags();
                } else {
                    $arrHistCurrentData = $oHistCurrentData->fetchTags('current_sec');
                }

                $arrCurrentData = $helperHistController->getCurrentDataObjects($arrHistCurrentData);
                $count = count($arrCurrentData);

                if (!$count) {
                    throw new Exception("Error reading data from the database history");
                }

                // ����� �������� ��������� ������ �� �������
                $endTimeGetHist = microtime(1);
                $timeDuration = $endTimeGetHist - $startTimeCycle;
                $timeDuration = strBox::getTimeDuration($timeDuration);
                sysBox::printTXT("OK... Received $count entries from history (timeDuration - $timeDuration)");

                // ������� ������ � ����
                $isSaveToFile = myConfig::$arrSystem['isSaveToFile'];
                if ($isSaveToFile) {
                    $filePath = Model_CurrentData::saveFile($arrCurrentData);

                    //��������� ���. ������
                    Model_CurrentData::restrictFiles();

                    // ����� �������� ������ ������ � �����
                    $endTimeSaveFiles = microtime(1);
                    $timeDuration = $endTimeSaveFiles - $endTimeGetHist;
                    $timeDuration = strBox::getTimeDuration($timeDuration);

                    sysBox::printTXT("OK... Data written to the file (timeDuration - $timeDuration)");
                }

                $isSaveToDB = sysBox::isSaveToDB();
                if ($isSaveToDB) {
                    // ������� ������ � ���� ������
                    sysBox::printTXT("Writting to the DB...");
                    $count = count($arrCurrentData);
                    foreach ($arrCurrentData as $oCurrentData) {
                        $oCurrentData->save();
                    }

                    //��������� ���. ������� � ���� ������
                    $oCurrentData = new Model_CurrentData();
                    $oCurrentData->restrictRows();


                    // ����� �������� ������ ������ � ���� ������
                    $endTimeSaveDB = microtime(1);
                    $timeDuration = $endTimeSaveDB - $endTimeSaveFiles;
                    $timeDuration = strBox::getTimeDuration($timeDuration);

                    sysBox::printTXT("OK... $count entries written to the DB (timeDuration - $timeDuration)");
                }

                sysBox::printTXT("");

                //��������� ������
                $oView = new View_HistCurrentData($arrHistCurrentData, $arrCurrentData);
                $oView->render();
                sysBox::printTXT("");


                $memoryUsage = sysBox::showMemoryUsage('mb');
                sysBox::printTXT("Memory used by the script: $memoryUsage mb.");

                // ����� �����
                $endTimeCycle = microtime(1);
                $cycleDuration = $endTimeCycle - $startTimeCycle;
                $cycleTime = strBox::getTimeDuration($cycleDuration);
                sysBox::printTXT("END GET DATA - OK...(Cycle timeDuration - $cycleTime)");
                sysBox::printTXT("---------------------------------------------");

                // ������� ���������� ������ � �����
                $_SESSION["debugs"] = array();

                // �������� ����� ������
                // �������� �������� ������������ �����
                $cycleDuration = round($cycleDuration);
                $sleepDelay = $delay_cycle - $cycleDuration;
                if ($sleepDelay > 0 && !strBox::isStopCycle()) {
                    sleep($sleepDelay);
                    $sleepDelay = strBox::getTimeDuration($sleepDelay);
                    sysBox::printTXT("Sleep: $sleepDelay");
                }
            }

            // ������ ����� ���������� ������
            strBox::deleteCycleControl("stop");
            strBox::deleteCycleControl("start");
        } catch (Exception $ex) {

            $errMessage = $ex->getMessage();

            // ������� ���. ������ �������� ��� ��������� ��������
            $countErrorCycle = myConfig::$arrSystem['count_error_cycle'];
            // ������� ����������� ��������� ������������� ������ ��������
            $maxMemoryUsage = myConfig::$arrSystem['maxMemoryUsage'];

            // ������ �� ������� �� �����
            if (strBox::isStopCycle()) {
                throw new Exception($errMessage);
            }

            // ���. �������� = 0 ������ �� �������
            if ($countErrorCycle == 0) {
                throw new Exception($errMessage);
            }

            // ������� ���. ������������ �������� ������
            $memoryUsage = sysBox::showMemoryUsage('mb', FALSE);
            if ($memoryUsage > $maxMemoryUsage) {
                // �������� ������ � ����
                strBox::saveErr2Log($errMessage);

                // ������ ����� ���������� ������
                strBox::deleteCycleControl("start");

                return;
            }

            // ���. �������� > 0 ������� ������.
            if ($countErrorCycle > 0 && $this->errorCycle < $countErrorCycle) {
                $this->errorCycle++;

                // �������� ������ � ����
                strBox::saveErr2Log($errMessage);

                // ������ ����� ���������� ������
                strBox::deleteCycleControl("start");

                sleep(10);

                // ���� ���� �� ��������� ����
                if (strBox::isStopCycle()) {
                    // ������ ����� ���������� ������
                    strBox::deleteCycleControl("stop");
                    return;
                }

                // ���������� ������� ������ ��������
                $this->current_data_cycleAction();
            }

            // ���. �������� < 0 ������� ����������� ���� ��������
            if ($countErrorCycle == -1) {

                // �������� ������ � ����
                strBox::saveErr2Log($errMessage);

                // ������ ����� ���������� ������
                strBox::deleteCycleControl("start");

                sleep(10);

                // ���� ���� �� ��������� ����
                if (strBox::isStopCycle()) {
                    // ������ ����� ���������� ������
                    strBox::deleteCycleControl("stop");
                    return;
                }

                // ���������� ������� ������ ��������
                $this->current_data_cycleAction();
            }
        }
    }

    /**
     * �������� ����������� �� ���������
     * ������� ������ � ����� �� �������
     * ���������� ���� ������ � ��������� �����
     * � � ���� ������
     *
     * ���������� ����� urls:
     * - c=hist
     * - c=hist&a=current_values_cycle
     *
     * @return void
     */
    public function current_values_cycleAction() {
        //--------------------
//        $delay_cycle = myConfig::$arrSystem['delay_cycle'];
        $delay_cycle = myConfig::getDelayCycle();
        try {
            // ��������� ������� �� ������
            // ���� ��� �������, �� ������ �� �����
            if (strBox::isStartCycle()) {
                sysBox::printTXT("Error running the script. Unable to run two scripts simultaneously");
                return;
            } else {
                strBox::createCycleControl("start");
                strBox::deleteCycleControl("stop");
            }

            // �������� �������
            $helperHistController = new Helper_HistController();
            $oHistCurrentData = new Model_HistCurrentData();
            sysBox::printTXT("");

            while (!strBox::isStopCycle()) {
                // ������ �����
                $startTimeCycle = microtime(1);

                $datetime = date("Y-m-d H:i:s");
                sysBox::printTXT("---------------------------------------------");
                sysBox::printTXT("BEGIN GET DATA (time - $datetime)");
                sysBox::printTXT("");

                //������ ��� ����
                sysBox::deleteLogFile("HistCurrentData");
                sysBox::deleteLogFile("ErrScript");

                //������� ������� ������ �� ������� 
                if (isset(myConfig::$arrArguments["test"])) {
                    $arrHistCurrentData = $oHistCurrentData->fetchTestTags();
                } else {
                    $arrHistCurrentData = $oHistCurrentData->fetchTags('current_sec');
                }


                $count = count($arrHistCurrentData);

                if (!$count) {
                    throw new Exception("Error reading data from the database history");
                }

                // ����� �������� ��������� ������ �� �������
                $endTimeGetHist = microtime(1);
                $timeDuration = $endTimeGetHist - $startTimeCycle;
                $timeDuration = strBox::getTimeDuration($timeDuration);
                sysBox::printTXT("OK... Received $count entries from history (timeDuration - $timeDuration)");

                // ������� ������ � ����
                $isSaveToFile = myConfig::$arrSystem['isSaveToFile'];
                if ($isSaveToFile) {
                    $oCurrentValuesForFile = $helperHistController->getCurrentValuesObjects($arrHistCurrentData, false);
                    $filePath = Model_CurrentValues::saveFile($oCurrentValuesForFile);

                    //��������� ���. ������
                    Model_CurrentValues::restrictFiles();

                    // ����� �������� ������ ������ � �����
                    $endTimeSaveFiles = microtime(1);
                    $timeDuration = $endTimeSaveFiles - $endTimeGetHist;
                    $timeDuration = strBox::getTimeDuration($timeDuration);

                    sysBox::printTXT("OK... Data written to the file (timeDuration - $timeDuration)");
                    // sysBox::printTXT("OK... Data written to the file (filePath - '$filePath')");
                }

                $oCurrentValues = $helperHistController->getCurrentValuesObjects($arrHistCurrentData);
                $isSaveToDB = sysBox::isSaveToDB();
                if ($isSaveToDB) {
                    // ������� ������ � ���� ������
                    if (myConfig::$Bootstrap->checkAccessToDataHost()) {
                        $oCurrentValues->save();
                    } else {
                        $dataHost1 = myConfig::$dataHost1;
                        $dataHost2 = myConfig::$dataHost2;
                        throw new Exception("Error save data to DB. This hosts '{$dataHost1}' and '{$dataHost2}' does not exist.");
                    }

                    //��������� ���. ������� � ���� ������
                    if (myConfig::$Bootstrap->checkAccessToDataHost()) {
                        $oCurrentValues->restrictRows();
                    } else {
                        $dataHost1 = myConfig::$dataHost1;
                        $dataHost2 = myConfig::$dataHost2;
                        throw new Exception("Error restrict data from DB. This hosts '{$dataHost1}' and '{$dataHost2}' does not exist.");
                    }
                    // ����� �������� ������ ������ � ���� ������
                    $endTimeSaveDB = microtime(1);
                    $timeDuration = $endTimeSaveDB - $endTimeSaveFiles;
                    $timeDuration = strBox::getTimeDuration($timeDuration);

                    sysBox::printTXT("OK... Data written to the DB (timeDuration - $timeDuration)");
                    sysBox::printTXT("");
                }


                //��������� ������
                $oView = new View_HistCurrentValues($arrHistCurrentData, array($oCurrentValues));
                $oView->render();
                sysBox::printTXT("");


                $memoryUsage = sysBox::showMemoryUsage('mb');
                sysBox::printTXT("Memory used by the script: $memoryUsage mb.");

                // ����� �����
                $endTimeCycle = microtime(1);
                $cycleDuration = $endTimeCycle - $startTimeCycle;
                $cycleTime = strBox::getTimeDuration($cycleDuration);
                sysBox::printTXT("END GET DATA - OK...(Cycle timeDuration - $cycleTime)");
                sysBox::printTXT("---------------------------------------------");

                // ������� ���������� ������ � �����
                $_SESSION["debugs"] = array();

                // �������� ����� ������
                // �������� �������� ������������ �����
                $cycleDuration = round($cycleDuration);
                $sleepDelay = $delay_cycle - $cycleDuration;
                if ($sleepDelay > 0 && !strBox::isStopCycle()) {
                    sleep($sleepDelay);
                    $sleepDelay = strBox::getTimeDuration($sleepDelay);
                    sysBox::printTXT("Sleep: $sleepDelay");
                }
            }

            // ������ ����� ���������� ������
            strBox::deleteCycleControl("stop");
            strBox::deleteCycleControl("start");
        } catch (Exception $ex) {

            $errMessage = $ex->getMessage();

            // ������� ���. ������ �������� ��� ��������� ��������
            $countErrorCycle = myConfig::$arrSystem['count_error_cycle'];
            // ������� ����������� ��������� ������������� ������ ��������
            $maxMemoryUsage = myConfig::$arrSystem['maxMemoryUsage'];

            // ������ �� ������� �� �����
            if (strBox::isStopCycle()) {
                throw new Exception($errMessage);
            }

            // ���. �������� = 0 ������ �� �������
            if ($countErrorCycle == 0) {
                throw new Exception($errMessage);
            }

            // ������� ���. ������������ �������� ������
            $memoryUsage = sysBox::showMemoryUsage('mb', FALSE);
            if ($memoryUsage > $maxMemoryUsage) {
                // �������� ������ � ����
                strBox::saveErr2Log($errMessage);

                // ������ ����� ���������� ������
                strBox::deleteCycleControl("start");

                return;
            }

            // ���. �������� > 0 ������� ������.
            if ($countErrorCycle > 0 && $this->errorCycle < $countErrorCycle) {
                $this->errorCycle++;

                // �������� ������ � ����
                strBox::saveErr2Log($errMessage);

                // ������ ����� ���������� ������
                strBox::deleteCycleControl("start");

                sleep(10);

                // ���� ���� �� ��������� ����
                if (strBox::isStopCycle()) {
                    // ������ ����� ���������� ������
                    strBox::deleteCycleControl("stop");
                    return;
                }

                // ���������� ������� ������ ��������
                $this->current_values_cycleAction();
            }

            // ���. �������� < 0 ������� ����������� ���� ��������
            if ($countErrorCycle == -1) {

                // �������� ������ � ����
                strBox::saveErr2Log($errMessage);

                // ������ ����� ���������� ������
                strBox::deleteCycleControl("start");

                sleep(10);

                // ���� ���� �� ��������� ����
                if (strBox::isStopCycle()) {
                    // ������ ����� ���������� ������
                    strBox::deleteCycleControl("stop");
                    return;
                }

                // ���������� ������� ������ ��������
                $this->current_values_cycleAction();
            }
        }
    }

    /**
     * �������� ����������� ��� �������� 
     * ������, ����������� �  �����
     *
     * ���������� ����� urls:
     * - c=hist
     * - c=hist&a=stop_cycle
     *
     * @return void
     */
    public function stop_cycleAction() {
        strBox::createCycleControl("stop");
        strBox::deleteCycleControl("start");
    }

}

?>