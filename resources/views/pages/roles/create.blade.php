@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Create Role</h5>
                <a href="{{ route('roles.index') }}" class="btn btn-success btn-sm">Back</a>
            </div>

            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Role Name</label>
                        <input type="text" class="form-control" placeholder="Enter role name" id="name"
                            name="name" required value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <hr>
                    <h4>Permissions</h4>

                    @foreach ($permissions as $category => $categoryPermissions)
                        <h5>{{ $category }}</h5>

                        <div class="row">
                            @foreach ($categoryPermissions as $permissionKey => $permissionName)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $permissionKey }}"
                                            id="permission_{{ $permissionKey }}" name="permissions[]">
                                        <label class="form-check-label" for="permission_{{ $permissionKey }}">
                                            {{ $permissionName }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Create Role</button>
                </div>
            </form>
        </div>
    </div>
@endsection
