<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FSLogFood extends Model{

    protected $table = 'fs_log_food';
    public $timestamps = false;


    protected $fillable = ['date','bls','bls_key','food','meal_type','people'];
		
    protected $casts = [
        'people' => 'integer'
        // 'sleep' => 'integer',
        // 'mood' => 'integer',
    ];

    protected $dates = [
        'date','received'
    ];

    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function bls(){
        return $this->belongsTo('App\FSBLS');
    }


}
