
<?php
/*=============  ����� ��������� �������������� ������ ========//
 * ������ ������������
 * Modul MathBox.php Copyright @ 2009 BSA
 * @uses    Exception
 * @package ZF-BUH1C
 */
class mathException extends Exception {
    private $typeError = "";
    //-------------------------------
    //����������� ������
    public function __construct($typeError,$message,$code=0) {
        parent::__construct($message,$code);
        $this->typeError = $typeError;
    }
    //���������� ����� toString()
    public function __toString() {
        return "$this->message\n";
    }
    //������� ��� ������
    public function getTypeError() {
        return $this->typeError;
    }
}

/*================ ����� ������ � ��������������� ��������� =========//
 * ������ ������������
 * Modul MathBox.php Copyright @ 2009 BSA
 * @uses
 * @package ZF-BUH1C
 */
class mathBox {
//===================== �������������� �������� � ��������� ========================//
//��������� �������� ��� ��������
    static function doOperation($TypeOperation,array $arrValues) {
        $count = count($arrValues);
        if($count==0) {
            MathBox::errMath("ERR_OPERATION_FOR_EMPTY_ARRAY");
            return;
        }
        switch($TypeOperation) {
            case "sum":
                $result = array_sum($arrValues);
                break;
            case "min":
                $result = min($arrValues);
                break;
            case "max":
                $result = max($arrValues);
                break;
            case "average":
                $count = count($arrValues);
                $result = array_sum($arrValues)/$count;
                break;
            case "count":
                $count = count($arrValues);
                $result = $count;
                break;
            default:
                MathBox::errMath("ERR_NOT_THIS_OPERATION",array($TypeOperation));
                break;
        }
        return  $result;
    }
    //================ DEC TO HEX ======================//
    //����������� ������������ �������� � ����������������� ��������
    //� ������ ���. �������� ��������
    static function DecToHex($Size,$DecNumber) {
        $result = "";
        $hex_value = "";
        //-------------
        for($count=0;$count<$Size;$count++) {
            $hex_value = $hex_value . "F";
        }
        //echo $hex_value."<br>\n";
        if($DecNumber < 0) {
            $result = "0";
            return  $result;
        }
        if($DecNumber > hexdec($hex_value)) {
            $result = "0";
            return  $result;
        }
        $hex_value = dechex($DecNumber);
        return  sprintf("%0".$Size."X", $DecNumber);
    //return  sprintf("%X", $DecNumber);
    }
    //������� ������� � HEX ����
    static function CountHex($Size,$HexNumber) {
        $result = "";
        //------------------
        $count_hex = substr($HexNumber,strlen($HexNumber)-$Size,$Size);
        $count_10 = hexdec($count_hex);
        $count_10 = $count_10 + 1;
        $count_hex = MathBox::DecToHex($Size,$count_10);
        $number_base_hex= substr($HexNumber,0,strlen($HexNumber)-$Size);
        $result = $number_base_hex . $count_hex;
        return  $result;
    }
    //==================== ����� �������������� ������  ==================//
    static  function errMath($typeError, array $arrParam) {
        $myMsg = "";
        //------------------
        switch ($typeError) {
            case "ERR_DIV_ZERRO":
                $myMsg = "WEB: ������ ������� �� ����.";
                break;
            case "ERR_OPERATION_FOR_EMPTY_ARRAY":
                $myMsg = "WEB: ���������� ��������� �������� ��� ������ ��������.";
                break;
            case "ERR_NOT_THIS_OPERATION":
                $myMsg = "WEB: ��� ����� �������� - '%s'.";
                $myMsg = sprintf($myMsg, $arrParam[0]);
                break;
        }
        throw new mathException($typeError,$myMsg);
    }
}

?>
    