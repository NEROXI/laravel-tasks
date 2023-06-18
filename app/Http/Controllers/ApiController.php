<?php

namespace App\Http\Controllers;

use App\Services\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
    public function create(Request $request, ReviewService $reviewService)
    {
        try {
            $validatedData = $request->validate([
                'full_name' => ['required', 'string', 'min:3', 'max:255'],
                'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
                'context' => ['required', 'string', 'max:500', 'min:3'],
                'image' => ['nullable', 'file', 'mimes:jpeg,png'],
                'likes' => ['nullable', 'integer', 'min:0']
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $filename = implode('.',[
                    md5($image->getClientOriginalName().(new \DateTime())->getTimestamp()),
                    $extension
                ]);
                $image->storeAs('public','images/'.$filename);
                $validatedData['image'] = Storage::url('images/'.$filename);
            }

            $review = $reviewService->createReview($validatedData);
            return response()->json([
                'status' => 'success',
                'data' => ['id' => $review->id]
            ], 201);

        } catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json([
                'status' => 'error',
                'errors' => $errors
            ], 422);
        }
    }

    public function get(Request $request, ReviewService $reviewService)
    {
        try {
            $validateData = $request->validate([
                'id' => ['required', 'integer', Rule::exists('reviews', 'id')]
            ]);

            if($review = $reviewService->getReviewById($request->get('id'))) {
                return response()->json([
                    'status' => 'success',
                    'data' => $review
                ], 201);
            }
        }
        catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json([
                'status' => 'error',
                'errors' => $errors
            ], 422);
        }
    }

    public function update(Request $request, ReviewService $reviewService)
    {
        try {
            $validatedData = $request->validate([
                'id' => ['required', 'integer', Rule::exists('reviews', 'id')],
                'full_name' => ['required', 'string', 'min:3', 'max:255'],
                'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
                'context' => ['required', 'string', 'max:500', 'min:3'],
                'image' => ['nullable', 'file', 'mimes:jpeg,png'],
                'likes' => ['nullable', 'integer', 'min:0']
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $filename = implode('.',[
                    md5($image->getClientOriginalName().(new \DateTime())->getTimestamp()),
                    $extension
                ]);
                $image->storeAs('public','images/'.$filename);
                $validatedData['image'] = Storage::url('images/'.$filename);
            }

            $review = $reviewService->updateReview($validatedData);
            return response()->json([
                'status' => 'success',
                'data' => ['id' => $review->id]
            ], 201);

        } catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json([
                'status' => 'error',
                'errors' => $errors
            ], 422);
        }
    }

    public function getAll(Request $request, ReviewService $reviewService)
    {
        try {
            $validationData = $request->validate([
                'from' => ['nullable', 'integer', 'min:1'],
                'to' => ['nullable', 'integer', 'min:1'],
            ]);

            $range = false;
            if($request->query->has('from') && $request->query->has('to')) {
                $range['from'] = $request->query->get('from');
                $range['to'] = $request->query->get('to');
            }

            if($reviews = $reviewService->getReviews($range)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $reviews
                ], 201);
            }
        }
        catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json([
                'status' => 'error',
                'errors' => $errors
            ], 422);
        }
    }

    public function getByPage(Request $request, ReviewService $reviewService)
    {
        try {
            $validationData = $request->validate([
                'page' => ['required', 'integer', 'min:1']
            ]);

            if($reviews = $reviewService->getReviewsPerPage($validationData['page'])) {
                return response()->json([
                    'status' => 'success',
                    'data' => $reviews
                ], 201);
            }
        }
        catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json([
                'status' => 'error',
                'errors' => $errors
            ], 422);
        }
    }
    public function getCount(Request $request, ReviewService $reviewService)
    {
        try {
            if($reviewsCount = $reviewService->getReviewsCount()) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'count' => $reviewsCount
                    ]
                ], 201);
            }
        }
        catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json([
                'status' => 'error',
                'errors' => $errors
            ], 422);
        }
    }
    public function createCategory(Request $request, ReviewService $reviewService)
    {
        try {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'min:1', 'max:255']
            ]);

            if($category = $reviewService->createCategory($validatedData['name'])) {
                return response()->json([
                    'status' => 'success',
                    'data' => ['id' => $category->id]
                ], 201);
            }
            else {
                return response()->json([
                    'status' => 'error'
                ], 409);
            }

        }
        catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json([
                'status' => 'error',
                'errors' => $errors
            ], 422);
        }
    }
}
