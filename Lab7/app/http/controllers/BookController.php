<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the user's books on the dashboard.
     */
    public function index()
    {
        // Retrieve only the logged-in user's books, newest first
        $books = Book::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('dashboard', compact('books'));
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {
        // Validate inputs based on requirements
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'author' => 'required|string|max:100',
            'pages' => 'required|integer|between:1,10000',
        ]);

        // Assign user_id from authenticated session before saving
        $validated['user_id'] = Auth::id();

        // Save the book
        Book::create($validated);

        // Redirect to dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Book registered successfully!');
    }
}
