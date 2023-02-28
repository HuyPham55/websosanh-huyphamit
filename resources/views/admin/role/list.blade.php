@extends('admin.layout')
@section('title', __('label.roles'))


@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('label.roles') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('label.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('label.roles') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @includeIf('components.notification')
            @can('add_roles')
                @includeIf('components.buttons.add', ['route' => route('roles.add')])
            @endcan
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ __('label.title') }}</th>
                                <th>{{ __('label.action.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $role)
                                <tr id="row-id-{{ $role->id }}">
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @if($role->name <> \App\Enums\RoleEnum::Admin)
                                            @can('edit_roles')
                                                @includeIf('components.buttons.edit', ['route' => route('roles.edit', $role->id)])
                                            @endcan

                                            @can('edit_roles')
                                                @includeIf('components.buttons.delete', ['route' => route('roles.delete'), 'id' => $role->id])
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" style="text-align: center"><i>No record</i></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
