<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /** Mark a single notification as read */
    public function markRead(Request $request, string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return response()->json(['success' => true]);
    }

    /** Mark all notifications as read */
    public function markAllRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }

    /** Delete a single notification */
    public function destroy(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();
        return response()->json(['success' => true]);
    }

    /** Get notifications as JSON (for AJAX polling) */
    public function index(Request $request)
    {
        $notifications = auth()->user()->notifications()
            ->latest()
            ->take(10)
            ->get()
            ->map(fn($n) => [
                'id'        => $n->id,
                'data'      => $n->data,
                'read'      => !is_null($n->read_at),
                'time'      => $n->created_at->diffForHumans(),
            ]);

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => auth()->user()->unreadNotifications->count(),
        ]);
    }
}
