<?php
return array(
    'service_manager' => array(
        'invokables' => array(
            'ZF\\Rest\\RestParametersListener' => 'ZF\\Rest\\Listener\\RestParametersListener',
        ),
        'factories' => array(
            'ZF\\Rest\\OptionsListener' => 'ZF\\Rest\\Factory\\OptionsListenerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'api.rest.visits' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/visits[/:visits_id]',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rest\\Visits\\Controller',
                    ),
                ),
            ),
            'api.rpc.ping' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/ping',
                    'defaults' => array(
                        'controller' => 'api\\V1\\Rpc\\Ping\\Controller',
                        'action' => 'ping',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'api.rest.visits',
            1 => 'api.rpc.ping',
        ),
    ),
    'zf-rest' => array(
        'api\\V1\\Rest\\Visits\\Controller' => array(
            'listener' => 'api\\V1\\Rest\\Visits\\VisitsResource',
            'route_name' => 'api.rest.visits',
            'route_identifier_name' => 'visits_id',
            'collection_name' => 'visits',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(
                0 => 'page',
            ),
            'page_size' => '30',
            'page_size_param' => 'page',
            'entity_class' => 'api\\V1\\Rest\\Visits\\VisitsEntity',
            'collection_class' => 'api\\V1\\Rest\\Visits\\VisitsCollection',
            'service_name' => 'visits',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'api\\V1\\Rest\\Visits\\Controller' => 'HalJson',
            'api\\V1\\Rpc\\Ping\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'api\\V1\\Rest\\Visits\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'api\\V1\\Rpc\\Ping\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'api\\V1\\Rest\\Visits\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
            'api\\V1\\Rpc\\Ping\\Controller' => array(
                0 => 'application/vnd.api.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'api\\V1\\Rest\\Visits\\VisitsEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.visits',
                'route_identifier_name' => 'visits_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'api\\V1\\Rest\\Visits\\VisitsCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'api.rest.visits',
                'route_identifier_name' => 'visits_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-apigility' => array(
        0 => array(
            'db-connected' => array(
                'api\\V1\\Rest\\Visits\\VisitsResource' => array(
                    'adapter_name' => 'mmg',
                    'table_name' => 'visits',
                    'hydrator_name' => 'ArraySerializable',
                    'controller_service_name' => 'api\\V1\\Rest\\Visits\\Controller',
                    'table_service' => 'api\\V1\\Rest\\Visits\\VisitsResource\\Table',
                ),
            ),
        ),
    ),
    'zf-content-validation' => array(
        'api\\V1\\Rest\\Visits\\Controller' => array(
            'input_filter' => 'api\\V1\\Rest\\Visits\\Validator',
        ),
        'api\\V1\\Rpc\\Ping\\Controller' => array(
            'input_filter' => 'api\\V1\\Rpc\\Ping\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'api\\V1\\Rest\\Visits\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'stops',
                'allow_empty' => true,
                'description' => 'The stops on the visit to the museum',
            ),
            1 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'started',
                'description' => 'The start time for the visit',
            ),
            2 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'ended',
                'description' => 'The end time for the visit',
            ),
            3 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'subscribed',
                'description' => 'Whether the user of the audio guide has subscribed to the BM newsletter',
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
            4 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'email',
                'description' => 'An email address for the user',
                'allow_empty' => true,
                'continue_if_empty' => true,
            ),
        ),
        'api\\V1\\Rpc\\Ping\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'acknowledge',
                'description' => 'Acknowledge the request with timestamp returned',
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'api\\V1\\Rest\\Visits\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'api\\V1\\Rpc\\Ping\\Controller' => 'api\\V1\\Rpc\\Ping\\PingControllerFactory',
        ),
    ),
    'zf-rpc' => array(
        'api\\V1\\Rpc\\Ping\\Controller' => array(
            'service_name' => 'ping',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'api.rpc.ping',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            0 => __DIR__ . '/../view',
        ),
    ),
);
