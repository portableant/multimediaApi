<?php
namespace api;

use ZF\Apigility\Provider\ApigilityProviderInterface;


class Module implements ApigilityProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'ZF\Apigility\Autoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'api\V1\Rest\Visits\VisitsMapper' => function ($sm) {
                    $adapterMaster = $sm->get('dbMasterAdapter');
                    $adapterSlave = $sm->get('dbSlaveAdapter');
                    return new \api\V1\Rest\Visits\VisitsMapper($adapterMaster, $adapterSlave);
                },
                'api\V1\Rest\Visits\VisitsResource' => function ($sm) {
                    $mapper = $sm->get('api\V1\Rest\Visits\VisitsMapper');
                    return new \api\V1\Rest\Visits\VisitsResource($mapper);
                },
            ),
        );
    }

}
