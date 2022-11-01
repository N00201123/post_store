<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //this will return a certain amount of attributes
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'likes' => $this->likes,
        ];
    }
}
