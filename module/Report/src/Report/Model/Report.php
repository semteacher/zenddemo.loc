<?php
namespace Report\Model;

 class Report
 {
     public $id;
     public $repname;
     public $reptitle;

     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->repname = (!empty($data['repname'])) ? $data['repname'] : null;
         $this->reptitle  = (!empty($data['reptitle'])) ? $data['reptitle'] : null;
     }
 }