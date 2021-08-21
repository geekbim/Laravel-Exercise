<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Topup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
    protected $user, $topup, $history;

    public function __construct(User $user, Topup $topup, History $history)
    {
        $this->user     = $user;
        $this->topup    = $topup;
        $this->history  = $history;
    }

    public function index()
    {
        // get user mobile number
        $user = $this->user->find(Auth::user()->id);

        return view('topup', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|integer|digits_between:7,12',
            'value'         => 'required|in:10000,50000,100000',
        ]);

        // id user
        $id = Auth::user()->id;

        // update users table
        $user = $this->user->find($id);

        $user->mobile_number = '081'. $request->mobile_number;

        $user->save();

        // insert/update into topup table
        $topup = $this->topup->where('user_id', $id)->first();
        if ($topup) {
            $this->topup
                ->where('user_id', $id)
                ->update([
                    'user_id'          => $id,
                    'mobile_number'    => '081' . $request->mobile_number,
                    'value'            => $topup->value + $request->value 
                ]);
        } else {
            $topup = $this->topup;

            $topup->user_id         = $id;
            $topup->mobile_number   = $request->mobile_number;
            $topup->value           = $request->value;
            $topup->status          = '1';
    
            $topup->save();
        }

        // insert into table histories
        $history = $this->history;

        $history->user_id       = $id;
        $history->topup_id      = $topup->id;
        $history->mobile_number = $request->mobile_number;
        $history->value         = $request->value;
        $history->status        = '1';

        $history->save();

        return back()->with('success', 'Topup successfully');
    }
}
