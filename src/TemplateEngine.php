<?php

namespace SilverStripe\Twig;

use SilverStripe\Control\Director;
use SilverStripe\Core\Flushable;
use SilverStripe\Core\Path;
use SilverStripe\Template\View\SSViewer_Scope;
use SilverStripe\Twig\Loader\ThemeResourceTemplateLoader;
use SilverStripe\View\SSViewer;
use SilverStripe\View\TemplateEngine as ViewTemplateEngine;
use SilverStripe\View\ViewableData;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

class TemplateEngine implements ViewTemplateEngine, Flushable
{
    private Environment $twig;

    public function __construct()
    {
        $options = [
            'cache' => static::getCacheDir(),
        ];
        if (Director::isDev() && SSViewer::config()->uninherited('source_file_comments')) {
            $options['debug'] = true;
        }
        $this->twig = new Environment(new ThemeResourceTemplateLoader(), $options);
        $this->loadGlobals();
    }

    public function process(string $template, ViewableData $item, array $overlay, array $underlay, ?SSViewer_Scope $inheritedScope = null): string
    {
        return $this->twig->render($template, ['obj' => $item]);
    }

    public static function flush()
    {
        $fileSystem = new Filesystem();
        $fileSystem->remove(static::getCacheDir());
    }

    /**
     * Load the template global properties into the twig environment
     */
    protected function loadGlobals(): void
    {
        // Maybe these should be loaded as functions?
        $this->twig->mergeGlobals(SSViewer::getGlobalProperties());
    }

    /**
     * Get the path to the directory where template cache is stored
     */
    protected static function getCacheDir(): string
    {
        return Path::join(TEMP_PATH, '.twig-template-cache');
    }
}
