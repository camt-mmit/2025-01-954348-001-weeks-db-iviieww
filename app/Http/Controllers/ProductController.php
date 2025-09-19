<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;

class ProductController extends SearchableController
{
    const int MAX_ITEMS = 5;

    #[\Override]
    function getQuery(): Builder
    {
        return Product::orderBy('code');
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

    #[\override]
    function applyWhereToFilterByTerm(Builder $query, string $word): void
    {
        parent::applyWhereToFilterByTerm($query, $word);

        $query
            ->orWhereHas('category', function (Builder $q) use ($word) {
                $q->where('name', 'LIKE', "%{$word}%");
            });
    }

    function filterByPrice(
        Builder|Relation $query,
        ?float $minPrice,
        ?float $maxPrice
    ): Builder|Relation {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }

    #[\Override]
    function filter(Builder|Relation $query, array $criteria): Builder|Relation
    {
        $query = parent::filter($query, $criteria);
        $query = $this->filterByPrice(
            $query,
            $criteria['minPrice'],
            $criteria['maxPrice'],
        );

        return $query;
    }

    function list(ServerRequestInterface $request): View
    {
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria)->with('category')->withCount('shops');

        return view('products.list', [
            'products' => $query->paginate(self::MAX_ITEMS),
            'criteria' => $criteria,
        ]);
    }

    function view(string $productCode): View
    {
        $product = Product::where('code', $productCode)->with('category')->firstOrFail();
        return view('products.view', [
            'product' => $product,
        ]);
    }

    function showCreateForm(
        CategoryController $categoryController,
    ): View {
        $categories = $categoryController->getQuery()->get();

        return view('products.create-form', [
            'categories' => $categories,
        ]);
    }

    function create(
        ServerRequestInterface $request,
        CategoryController $categoryController,
    ): RedirectResponse {
        $data = $request->getParsedBody();
        $category = $categoryController->find($data['category']);

        $product = new Product();
        $product->fill($data);
        $product->category()->associate($category);
        $product->save();

        return redirect()->route('products.list');
    }

    function updateForm(
        CategoryController $categoryController,
        string $productCode,
    ): View {
        $product = $this->find($productCode);
        $categories = $categoryController->getQuery()->get();

        return view('products.update-form', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    function update(
        ServerRequestInterface $request,
        CategoryController $categoryController,
        string $productCode,
    ): RedirectResponse {
        $data = $request->getParsedBody();
        $product = $this->find($productCode);
        $category = $categoryController->find($data['category']);

        $product->fill($data);
        $product->category()->associate($category);
        $product->save();

        return redirect()->route('products.view', [
            'product' => $product->code,
        ]);
    }

    function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->delete();

        return redirect()->route('products.list');
    }

    function viewShops(
        ServerRequestInterface $request,
        ShopController $shopController,
        string $productCode
    ): View {
        $product = $this->find($productCode);
        $criteria = $shopController->prepareCriteria($request->getQueryParams());
        $query = $shopController

            ->filter($product->shops(), $criteria)
            ->withCount('products');
        return view('products.view-shops', [
            'product' => $product,
            'criteria' => $criteria,
            'productCode' => $productCode,
            'shops' => $query->paginate($shopController::MAX_ITEMS),
        ]);
    }

    function showAddShopsForm(
        ServerRequestInterface $request,
        shopController $shopController,
        string $productCode
    ): View {
        $product = $this->find($productCode);
        $criteria = $shopController->prepareCriteria($request->getQueryParams());
        $query = $shopController
            ->getQuery()
            ->whereDoesntHave(
                'products',
                function (Builder $innerQuery) use ($product) {
                    return $innerQuery->where('code', $product->code);
                },
            );
        $query = $shopController->filter($query, $criteria)->withCount('products');
        return view('products.add-shops-form', [
            'criteria' => $criteria,
            'product' => $product,
            'shops' => $query->paginate($shopController::MAX_ITEMS),
        ]);
    }

    function addShop(
        ServerRequestInterface $request,
        ShopController $shopController,
        string $productCode,
    ): RedirectResponse {
        // Method body
        $product = $this->find($productCode);
        $data = $request->getParsedBody();
        // To make sure that no duplicate shop.
        $shop = $shopController
            ->getQuery()
            ->whereDoesntHave(
                'products',
                function (Builder $innerQuery) use ($product) {
                    return $innerQuery->where('code', $product->code);
                },
            )
            ->where('code', $data['shop'])
            ->firstOrFail();
        // Add $shop to $product
        $product->shops()->attach($shop);
        return redirect()->back();
    }

    function removeShop(
        ServerRequestInterface $request,
        string $productCode,
    ): RedirectResponse {
        $product = $this->find($productCode);
        $data = $request->getParsedBody();
        // To get existing shop
        $shop = $product->shops()
            ->where('code', $data['shop'])
            ->firstOrFail();
        // Remove $shop from $product
        $product->shops()->detach($shop);
        return redirect()->back();
    }
}
