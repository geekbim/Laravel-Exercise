<?php

namespace App\Console\Commands;

use App\Models\History;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckOrder extends Command
{
    protected $order, $history;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'everyminute:checkorder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automate check order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Order $order, History $history)
    {
        parent::__construct();
        $this->order    = $order;
        $this->history  = $history;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // get order
        $orders = $this->order
                ->where('status', null)
                ->where('created_at', '<', Carbon::now()->subMinutes(5)->toDateTimeString())
                ->get();

        foreach ($orders as $order) {
            // update orders table
            $order = $this->order->find($order->id);

            $order->status = '2';

            $order->save();

            // update histories table
            $this->history
                ->where('order_id', $order->id)
                ->update([
                    'status' => 2
                ]);
        }

        $this->info('Checked order successfully');
    }
}
