<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();
        if ($request->filled('status')) {
            $query->where('is_read', $request->status === 'read');
        }
        $contacts = $query->latest()->paginate(15)->withQueryString();
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        $contact->update(['is_read' => true]);
        return view('admin.contacts.show', compact('contact'));
    }

    public function reply(Request $request, Contact $contact)
    {
        $request->validate(['reply' => 'required|string']);
        $contact->update([
            'reply'      => $request->reply,
            'replied_at' => now(),
        ]);
        return back()->with('success', 'Reply saved.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Message deleted.');
    }
}
