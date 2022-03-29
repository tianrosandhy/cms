<?php
namespace TianRosandhy\Autocrud\StructureCollection;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Collection;

interface FormStructureCollectionContract extends BaseStructureCollectionContract
{
    public function formRoute(): string;

    public function isMultiLanguage(): bool;

    public function isAjax(): bool;
}