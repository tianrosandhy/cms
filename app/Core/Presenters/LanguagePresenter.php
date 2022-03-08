<?php
namespace App\Core\Presenters;

use App\Core\Base\Presenters\BaseViewPresenter;
use Language;

class LanguagePresenter extends BaseViewPresenter
{
    public function __construct()
    {
        $this->title = __('core::module.menu.language_management');
        $this->default_language = Language::default();
        $this->secondary_language = Language::secondary();
        $this->view = 'core::pages.language.index';
    }

    public function setSelectedMenuName()
    {
        return 'language';
    }
}
