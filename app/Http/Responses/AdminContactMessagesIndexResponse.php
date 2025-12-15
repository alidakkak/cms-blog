<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminContactMessagesIndexResponse implements Responsable
{
    public function __construct(
        public LengthAwarePaginator $messages,
        public int $totalCount,
        public int $unreadCount
    ) {}

    public function toResponse($request)
    {
        return response()->view('admin.contact_messages.index', [
            'messages'    => $this->messages,
            'totalCount'  => $this->totalCount,
            'unreadCount' => $this->unreadCount,
        ]);
    }
}
