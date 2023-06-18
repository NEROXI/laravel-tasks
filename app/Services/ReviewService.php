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
        $review =  Review::find($id);
        $review->load('category');
        return $review;
    }

    public function getReviews($range = false)
    {
        if ($range && is_array($range) && count($range) === 2) {
            $from = $range['from'];
            $to = $range['to'];

            $reviews = Review::skip($from - 1)->take($to)->get();
            $reviews->load('category');

            return $reviews;
        }
        else {
            $reviews = Review::all();

            return $reviews;
        }
    }

    public function getReviewsPerPage($page)
    {
        $perPage = 10;
        $skip = ($page - 1) * $perPage;

        $reviews = Review::skip($skip)->take($perPage)->get();
        $reviews->load('category');
        return $reviews;
    }

    public function getReviewsCount()
    {
        $reviewCount = Review::count();

        return $reviewCount;
    }
}
