<?php

namespace SilverStripe\Twig;

use BadMethodCallException;
use SilverStripe\View\TemplateEngine as ViewTemplateEngine;

class TemplateEngine implements ViewTemplateEngine
{
    public function renderString(string $content, bool $includeDebugComments = false, string $templateName = ''): string
    {
        throw new BadMethodCallException('This has not been implemented yet.');
    }
}
