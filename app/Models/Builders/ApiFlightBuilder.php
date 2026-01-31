<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class ApiFlightBuilder extends Builder
{
    public function get($columns = ['*'])
    {
        $response = Http::get(route('api.flights'), $this->prepareApiParams());

        if ($response->failed()) {
            return new Collection();
        }

        $data = $response->json('data.flights', []);

        // Hydrate models
        return $this->model->hydrate($data);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null, $total = null)
    {
        $items = $this->get();
        $total = $items->count();
        $perPage = $perPage ?: 15;
        $page = $page ?: 1;

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    }

    public function count($columns = '*')
    {
        return $this->get()->count();
    }

    protected function prepareApiParams()
    {
        
        $params = [];

        foreach ($this->getQuery()->wheres as $where) {
            if ($where['type'] === 'Basic') {
                $column = $where['column'];
                $value = $where['value'];

                if ($column === 'class') {
                    $params['class'] = $value;
                }
                
                if ($column === 'origin') $params['origin'] = $value;
                if ($column === 'destination') $params['destination'] = $value;
            }
        }
        
        return $params;
    }
}
