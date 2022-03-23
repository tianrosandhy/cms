<?php
$rfield = str_replace('[]', '', $struct->getField());
?>
@if($struct->getDataSource() == null)
    @if(in_array($struct->getInputType(), [Input::TYPE_DATE, Input::TYPE_DATERANGE, Input::TYPE_DATETIME]))
        <x-autocrud-input::daterange :name="'datatable_filter['.$rfield.'][]'" :attr="[
            'data-id' => 'datatable-filter-' . $rfield
        ]" />
    @else
        <x-autocrud-input::text :name="'datatable_filter['.$rfield.']'" :attr="[
            'data-id' => 'datatable-filter-' . $rfield
        ]" />
    @endif
@else
    <?php
    $source = $struct->getDataSource();
    if(is_callable($source)){
        $source = call_user_func($source);
        if($source instanceof \Illuminate\Support\Collection){
            $source = collect()->unwrap($source);
        }
    }
    ?>
    @if(is_array($source))
    <x-autocrud-input::select name="'datatable_filter['.$rfield.']'" :source="$source" :attr="[
        'data-id' => 'datatable-filter-' . $rfield
    ]" />
    @endif
@endif