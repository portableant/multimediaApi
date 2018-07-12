<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace MyVisit;

return array(
    'router' => array(
        'routes' => array(
            'myvisit' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/visit',
                    'defaults' => array(
                        '__NAMESPACE__' => 'MyVisit\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]:id[/]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'MyVisit\Controller',
                                'controller'    => 'Index',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'MyVisit\Controller\Index' => 'MyVisit\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ .  '/../../Application/view/layout/layout.phtml',
            'myvisit/index/index' => __DIR__ . '/../view/my-visit/index/index.phtml',
            'error/404'               => __DIR__ . '/../../Application/view/error/404.phtml',
            'error/index'             => __DIR__ . '/../../Application/view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
            __DIR__ . '/../view/my-visit/partials/',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'contentfulRecordHelper' => 'MyVisit\View\Helper\ContentfulRecordHelper',
            'streetViewHelper' => 'MyVisit\View\Helper\ContentfulRecordHelper',
            'dateTime' => 'MyVisit\View\Helper\Datetime'
        ),
//        'factories' => array(
//            'contentfulRecordHelper' => 'MyVisit\Factory\View\Helper\ContentfulRecordHelperFactory'
//        ),
    ),
    'controller_plugins' => array(
        'factories' => array(
            'contentfulRecordHelper' => 'MyVisit\Factory\Controller\Plugin\ContentfulRecordHelperFactory',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
