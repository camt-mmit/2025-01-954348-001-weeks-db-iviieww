<?php

namespace App\Http\Controllers;

use App\Models\shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
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
    function applyWhereToFilterByTerm(Builder $query, string $word): void
    {
        // parent::applyWhereToFilterByTerm(Builder $query,string $word) ##can make this same.
        $query
            ->where('code', 'LIKE', "%{$word}%")
            ->orWhere('name', 'LIKE', "%{$word}%")
            ->orWhere('owner', 'LIKE', "%{$word}%");
    }

    #[\Override]
    function filter(Builder|Relation $query, array $criteria): Builder|Relation
    {
        $query = parent::filter($query, $criteria);

        return $query;
    }

    function list(ServerRequestInterface $request): View
    {
        Gate::authorize('list', Shop::class);
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria)->withCount('products');

        return view('shops.list', [
            'shops' => $query->paginate(self::MAX_ITEMS),
            'criteria' => $criteria,
        ]);
    }

    function view(string $productCode): View
    {
        $shop = shop::where('code', $productCode)->firstOrFail();
        Gate::authorize('view',$shop);
        return view('shops.view', [
            'shops' => $shop,
        ]);
    }

    function showCreateForm(): View
    {
        Gate::authorize('craete',Shop::class);

        return view('shops.create-form');
    }

    function create(ServerRequestInterface $request): RedirectResponse
    {
        $shop = shop::create($request->getParsedBody());
        Gate::authorize('create',$shop);
        return redirect(
            session()->get('bookmarks.shops.create-form', route('shops.list'))
        )
            ->with('status', "Shop {$shop->code} was created.");
    }

    function updateForm(string $productCode): View
    {
        $shop = $this->find($productCode);
        Gate::authorize('update',$shop);

        return view('shops.update-form', [
            'shops' => $shop,
        ]);
    }

    function update(ServerRequestInterface $request, string $productCode): RedirectResponse
    {
        $shops = $this->find($productCode);
        Gate::authorize('update',Shop::class);
        $shops->fill($request->getParsedBody());
        $shops->save();

        return redirect()->route('shops.view', [
            'shops' => $shops->code,
        ])
        ->with('status', "Shop {$shops->code} was updated.");
    }

    function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        Gate::authorize('delete',Shop::class);
        $product->delete();

        return redirect(
            session()->get('bookmarks.shops.list', route('shops.list'))
        )
            ->with('status', "Shop {$product->code} was deleted.");
    }

    function viewProducts(
        ServerRequestInterface $request,
        ProductController $productController,
        string $shop
    ): View {
        $shop = $this->find($shop);
        Gate::authorize('view',Shop::class);
        $criteria = $productController->prepareCriteria($request->getQueryParams());
        $query = $productController

            ->filter($shop->products(), $criteria)
            ->with('category')
            ->withCount('shops');
        return view('shops.view-products', [
            'criteria' => $criteria,
            'shop' => $shop,
            'products' => $query->paginate($productController::MAX_ITEMS),
        ]);
    }

    function showAddProductsForm(
        ServerRequestInterface $request,
        ProductController $ProductController,
        string $shopCode
    ): View {
        $shop = $this->find($shopCode);
        Gate::authorize('update',Shop::class);
        $criteria = $ProductController->prepareCriteria($request->getQueryParams());
        $query = $ProductController
            ->getQuery()
            ->whereDoesntHave(
                'shops',
                function (Builder $innerQuery) use ($shop) {
                    return $innerQuery->where('code', $shop->code);
                },
            );
        $query = $ProductController->filter($query, $criteria)->withCount('shops');
        return view('shops.add-products-form', [
            'criteria' => $criteria,
            'shop' => $shop,
            'products' => $query->paginate($ProductController::MAX_ITEMS),
        ]);
    }

    function addProduct(
        ServerRequestInterface $request,
        ProductController $ProductController,
        string $shopCode,
    ): RedirectResponse {
        // Method body
        $shop = $this->find($shopCode);
        Gate::authorize('update',Shop::class);
        $data = $request->getParsedBody();
        // To make sure that no duplicate shop.
        $product = $ProductController
            ->getQuery()
            ->whereDoesntHave(
                'shops',
                function (Builder $innerQuery) use ($shop) {
                    return $innerQuery->where('code', $shop->code);
                },
            )
            ->where('code', $data['products'])
            ->firstOrFail();
        // Add $shop to $product
        $shop->products()->save($product);
        return redirect()->back()
        ->with('status', "Product {$product->code} was add to Shop {$shop->code}.");
    }

    function removeProduct(
        ServerRequestInterface $request,
        string $shopCode,
    ): RedirectResponse {
        $shop = $this->find($shopCode);
        Gate::authorize('update',Shop::class);
        $data = $request->getParsedBody();
        // To get existing shop
        $product = $shop->products()
            ->where('code', $data['product'])
            ->firstOrFail();
        // Remove $shop from $product
        $shop->products()->detach($product);
        return redirect()->back()
        ->with('status', "Product {$product->code} was remove from Shop {$shop->code}.");
    }
}
