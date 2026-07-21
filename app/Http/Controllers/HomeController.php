<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Facility;
use App\Models\Gallery;
use App\Models\Promotion;
use App\Models\Testimonial;
use App\Models\Contact;
use App\Mail\ContactInquiryMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        $featuredRooms = Room::with('roomType')
            ->where('is_featured', true)
            ->where('status', 'available')
            ->take(6)
            ->get();

        $facilities = Facility::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $galleries = Gallery::where('category', 'hotel')
            ->where('is_featured', true)
            ->take(12)
            ->get();

        $promotions = Promotion::where('is_active', true)
            ->take(3)
            ->get();

        $testimonials = Testimonial::where('is_active', true)
            ->where('is_featured', true)
            ->take(6)
            ->get();

        return view('home', compact(
            'featuredRooms', 'facilities', 'galleries', 'promotions', 'testimonials'
        ));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        Contact::create($validated);

        // Send email notification to hotel admin
        try {
            Mail::to(config('mail.from.address'))
                ->send(new ContactInquiryMail(
                    senderName:     $validated['name'],
                    senderEmail:    $validated['email'],
                    senderPhone:    $validated['phone'] ?? '',
                    inquirySubject: $validated['subject'],
                    messageBody:    $validated['message'],
                ));
        } catch (\Exception $e) {
            \Log::error('Contact inquiry mail failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Your message has been sent! We will get back to you soon.');
    }

    public function gallery()
    {
        $galleries = Gallery::orderBy('sort_order')->get()->groupBy('category');
        return view('gallery', compact('galleries'));
    }

    public function facilities()
    {
        $facilities = Facility::where('is_active', true)->orderBy('sort_order')->get();
        return view('facilities', compact('facilities'));
    }
}
