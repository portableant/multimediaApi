<?php
require __DIR__ . '/src/api/Module.php';

class Module
{

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                /* Models */
                'MyModule\MyModel' => function ($sm) {
                    return new Models\MyModel($sm);
                },
            ),
        );
    }
}