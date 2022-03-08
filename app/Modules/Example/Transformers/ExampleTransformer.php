<?php
namespace App\Modules\Example\Transformers;

use App\Core\Base\Transformer\BaseTransformer;
use App\Core\Contracts\CanTransform;
use Permission;

class ExampleTransformer extends BaseTransformer implements CanTransform
{
    public function transform($row, $mode = 'datatable')
    {
        if ($mode == 'export') {
            $daterange = json_decode($row->daterange, true);
            $sdaterange = '';
            if ($daterange) {
                $sdaterange = implode(', ', $daterange);
            }
            $select_multiple = json_decode($row->select_multiple, true);
            $sselect_multiple = '';
            if ($select_multiple) {
                $sselect_multiple = implode(', ', $select_multiple);
            }
            $checkbox = json_decode($row->checkbox, true);
            $scheckbox = '';
            if ($checkbox) {
                $scheckbox = implode(', ', $checkbox);
            }

            return [
                'text' => $row->e('text'),
                'number' => $row->number,
                'dates' => $row->dates,
                'daterange' => $sdaterange,
                'select' => $row->select,
                'select_multiple' => $sselect_multiple,
                'radio' => $row->radio,
                'checkbox' => $scheckbox,
                'yesno' => $row->yesno ? 'YES' : 'NO',
            ];
        }

        // default return
        return [
            'id' => $this->checkerFormat($row),
            'text' => $row->e('text'),
            'number' => $row->number,
            'dates' => $row->dates,
            'daterange' => $row->generateTags('daterange'),
            'select' => $row->select,
            'select_multiple' => $row->generateTags('select_multiple'),
            'textarea' => $row->textarea,
            'richtext' => $row->richtext,
            'image' => $row->outputImage('image'),
            'image_multiple' => $row->outputImage('image_multiple'),
            'file' => $row->outputFile('file'),
            'file_multiple' => $row->outputFile('file_multiple'),
            'radio' => $row->radio,
            'checkbox' => $row->generateTags('checkbox'),
            'yesno' => $this->switcherFormat($row, 'yesno', (Permission::has('admin.example.switch') ? 'toggle' : 'label')),
            'map' => $row->generateTags('map'),
            'action' => $this->actionButton($row),
        ];
    }

    protected function actionButton($row)
    {
        $out = '<div class="btn-group">';
        if (Permission::has('admin.example.edit')) {
            $out .= '<a href="' . route('admin.example.edit', ['id' => $row->id]) . '" class="btn btn-light text-primary" data-popup-lg title="Edit"><span class="iconify" data-icon="dashicons:edit"></span></a>';
        }
        if (Permission::has('admin.example.delete')) {
            $out .= '<a href="' . route('admin.example.delete', ['id' => $row->id]) . '" class="btn btn-light text-danger delete-button" title="Delete"><span class="iconify" data-icon="fluent:delete-16-filled"></span></a>';
        }
        $out .= '</div>';
        return $out;
    }

}
