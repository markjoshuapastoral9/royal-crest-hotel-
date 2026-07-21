<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EmailBlastMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailBlastController extends Controller
{
    public function index()
    {
        $totalGuests  = User::where('role', 'customer')->count();
        $activeGuests = User::where('role', 'customer')->where('is_active', true)->count();

        return view('admin.email-blast.index', compact('totalGuests', 'activeGuests'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'target'  => 'required|in:all,active',
        ]);

        $query = User::where('role', 'customer');
        if ($request->target === 'active') {
            $query->where('is_active', true);
        }
        $guests = $query->get();

        if ($guests->count() === 0) {
            return back()->with('error', 'No guests found for the selected target.');
        }

        $sent   = 0;
        $failed = 0;
        $errors = [];

        foreach ($guests as $guest) {
            try {
                \Log::info("Sending email blast to: {$guest->email}");
                Mail::to($guest->email)->send(
                    new EmailBlastMail($request->subject, $request->message, $guest->name)
                );
                $sent++;
                \Log::info("Email sent successfully to: {$guest->email}");
            } catch (\Exception $e) {
                $failed++;
                $errors[] = $guest->email . ': ' . $e->getMessage();
                \Log::error("Failed to send email to {$guest->email}: " . $e->getMessage());
            }
        }

        if ($failed > 0) {
            \Log::error("Email blast failures", ['errors' => $errors]);
        }

        $msg = "Email blast sent successfully to {$sent} guest(s).";
        if ($failed > 0) {
            $msg .= " {$failed} delivery failure(s). Check logs for details.";
            return back()->with('warning', $msg);
        }

        return back()->with('success', $msg);
    }
}
