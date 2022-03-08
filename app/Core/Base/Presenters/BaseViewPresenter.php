<?php
namespace App\Core\Base\Presenters;

use App\Core\Exceptions\ViewPresenterException;
use App\Core\Shared\DynamicProperty;
use Log;
use Setting;
use Sidebar;
use Exception;

class BaseViewPresenter
{
    use DynamicProperty;

    public $view;
    public $user;
    public $selected_menu;
    public $custom_css;
    public $custom_js;
    public $base_layout = null;
    public $default_base_layout = 'core::layouts.master'; // default view layout main extends

    public function setDefaultProperty()
    {
        $request = request();
        $this->request = $request;
        $this->user = $request->get('user');
        $this->role = $request->get('role');
        $this->is_sa = $request->get('is_sa');
        $this->base_permission = $request->get('base_permission');

        $this->setting = Setting::data();
        $this->sidebar = Sidebar::generate();

        if (empty($this->selected_menu)) {
            if (method_exists($this, 'setSelectedMenuName')) {
                $this->selected_menu = $this->setSelectedMenuName();
            } else {
                $this->selected_menu = Sidebar::fallbackSelectedMenu();
            }
        }

        if (!property_exists($this, 'breadcrumb')) {
            $this->breadcrumb = [];
        }

        if (empty($this->base_layout)) {
            $this->base_layout = $this->default_base_layout;
            if ($this->request->ajax()) {
                // return a blank base layout instead if the base_layout not defined
                $this->base_layout = 'core::layouts.master-ajax';
            }
        }
    }

    public function render()
    {
        if (!$this->view) {
            throw new ViewPresenterException('You need to set the view target with "->setView(...)" before render the presenter');
        }

        $this->setDefaultProperty();

        $data = get_object_vars($this);
        try {
            $view = view($this->view, $data)->render();
        } catch (Exception $e) {
            Log::error("THROWN VIEW PRESENTER EXCEPTION IN " . get_class($this) . " : ", [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);
            throw $e;
        }
        return $view;
    }

}
