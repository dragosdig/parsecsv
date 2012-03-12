<?php

class Application_Form_Upload extends Zend_Form
{

    public function init()
    {
        $this->setName('uploadcsv');

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email address:')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('EmailAddress');
        $csv_file = new Zend_Form_Element_File('csv_file');
        $csv_file->setLabel('Csv file:')
            ->setDestination(UPLOAD_PATH)
            ->setRequired(true)
            ->addValidator('Size', false, 102400)
            ->addValidator('Extension', false, 'txt,csv')
            ->addValidator(new Common_Validate_File_CsvFile());
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'do_upload');

        $this->addElements(array($email, $csv_file, $submit));
    }


}
