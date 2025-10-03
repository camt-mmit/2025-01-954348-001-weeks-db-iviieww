<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Psr\Http\Message\ServerRequestInterface;

class CategoryController extends SearchableController
{
    const int MAX_ITEMS = 5;

    #[\Override]
    function getQuery(): Builder
    {
        return category::orderBy('code');
    }


    function list(ServerRequestInterface $request): View
    {
        Gate::authorize('list',category::class);
        $criteria = $this->prepareCriteria($request->getQueryParams());
        $query = $this->search($criteria)->withCount('products');

        return view('categories.list', [
            'categories' => $query->paginate(self::MAX_ITEMS),
            'criteria' => $criteria,
        ]);
    }

    function view(string $catCode): View
    {
        Gate::authorize('view',category::class);
        $category = category::where('code', $catCode)->firstOrFail();
        return view('categories.view', [
            'category' => $category,
        ]);
    }

    function showCreateForm(): View
    {
        Gate::authorize('create',category::class);
        return view('categories.create-form');
    }

    function create(ServerRequestInterface $request): RedirectResponse
    {
        Gate::authorize('create',category::class);
        $category = category::create($request->getParsedBody());
        return redirect()->route('categories.list')
            ->with('status', "Category {$category->code} was created.");
    }

    function updateForm(string $catCode): View
    {
        $category = $this->find($catCode);
        Gate::authorize('update',category::class);

        return view('categories.update-form', [
            'category' => $category,
        ]);
    }

    function update(ServerRequestInterface $request, string $catCode): RedirectResponse
    {
        Gate::authorize('update',category::class);
        $category = $this->find($catCode);
        $category->fill($request->getParsedBody());
        $category->save();

        return redirect()->route('categories.view', [
            'catCode' => $category->code,
        ])
            ->with('status', "Category {$category->code} was updated.");
    }

    function delete(string $category): RedirectResponse
    {
        $category = $this->find($category);
        Gate::authorize('delete', $category);
        $category->delete();

        return redirect()->route('categories.list')
            ->with('status', "Category {$category->code} was deleted.");
    }

    function viewProducts(
        ServerRequestInterface $request,
        ProductController $productController,
        string $catCode
    ): View {
        $category = $this->find($catCode);
        $criteria = $productController->prepareCriteria($request->getQueryParams());
        $query = $productController

            ->filter($category->products(), $criteria)
            ->with('category')
            ->withCount('shops');
        return view('categories.view-products', [
            'categories' => $category,
            'criteria' => $criteria,
            'shop' => $category,
            'products' => $query->paginate($productController::MAX_ITEMS),
        ]);
    }

    function showAddProductsForm(
        ServerRequestInterface $request,
        ProductController $ProductController,
        string $categoryCode
    ): View {
        $category = $this->find($categoryCode);
        $criteria = $ProductController->prepareCriteria($request->getQueryParams());
        $query = $ProductController
            ->getQuery()
            ->whereDoesntHave(
                'category',
                function (Builder $innerQuery) use ($category) {
                    return $innerQuery->where('code', $category->code);
                },
            );
        $query = $ProductController->filter($query, $criteria)->withCount('shops');
        return view('categories.add-products-form', [
            'criteria' => $criteria,
            'category' => $category,
            'products' => $query->paginate($ProductController::MAX_ITEMS),
        ]);
    }

    function addProduct(
        ServerRequestInterface $request,
        ProductController $ProductController,
        string $categoryCode,
    ): RedirectResponse {
        // Method body
        $category = $this->find($categoryCode);
        $data = $request->getParsedBody();
        // To make sure that no duplicate shop.
        $product = $ProductController
            ->getQuery()
            ->whereDoesntHave(
                'category',
                function (Builder $innerQuery) use ($category) {
                    return $innerQuery->where('code', $category->code);
                },
            )
            ->where('code', $data['products'])
            ->firstOrFail();
        // Add $shop to $product
        $category->products()->save($product);
        return redirect()->back()
            ->with('status', "Product {$product->code} was add to Category {$category->code}.");
    }
}
