<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MetricHistoryRunResource extends JsonResource
{

    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'accesibility_metric' => $this->accesibility_metric,
            'pwa_metric' => $this->pwa_metric,
            'performance_metric' => $this->performance_metric,
            'seo_metric' => $this->seo_metric,
            'best_practices_metric' => $this->best_practices_metric,
            'strategy' => $this->strategy->name,
            'created_at' => $this->created_at->format('d-m-Y H:i'),
        ];
    }
}
