@if(!empty($permission))
    <div class="bt-switch">
        <input type="checkbox" class="change-status" data-field="status" data-item-id="{{ $data->id }}"
               data-size="normal" data-on-color="success" title=""
               data-on-text="{{ __('label.on') }}" data-off-text="{{ __('label.off') }}"
               {{ $data->status == 1 ? 'checked' : '' }}
               @cannot($permission)
                   disabled
            @endcannot
        />
    </div>
@endif

