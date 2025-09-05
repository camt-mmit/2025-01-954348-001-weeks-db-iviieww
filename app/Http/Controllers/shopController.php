<?php

namespace App\Http\Controllers;

use App\Models\shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;

class shopController extends SearchableController
{
    const int MAX_ITEMS = 5;

    #[\Override]
    function getQuery(): Builder
    {
        return shop::orderBy('code');
    }

    #[\Override]
    function prepareCriteria(array $criteria): array
    {
        return [
            ...parent::prepareCriteria($criteria),
            'minPrice' => (($criteria['minPrice'] ?? null) === null)
                ? null
                : (float) $criteria['minPrice'],
            'maxPrice' => (($criteria['maxPrice'] ?? null) === null)
                ? null
                : (float) $criteria['maxPrice'],
        ];
    }

    #[\Override]
    function applyWhereToFilterByTerm(Builder $query, string $word): void {
        $query
            ->where('code', 'LIKE', "%{$word}%")
            ->orWhere('name', 'LIKE', "%{$word}%")
            ->orWhere('owner', 'LIKE', "%{$word}%");
        }

    #[\Override]
    function filter(Builder $query, array $criteria): Builder
    {
        $query = parent::filter($query, $criteria);

        return $query;
    }

    function list(ServerRequestInterface $request): View
    {
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria);

        return view('shops.list', [
            'shops' => $query->paginate(self::MAX_ITEMS),
            'criteria' => $criteria,
        ]);
    }

    function view(string $productCode): View
    {
        $shop = shop::where('code', $productCode)->firstOrFail();
        return view('shops.view', [
            'shops' => $shop,
        ]);
    }

    function showCreateForm(): View
    {
        return view('shops.create-form');
    }

    function create(ServerRequestInterface $request): RedirectResponse
    {
        $shop = shop::create($request->getParsedBody());
        return redirect()->route('shops.list');
    }

    function updateForm(string $productCode): View
    {
        $shop = $this->find($productCode);

        return view('shops.update-form', [
            'shops' => $shop,
        ]);
    }

    function update(ServerRequestInterface $request, string $productCode): RedirectResponse
    {
        $shops = $this->find($productCode);
        $shops->fill($request->getParsedBody());
        $shops->save();

        return redirect()->route('shops.view', [
            'shops' => $shops->code,
        ]);
    }

    function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->delete();

        return redirect()->route('shops.list');
    }
}
