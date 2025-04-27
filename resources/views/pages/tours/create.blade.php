@extends('layouts.app')

@section('title', 'Create Tour')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Create Tour</h5>
                <a href="{{ route('tours.index') }}" class="btn btn-success btn-sm">Back</a>
            </div>

            <form action="{{ route('tours.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="title" class="form-label">Tour Title</label>
                            <input type="text" class="form-control" placeholder="Enter tour title" id="title"
                                name="title" required value="{{ old('title') }}">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required
                                value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required
                                value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="description" class="form-label">Tour Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Enter tour description"
                                required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="images" class="form-label">Tour Images</label>
                            <input type="file" class="form-control" name="images[]" id="images" multiple
                                accept="image/*">
                            @error('images')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Create Tour</button>
                </div>
            </form>
        </div>
    </div>
@endsection
