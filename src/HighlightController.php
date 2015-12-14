<?php

namespace Pagekit\Highlight;

use Pagekit\Application as App;
use Pagekit\Site\Model\Node;


/**
 * @Access(admin=true)
 */
class HighlightController
{
    /*
     *  Returns several config settings needed for the settings view.
     */
    public function configAction()
    {
        $styles = $this->getStyles();

        return compact('styles');
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
