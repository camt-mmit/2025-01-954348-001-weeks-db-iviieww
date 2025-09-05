<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

{
    abstract class SearchableController extends Controller 
    {
        abstract function getQuery() : Builder;
        function prepareCriteria(array $criteria) : array {
        return [
                'term' => null,
                ...$criteria,
            ];
        }

        function applyWhereToFilterByTerm(Builder $query, string $word): void {
        $query
            ->where('code', 'LIKE', "%{$word}%")
            ->orWhere('name', 'LIKE', "%{$word}%");
        }

        function filterByTerm(Builder $query, ?string $term) : Builder {
            if(!empty($term)) {
                foreach(\preg_split('/\s+/', \trim($term)) as $word) {
                    $query->where(function(Builder $innerQuery) use ($word) {
                        $this->applyWhereToFilterByTerm($innerQuery, $word);
                    });
                }
            }

            return $query;
        }

        function filter(Builder $query, array $criteria) : Builder {
            return $this->filterByTerm($query, $criteria['term']);
        }

        function search(array $criteria) : Builder {
            $query = $this->getQuery();
            return $this->filter($query, $criteria);
        }

        // For easily searching by code.
        function find(string $code): Model {
            return $this->getQuery()->where('code', $code)->firstOrFail();
        }
    }
}
