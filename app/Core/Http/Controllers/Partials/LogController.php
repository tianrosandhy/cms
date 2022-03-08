<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Base\Presenters\BaseViewPresenter;

trait LogController
{

    public function log()
    {
        $title = 'Log';

        $active_log = $this->request->active_log;
        $available_log = $this->getAvailableFileLog();
        $log_size = $this->getLogSize();

        $selected_menu = 'log';
        $presenter = (new BaseViewPresenter)->with(compact(
            'title',
            'available_log',
            'active_log',
            'log_size',
            'selected_menu'
        ))->setView('core::pages.log.index');
        return $presenter->render();
    }

    public function getLogSize()
    {
        $this->request->active_log;
        $ava = $this->getAvailableFileLog();
        if (in_array($this->request->active_log, $ava)) {
            $filepath = $this->logPath($this->request->active_log);
            return filesize_formatted($filepath);
        }
        return false;
    }

    public function getFileLog($filename = '')
    {
        $available = $this->getAvailableFileLog();
        if (strlen($filename) > 0) {
            if (in_array($filename, $available)) {
                $logpath = $this->logPath($filename);
                if (is_file($logpath)) {
                    return file_get_contents($logpath);
                }
            }
        }
        return false;
    }

    public function getAvailableFileLog()
    {
        $path = $this->logPath();
        if (is_dir($path)) {
            $list = scandir($path);
            //buang . , .. , .gitignore , laravel.log
            $list = array_values(array_diff($list, [
                '.',
                '..',
                '.gitignore',
            ]));

            if ($list) {
                return $list;
            }
        }
        return [];
    }

    protected function logPath($path = '')
    {
        return storage_path('logs') . (strlen($path) > 0 ? '/' . $path : '');
    }

    public function logExport()
    {
        $active_log = $this->request->active_log;
        $available = $this->getAvailableFileLog();
        if (!in_array($active_log, $available)) {
            abort(404);
        }

        $file_log = $this->logPath($active_log);
        if (strlen($file_log) > 0) {
            return response()->download($file_log);
        }
    }

}
