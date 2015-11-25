<?php

namespace Pagekit\Highlight;

use Pagekit\Application as App;

/**
 * @Access(admin=true)
 */
class HighlightController
{
    public function settingsAction()
    {
        $module = App::module('highlight');

        // fetch available styles
        $stylefolder = App::locator()->get('highlight:assets/styles');
        $styles = array_map(function($fn){
            return pathinfo($fn, PATHINFO_FILENAME);
        }, glob($stylefolder.'/*.css'));

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

    /**
     * @Request({"style": "string", "enable": "string"}, csrf=true)
     */
    public function saveAction($style, $enable)
    {
        App::config('highlight')
            ->set('style', $style)
            ->set('enable', $enable);

        return ['success' => true];
    }
}
