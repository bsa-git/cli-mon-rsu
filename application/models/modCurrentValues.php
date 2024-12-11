<?php

/**
 * ����� ������� CurrentValues (������� ��������)
 * ������������ ����� ��� ������ � �������� ����������
 * ����� � ����� ������ �������������� ������� Model_XXXXMapper
 *
 * @uses       Model_XXXMapper
 * @package    �li-azot-m5
 * @subpackage Model
 */
class Model_CurrentValues {

    /** ID ������������
     * @var int
     */
    protected $_id;

    /** ����� �������
     * @var DateTime
     */
    protected $_ts;

    /** �������� �������
     * @var string
     */
    protected $_name;

    /** ���� �������� ������ � �������
     * @var Date
     */
    protected $_date_hist;

    /** ����� �������� ������ � �������
     * @var Time
     */
    protected $_time_hist;

    /** �������� ������ � �������
     * @var string
     */
    protected $_value;

    /** ������ ����� ����� ����� ������ � �������� ����������
     * @var Model_XXXXMapper
     */
    protected $_mapper;

    /* -------------------------------------------------------
     * Constructor
     *
     * @param  array|null $aOptions
     * @return void
     */

    public function __construct(array $aOptions = null) {
        if (is_array($aOptions)) {
            $this->setValues($aOptions);
        }
    }

    /*     * ----------------------------------
     * Overloading: allow property access
     *
     * @param  string $aName
     * @param  mixed $aValue
     * @return void
     */

    public function __set($aName, $aValue) {
        $method = 'set' . $aName;
        if ('mapper' == $aName || !method_exists($this, $method)) {
            throw Exception('Invalid property specified');
        }
        $this->$method($aValue);
    }

    /*     * ----------------------------------
     * Overloading: allow property access
     *
     * @param  string $name
     * @return mixed
     */

    public function __get($aName) {
        $method = 'get' . $aName;
        if ('mapper' == $aName || !method_exists($this, $method)) {
            throw Exception('Invalid property specified');
        }
        return $this->$method();
    }

