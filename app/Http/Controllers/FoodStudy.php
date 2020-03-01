<?php

namespace App\Http\Controllers;

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

        $data = $request->only(['date', 'sleep', 'mood', 'digestion']);
        if( empty($data) )
            throw new Exception('no data',422);

        if( !empty($data['date']) )
            $data['date'] = strtotime( $data['date'] );

        $log = new FSLog();
        $log->user = $user->id;

        $log->fill( $data );

        $saved = $log->save();
        return \json_encode($saved);
    }

    public function recordFood( Request $request ){
        $user = Auth::guard()->user();

        $data = $request->only(['date', 'food', 'meal_type', 'people']);

        if( empty($data) )
            throw new Exception('no data',422);

        if( !empty($data['date']) )
            $data['date'] = strtotime( $data['date'] );

        $log = new FSLogFood();
        $log->user = $user->id;
        $log->fill( $data );


        $saved = $log->save();
        return \json_encode($saved);
    }



}
