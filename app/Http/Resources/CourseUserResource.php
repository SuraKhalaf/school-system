<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
            'first' => $request->first,
            'mid' => $request->mid,
            'final' => $request->final,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ];
    }
}
