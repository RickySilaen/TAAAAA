<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
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
        $newsletters = Newsletter::latest()->paginate(10);

        return view('admin.newsletter.index', compact('newsletters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.newsletter.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'recipients' => 'required|array',
            'recipients.*' => 'email',
        ]);

        $newsletter = Newsletter::create([
            'subject' => $request->subject,
            'content' => $request->content,
            'recipients' => json_encode($request->recipients),
            'status' => 'draft',
        ]);

        return redirect()->route('admin.newsletter.index')->with('success', 'Newsletter berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $newsletter = Newsletter::findOrFail($id);

        return view('admin.newsletter.show', compact('newsletter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $newsletter = Newsletter::findOrFail($id);

        return view('admin.newsletter.edit', compact('newsletter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $newsletter = Newsletter::findOrFail($id);

        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'recipients' => 'required|array',
            'recipients.*' => 'email',
        ]);

        $newsletter->update([
            'subject' => $request->subject,
            'content' => $request->content,
            'recipients' => json_encode($request->recipients),
        ]);

        return redirect()->route('admin.newsletter.index')->with('success', 'Newsletter berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();

        return redirect()->route('admin.newsletter.index')->with('success', 'Newsletter berhasil dihapus.');
    }

    /**
     * Send newsletter.
     */
    public function send($id)
    {
        $newsletter = Newsletter::findOrFail($id);

        if ($newsletter->status === 'sent') {
            return redirect()->route('admin.newsletter.index')->with('error', 'Newsletter sudah dikirim sebelumnya.');
        }

        $recipients = json_decode($newsletter->recipients, true);

        try {
            // Send to each recipient
            foreach ($recipients as $email) {
                Mail::raw($newsletter->content, function ($message) use ($newsletter, $email) {
                    $message->to($email)
                        ->subject($newsletter->subject)
                        ->from(config('mail.from.address'), config('mail.from.name'));
                });
            }

            $newsletter->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            return redirect()->route('admin.newsletter.index')->with('success', 'Newsletter berhasil dikirim ke ' . count($recipients) . ' penerima.');
        } catch (\Exception $e) {
            return redirect()->route('admin.newsletter.index')->with('error', 'Gagal mengirim newsletter: ' . $e->getMessage());
        }
    }

    /**
     * Get all subscriber emails.
     */
    public function getSubscribers()
    {
        $subscribers = Newsletter::where('status', 'subscribed')->pluck('email')->toArray();

        return response()->json($subscribers);
    }
}
