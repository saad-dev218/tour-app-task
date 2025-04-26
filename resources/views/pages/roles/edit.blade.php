@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Role</h5>
                <a href="{{ route('roles.index') }}" class="btn btn-success btn-sm">Back</a>
            </div>

            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter role name" value="{{ old('name', $role->name) }}" required>
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
                                            id="permission_{{ $permissionKey }}" name="permissions[]"
                                            {{ in_array($permissionKey, $role->permissions->pluck('name')->toArray()) ? 'checked' : '' }}>
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
                    <button type="submit" class="btn btn-primary">Update Role</button>
                </div>
            </form>
        </div>
    </div>
@endsection
