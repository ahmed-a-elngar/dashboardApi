<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $note = $this->note;

        return [
            'id'            =>      $this->id,
            'name'          =>      $this->name,
            'email'         =>      $this->email,
            'website'       =>      $this->website,
            'note_title'    =>      $note->title ?? '',
            'note_body'     =>       $note->body ?? '',
        ];
    }
}
