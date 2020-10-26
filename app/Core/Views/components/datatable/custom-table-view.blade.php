<div class="custom-datatable-wrapper">
    @include ('core::components.datatable.filter-box')
    <div class="card card-body">
        <input type="hidden" id="{{ $skeleton->getSkeletonName() }}-page" value="1">
        <div class="row">
            <div class="col-lg-2 col-sm-4">
                <div class="form-group">
                    <label>Data per Page</label>
                    <input type="number" id="{{ $skeleton->getSkeletonName() }}-perpage" min="5" max="100" class="form-control custom-datatable-filter" value="10">
                </div>
            </div>
            <div class="col-lg-3 col-sm-4">
                <div class="form-group">
                    <label>Sort By</label>
                    <select id="{{ $skeleton->getSkeletonName() }}-sortby" class="form-control custom-datatable-filter">
                        @foreach($skeleton->structure as $ids => $structure)
                            @if($structure->orderable)
                                <?php
                                $field_name = str_replace('[]', '', $structure->field);
                                ?>
                                <option value="{{ $ids }}">{{ $structure->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4">
                <div class="form-group">
                    <label>Direction</label>
                    <select id="{{ $skeleton->getSkeletonName() }}-sortdir" class="form-control custom-datatable-filter">
                        <option value="asc">Oldest First</option>
                        <option value="desc">Newest First</option>
                    </select>
                </div>
            </div>
        </div>
        <div id="{{ $skeleton->getSkeletonName() }}" class="datatable-custom-view"></div>
        <div id="{{ $skeleton->getSkeletonName() }}-pagination" class="custom-pagination"></div>
    </div>
</div>
