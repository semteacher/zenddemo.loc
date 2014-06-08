<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Report;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
 use Report\Model\Report;
 use Report\Model\ReportTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;

class Module
{


    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
     // Add this method:
     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Report\Model\ReportTable' =>  function($sm) {
                     $tableGateway = $sm->get('ReportTableGateway');
                     $table = new ReportTable($tableGateway);
                     return $table;
                 },
                 'ReportTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Report());
                     return new TableGateway('report', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

}
