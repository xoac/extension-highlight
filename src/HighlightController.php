<?php

namespace Pagekit\Highlight;

use Pagekit\Application as App;
use Pagekit\Site\Model\Node;


/**
 * @Access(admin=true)
 */
class HighlightController
{
    public function settingsAction()
    {
        $module = App::module('highlight');

        $styles = $this->getStyles();

        return [
            '$view' => [
                'name' => 'highlight:views/settings.php',
                'title' => 'Highlight settings'
            ],
            '$data' => [
                'config' => $module->config,
                'styles' => $styles
            ]
        ];
    }

    public function configAction()
    {
        $styles = $this->getStyles();
        $config = [
            'menus' => App::menu(),
            'nodes' => array_values(Node::query()->get())
        ];

        return compact('styles', 'config');
    }

    /**
     * Return an array of all available styles.
     */
    protected function getStyles()
    {
        $stylefolder = App::locator()->get('highlight:assets/styles');

        return array_map(function($fn){
            return pathinfo($fn, PATHINFO_FILENAME);
        }, glob($stylefolder.'/*.css'));
    }


}
