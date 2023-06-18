<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Review;

class ReviewService
{
    public function createReview($data)
    {
        $review = Review::create($data);
        return $review;
    }

    public function updateReview($data)
    {
        $review = Review::findOrFail($data['id']);

        $review->update($data);

        return $review;
    }

    public function createCategory($name)
    {
        $category = Category::create([
            'name' => $name
        ]);

        return $category;
    }

    public function getReviewById($id)
    {
        return Review::find($id);
    }

    public function getReviews($limit = false)
    {
        $reviews = $limit ? Review::take($limit)->get() : Review::all();

        return $reviews;
    }

    public function getReviewsCount()
    {
        $reviewCount = Review::count();

        return $reviewCount;
    }
}
