<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        $users = DB::table('users')->whereNotNull('phone')->get(['id','phone']);
        foreach($users as $u){
            $digits = preg_replace('/[^0-9]/','', $u->phone);
            if(strlen($digits) > 10){
                $digits = substr($digits, -10); // keep last 10
            }
            if(strlen($digits) === 10){
                DB::table('users')->where('id',$u->id)->update(['phone'=>$digits]);
            } else {
                // If not 10 digits after cleaning, null it out
                DB::table('users')->where('id',$u->id)->update(['phone'=>null]);
            }
        }
    }
    public function down(): void {
        // irreversible cleanup; do nothing
    }
};
