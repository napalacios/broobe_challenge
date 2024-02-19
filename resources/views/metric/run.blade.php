<x-layout>
    <x-slot:title>
        Broobe Metric Run
        </x-slot>
        <div class="row">
            <div class="text-info w-100 float-left col-md-12">
                <h1 class="text-lightblue">Metric Run</h1>
            </div>
        </div>
        <div class="overlay-wrapper">
            <div class="overlay" id="spinner-run" style="display:none">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                <div class="text-bold pt-2" id="text-spinner-run">Loading...</div>
            </div>
            @include('metric.form')
            @include('metric.result')
        </div>
</x-layout>