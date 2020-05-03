<?php

namespace App\Http\Controllers;

use App\FSBLS;
use App\FSLog;
use App\FSLogFood;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodStudy extends Controller{
    
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function recordLog( Request $request ){
        $user = Auth::guard()->user();

        $data = $request->only(['data','date']);
        if( empty($data) )
            throw new Exception('no data',422);

        if( !empty($data['date']) )
            $data['date'] = strtotime( $data['date'] );

        $log = new FSLog();
        $log->user = $user->id;
        $log->study = $user->fs_study ?: 0;
        $log->data = $data['data'];

        $log->fill( $data );

        $saved = $log->save();
        return \json_encode($saved);
    }

    
    public function recordFood( Request $request ){
        $user = Auth::guard()->user();

        $data = $request->only(['date', 'meal_type', 'people', 'data']);

        if( empty($data) || empty($data['data']) )
            throw new Exception('no data',422);

        if( !empty($data['date']) )
            $data['date'] = strtotime( $data['date'] );

        
        $foodData = [];
        foreach( $data['data'] as $entry ){
        	array_push($foodData, ['k'=> strip_tags($entry['k']), 'q'=>intval($entry['q'])]);
        }
        
        
        $log = new FSLogFood();
        $log->user = $user->id;
        $log->study = $user->fs_study ?: 0;
        $log->data = $foodData;
        
        $log->fill( $data );


        $saved = $log->save();
        return \json_encode($saved);
    }


    public function bls( Request $request ){
        if( !$this->authorize('browse_admin') )
        	throw new Exception('this is not public data',403);
        
        
    	$list = FSBLS::all(['id','bls_key','name_de']);
    	$list->each(function($r){
    		$r['key'] = $r['bls_key'];
    		$r['de'] = $r['name_de'];
    		unset( $r['bls_key'] );
    		unset( $r['name_de'] );
	    });
    	return $list;
    	
    }
    

}
