<?php

namespace App\Support;

use Illuminate\Contracts\Support\Arrayable;
use Inertia\ResponseFactory;

class InertiaRenderer extends ResponseFactory
{
    public function render(string $component, $props = []): InertiaResponse
    {
        if ($props instanceof Arrayable) {
            $props = $props->toArray();
        }

        $response = new InertiaResponse(
            $component,
            array_merge($this->sharedProps, $props),
            $this->rootView,
            $this->getVersion()
        );

        $response->setRootUrl(config('app.url'));

        return $response;
    }
}
