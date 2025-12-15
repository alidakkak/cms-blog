<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status'); // pending|approved|rejected|null

        $query = Comment::query()
            ->with(['user', 'article'])
            ->latest('created_at');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('body', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%"))
                    ->orWhereHas('article', fn($aq) => $aq->where('title', 'like', "%{$search}%"));
            });
        }

        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $query->where('status', $status);
        }

        $comments = $query->paginate(12)->withQueryString();

        // Stats
        $totalCount    = Comment::count();
        $pendingCount  = Comment::where('status', 'pending')->count();
        $approvedCount = Comment::where('status', 'approved')->count();
        $rejectedCount = Comment::where('status', 'rejected')->count();

        return view('admin.comments.index', compact(
            'comments',
            'totalCount',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }


    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);
        return back()->with('success', 'Comment approved.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Comment deleted.');
    }
}
