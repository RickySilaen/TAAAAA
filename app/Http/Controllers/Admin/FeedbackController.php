<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(10);

        return view('admin.feedback.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Feedback is submitted by guests, not created by admin
        return redirect()->route('admin.feedback.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Feedback is submitted by guests, not created by admin
        return redirect()->route('admin.feedback.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $feedback = Feedback::findOrFail($id);

        return view('admin.feedback.show', compact('feedback'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Feedback cannot be edited by admin
        return redirect()->route('admin.feedback.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Feedback cannot be edited by admin
        return redirect()->route('admin.feedback.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedback.index')->with('success', 'Feedback berhasil dihapus.');
    }

    /**
     * Mark feedback as read.
     */
    public function markAsRead($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->status = 'read';
        $feedback->save();

        return redirect()->route('admin.feedback.index')->with('success', 'Feedback telah ditandai sebagai sudah dibaca.');
    }

    /**
     * Mark feedback as unread.
     */
    public function markAsUnread($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->status = 'unread';
        $feedback->save();

        return redirect()->route('admin.feedback.index')->with('success', 'Feedback telah ditandai sebagai belum dibaca.');
    }
}
