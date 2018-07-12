<?php

namespace MyVisit\Factory\Controller\Plugin;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use \MyVisit\Controller\Plugin\ContentfulRecordHelper;

class ContentfulRecordHelperFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return SiteConfigHelper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->getServiceLocator()->get('Config');

        return new ContentfulRecordHelper($config);
    }

}
