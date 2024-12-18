<?php

namespace App\Http\Controllers;

use App\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardHistoryController extends Controller
{
    public function index()
    {


        $buytransactions = TransactionDetail::with(['transaction.user', 'product.galleries', 'transaction'])
            ->whereHas('transaction', function ($transaction) {
                $transaction->where('users_id', Auth::user()->id);
            })->orderByDesc('created_at')->get();


        return view('pages.dashboard-history', [

            'buytransactions' => $buytransactions
        ]);
    }

    public function detail(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user', 'product.galleries', 'transaction'])
            ->findOrFail($id);
        return view('pages.dashboard-history-detail', [
            'transaction' => $transaction,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $item = TransactionDetail::findOrFail($id);
        $item->update($data);
        return redirect()->route('dashboard-transaction-detail', $id);
    }
}
