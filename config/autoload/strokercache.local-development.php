<?php
return array(
    'strokercache' => array(
        'storage_adapter' => array(
            'name' => 'filesystem',
            'options' => [
                'cache_dir' => __DIR__ . '/../../data/cache'
            ],
        ),
        'strategies' => array(
            'enabled' => array(
                'StrokerCache\Strategy\RouteName' => array(
                    'routes' => array(
                        'home',
                        'myvisit/default'
                    ),
                ),
            ),
        )
    )
);