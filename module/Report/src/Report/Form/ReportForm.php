<?php
namespace Report\Form;

 use Zend\Form\Form;

 class ReportForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('report');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'reptitle',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Report Title',
             ),
         ));
         $this->add(array(
             'name' => 'repname',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Report Name',
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }