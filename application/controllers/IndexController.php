<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $form = new Application_Form_Upload();
        $form->submit->setLabel('Send');
        $this->view->form = $form;

        if($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData))
            {
                try {
                    $values = $form->getValues();
                    $this->view->data = $values;
                    $this->render('result');
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
            else
            {
                $form->populate($formData);
            }
        }
    }



}



