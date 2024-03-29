<?php
namespace App\Core\Components\Sidebar;

use App\Core\Shared\DynamicProperty;

// class instance utk single sidebar item
class SidebarItem
{
    use DynamicProperty;

    private $name;
    private $url;
    private $route;
    private $label;
    private $icon;
    private $sort_no = 999;
    private $privilege = [];
    private $parent;
    private $children;
    private $active_key = [];

    public function __construct($name = null, $config = [])
    {
        $this->setName($name);
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function addChildren($keyname, SidebarItem $item)
    {
        $this->children[$keyname] = $item;
        return $this;
    }

    public function setActiveKey($var)
    {
        if (!is_array($var)) {
            $var = [$var];
        }
        $this->active_key = $var;
        return $this;
    }

    public function setRoute($var)
    {
        $this->route = $var;
        $this->url = route($var);
        return $this;
    }

    public function url()
    {
        if ($this->url) {
            return url($this->url);
        }
        return '#';
    }
}
