<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransactionDetail;
use App\User;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{
    public function index()
    {
        $transactions = TransactionDetail::with(['transaction.user', 'product.galleries', 'transaction'])
            ->whereHas('transaction', function ($transaction) {
                $transaction->where('users_id', Auth::user()->id);
            })->orderByDesc('created_at');
        $transactionsData = $transactions->get();

        // Hitung revenue dari total price transaksi
        $revenue = $transactionsData->reduce(function ($carry, $item) {
            return $carry + $item->transaction->total_price;
        });
        $customer = User::count();

        return view('pages.dashboard', [
            'transactions_count' => $transactionsData->count(),
            'transactions_data' => $transactionsData,
            'revenue' => $revenue,
            'customer' => $customer,


        ]);
    }
}
