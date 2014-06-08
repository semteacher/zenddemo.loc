<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Report\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;

 class ReportController extends AbstractActionController
 {
	protected $reportTable;
 
     public function indexAction()
     {
	          return new ViewModel(array(
             'reports' => $this->getReportTable()->fetchAll(),
         ));
     }

     public function addAction()
     {
     }

     public function editAction()
     {
     }

     public function deleteAction()
     {
     }
     public function getReportTable()
     {
         if (!$this->reportTable) {
             $sm = $this->getServiceLocator();
             $this->reportTable = $sm->get('Report\Model\ReportTable');
         }
         return $this->reportTable;
     }	 
 }
