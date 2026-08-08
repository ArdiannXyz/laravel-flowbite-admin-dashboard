<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GlobalSearchController extends Controller
{
    /**
     * Perform a global search across products, transactions, suppliers, and categories.
     */
    public function index(Request $request): View
    {
        $query = trim($request->input('q', ''));

        $products = collect();
        $transactions = collect();
        $suppliers = collect();
        $categories = collect();

        if (!empty($query)) {
            // 1. Search Products
            $products = Product::with(['category', 'supplier'])
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('sku', 'like', "%{$query}%")
                      ->orWhere('unit', 'like', "%{$query}%");
                })
                ->latest()
                ->take(15)
                ->get();

            // 2. Search Stock Transactions
            $transactions = StockTransaction::with(['product', 'user', 'supplier'])
                ->where(function ($q) use ($query) {
                    $q->where('transaction_code', 'like', "%{$query}%")
                      ->orWhere('notes', 'like', "%{$query}%")
                      ->orWhereHas('product', function ($pq) use ($query) {
                          $pq->where('name', 'like', "%{$query}%")
                             ->orWhere('sku', 'like', "%{$query}%");
                      });
                })
                ->latest('id')
                ->take(15)
                ->get();

            // 3. Search Suppliers
            $suppliers = Supplier::withCount('products')
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('code', 'like', "%{$query}%")
                      ->orWhere('email', 'like', "%{$query}%")
                      ->orWhere('phone', 'like', "%{$query}%")
                      ->orWhere('address', 'like', "%{$query}%");
                })
                ->latest('id')
                ->take(15)
                ->get();

            // 4. Search Categories
            $categories = Category::withCount('products')
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->latest('id')
                ->take(15)
                ->get();
        }

        $totalResults = $products->count() + $transactions->count() + $suppliers->count() + $categories->count();

        return view('pages.search.results', compact(
            'query',
            'products',
            'transactions',
            'suppliers',
            'categories',
            'totalResults'
        ));
    }
}
