<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ModelEventObserver
{
    protected function log(Model $model, string $action, array $meta = [])
    {
        try {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'route' => optional(request()->route())->getName() ?? request()->path(),
                'method' => request()->method(),
                'model_type' => get_class($model),
                'model_id' => $model->getKey(),
                'meta' => $meta,
            ]);
        } catch (\Throwable $e) {
            // avoid breaking app on logging failures
        }
    }

    public function created(Model $model)
    {
        $this->log($model, 'create', ['attributes' => $model->getAttributes()]);
    }

    public function updated(Model $model)
    {
        $this->log($model, 'update', ['changes' => $model->getChanges()]);
    }

    public function deleted(Model $model)
    {
        $this->log($model, 'delete', ['attributes' => $model->getAttributes()]);
    }

    public function retrieved(Model $model)
    {
        // optional: log views when model is retrieved via controller show
    }
}
