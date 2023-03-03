@php
    use App\Enums\CommonStatus;
@endphp
@extends('admin.layout')
@section('title', trans('backend.members'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('backend.members') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('label.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('backend.members') }}</li>
            </ol>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            @includeIf('components.notification')
            @can('add_members')
                @includeIf('components.buttons.add', ['route' => route('members.add')])
            @endcan

            @include('admin.members.filter_bar')

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>{{trans('label.total')}}: {{$data->total()}}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                            <tr>
                                <th scope="col">{{ __('label.name') }}</th>
                                <th>{{ __('label.username') }}</th>
                                <th>{{ __('label.email') }}</th>
                                <th>{{ __('label.phone') }}</th>
                                <th>{{ __('label.action.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $user)
                                <tr id="row-id-{{ $user->id }}">
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        @can('edit_members')
                                            @includeIf('components.buttons.edit', ['route' => route('members.edit', $user->id)])
                                        @endcan

                                        @can('delete_members')
                                            @includeIf('components.buttons.delete', ['route' => route('members.delete'), 'id' => $user->id])
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" style="text-align: center"><i>No record</i></td>
                                </tr>
                            @endforelse
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
