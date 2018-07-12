<?php

namespace Myvist\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use \Myvisit\View\Helper\ContentfulRecordHelper;
use Zend;


class ContentfulRecordHelperFactory implements FactoryInterface {

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ContentfulRecordHelper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->getServiceLocator()->get('Config');
        return new ContentfulRecordHelper($config);
    }

}
