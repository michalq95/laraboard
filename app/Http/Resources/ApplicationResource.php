<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Route;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $includeUser = \Request::getRequestUri() === '/api/application/company';
        $includeOffer = \Request::getRequestUri() === '/api/application/application';
        return [
            'id' => $this->id,
            'application' => $this->application,
            'resume' => $this->resume,
            'user' => $includeUser ? $this->user : null,
            // 'offer' => $includeOffer ? $this->offer : null,
            'offer' => $this->offer,
            'status' => $this->status,
            'created_at' => $this->created_at

        ];
    }
}