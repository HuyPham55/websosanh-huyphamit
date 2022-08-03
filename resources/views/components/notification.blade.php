@if(session()->has('message'))
    <div class="alert alert-{{ session()->get('status') }}">
        <h5>
            @switch(session('status'))
                @case('success')
                    <i class="icon fas fa-check"></i>
                    @break
                @case('danger')
                @case('error')
                @case('failed')
                    <i class="icon fas fa-ban"></i>
                    @break
            @endswitch
            Alert!
        </h5>
        {{ session()->get('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <h5>
            <i class="icon fas fa-ban"></i>
            Alert!
        </h5>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
