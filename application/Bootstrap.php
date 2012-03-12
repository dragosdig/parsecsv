<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initUploadDir() {
        define('UPLOAD_PATH', '/tmp');
    }
}

