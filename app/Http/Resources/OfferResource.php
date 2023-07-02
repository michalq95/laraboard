<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'company_id' => $this->company?->id,
            'company_name' => $this->company?->name,
            'loc_x' => $this->company?->loc_x,
            'loc_y' => $this->company?->loc_y,

            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y/m/d'),
            'updated_at' => $this->updated_at->format('Y/m/d'),
            'expire_date' => $this->expire_date->format('Y/m/d'),
            'bracket_low' => $this->bracket_low,
            'bracket_high' => $this->bracket_high,
            'currency' => $this->currency,
            'icon' => $this->icon,
            'tags' => $this->tags->pluck('name'),
            'company' => $this->company

        ];
    }
}