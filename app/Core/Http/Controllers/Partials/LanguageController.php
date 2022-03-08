<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Presenters\LanguagePresenter;
use Language as Helper;

trait LanguageController
{
    public function language()
    {
        return (new LanguagePresenter)->render();
    }

    public function addLanguage()
    {
        if (is_array($this->request->languages)) {
            foreach ($this->request->languages as $lang) {
                Helper::setAsSecondary($lang);
            }
        }
        removeCache('language');
        return redirect()->route('admin.language.index')->with('success', 'Secondary languages has been updated');
    }

    public function setAsDefaultLanguage($code)
    {
        Helper::setAsDefault($code);
        removeCache('language');
        return redirect()->route('admin.language.index')->with('success', 'Default language has been changed');
    }

    public function removeLanguage($code)
    {
        Helper::remove($code);
        removeCache('language');
        return redirect()->route('admin.language.index')->with('success', 'Default language has been deleted');
    }

}
