<?php

namespace SilverStripe\Twig;

use BadMethodCallException;
use SilverStripe\Template\View\SSViewer_Scope;
use SilverStripe\View\TemplateEngine as ViewTemplateEngine;
use SilverStripe\View\ViewableData;

class TemplateEngine implements ViewTemplateEngine
{
    public function process(string $template, ViewableData $item, array $overlay, array $underlay, ?SSViewer_Scope $inheritedScope = null): string
    {
        throw new BadMethodCallException('This has not been implemented yet.');
    }

    public static function flush()
    {
        // no-op for now
    }
}
