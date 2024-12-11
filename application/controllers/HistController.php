<?php

/**
 * Контроллер для получения данных
 * из истории (AIM HISTORY)
 *
 *
 * @package    cli-azot-m5
 * @subpackage Controller
 */
class HistController {

    /**
     * 
     * Кол. повторов при ошибке
     * @var int 
     */
    private $errorCycle = 0;

    /**
     * Действие контроллера по умолчанию
     *
     * Вызывается через urls:
     * - c=hist
     * - c=hist&a=index
     *
     * @return void
     */
    public function indexAction() {
        
    }

    /**
     * Действие контроллера по получению
     * суточных данных
     *
     * Вызывается через urls:
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

        //Удалим лог файл
        sysBox::deleteLogFile("HistDayData");
        sysBox::deleteLogFile("ErrScript");

        //Получим суточные данные
        $oHistDayData = new Model_HistDayData();
        $arrHistDayData = $oHistDayData->fetchTags();

        //Запомним данные в базе данных
        $helperHistController = new Helper_HistController();
        sysBox::printTXT("Obtain data to write to DB...");
        $arrDayData = $helperHistController->getDayDataObjects($arrHistDayData);
        $count = count($arrDayData);
        sysBox::printTXT("OK... Obtained  $count records from history");

        $isSaveToFile = myConfig::$arrSystem['isSaveToFile'];

        //Удалим дублированные записи в базе данных
        $helperHistController->deleteDoubleRows_DayData($arrDayData);

        //Сохраним данные в базе данных
        sysBox::printTXT("We write the data to DB...");
        $count = 0;
        foreach ($arrDayData as $oDayData) {
            $oDayData->save();
            $count++;
        }
        sysBox::printTXT("OK... It was written $count entries to the DB");

        //Ограничим кол. записей в базе данных
        sysBox::printTXT("Limit the number records for DB...");
        $oDayData = new Model_DayData();
        $count = $oDayData->restrictRows();
        sysBox::printTXT("OK...Deleted records - $count");

        //Отобразим данные, полученные с истории
        $oView = new View_HistDayData($arrHistDayData, $arrDayData);
        $oView->render();

        $datetime = date("Y-m-d H:i:s");
        sysBox::printTXT("Daily data were obtained - OK... (time - $datetime)");
    }

    /**
     * Действие контроллера по получению
     * текущих данных
     *
     * Вызывается через urls:
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

        //Удалим лог файл
        sysBox::deleteLogFile("HistCurrentData");
        sysBox::deleteLogFile("ErrScript");

        //Получим текущие данные из истории
        $oHistCurrentData = new Model_HistCurrentData();
        $arrHistCurrentData = $oHistCurrentData->fetchTags();

        $helperHistController = new Helper_HistController();
        sysBox::printTXT("Obtain data to write to DB...");
        $arrCurrentData = $helperHistController->getCurrentDataObjects($arrHistCurrentData);
        $count = count($arrCurrentData);
        sysBox::printTXT("OK...Obtained  $count records from history");

        // Запишем данные в файл
        $isSaveToFile = myConfig::$arrSystem['isSaveToFile'];
        if ($isSaveToFile) {
            $filePath = Model_CurrentData::saveFile($arrCurrentData);
            sysBox::printTXT("OK...It was written $count entries to the file - '$filePath'");

            //Ограничим кол. файлов
            $count = Model_CurrentData::restrictFiles();
            sysBox::printTXT("OK...Deleted files - $count");
        }


        $isSaveToDB = sysBox::isSaveToDB();
        if ($isSaveToDB) {
            // Запишем данные в базу данных
            sysBox::printTXT("We write the data to DB...");
            $count = count($arrCurrentData);
            foreach ($arrCurrentData as $oCurrentData) {
                $oCurrentData->save();
            }
            sysBox::printTXT("OK...It was written $count entries to the DB");

            //Ограничим кол. записей в базе данных
            sysBox::printTXT("Limit the number records of DB...");
            $oCurrentData = new Model_CurrentData();
            $count = $oCurrentData->restrictRows();
            sysBox::printTXT("OK...Deleted records - $count");
        }

        //Отобразим данные
        $oView = new View_HistCurrentData($arrHistCurrentData, $arrCurrentData);
        $oView->render();

        $datetime = date("Y-m-d H:i:s");
        sysBox::printTXT("Current data were obtained - OK... (time - $datetime)");
    }

    /**
     * Действие контроллера по получению
     * текущих данных в цикле
     *
     * Вызывается через urls:
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
            // Определим запущен ли скрипт
            // если уже запущен, то выйдем из цикла
            if (strBox::isStartCycle()) {
                sysBox::printTXT("Error running the script. Unable to run two scripts simultaneously");
                return;
            } else {
                strBox::createCycleControl("start");
                strBox::deleteCycleControl("stop");
            }

            // Создадим обьекты
            $helperHistController = new Helper_HistController();
            $oHistCurrentData = new Model_HistCurrentData();
            sysBox::printTXT("");

            while (!strBox::isStopCycle()) {
                // Начала цикла
                $startTimeCycle = microtime(1);

                $datetime = date("Y-m-d H:i:s");
                sysBox::printTXT("---------------------------------------------");
                sysBox::printTXT("BEGIN GET DATA (time - $datetime)");
                sysBox::printTXT("");

                //Удалим лог файл
                sysBox::deleteLogFile("HistCurrentData");
                sysBox::deleteLogFile("ErrScript");

                //Получим текущие данные из истории 
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

                // Конец операции получения данных из истории
                $endTimeGetHist = microtime(1);
                $timeDuration = $endTimeGetHist - $startTimeCycle;
                $timeDuration = strBox::getTimeDuration($timeDuration);
                sysBox::printTXT("OK... Received $count entries from history (timeDuration - $timeDuration)");

                // Запишем данные в файл
                $isSaveToFile = myConfig::$arrSystem['isSaveToFile'];
                if ($isSaveToFile) {
                    $filePath = Model_CurrentData::saveFile($arrCurrentData);

                    //Ограничим кол. файлов
                    Model_CurrentData::restrictFiles();

                    // Конец операции записи данных в файлы
                    $endTimeSaveFiles = microtime(1);
                    $timeDuration = $endTimeSaveFiles - $endTimeGetHist;
                    $timeDuration = strBox::getTimeDuration($timeDuration);

                    sysBox::printTXT("OK... Data written to the file (timeDuration - $timeDuration)");
                }

                $isSaveToDB = sysBox::isSaveToDB();
                if ($isSaveToDB) {
                    // Запишем данные в базу данных
                    sysBox::printTXT("Writting to the DB...");
                    $count = count($arrCurrentData);
                    foreach ($arrCurrentData as $oCurrentData) {
                        $oCurrentData->save();
                    }

                    //Ограничим кол. записей в базе данных
                    $oCurrentData = new Model_CurrentData();
                    $oCurrentData->restrictRows();


                    // Конец операции записи данных в базу данных
                    $endTimeSaveDB = microtime(1);
                    $timeDuration = $endTimeSaveDB - $endTimeSaveFiles;
                    $timeDuration = strBox::getTimeDuration($timeDuration);

                    sysBox::printTXT("OK... $count entries written to the DB (timeDuration - $timeDuration)");
                }

                sysBox::printTXT("");

                //Отобразим данные
                $oView = new View_HistCurrentData($arrHistCurrentData, $arrCurrentData);
                $oView->render();
                sysBox::printTXT("");


                $memoryUsage = sysBox::showMemoryUsage('mb');
                sysBox::printTXT("Memory used by the script: $memoryUsage mb.");

                // Конец цикла
                $endTimeCycle = microtime(1);
                $cycleDuration = $endTimeCycle - $startTimeCycle;
                $cycleTime = strBox::getTimeDuration($cycleDuration);
                sysBox::printTXT("END GET DATA - OK...(Cycle timeDuration - $cycleTime)");
                sysBox::printTXT("---------------------------------------------");

                // Очистим отладочные данные в сесии
                $_SESSION["debugs"] = array();

                // Задержка цикла опроса
                // Округлим значение длительности цикла
                $cycleDuration = round($cycleDuration);
                $sleepDelay = $delay_cycle - $cycleDuration;
                if ($sleepDelay > 0 && !strBox::isStopCycle()) {
                    sleep($sleepDelay);
                    $sleepDelay = strBox::getTimeDuration($sleepDelay);
                    sysBox::printTXT("Sleep: $sleepDelay");
                }
            }

            // Удалим файлы управления циклом
            strBox::deleteCycleControl("stop");
            strBox::deleteCycleControl("start");
        } catch (Exception $ex) {

            $errMessage = $ex->getMessage();

            // Получим кол. циклов повторов для ошибочной ситуации
            $countErrorCycle = myConfig::$arrSystem['count_error_cycle'];
            // Получим максимально возможное использование памяти скриптом
            $maxMemoryUsage = myConfig::$arrSystem['maxMemoryUsage'];

            // Выйдем из скрипта по стопу
            if (strBox::isStopCycle()) {
                throw new Exception($errMessage);
            }

            // Кол. повторов = 0 Выйдем из скрипта
            if ($countErrorCycle == 0) {
                throw new Exception($errMessage);
            }

            // Получим кол. используемой скриптом памяти
            $memoryUsage = sysBox::showMemoryUsage('mb', FALSE);
            if ($memoryUsage > $maxMemoryUsage) {
                // Сохраним ошибку в логе
                strBox::saveErr2Log($errMessage);

                // Удалим файлы управления циклом
                strBox::deleteCycleControl("start");

                return;
            }

            // Кол. повторов > 0 Сделаем повтор.
            if ($countErrorCycle > 0 && $this->errorCycle < $countErrorCycle) {
                $this->errorCycle++;

                // Сохраним ошибку в логе
                strBox::saveErr2Log($errMessage);

                // Удалим файлы управления циклом
                strBox::deleteCycleControl("start");

                sleep(10);

                // Если стоп то закончить цикл
                if (strBox::isStopCycle()) {
                    // Удалим файлы управления циклом
                    strBox::deleteCycleControl("stop");
                    return;
                }

                // Рекурсивно сделаем повтор операции
                $this->current_data_cycleAction();
            }

            // Кол. повторов < 0 Сделаем бесконечный цикл повторов
            if ($countErrorCycle == -1) {

                // Сохраним ошибку в логе
                strBox::saveErr2Log($errMessage);

                // Удалим файлы управления циклом
                strBox::deleteCycleControl("start");

                sleep(10);

                // Если стоп то закончить цикл
                if (strBox::isStopCycle()) {
                    // Удалим файлы управления циклом
                    strBox::deleteCycleControl("stop");
                    return;
                }

                // Рекурсивно сделаем повтор операции
                $this->current_data_cycleAction();
            }
        }
    }

    /**
     * Действие контроллера по получению
     * текущих данных в цикле из истории
     * сохранении этих данных в текстовом файле
     * и в базе данных
     *
     * Вызывается через urls:
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
            // Определим запущен ли скрипт
            // если уже запущен, то выйдем из цикла
            if (strBox::isStartCycle()) {
                sysBox::printTXT("Error running the script. Unable to run two scripts simultaneously");
                return;
            } else {
                strBox::createCycleControl("start");
                strBox::deleteCycleControl("stop");
            }

            // Создадим обьекты
            $helperHistController = new Helper_HistController();
            $oHistCurrentData = new Model_HistCurrentData();
            sysBox::printTXT("");

            while (!strBox::isStopCycle()) {
                // Начала цикла
                $startTimeCycle = microtime(1);

                $datetime = date("Y-m-d H:i:s");
                sysBox::printTXT("---------------------------------------------");
                sysBox::printTXT("BEGIN GET DATA (time - $datetime)");
                sysBox::printTXT("");

                //Удалим лог файл
                sysBox::deleteLogFile("HistCurrentData");
                sysBox::deleteLogFile("ErrScript");

                //Получим текущие данные из истории 
                if (isset(myConfig::$arrArguments["test"])) {
                    $arrHistCurrentData = $oHistCurrentData->fetchTestTags();
                } else {
                    $arrHistCurrentData = $oHistCurrentData->fetchTags('current_sec');
                }


                $count = count($arrHistCurrentData);

                if (!$count) {
                    throw new Exception("Error reading data from the database history");
                }

                // Конец операции получения данных из истории
                $endTimeGetHist = microtime(1);
                $timeDuration = $endTimeGetHist - $startTimeCycle;
                $timeDuration = strBox::getTimeDuration($timeDuration);
                sysBox::printTXT("OK... Received $count entries from history (timeDuration - $timeDuration)");

                // Запишем данные в файл
                $isSaveToFile = myConfig::$arrSystem['isSaveToFile'];
                if ($isSaveToFile) {
                    $oCurrentValuesForFile = $helperHistController->getCurrentValuesObjects($arrHistCurrentData, false);
                    $filePath = Model_CurrentValues::saveFile($oCurrentValuesForFile);

                    //Ограничим кол. файлов
                    Model_CurrentValues::restrictFiles();

                    // Конец операции записи данных в файлы
                    $endTimeSaveFiles = microtime(1);
                    $timeDuration = $endTimeSaveFiles - $endTimeGetHist;
                    $timeDuration = strBox::getTimeDuration($timeDuration);

                    sysBox::printTXT("OK... Data written to the file (timeDuration - $timeDuration)");
                    // sysBox::printTXT("OK... Data written to the file (filePath - '$filePath')");
                }

                $oCurrentValues = $helperHistController->getCurrentValuesObjects($arrHistCurrentData);
                $isSaveToDB = sysBox::isSaveToDB();
                if ($isSaveToDB) {
                    // Запишем данные в базу данных
                    if (myConfig::$Bootstrap->checkAccessToDataHost()) {
                        $oCurrentValues->save();
                    } else {
                        $dataHost1 = myConfig::$dataHost1;
                        $dataHost2 = myConfig::$dataHost2;
                        throw new Exception("Error save data to DB. This hosts '{$dataHost1}' and '{$dataHost2}' does not exist.");
                    }

                    //Ограничим кол. записей в базе данных
                    if (myConfig::$Bootstrap->checkAccessToDataHost()) {
                        $oCurrentValues->restrictRows();
                    } else {
                        $dataHost1 = myConfig::$dataHost1;
                        $dataHost2 = myConfig::$dataHost2;
                        throw new Exception("Error restrict data from DB. This hosts '{$dataHost1}' and '{$dataHost2}' does not exist.");
                    }
                    // Конец операции записи данных в базу данных
                    $endTimeSaveDB = microtime(1);
                    $timeDuration = $endTimeSaveDB - $endTimeSaveFiles;
                    $timeDuration = strBox::getTimeDuration($timeDuration);

                    sysBox::printTXT("OK... Data written to the DB (timeDuration - $timeDuration)");
                    sysBox::printTXT("");
                }


                //Отобразим данные
                $oView = new View_HistCurrentValues($arrHistCurrentData, array($oCurrentValues));
                $oView->render();
                sysBox::printTXT("");


                $memoryUsage = sysBox::showMemoryUsage('mb');
                sysBox::printTXT("Memory used by the script: $memoryUsage mb.");

                // Конец цикла
                $endTimeCycle = microtime(1);
                $cycleDuration = $endTimeCycle - $startTimeCycle;
                $cycleTime = strBox::getTimeDuration($cycleDuration);
                sysBox::printTXT("END GET DATA - OK...(Cycle timeDuration - $cycleTime)");
                sysBox::printTXT("---------------------------------------------");

                // Очистим отладочные данные в сесии
                $_SESSION["debugs"] = array();

                // Задержка цикла опроса
                // Округлим значение длительности цикла
                $cycleDuration = round($cycleDuration);
                $sleepDelay = $delay_cycle - $cycleDuration;
                if ($sleepDelay > 0 && !strBox::isStopCycle()) {
                    sleep($sleepDelay);
                    $sleepDelay = strBox::getTimeDuration($sleepDelay);
                    sysBox::printTXT("Sleep: $sleepDelay");
                }
            }

            // Удалим файлы управления циклом
            strBox::deleteCycleControl("stop");
            strBox::deleteCycleControl("start");
        } catch (Exception $ex) {

            $errMessage = $ex->getMessage();

            // Получим кол. циклов повторов для ошибочной ситуации
            $countErrorCycle = myConfig::$arrSystem['count_error_cycle'];
            // Получим максимально возможное использование памяти скриптом
            $maxMemoryUsage = myConfig::$arrSystem['maxMemoryUsage'];

            // Выйдем из скрипта по стопу
            if (strBox::isStopCycle()) {
                throw new Exception($errMessage);
            }

            // Кол. повторов = 0 Выйдем из скрипта
            if ($countErrorCycle == 0) {
                throw new Exception($errMessage);
            }

            // Получим кол. используемой скриптом памяти
            $memoryUsage = sysBox::showMemoryUsage('mb', FALSE);
            if ($memoryUsage > $maxMemoryUsage) {
                // Сохраним ошибку в логе
                strBox::saveErr2Log($errMessage);

                // Удалим файлы управления циклом
                strBox::deleteCycleControl("start");

                return;
            }

            // Кол. повторов > 0 Сделаем повтор.
            if ($countErrorCycle > 0 && $this->errorCycle < $countErrorCycle) {
                $this->errorCycle++;

                // Сохраним ошибку в логе
                strBox::saveErr2Log($errMessage);

                // Удалим файлы управления циклом
                strBox::deleteCycleControl("start");

                sleep(10);

                // Если стоп то закончить цикл
                if (strBox::isStopCycle()) {
                    // Удалим файлы управления циклом
                    strBox::deleteCycleControl("stop");
                    return;
                }

                // Рекурсивно сделаем повтор операции
                $this->current_values_cycleAction();
            }

            // Кол. повторов < 0 Сделаем бесконечный цикл повторов
            if ($countErrorCycle == -1) {

                // Сохраним ошибку в логе
                strBox::saveErr2Log($errMessage);

                // Удалим файлы управления циклом
                strBox::deleteCycleControl("start");

                sleep(10);

                // Если стоп то закончить цикл
                if (strBox::isStopCycle()) {
                    // Удалим файлы управления циклом
                    strBox::deleteCycleControl("stop");
                    return;
                }

                // Рекурсивно сделаем повтор операции
                $this->current_values_cycleAction();
            }
        }
    }

    /**
     * Действие контроллера для останова 
     * скрипа, работающего в  цикле
     *
     * Вызывается через urls:
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