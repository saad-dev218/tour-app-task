@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('Manage Users') }}</h5>
                <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">Add New User</a>
            </div>

            <div class="card-body">
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

                {{ $users->links() }} {{-- Pagination --}}

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('pages.users.script')
@endpush
