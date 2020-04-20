<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FSLog extends Model{
    protected $table = 'fs_log';

    public $timestamps = false;


    protected $fillable = ['date','sleep','mood','digestion'];
		
    protected $casts = [
        // 'sleep' => 'integer',
        // 'mood' => 'integer',
        // 'digestion' => 'integer'
    ];

    protected $dates = [
        'date','received'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function study(){
        return $this->belongsTo('App\FSStudy');
    }

}
