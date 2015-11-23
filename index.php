<?php

use Pagekit\Application;

return [

    'name' => 'highlight',

    'resources' => [
        'highlight:' => ''
    ],

    'events' => [

        'site' => function ($event, $app) {

            $app->on('view.content', function ($event) {

                if(strpos($event->getResult(), '<pre') || strpos($event->getResult(), '<code')) {
                    Application::scripts()->add('highlight', 'highlight:assets/highlight.pack.js');
                    Application::scripts()->add('highlight-init', 'highlight:assets/highlight.js', 'highlight');
                    Application::styles()->add('highlight', 'highlight:assets/styles/github.css');
                    Application::styles()->add('highlight-override', 'highlight:assets/style-override.css', ['highlight-style']);
                }
            });
        }

    ]

];
