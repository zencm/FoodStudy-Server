<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FSLogFood extends Model{

    protected $table = 'fs_log_food';
    public $timestamps = false;


    protected $fillable = ['date','meal_type','people', 'data'];
		
    protected $casts = [
    	'data' => 'json',
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

    public function study(){
        return $this->belongsTo('App\FSStudy');
    }

}
