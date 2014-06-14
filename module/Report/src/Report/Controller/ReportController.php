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
 use Report\Model\Report;          
 use Report\Form\ReportForm;
 
 use Doctrine\ORM\EntityManager; //doctrine

 class ReportController extends AbstractActionController
 {
	protected $reportTable;
    protected $em;
 
     public function indexAction()
     {
	          return new ViewModel(array(
             'reports' => $this->getReportTable()->fetchAll(),
         ));
     }

     public function addAction()
     {
         $form = new ReportForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $report = new Report();
             $form->setInputFilter($report->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $report->exchangeArray($form->getData());
                 $this->getReportTable()->saveReport($report);

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('report');
             }
         }
         return array('form' => $form);
     }

     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('report', array(
                 'action' => 'add'
             ));
         }

         // Get the Report with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $report = $this->getReportTable()->getReport($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('report', array(
                 'action' => 'index'
             ));
         }

         $form  = new ReportForm();
         $form->bind($report);
         $form->get('submit')->setAttribute('value', 'Save changes');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($report->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getReportTable()->saveReport($report);

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('report');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
     }

     public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('report');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getReportTable()->deleteReport($id);
             }

             // Redirect to list of albums
             return $this->redirect()->toRoute('report');
         }

         return array(
             'id'    => $id,
             'report' => $this->getReportTable()->getReport($id)
         );
     }
     
    //doctrine 
    public function getEntityManager()
    {
    if (null === $this->em) {
        $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }
    return $this->em;
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
