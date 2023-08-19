<?php

use Illuminate\Support\Facades\Route;
use App\Models\PartnerBundle;
use App\Models\CommandHistory;
use App\Models\BonusTransfer;
use App\Models\Customer;
use App\Models\Segmentation;
use Illuminate\Http\Request;
use App\Events\NotifyEvent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('login',function(){
    return response()->json(['message'=>'please login first!'],401);
})->name('login');


Route::get('date',function(){
    return getdate();
});


# TEST FOR BONUS EXPIRATION COMMAND (Valid for one day then cahnge your date)
Route::get('test',function(){
    $bts = BonusTransfer::all();
    
    foreach ($bts as $bt) {

        $datenow = new DateTime(getdate()["year"] . "-" . getdate()["mon"] . "-" . getdate()["mday"]);
        $date = new DateTime($bt->exp_date);

        $rest_date = ($datenow->diff($date))->format('%R%a');

        echo "\n rest_date = " . $rest_date . "\n\n";

        if ($rest_date == -1) {

            $receiver_bonus_transfer_as_sender = BonusTransfer::where('sender_user_id',$bt->receiverUser->id)->get();

            echo "receiverUser id = " . $bt->receiverUser->id . "\n\n";

            $cus = Customer::firstWhere('user_id',$bt->receiverUser->id);
            if(sizeof($receiver_bonus_transfer_as_sender) > 0){
                            
                $total_sender = 0;
                foreach($receiver_bonus_transfer_as_sender as $bt2){
                    $total_sender += $bt2->value;                    
                }
                echo "total_sender = " . $total_sender . "\n\n";
    
                if($bt->value >= $total_sender){
                    echo "bt->value = $bt->value ,  total_sender = $total_sender\n\n";
                    echo "new cur_bonus = " . ($cus->cur_bonus - ($bt->value - $total_sender)) . "\n\n";
                    $cus->update(['cur_bonus' => $cus->cur_bonus - ($bt->value - $total_sender)]);
    
                    CommandHistory::create([
                        'command_name' => 'bonusExpirationCommand',
                        'action' => 'expire bonus  (' . $bt->value . ")  :  " . $bt->receiverUser->fname . " " . $bt->receiverUser->lname  ,
                        'value' => $cus->cur_bonus + ($bt->value - $total_sender)
                    ]);
                }
            }else{
                echo "This user have no sending !\n\n";
                echo "new cur_bonus = " . ($cus->cur_bonus - $bt->value) . "\n\n";
                $cus->update(['cur_bonus' => $cus->cur_bonus - $bt->value]);
    
                CommandHistory::create([
                    'command_name' => 'bonusExpirationCommand',
                    'action' => 'expire bonus  (' . $bt->value . ")  :  " . $bt->receiverUser->fname . " " . $bt->receiverUser->lname  ,
                    'value' => $cus->cur_bonus + $bt->value
                ]);
            }
        }
        echo "-----------------------------------------------------------------------------------------------------------------------\n";
    }
    return response()->json(['message' => 'response']);

});

# NEED MORE WORK AND CHECKING AND TESTING

Route::get('test2',function(){
    $customers_count = sizeof(Customer::all());
    $customers_bronze_count = sizeof(Customer::where('segmentation_id',3)->get());
    $customers_new_count = sizeof(Customer::where('segmentation_id',4)->get());
    $customers_new = Customer::where('segmentation_id',4)->orderBy('total_gems','desc')->get();
    dd($customers_new->toArray());
    $new = Segmentation::first(4);

    foreach($customers_new as $customer){
        if(($customer->total_gems >= $new->gems || $customer->created_at >= $new->period) 
        && ($customers_bronze_count +1 /$customers_count) <= 0.8  || (($customers_count-$customers_new_count+1)/$customers_count) <= 0.8 )
        {
            $customer->update(['segmentation_id' => 3]);
        }
    }
});



Route::get('testApi',function(){
    $request = Request();
});


Route::get('notify',function(){
    event(new NotifyEvent('Manchester City Europe Super League Champion !'));
    return response()->json(['message'=> 'your notifiacation sent Successfully']);
});

Route::get('index',function(){
    return view('index');
});


/**
 *                 $pusher = new Pusher('7e128d7214eddf18c6d0', '36b32569fb0299435f99', '1442095', array('cluster' => 'ap2'));
 
 *               $pusher->trigger(
 *                  '1-channel',
 *                 'my-event',
 *                "$pu->name blocked automaticlly because he canceled appointments 5 times!",
 *               // array('info' => 'subscription_count')
 *          );

 */