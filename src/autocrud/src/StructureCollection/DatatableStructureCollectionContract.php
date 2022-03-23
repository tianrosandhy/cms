<?php
namespace TianRosandhy\Autocrud\StructureCollection;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Collection;

interface DatatableStructureCollectionContract extends BaseStructureCollectionContract
{
    public function dataTableRoute(): string;

    public function queryBuilder(): QueryBuilder|EloquentBuilder;

    public function transformer($raw_data): array;
}