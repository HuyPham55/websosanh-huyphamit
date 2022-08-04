<form action="" method="POST" class="form-horizontal pt-3">
    @csrf
    <div class="card-body">
        <div class="form-group row">
            <label for="name"
                   class="col-sm-2 control-label col-form-label">{{ __('label.name') }}</label>
            <div class="col-sm-10">
                <input type="text" id="name" name="name" value="{{ old('name') ?? $data->name}}"
                       class="form-control" required>
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="email"
                   class="col-sm-2 control-label col-form-label">{{ __('label.email') }}</label>
            <div class="col-sm-10">
                <input type="email" id="email" name="email" value="{{ old('email') ?? $data->email }}"
                       class="form-control" required>
                <i class="fa fa-user"></i>
                @error('email')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password"
                   class="col-sm-2 control-label col-form-label">{{ __('label.password') }}</label>
            <div class="col-sm-10">
                <input type="password" id="password" name="password" value="{{ old('password') }}"
                       class="form-control" minlength="8" required>
                @error('password')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password_confirmation"
                   class="col-sm-2 control-label col-form-label">{{ __('label.password_confirmation') }}</label>
            <div class="col-sm-10">
                <input type="password" id="password_confirmation" name="password_confirmation"
                       value="{{ old('password_confirmation') }}" class="form-control" minlength="8"
                       required>
                @error('password_confirmation')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        @php
            $rolesOfUser = $data->getRoleNames()->toArray();
        @endphp
        <x-adminlte-select2 name="role[]" id="role" label="{{ __('label.role') }}" required>
            @foreach($roles as $role)
                <option
                    value="{{ $role->id }}" {{ in_array($role->name, $rolesOfUser) ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </x-adminlte-select2>
        @include('components.form_elements.mono_radio',
        [
            'value' => $data->status ?? true,
            'label' => __('label.status.status'),
            'name' => 'status',
        ])
    </div>
    <hr>
    <div class="card-body">
        <div class="action-form">
            <div class="form-group mb-0 text-center">
                @includeIf('components.buttons.submit')
                @includeIf('components.buttons.cancel')
            </div>
        </div>
    </div>
</form>
