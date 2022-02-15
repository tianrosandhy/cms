<?php
$rfield = str_replace('[]', '', $row->getField());
?>
@if($row->getDataSource() == 'text')
    @if(in_array($row->getInputType(), ['date', 'daterange', 'datetime']))
        <x-core::input.daterange :name="'datatable_filter['.$rfield.'][]'" :attr="[
            'data-id' => 'datatable-filter-' . $rfield
        ]" />
    @else
        <x-core::input.text :name="'datatable_filter['.$rfield.']'" :attr="[
            'data-id' => 'datatable-filter-' . $rfield
        ]" />
    @endif
@else
    <?php
    $source = $row->getDataSource();
    if(is_callable($source)){
        $source = call_user_func($source);
        if($source instanceof \Illuminate\Support\Collection){
            $source = collect()->unwrap($source);
        }
    }
    ?>
    @if(is_array($source))
    <x-core::input.select name="'datatable_filter['.$rfield.']'" :source="$source" :attr="[
        'data-id' => 'datatable-filter-' . $rfield
    ]" />
    @endif
@endif