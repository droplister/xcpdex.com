<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Resources\MempoolResource;
use Droplister\XcpCore\App\Mempool;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MempoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = Mempool::where('command', '=', 'insert')
            ->whereIn('category', ['orders', 'cancels'])
            ->whereDoesntHave('transaction')
            ->where('created_at', '>', Carbon::now()->subDays(1))
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return [
            'mempool' => MempoolResource::collection($transactions),
            'last_page' => ceil($transactions->total() / 30),
            'current_page' => (int) $request->input('page', 1),
        ];
    }
}
