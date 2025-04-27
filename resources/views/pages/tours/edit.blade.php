@extends('layouts.app')

@section('title', 'Edit Tour')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Tour</h5>
                <a href="{{ route('tours.index') }}" class="btn btn-success btn-sm">Back</a>
            </div>

            <form action="{{ route('tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="title" class="form-label">Tour Title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ old('title', $tour->title) }}" required>
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ old('start_date', $tour->start_date) }}" required>
                            @error('start_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ old('end_date', $tour->end_date) }}" required>
                            @error('end_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="description" class="form-label">Tour Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $tour->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="images" class="form-label">Upload New Images</label>
                            <input type="file" class="form-control" name="images[]" id="images" multiple
                                accept="image/*">
                            @error('images')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($tour->images && count($tour->images))
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Existing Images</label>
                                <div class="row">
                                    @foreach ($tour->images as $image)
                                        <div class="col-md-3 mb-3" id="image-{{ $image->id }}">
                                            <div class="card">
                                                <img src="{{ asset($image->image_path) }}" class="card-img-top"
                                                    alt="Tour Image" style="height: 150px; object-fit: cover;">
                                                <div class="card-footer">
                                                    <div class="text-center  align-items-center">
                                                        @can('edit_tour')
                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                onclick="EditImage({{ $image->id }})">Update</button>
                                                        @endcan
                                                        @can('delete_tour')
                                                            <button class="btn btn-danger btn-sm" type="button"
                                                                onclick="DeleteImage({{ $image->id }})">Delete</button>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Update Tour</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="EditImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Image</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data" id="editImageForm">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="image_id" name="image_id">
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    @include('pages.tours.scripts')
@endpush
