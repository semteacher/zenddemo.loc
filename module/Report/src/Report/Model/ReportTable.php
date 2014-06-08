<?php
namespace Report\Model;

 use Zend\Db\TableGateway\TableGateway;

 class ReportTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getReport($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveReport(Report $report)
     {
         $data = array(
             'repname' => $report->repname,
             'reptitle'  => $report->reptitle,
         );

         $id = (int) $report->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getReport($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Report id does not exist');
             }
         }
     }

     public function deleteReport($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }