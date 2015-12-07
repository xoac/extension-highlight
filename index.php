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
        // default style. styles are located as css files in the styles folder
        'style' => 'github',

        // Only load if page contains pre or code
        'autodetect' => true,

        // ids of pages where highlighting should be enabled
        'nodes' => []
    ],

    'settings' => 'highlight-settings',

    'events' => [
		'view.scripts' => function ($event, $scripts) use ($app) {
			$scripts->register('highlight-settings', 'highlight:app/bundle/highlight-settings.js', ['~extensions', 'input-tree']);
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

                $current = Application::node()->id;

                // should be loaded on current page?
                if (in_array($current, $config['nodes'])) {

                    if($config['autodetect'] && (strpos($event->getResult(), '<pre') || strpos($event->getResult(), '<code'))) {

                        $load();

                    } elseif (!$config['autodetect']) {

                        $load();

                    }
                }
            });
        }

    ]

];
