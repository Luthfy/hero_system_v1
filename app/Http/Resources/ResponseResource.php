<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function toResponse ($request, $message = "success", $status = TRUE)
    {
        return [
            "status" => $status,
            "message" => $message,
            "data" => $request
        ];
    }
}