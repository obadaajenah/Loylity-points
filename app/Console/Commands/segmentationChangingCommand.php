<?php

namespace App\Console\Commands;

use App\Models\Segmentation;
use App\Models\Customer;
use App\Models\CommandHistory;
use Illuminate\Console\Command;
use DateTime;

class segmentationChangingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:segmentation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change segmentation';

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
        $customers = Customer::where('segmentation_id','>',1)->get();

        foreach($customers as $customer){
            $seg = Segmentation::findOrFail($customer->segmentation_id - 1);

            $now = new DateTime();
            $user_created = date_add($customer->created_at,date_interval_create_from_date_string($seg->period . ' days')); //$customer->created_at+$seg->period

            $rest_date = ($now->diff($user_created))->format('%R%a');

            $flag=0;
            if($seg->relation == 1){
                if($customer->total_gems >= $seg->gems && $rest_date <= 0){$flag = 1;}
                else{$flag=0;}
            }else{
                if($customer->total_gems >= $seg->gems || $rest_date <= 0){$flag=1;}
                else{$flag=0;}
            }
    
            if($flag){
                CommandHistory::create([
                    'command_name' => 'segmentationChangingCommand',
                    'action' => 'customer ('. $customer->user->fname . " " . $customer->user->lname . ') segmentation : ('.$customer->segmentation->name.') high up' ,
                    'value' => $seg->name
                ]);    
                $customer->update(['segmentation_id'=>$customer->segmentation_id-1]);
            }
        }
    }
}
