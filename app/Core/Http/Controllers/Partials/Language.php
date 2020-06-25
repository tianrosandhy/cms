<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Presenters\LanguagePresenter;
use App\Core\Http\Process\LanguageDatatableProcess;

trait Language
{
	public function language(){
		return (new LanguagePresenter)->render();
	}

	public function languageDataTable(){
		return (new LanguageDatatableProcess)
			->type('datatable')
			->handle();
	}
}