    /**
     * Set object state
     *
     * @param  array $aValues
     * @return Model_XXXX
     */
    public function setValues(array $aValues) {
        $methods = get_class_methods($this);
        foreach ($aValues as $key => $value) {
            $key = strtolower($key);
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    /**
     * �������� ������ (���� =��������) �������
     *
     * @return array
     */
    public function getValues() {
        $arrValues = array();
        //-------------------
        //������� ��� ������ �������
        $methods = get_class_methods($this);
        foreach ($methods as $method) {
            //������ ������ ������
            if (('getValues' != $method) AND ( 'getMapper' != $method) AND ( strpos($method, 'get') === 0)) {
                //���� �������� �� ����� NULL, �� �������� ��� � �������
                $value = $this->$method();
                if (!is_null($value)) {
                    $method = strtolower($method);
                    $key = substr($method, 3);
                    $arrValues[$key] = $value;
                }
            }
        }
        return $arrValues;
    }

    /**
     * �������� �������� �������
     *
     * @return Model_XXXX
     */
    public function clearValues() {

        //-------------------
        $arrValues = $this->getValues();
        //������� ��� ������ �������
        foreach ($arrValues as $key => $value) {
            $this->$key = NULL;
        }
        return $this;
    }

    /*     * ----------------
     * Set data mapper
     *
     * @param  mixed $aMapper
     * @return Model_XXXX
     */

    public function setMapper($aMapper) {
        $this->_mapper = $aMapper;
        return $this;
    }

    /**
     * Get data mapper
     *
     * Lazy loads Default_Model_Buh1cMapper instance if no mapper registered.
     *
     * @return Model_XXXXMapper
     */
    public function getMapper() {
        if (null === $this->_mapper) {
            $this->setMapper(new Model_CurrentValuesMapper());
        }
        return $this->_mapper;
    }

    //=============== �������� �������� ===============//

    /**
     * ���������� ID ������ ��� ���������
     *
     * @param  string $aID
     * @return Model_XXXX
     */
    public function setId($aID) {
        if ($aID === null) {
            $this->_id = null;
        } else {
            $this->_id = (int) $aID;
        }

        return $this;
    }

    /**
     * �������� �������� ��������
     *
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * ���������� ����� �������
     *
     * @param  string $aTS
     * @return Model_XXXX
     */
    public function setTs($aTS) {
        if ($aTS === null) {
            $this->_ts = null;
        } else {
            $this->_ts = (string) $aTS;
        }

        return $this;
    }

    /**
     * �������� �������� ��������
     *
     * @return string
     */
    public function getTs() {
        return $this->_ts;
    }

    /**
     * ���������� ������� �������
     *
     * @param  string $aName
     * @return Model_XXXX
     */
    public function setName($aName) {
        if ($aName === null) {
            $this->_name = null;
        } else {
            $this->_name = (string) $aName;
        }

        return $this;
    }

    /**
     * �������� ������� �������
     *
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * ���������� ���� �������� ������ � �������
     *
     * @param  string $aDate_hist
     * @return Model_XXXX
     */
    public function setDate_hist($aDate_hist) {
        if ($aDate_hist === null) {
            $this->_date_hist = null;
        } else {
            $this->_date_hist = (string) $aDate_hist;
        }

        return $this;
    }

    /**
     * �������� ���� �������� ������ � �������
     *
     * @return string
     */
    public function getDate_hist() {
        return $this->_date_hist;
    }

    /**
     * ���������� ����� �������� ������ � �������
     *
     * @param  string $aTime_hist
     * @return Model_XXXX
     */
    public function setTime_hist($aTime_hist) {
        if ($aTime_hist === null) {
            $this->_time_hist = null;
        } else {
            $this->_time_hist = (string) $aTime_hist;
        }

        return $this;
    }

    /**
     * �������� ����� �������� ������ � �������
     *
     * @return string
     */
    public function getTime_hist() {
        return $this->_time_hist;
    }

    /**
     * ���������� �������� ������ � �������
     *
     * @param  float $aValue
     * @return Model_XXXX
     */
    public function setValue($aValue) {
        if ($aValue === null) {
            $this->_value = null;
        } else {
            $this->_value = (string) $aValue;
        }

        return $this;
    }

    /**
     * �������� �������� ������ � �������
     *
     * @return float
     */
    public function getValue() {
        return $this->_value;
    }

    //====================== ������ ������� ======================//

    /**
     * ��������� ������ �������
     *
     * @return Model_XXXX
     */
    public function save() {
        $this->getMapper()->save($this);
        return $this;
    }

    /**
     * �������� ������ � ���� ��������
     *
     *
     * @return array //������ �������� Model_XXXX
     */
    public function fetchAll() {
        return $this->getMapper()->fetchAll();
    }

    /**
     * �������� ������ � ���������� �������
     *
     *
     * @return array //������ �������� Model_XXXX
     */
    public function fetch() {
        $this->getMapper()->fetch($this);
        return $this;
    }

    /**
     * ������� ��� ������ �� ��������
     *
     * @return int //���������� ��������� �������
     */
    public function deleteAll() {
        $count = $this->getMapper()->deleteAll();
        return $count;
    }

    /**
     * ���������� ���. ������� � ���� ������
     *
     * @return int //���������� ��������� �������
     */
    public function restrictRows() {
        $count = $this->getMapper()->restrictRows();
        return $count;
    }

    /**
     * �������� ���������� �� �������� � �����
     *
     * @param  Model_CurrentValues $aObject
     * @return void
     */
    static function saveFile($aObject) {
        $arrObjects = array();
        $strTags = '';
        $strValues = '';
        $nameFile = '';
        //--------------------------------
        // ����������� ������ �������� 
        // � ������������ � �������� -> myConfig::$arrCurrentTags
        $arrNames = explode(';', $aObject->name);
        $arrValues = explode(';', $aObject->value);
        foreach ($arrNames as $index => $name) {
            $arrObjects[] = array('name' => $name, 'value' => $arrValues[$index]);
        }
        $arrAlias = array_values(myConfig::$arrCurrentTags);
        $arrSortValues = sysBox::SortArrArr($arrObjects, $arrAlias, "name");

        if (!$aObject) {
            throw new Exception("Error writing file. Data for write does not exist");
        }
        // ������ �������� �����
        $date_hist = $aObject->date_hist;
        $time_hist = $aObject->time_hist;
        $date_hist = str_replace('-', '', $date_hist);
        $time_hist = str_replace(':', '', $time_hist);
        $nameFile = "data-{$date_hist}_{$time_hist}.txt";
        // ������� ������ ������� � �������� �����
        foreach ($arrSortValues as $arrValue) {
            $strTags .= $arrValue['name'] . ';';
            $strValues .= $arrValue['value'] . ';';
        }
        // ������ ��������� ������ ";"
        $strTags = trim($strTags);
        $strTags = trim($strTags, ';');
        $strValues = trim($strValues);
        $strValues = trim($strValues, ';');

        $aContent = $strTags . PHP_EOL . $strValues;

        if (isset(myConfig::$arrArguments["test"])) {
            $filePath = ROOT_DOCUMENT . myConfig::$arrSystem['www_dir_test'] . '/';
            $filePath .= $nameFile;
            file_put_contents($filePath, $aContent);
        } else {
            $argHist = myConfig::$arrArguments["hist"];
            $wwwDir = ($argHist == 2)? myConfig::$arrSystem['www_dir2'] : myConfig::$arrSystem['www_dir'];
            // Save file to dataHost
            if (myConfig::$Bootstrap->checkAccessToDataHost()) {
                $filePath = myConfig::$dataHost . $wwwDir . '\\';
                $filePath .= $nameFile;
                file_put_contents($filePath, $aContent);
            }else{
                $dataHost1 = myConfig::$dataHost1;
                $dataHost2 = myConfig::$dataHost2;
                throw new Exception("Error writing file. This hosts '{$dataHost1}' and '{$dataHost2}' does not exist.");
            }
        }
        return $filePath;
    }

    /**
     * ���������� ���. ������
     *
     * @return int //���������� ��������� ������
     */
    static function restrictFiles() {
        $delCount = 0;
        //--------------------------
        if (isset(myConfig::$arrArguments["test"])) {
            $dir = ROOT_DOCUMENT . myConfig::$arrSystem['www_dir_test'] . '/';
            $delCount = self::deleteFiles($dir);
        } else {
            if (myConfig::$Bootstrap->checkAccessToDataHost()) {
                $argHist = myConfig::$arrArguments["hist"];
                $wwwDir = ($argHist == 2)? myConfig::$arrSystem['www_dir2'] : myConfig::$arrSystem['www_dir'];
                $dir = myConfig::$dataHost . $wwwDir . '\\';
                $delCount = self::deleteFiles($dir);
            }  else {
                $dataHost1 = myConfig::$dataHost1;
                $dataHost2 = myConfig::$dataHost2;
                throw new Exception("Error restrict files. This hosts '{$dataHost1}' and '{$dataHost2}' does not exist.");
            }
        }
        return $delCount;
    }

    /**
     * Delete files
     *
     * @return int  Count of deleted files
     */
    static function deleteFiles($dir) {
        $maxFiles = (int) myConfig::$arrSystem['maxFiles'];
        $count = 0;
        $delCount = 0;
        //--------------------------
        $arrNameFiles = strBox::getNameFilesSortDesc($dir);
        if (count($arrNameFiles) > $maxFiles) {
            foreach ($arrNameFiles as $fileName) {
                $fileName = strtolower($fileName);
                $count++;
                if ($count <= $maxFiles) {
                    continue;
                }
                if (unlink($dir . $fileName)) {
                    $delCount++;
                }
            }
        }
        return $delCount;
    }

}

?>