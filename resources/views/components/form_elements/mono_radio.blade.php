<div class="col-md-4">
    <div class="form-group">
        <label class="control-label">{{ $label }}</label>
        <div>
            @foreach($status as $key => $statusName)
                <div class="form-check form-check-inline">
                    <div class="custom-control custom-radio">
                        <input type="radio" name="{{$name}}" id="{{$name}}-{{ $key }}"
                               class="custom-control-input {{$key?:'custom-control-input-danger'}}"
                               value="{{ $key }}"
                            {{ (old($name)!==null && old($name) == $key) || $value == $key ? 'checked' : '' }}>
                        <label class="custom-control-label {{ $key?"text-primary":"text-danger" }}"
                               for="{{$name}}-{{ $key }}">{{ $statusName }}</label>
                    </div>
                </div>
            @endforeach
            @error($name)
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

{{--
'name': Name attribute of the inputs
'label: For display
'value': For initial value
--}}

{{--Example--}}
{{--
    @include('components.form_elements.mono_radio',
    [
        'value' => $data->status??true,
        'label' => __('label.status.status'),
        'name' => 'status',
    ])
--}}
