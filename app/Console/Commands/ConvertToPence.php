<?php

namespace App\Console\Commands;

use App\User;
use App\Expense;
use App\Purchase;
use App\WeekItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ConvertToPence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts the currency to pence.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->toPence(Expense::class, 'expenses', 'amount');
        $this->toPence(Purchase::class, 'purchases', 'amount');
        $this->toPence(User::class, 'users', 'goal');
        $this->toPence(User::class, 'users', 'savings');
        $this->toPence(WeekItem::class, 'week_items', 'rate');
    }

    /**
     * Converts the given table column to pence.
     *
     * @return void
     */
    public function toPence($model, $table, $column)
    {
        $rows = $model::all();

        Schema::table($table, function (Blueprint $table) use ($column) {
            $table->dropColumn($column);
        });

        Schema::table($table, function (Blueprint $table) use ($column) {
            $table->bigInteger($column)->nullable();
        });

        $rows->each(function ($row) use ($column) {
            $row->update([
                $column => $row->$column * 100
            ]);
        });
    }
}
