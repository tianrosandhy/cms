<?php
namespace App\Core\Transformers;

use App\Core\Base\Transformer\BaseTransformer;
use App\Core\Contracts\CanTransform;
use Media;
use Permission;

class UserTransformer extends BaseTransformer implements CanTransform
{
    public function transform($row, $mode='datatable'){
		return [
			'id' => $this->checkerFormat($row),
			'name' => $row->name,
			'email' => $row->email,
			'role_id' => $row->role->name ?? '<small class="text-danger">Unassigned</small>',
			'image' => '<img src="'.Media::getSelectedImage($row->image, 'thumb').'" style="height:50px;">',
			'is_active' => $this->switcherFormat($row, 'is_active', (Permission::has('admin.user.switch') ? 'toggle' : 'label')),
			'action' => $this->actionButton($row)
		];
    }

	protected function actionButton($row){
		$out = '
		<div class="btn-group">
		';
		if(Permission::has('admin.user.edit'))
		$out .= '<a href="'.route('admin.user.edit', ['id' => $row->id]).'" class="btn btn-light text-primary"><span class="iconify" data-icon="dashicons:edit"></span></a>';

		$is_sa = $row->role->is_sa ?? false;
		if(!$is_sa){
			if(Permission::has('admin.user.delete')){
				$out .= '
				<a href="'. route('admin.user.delete', ['id' => $row->id]) .'" class="btn btn-light text-danger delete-button"><span class="iconify" data-icon="fluent:delete-16-filled"></span></a>
				';
			}
		}
		$out .= '</div>';

		return $out;
	}
}