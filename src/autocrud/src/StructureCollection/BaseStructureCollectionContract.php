<?php
namespace TianRosandhy\Autocrud\StructureCollection;

use Illuminate\Support\Collection;

interface BaseStructureCollectionContract
{
    public function registers(array $item);

    public function output(): Collection;
}
