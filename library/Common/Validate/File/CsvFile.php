<?php
class Common_Validate_File_CsvFile extends Zend_Validate_Abstract
{
    const NOT_READABLE = "notReadable";
    const NOT_ACCEPTED_FORMAT = "formatNotAccepted";
    const NOT_ACCEPTED_HEADER = "headerNotAccepted";

    protected $_messageTemplates = array(
        self::NOT_READABLE => "File '%value%' is not readable",
        self::NOT_ACCEPTED_FORMAT => "File '%value%' is not csv or the format of lines is not \"Id, Firstname, Lastname\"",
        self::NOT_ACCEPTED_HEADER => "File '%value%' must have the first line \"Id, Firstname, Lastname\"");

    public function isValid($value, $file=null)
    {
        if($file === null)
        {
            $file = array('type' => null, 'name' => $value);
        }

        if (!Zend_Loader::isReadable($value)) {
            return $this->_throw($file, self::NOT_READABLE);
        }
        $header = array("Id", "Firstname", "Lastname");
        $header_row = array();
        $check = 1;
        if (($fh = fopen($file['tmp_name'], "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($fh, 1000, ",")) !== FALSE) {
                $num = count($data);
                if($num != 3)
                {
                    $check = 0;
                }
                if($i == 0)
                {
                    $header_row = $data;
                }
                $i++;
            }
            fclose($fh);
        }
        if(!$check)
        {
            return $this->_throw($file, self::NOT_ACCEPTED_FORMAT);
        }
        if($header_row !== $header)
        {
            return $this->_throw($file, self::NOT_ACCEPTED_HEADER);
        }
    }

    protected function _throw($file, $errorType)
    {
        $this->_value = $file["name"];
        $this->_error($errorType);
        return false;
    }
}
?>
