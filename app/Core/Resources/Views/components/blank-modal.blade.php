<?php
$modal_name = $modal_name ?? 'global-popup';
$modal_size = $modal_size ?? 'lg';
?>
<div class="modal fade" id="{{ $modal_name }}">
  <div class="modal-dialog modal-{{ $modal_size }}">
    <div class="modal-content">
      <div class="modal-header">
        <span class="title my-0"></span>
        <button class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      
      </div>
    </div>
  </div>
</div>