<div class="card-body">
    <div class="form-group">
        <label for="username" class="col-sm-2 control-label col-form-label">{{ __('label.username') }}</label>
        <div class="col-sm-10">
            <input type="text" id="username" name="username" value="{{ old('username') ?? $member->username }}"
                   class="form-control">
            @error('username')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="email"
               class="col-sm-2 control-label col-form-label">{{ __('label.email') }}</label>
        <div class="col-sm-10">
            <input type="email" id="email" name="email" value="{{ old('email') ?? $member->email }}"
                   class="form-control" required>
            @error('email')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="name"
               class="col-sm-2 control-label col-form-label">{{ __('label.name') }}</label>
        <div class="col-sm-10">
            <input type="text" id="name" name="name" value="{{ old('name') ?? $member->name}}"
                   class="form-control" required>
            @error('name')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="phone" class="col-sm-2 control-label col-form-label">{{ __('label.phone') }}</label>
        <div class="col-sm-10">
            <input type="text" id="phone" name="phone" value="{{ old('phone') ?? $member->phone }}"
                   class="form-control">
            @error('phone')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="password"
               class="col-sm-2 control-label col-form-label">{{ __('label.password') }}</label>
        <div class="col-sm-10">
            <input type="password" id="password" name="password" value="{{ old('password') }}"
                   class="form-control" minlength="8">
            @error('password')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="password_confirmation"
               class="col-sm-2 control-label col-form-label">{{ __('label.password_confirmation') }}</label>
        <div class="col-sm-10">
            <input type="password" id="password_confirmation" name="password_confirmation"
                   value="{{ old('password_confirmation') }}" class="form-control" minlength="8">
            @error('password_confirmation')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="gender" class="control-label">{{ __('label.gender') }}</label>
            <select id="gender" class="form-control select2" name="gender" required>
                @foreach($genders as $key => $gender)
                    <option value="{{$key}}">
                        {{$gender}}
                    </option>
                @endforeach
            </select>
            @error('gender')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
    </div>

    @include('components.form_elements.mono_radio',
    [
        'value' => $member->status ?? true,
        'label' => __('label.status.status'),
        'name' => 'status',
    ])
</div>
<hr>
<div class="card-footer">
    <div class="action-form">
        <div class="form-group mb-0 text-center">
            @includeIf('components.buttons.submit')
            @includeIf('components.buttons.cancel')
        </div>
    </div>
</div>

@include('components.Select2')
