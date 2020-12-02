@extends ('core::layouts.master')

{{-- You can delete this block if you dont wanna use Google Analytic Dashboard Component --}}
@if(env('ANALYTICS_VIEW_ID'))
    @include ('core::components.analytic.dashboard')
@endif
{{-- end analytic block --}}