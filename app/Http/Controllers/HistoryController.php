<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    protected $history;

    public function __construct(History $history)
    {
        $this->history = $history;
    }

    public function index(Request $request)
    {
        $histories = $this->history->query();

        if ($request->search) {
            $histories  = $this->history
                        ->where('no_order', 'like', '%'. $request->search .'%');
        }

        $histories  = $histories
                    ->with(['topup', 'order'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);

        return view('history', compact('histories'));
    }
}
