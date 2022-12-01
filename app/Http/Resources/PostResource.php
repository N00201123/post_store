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
        $tags = array();
        foreach ($this->tags as $tag) {
            array_push($tags, $tag->name);
        }
        //this will return a certain amount of attributes
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'likes' => $this->likes,
            'post_image' => $this->post_image,
            'platform_id' => $this->platform->id,
            'platform_name' => $this->platform->name,
            'platform_description' => $this->platform->description,
            'tags' => $tags
        ];
    }
}
