<?php

namespace App\Http\Controllers;

use App\Services\ReviewService;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function list()
    {
        return view('tasks_list');
    }

    public function create(Request $request, ReviewService $reviewService)
    {
        $categories = $reviewService->getAllCategories();
        return view('task_create', [
            'categories' => $categories
        ]);
    }

    public function edit(Request $request, ReviewService $reviewService, $id = null)
    {
        if($id == null) {
            return to_route('homepage');
        }

        if($review = $reviewService->getReviewById($id)) {
            $categories = $reviewService->getAllCategories();
            return view('task_edit', [
                'review' => $review,
                'categories' => $categories
            ]);
        }
        else {
            return to_route('homepage');
        }
    }

    public function docs() {
        return 'docs';
    }
}
