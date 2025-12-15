<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class ContactPageResponse implements Responsable
{
    public function __construct(public ?string $statusMessage = null) {}

    public function toResponse($request)
    {
        return response()->view('front.contact', [
            'statusMessage' => $this->statusMessage,
        ]);
    }
}
