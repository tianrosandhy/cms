<?php
namespace App\Core\Excels;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ViewExporter implements FromView
{
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function view(): View
    {
        return $this->view;
    }
}
