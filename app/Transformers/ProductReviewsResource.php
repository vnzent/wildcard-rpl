<?php

namespace App\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'product' => $this->product->name,
            'account' => $this->account->name,
            'rate' => $this->rate,
            'review' => $this->review,
            'is_activated' => $this->is_activated,
        ];
    }
}
