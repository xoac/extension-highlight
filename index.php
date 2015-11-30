<?php

use Pagekit\Application;

return [

    'name' => 'highlight',

    'resources' => [
        'highlight:' => ''
    ],

    'autoload' => [
        'Pagekit\\Highlight\\' => 'src'
    ],

    'routes' => [
        '/highlight' => [
            'name' => '@highlight',
            'controller' => [
                'Pagekit\\Highlight\\HighlightController'
            ]
        ],
    ],

    'config' => [
        'style' => 'github',
        'enable' => 'auto'
    ],

    'settings' => 'highlight-settings',

    'events' => [
		'view.scripts' => function ($event, $scripts) use ($app) {
			$scripts->register('highlight-settings', 'highlight:app/bundle/highlight-settings.js', '~extensions');
		},

        'site' => function ($event, $app) {

            $config = Application::module('highlight')->config;

            $load = function() use ($config) {
                Application::scripts()->add('highlight', 'highlight:assets/highlight.pack.js');
                Application::scripts()->add('highlight-init', 'highlight:assets/highlight.js', 'highlight');
                Application::styles()->add('highlight', 'highlight:assets/styles/'.$config['style'].'.css');
                Application::styles()->add('highlight-override', 'highlight:assets/style.css', 'highlight');
            };

            $app->on('view.content', function ($event) use ($config, $load) {
                if($config['enable'] == "auto" && (strpos($event->getResult(), '<pre') || strpos($event->getResult(), '<code'))) {

                    $load();

                } else if($config['enable'] == "select") {

                    // FIXME

                }
            });
        }

    ]

];
