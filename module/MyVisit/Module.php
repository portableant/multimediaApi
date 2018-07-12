<?php

namespace MyVisit;

use MyVisit\Model\Visits;
use MyVisit\Model\VisitsTable;
use MyVisit\View\Helper\ContentfulRecordHelper;
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

//    public function getViewHelperConfig()
//    {
//        return array(
//            'ContentfulRecordHelper' => function($sm){
//                $locator = $sm->getServiceLocator();
//                $cache = new ContentfulRecordHelper();
//                return $cache->setCache($locator->get('cache'));
//            }
//        );
//    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'MyVisit\Model\VisitsTable' => function($sm){
                    $tableGateway = $sm->get('VisitsTableGateway');
                    $table = new VisitsTable($tableGateway);
                    return $table;
                },
                'VisitsTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $results = new ResultSet();
                    $results->setArrayObjectPrototype(new Visits());
                    return new TableGateway( 'visits', $dbAdapter, null, $results);
                },
            ),
        );
    }

}
