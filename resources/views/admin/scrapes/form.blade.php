<div class="card-body" id="app">
    <vue-product-scrape-component id="{{$post->id}}"></vue-product-scrape-component>
</div>

<div class="card-footer">
    <div class="action-form">
        <div class="form-group mb-0 text-center">
            @includeIf('components.buttons.submit')
            @includeIf('components.buttons.cancel')
        </div>
    </div>
</div>

@push('js')
    @vite(['resources/js/backend/app.js'])
@endpush

@include('components.Select2')
