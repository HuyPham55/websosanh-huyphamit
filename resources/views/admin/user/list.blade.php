@php
    use App\Enums\CommonStatus;
@endphp
@extends('admin.layout')
@section('title', trans('backend.user_list'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('backend.user_list') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('label.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('backend.user_list') }}</li>
            </ol>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            @includeIf('components.notification')
            @can('add_users')
                @includeIf('components.buttons.add', ['route' => route('users.add')])
            @endcan
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                            <tr>
                                <th>{{ __('label.name') }}</th>
                                <th>{{__('label.role')}}</th>
                                <th>{{ __('label.status.status') }}</th>
                                <th>{{ __('label.created_at') }}</th>
                                <th>{{ __('label.action.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $user)
                                <tr id="row-id-{{ $user->id }}">
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @foreach($user->getRoleNames() as $role)
                                            {{ $role }} {{ ! $loop->last ? ', ' : '' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $user->status == CommonStatus::Active ? 'success' : 'danger' }}">
                                            {{ data_get($status, $user->status, '-') }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        @if($user->id <> Auth::id())
                                            @can('edit_users')
                                                @includeIf('components.buttons.edit', ['route' => route('users.edit', $user->id)])
                                            @endcan

                                            @can('delete_users')
                                                @includeIf('components.buttons.delete', ['route' => route('users.delete'), 'id' => $user->id])
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <hr>
                        <div class="d-flex justify-content-center">
                            {{ $data->appends(request()->all())->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
