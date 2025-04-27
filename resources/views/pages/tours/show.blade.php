@extends('layouts.app')

@section('title', 'Tour Details')

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                <h5 class="mb-0">Tour Details</h5>
                <div>
                    @if (auth()->user()->role == 'admin' || (isset($tour) && $tour->created_by == auth()->id()))
                        <a href="{{ route('tours.edit', $tour->id) }}" class="btn btn-warning btn-sm me-2">Edit Tour</a>
                    @endif
                    <a href="{{ route('tours.index') }}" class="btn btn-light btn-sm">Back</a>
                </div>
            </div>

            <div class="card-body">
                <h3 class="mb-3">{{ $tour->title ?? 'No Title Available' }}</h3>

                <p>
                    {{ $tour->description ?? 'No Description Available' }}
                </p>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong>Start Date:</strong>
                        {{ $tour->start_date ? \Carbon\Carbon::parse($tour->start_date)->format('d M Y') : 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong>End Date:</strong>
                        {{ $tour->end_date ? \Carbon\Carbon::parse($tour->end_date)->format('d M Y') : 'N/A' }}
                    </div>
                </div>
                @if (count($tour->images))
                    <h5 class="mb-3">Gallery</h5>
                    <div class="row g-3">
                        @foreach ($tour->images as $image)
                            <div class="col-6 col-md-4">
                                <div class="card h-100">
                                    <img src="{{ asset($image->image_path) }}" class="w-100 h-100 img-thumbnail img-fluid  "
                                        alt="Tour Image{{ $loop->iteration }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="card-footer text-muted text-center">
                Last updated: {{ $tour->updated_at ? $tour->updated_at->format('d M Y') : 'N/A' }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('includes.delete_confirm')
@endpush
