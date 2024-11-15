<?php

namespace App\Http\Controllers;

use App\Models\Quiz;

class HomeController extends Controller
{
    public function index()
    {
        // Original query that incorrectly filters public quizzes
        $query = Quiz::whereHas('questions')
            ->withCount('questions')
            ->when(auth()->guest() || !auth()->user()->is_admin, function ($query) {
                return $query->where('published', 1); // This restricts visibility
            })
            ->get();

        // Modified query to show public quizzes to everyone
        $query = Quiz::whereHas('questions')
            ->withCount('questions')
            ->when(auth()->guest() || !auth()->user()->is_admin, function ($query) {
                return $query->where(function($q) {
                    $q->where('published', 1)
                      ->orWhere('public', 1); // Allow public quizzes to be visible
                });
            })
            ->get();

        $public_quizzes = $query->where('public', 1);
        $registered_only_quizzes = $query->where('public', 0);

        return view('home', compact('public_quizzes', 'registered_only_quizzes'));
    }

    public function show(Quiz $quiz)
    {
        return view('front.quizzes.show', compact('quiz'));
    }
}
