@extends('layouts.app')

@section('title', 'Manage Tours')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('Tours') }}</h5>
                <a href="{{ route('tours.create') }}" class="btn btn-success btn-sm">Create New Tour</a>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Created By</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tours as $tour)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $tour->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($tour->start_date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($tour->end_date)->format('d M Y') }}</td>
                                <td>{{ $tour->created_by ? $tour->user->name : 'N/A' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('tours.show', $tour->id) }}" class="btn btn-info btn-sm">View</a>
                                    @if (auth()->user()->role == 'admin' || ($tour->created_by && $tour->created_by == auth()->id()))
                                        <a href="{{ route('tours.edit', $tour->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('tours.destroy', $tour->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No tours found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $tours->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('includes.delete_confirm')
@endpush
