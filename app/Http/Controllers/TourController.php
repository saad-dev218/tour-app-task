<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourImage;
use Illuminate\Http\Request;

class TourController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tours = Tour::with('planner')->paginate(10);
        return view('pages.tours.index', compact('tours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.tours.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $tour = Tour::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => auth()->id(),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/tours'), $imageName);

                TourImage::create([
                    'tour_id' => $tour->id,
                    'image_path' => 'uploads/tours/' . $imageName,
                ]);
            }
        }

        return redirect()->route('tours.index')->with('success', 'Tour created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tour = Tour::with('images')->findOrFail($id);
        return view('pages.tours.show', compact('tour'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tour = Tour::with('images')->findOrFail($id);
        if (auth()->user()->hasRole('admin') || $tour->created_by == auth()->id()) {
            return view('pages.tours.edit', compact('tour'));
        } else {
            return redirect()->route('tours.index')->with('error', 'You do not have permission to edit this tour.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'replace_images' => 'nullable|array',
            'replace_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $tour = Tour::findOrFail($id);
        if (auth()->user()->hasRole('admin') || $tour->created_by == auth()->id()) {
            $tour->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/tours'), $imageName);

                    TourImage::create([
                        'tour_id' => $tour->id,
                        'image_path' => 'uploads/tours/' . $imageName,
                    ]);
                }
            }

            if ($request->has('replace_images')) {
                foreach ($request->replace_images as $imageId => $newImage) {
                    $image = TourImage::findOrFail($imageId);

                    // Delete old image file
                    if (file_exists(public_path($image->image_path))) {
                        unlink(public_path($image->image_path));
                    }

                    // Upload new image
                    $newImageName = time() . '_' . uniqid() . '.' . $newImage->getClientOriginalExtension();
                    $newImage->move(public_path('uploads/tours'), $newImageName);

                    // Update image path in database
                    $image->update([
                        'image_path' => 'uploads/tours/' . $newImageName,
                    ]);
                }
            }

            return redirect()->route('tours.index')->with('success', 'Tour updated successfully.');
        } else {
            return redirect()->route('tours.index')->with('error', 'You do not have permission to edit this tour.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tour = Tour::findOrFail($id);
        if (auth()->user()->hasRole('admin') || $tour->created_by == auth()->id()) {
            // Delete associated images
            foreach ($tour->images as $image) {
                if (file_exists(public_path($image->image_path))) {
                    unlink(public_path($image->image_path));
                }
                $image->delete();
            }
            // Delete tour
            $tour->delete();

            return redirect()->route('tours.index')->with('success', 'Tour deleted successfully.');
        } else {
            return redirect()->route('tours.index')->with('error', 'You do not have permission to delete this tour.');
        }
    }

    /**
     * Remove the image from storage.
     */
    public function destroyImage($id)
    {
        $image = TourImage::findOrFail($id);

        if ($image->tour->created_by == auth()->id() || auth()->user()->hasRole('admin')) {
            $imagePath = public_path($image->image_path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $image->delete();

            return response()->json(['success' => 'Image deleted successfully.'], 200);
        }

        return response()->json(['error' => 'You do not have permission to delete this image.'], 403);
    }

    /**
     * Update the image.
     */
    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $image = TourImage::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($image->tour->created_by == auth()->id() || auth()->user()->hasRole('admin')) {
                if (file_exists(public_path($image->image_path))) {
                    unlink(public_path($image->image_path));
                }

                // Upload new image
                $file = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/tours'), $imageName);

                // Update the image path in the database
                $image->image_path = 'uploads/tours/' . $imageName;
                $image->save();

                return back()->with('success', 'Image updated successfully.');
            }

            return back()->with('error', 'You do not have permission to update this image.');
        }

        return back()->with('error', 'Please select an image to upload.');
    }
}
