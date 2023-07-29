<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BonusTransfer;
use App\Models\CommandHistory;
use App\Models\Customer;
use DateTime;

class bonusExpirationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bonus:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bonus of customer passed exp_date';

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
        $bts = BonusTransfer::all();

        foreach ($bts as $bt) {
            $datenow = new DateTime(getdate()["year"] . "-" . getdate()["mon"] . "-" . getdate()["mday"]);
            $date = new DateTime($bt->exp_date);

            $rest_date = ($datenow->diff($date))->format('%R%a');

            if ($rest_date < 0) {

                $receiver_bonus_tranfer_as_sender = BonusTransfer::where('sender_user_id',$bt->receiverUser->id)->get();
                $total_sender = 0;
                foreach($receiver_bonus_tranfer_as_sender as $bt2){
                    $total_sender += $bt2->value;                    
                }

                $cus = Customer::firstWhere('user_id',$bt->receiverUser->id);
                if($bt->value >= $total_sender){
                    $cus->update(['cur_bonus' => $cus->cur_bonus - $total_sender]);

                    CommandHistory::create([
                        'command_name' => 'bonusExpirationCommand',
                        'action' => 'expire bonus  (' . $bt->value . ")  :  " . $bt->receiverUser->fname . " " . $bt->receiverUser->lname  ,
                        'value' => "$total_sender"
                    ]);
                }else{
                    $cus->update(['cur_bonus' => 0]);

                    CommandHistory::create([
                        'command_name' => 'bonusExpirationCommand',
                        'action' => 'expire bonus  (' . $bt->value . ")  :  " . $bt->receiverUser->fname . " " . $bt->receiverUser->lname  ,
                        'value' => "$total_sender"
                    ]);

                }
            }
        }
    }
}
