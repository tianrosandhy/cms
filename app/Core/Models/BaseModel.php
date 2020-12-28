<?php
namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\Shared\ImageGrabable;
use App\Core\Shared\FileGrabable;

//helper methods for every model in CMS
class BaseModel extends Model
{
    use ImageGrabable;
    use FileGrabable;

    public function e($field){
        return e($this->{$field});
    }

    public function generateTags($field, $config=[]){
        $tag_container = $config['container_class'] ?? 'tag-container';
        $template = $config['template'] ?? '<span class="badge badge-primary">|LABEL|</span> ';
        $out = '<div class="'.$tag_container.'">';
        $tags = json_decode($this->{$field}, true);
        if($tags){
            foreach($tags as $tg){
                $tpl = $template;
                $tpl = str_replace('|LABEL|', $tg, $tpl);
                $out .= $tpl;
            }
        }
        $out .= '</div>';
        return $out;
    }




}
