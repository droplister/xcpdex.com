<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class MempoolResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => json_decode($this->bindings),
            'date' => Carbon::createFromTimestamp($this->timestamp)->toDateTimeString(),
        ];
    }
}
