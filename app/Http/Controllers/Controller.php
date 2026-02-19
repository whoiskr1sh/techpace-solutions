<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Register authorization middleware for a resource controller.
     *
     * This provides a lightweight replacement for the framework's
     * AuthorizesResources trait when it's not available in the
     * current framework version.
     *
     * @param  string  $model
     * @param  string|null  $parameter
     * @return void
     */
    protected function authorizeResource($model, $parameter = null)
    {
        $parameter = $parameter ?: Str::snake(class_basename($model));

        $map = [
            'index' => 'viewAny',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
        ];

        foreach ($map as $method => $ability) {
            // For actions that operate on the resource collection or create a new model
            // (index, create, store) pass the model class to the policy. For actions
            // that operate on an existing model instance, pass the route parameter.
            if (in_array($method, ['index', 'create', 'store'])) {
                $this->middleware("can:{$ability},{$model}")->only($method);
            } else {
                $this->middleware("can:{$ability},{$parameter}")->only($method);
            }
        }
    }
}
