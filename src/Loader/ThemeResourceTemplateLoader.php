<?php

namespace SilverStripe\Twig\Loader;

use SilverStripe\Control\Director;
use SilverStripe\View\ThemeResourceLoader;
use Twig\Error\LoaderError;
use Twig\Loader\LoaderInterface;
use Twig\Source;

/**
 * Twig template loader which uses Silverstripe framework's ThemeResourceLoader to find interfaces.
 */
class ThemeResourceTemplateLoader implements LoaderInterface
{
    private ThemeResourceLoader $loader;

    private array $cache = [];

    public function __construct()
    {
        $this->loader = ThemeResourceLoader::inst();
    }

    public function getSourceContext(string $name): Source
    {
        $path = $this->findTemplate($name);
        if ($path === null) {
            throw new LoaderError("Could not find template '$name'");
        }

        return new Source(file_get_contents($path), $name, $path);
    }

    public function getCacheKey(string $name): string
    {
        $path = $this->findTemplate($name);
        if ($path === null) {
            throw new LoaderError("Could not find template '$name'");
        }
        return str_replace(['\\','/',':'], '.', Director::makeRelative(realpath($path ?? '')) ?? '') . '-php';
    }

    public function isFresh(string $name, int $time): bool
    {
        $path = $this->findTemplate($name);
        if ($path === null) {
            throw new LoaderError("Could not find template '$name'");
        }

        return filemtime($path) < $time;
    }

    public function exists(string $name)
    {
        $name = $this->normalizeName($name);
        if (isset($this->cache[$name])) {
            return true;
        }

        return $this->findTemplate($name, false) !== null;
    }

    protected function findTemplate(string $name): ?string
    {
        $path = $this->loader->findTemplate($name);
        if ($path !== null) {
            $name = $this->normalizeName($name);
            $this->cache[$name] = $path;
        }

        return $path;
    }

    private function normalizeName(string $name): string
    {
        return preg_replace('#/{2,}#', '/', str_replace('\\', '/', $name));
    }
}
