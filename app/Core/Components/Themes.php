<?php
namespace App\Core\Components;

class Themes
{
    public function __construct()
    {
        $this->fallback_theme = config('cms.admin.theme', 'xoric');
        $this->base_path = config('cms.admin.theme_paths', 'themes');
    }

    public function availableThemes()
    {
        $paths = public_path($this->base_path);
        if (!is_dir($paths)) {
            return [];
        }

        $listing = array_diff(scandir($paths), ['.', '..']);
        return array_values($listing);
    }

    public function activeTheme()
    {
        return setting('general.theme', $this->fallback_theme);
    }

    public function layoutPath()
    {
        return realpath(public_path($this->base_path . '/' . $this->activeTheme() . '/layouts'));
    }

    public function assetPath()
    {
        return realpath(public_path($this->base_path . '/' . $this->activeTheme() . '/assets'));
    }

    public function layoutExists()
    {
        $layout_path = $this->layoutPath();
        return is_dir($layout_path);
    }
    
    public function assetExists()
    {
        $asset_path = $this->assetPath();
        return is_dir($asset_path);
    }
    
    public function validTheme()
    {
        return ($this->layoutExists() && $this->assetExists());
    }
}