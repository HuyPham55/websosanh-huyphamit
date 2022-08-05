<form action="" method="POST">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="form-group row">
                <label for="name"
                       class="col-sm-2 control-label col-form-label">{{ __('label.name') }}</label>
                <div class="col-sm-10">
                    <input type="text" id="name" name="name" class="form-control" value="{{old('name')??$data->name}}"
                           required>
                    @error('name')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" id="check-all" class="custom-control-input">
                <label class="custom-control-label" for="check-all">{{__('label.all')}}</label>
            </div>
        </div>
    </div>

    @php
        $permissionSelected = array_column($data->permissions()->get()->toArray(), 'id');
    @endphp
    @foreach($permissionGroups as $group)
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $group->name }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($group->permissions as $permission)
                        <div class="col-md-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="permissions[]"
                                       id="permission-{{ $permission->id }}"
                                       class="custom-control-input"
                                       value="{{ $permission->id }}"
                                    {{ in_array($permission->id, $permissionSelected) ? 'checked' : '' }}>
                                <label class="custom-control-label"
                                       for="permission-{{ $permission->id }}">{{ $permission->title }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    @endforeach
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
