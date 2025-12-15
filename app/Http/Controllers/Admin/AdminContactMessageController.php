<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Responses\AdminContactMessagesIndexResponse;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminContactMessageController extends Controller
{
    /**
     * GET /admin/contact-messages
     * Filters:
     * - search: name/email/message
     * - status: read | unread
     */
    public function index(Request $request): AdminContactMessagesIndexResponse
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status'); // read|unread|null

        $query = ContactMessage::query()->latest('created_at');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($status === 'read') {
            $query->where('is_read', true);
        } elseif ($status === 'unread') {
            $query->where('is_read', false);
        }

        $messages = $query->paginate(12)->withQueryString();

        // Stats
        $totalCount  = ContactMessage::count();
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return new AdminContactMessagesIndexResponse(
            messages: $messages,
            totalCount: $totalCount,
            unreadCount: $unreadCount
        );
    }

    /**
     * PATCH /admin/contact-messages/{contactMessage}/read
     */
    public function markRead(ContactMessage $contactMessage): RedirectResponse
    {
        if (!$contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        return back()->with('success', 'Message marked as read.');
    }

    /**
     * PATCH /admin/contact-messages/{contactMessage}/unread
     */
    public function markUnread(ContactMessage $contactMessage): RedirectResponse
    {
        if ($contactMessage->is_read) {
            $contactMessage->update(['is_read' => false]);
        }

        return back()->with('success', 'Message marked as unread.');
    }
}
