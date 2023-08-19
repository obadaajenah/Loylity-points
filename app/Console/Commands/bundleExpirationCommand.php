<?php

namespace App\Console\Commands;

use App\Models\PartnerBundle;
use Illuminate\Console\Command;
use DateTime;
use App\Models\CommandHistory;
use App\Models\Partner;

class bundleExpirationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bundle:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bundle passed expiration_period';

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
     * @return int
     */
    public function handle()
    {
        $pbs = PartnerBundle::where('status',1)->get();

        foreach ($pbs as $pb) {
            $datenow = new DateTime(getdate()["year"] . "-" . getdate()["mon"] . "-" . getdate()["mday"]);
            $date = new DateTime($pb->end_date);

            $rest_date = ($datenow->diff($date))->format('%R%a');

            if ($rest_date <= 0) {
                $pb->update(['status' => 0]);
                Partner::firstOrFail($pb->partner_id)->update(['gems'=>0,'bonus'=>0]);
                CommandHistory::create([
                    'command_name' => 'bundleExpirationCommand',
                    'action' => 'expire bundle  (' . $pb->bundle->name . ')  :  ' . $pb->partner->user->fname,
                    'value' => "Deactived"
                ]);
            }
        }
    }
}
