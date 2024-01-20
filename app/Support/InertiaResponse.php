<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response as ResponseFactory;
use Inertia\LazyProp;
use Inertia\Response as BaseResponse;

class InertiaResponse extends BaseResponse
{
    protected ?string $rootUrl = null;

    public function setRootUrl(string $url): static
    {
        $this->rootUrl = $url;
        return $this;
    }

    public function toResponse($request): \Illuminate\Http\Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        $only = array_filter(explode(',', $request->header('X-Inertia-Partial-Data', '')));

        $props = ($only && $request->header('X-Inertia-Partial-Component') === $this->component)
            ? Arr::only($this->props, $only)
            : array_filter($this->props, static function ($prop) {
                return !($prop instanceof LazyProp);
            });

        $props = $this->resolvePropertyInstances($props, $request);

        $page = [
            'component' => $this->component,
            'props' => $props,
            'url' => ($this->rootUrl ?? $request->getBaseUrl()) . $request->getRequestUri(),
            'version' => $this->version,
        ];

        if ($request->header('X-Inertia')) {
            return new JsonResponse($page, 200, ['X-Inertia' => 'true']);
        }

        return ResponseFactory::view($this->rootView, $this->viewData + ['page' => $page]);
    }
}
