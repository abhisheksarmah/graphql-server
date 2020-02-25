<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

trait HasFilters
{
    public function scopeFilter($query, $filters = [])
    {
        Log::info($filters);
        if ($filters <> []) {
            foreach ($filters as $key => $value) {
                $methodName = 'scope' . ucfirst($key);

                if (method_exists($this, $methodName)) {
                    $this->{$methodName}($query, $value);
                } else {

                    $query->when(Str::endsWith($key, ':contains'), function ($q) use ($key, $value) {
                        $q->where($this->table . '.' . str_replace(':contains', '', $key), 'like', "%$value%");
                    })
                        ->when(Str::endsWith($key, ':missing'), function ($q) use ($key, $value) {
                            $q->where($this->table . '.' . str_replace(':missing', '', $key), 'not like', "%$value%");
                        })
                        ->when(Str::endsWith($key, ':equals'), function ($q) use ($key, $value) {
                            $q->where($this->table . '.' . str_replace(':equals', '', $key), '=', $value);
                        })
                        ->when(Str::endsWith($key, ':notequal'), function ($q) use ($key, $value) {
                            $q->where($this->table . '.' . str_replace(':notequal', '', $key), '<>', $value);
                        })
                        ->when(Str::endsWith($key, ':known'), function ($q) use ($key) {
                            $q->whereNotNull($this->table . '.' . str_replace(':known', '', $key));
                        })
                        ->when(Str::endsWith($key, ':unknown'), function ($q) use ($key) {
                            $q->whereNull($this->table . '.' . str_replace(':unknown', '', $key));
                        });
                }
            }
        }
    }
}
