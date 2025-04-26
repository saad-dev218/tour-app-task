@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3 mb-2 mb-md-0">
                        <h5 class="mb-0">{{ __('Manage Users') }}</h5>
                    </div>

                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <form action="{{ route('users.index') }}" method="GET"
                            class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2">
                            <select name="filter" id="filter" class="form-select form-select-sm" style="width: 200px;">
                                <option value="">Please Select</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ request('filter') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="btn-group" role="group" aria-label="Filter Buttons">
                                <button type="submit" class="btn btn-outline-primary btn-sm">Filter</button>
                                <a href="{{ route('users.index') }}" class="btn btn-outline-dark btn-sm">Clear</a>
                            </div>
                        </form>
                    </div>

                    <div class="col-12 col-md-3 text-md-end">
                        <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">Add New User</a>
                    </div>
                </div>
            </div>



            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }} </th>
                                <td>{{ ucfirst($user->name) }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->roles->first())
                                        <span class="badge bg-info text-dark">{{ $user->roles->first()->name }}</span>
                                    @else
                                        <span class="text-muted">No Role</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>


            </div>
            <div class="card-footer ">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('pages.users.script')
@endpush
