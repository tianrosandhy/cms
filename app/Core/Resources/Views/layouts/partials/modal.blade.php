@include ('core::components.blank-modal', [
    'modal_name' => 'global-popup',
    'modal_size' => 'lg'
])

@include ('core::components.blank-modal', [
    'modal_name' => 'global-popup-lg',
    'modal_size' => 'xl'
])

@include ('core::components.media.assets')

@stack ('modal')