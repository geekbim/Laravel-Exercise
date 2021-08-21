<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Order;
use App\Models\Topup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $order, $topup, $user, $history;

    public function __construct(Order $order, Topup $topup, User $user, History $history)
    {
        $this->order    = $order;
        $this->topup    = $topup;
        $this->user     = $user;
        $this->history  = $history;
    }

    public function index()
    {
        return view('order');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product'           => 'required|string|min:10|max:150',
            'shipping_address'  => 'required|string|min:10|max:150',
            'price'             => 'required|integer',
        ]);

        // get id user login
        $id = Auth::user()->id;

        // create no order
        $noOrder = random_int(1000000000, 9999999999);

        $order = $this->order;

        $order->no_order            = $noOrder;
        $order->user_id             = $id;
        $order->product             = $request->product;
        $order->shipping_address    = $request->shipping_address;
        $order->price               = $request->price;

        $order->save();

        // insert into table histories
        $history = $this->history;

        $history->user_id       = $id;
        $history->order_id      = $order->id;
        $history->no_order      = $noOrder;
        $history->product       = $request->product;
        $history->price         = $request->price;

        $history->save();

        return redirect()
            ->route('order.success', $noOrder)
            ->with('success', 'Order successfully');
    }

    public function success($noOrder)
    {
        // get user id
        $id = Auth::user()->id;

        // get value topup user
        $value  = $this->topup
                ->where('user_id', $id)
                ->pluck('value')
                ->toArray();

        // sum value topup user
        $value = (int)array_sum($value) + (int)array_sum($value) * 5/100;

        // get phone topup user
        $phone  = $this->user->find($id);

        // get product
        $order  = $this->order
                ->where('no_order', $noOrder)
                ->first();
        $price              = $order->price + 10000;
        $productName        = $order->product;
        $shippingAddress    = $order->shipping_address;
        $createdAt          = $order->created_at;

        return view('success', compact('noOrder', 'value', 'phone', 'price', 'productName', 'shippingAddress', 'createdAt'));
    }

    public function payPage($noOrder)
    {
        return view('pay', compact('noOrder'));
    }

    public function pay(Request $request)
    {
        // generate shipping code
        $shippingCode = strtoupper(bin2hex(random_bytes(8)));

        // update table orders
        $this->order
            ->where('no_order', $request->no_order)
            ->update([
                'shipping_code' => $shippingCode,
                'status'        => '1'
            ]);

        // get order
        $order  = $this->order
                ->where('no_order', $request->no_order)
                ->first();

        // update table histories
        $this->history
            ->where('order_id', $order->id)
            ->update([
                'shipping_code' => $shippingCode,
                'status' => '1'
            ]);

        return redirect()->route('history');
    }
}
