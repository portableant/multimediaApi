<?php
/**
 * Created by PhpStorm.
 * User: danielpett
 * Date: 28/10/2015
 * Time: 14:53
 */
return array(
    'modules' => array(
        'ZF\Apigility\Admin',
        'ZF\Configuration',
        'BjyProfiler',
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}-development.php',
        )
    )
);