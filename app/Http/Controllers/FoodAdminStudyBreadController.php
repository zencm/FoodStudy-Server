<?php

namespace App\Http\Controllers;

use App\FSStudy;
use App\Http\Controllers\Voyager\VoyagerBaseController;
use App\Http\Controllers\Voyager\VoyagerBreadController;
use Illuminate\Http\Request;

class FoodAdminStudyBreadController extends VoyagerBaseController
{
	public function getSlug( Request $request ){
		return 'fs-studies';
	}
	
	public function qrsignup( Request $request ){
		$study = FSStudy::findOrFail( $request->get('id') );
		
		return View('foodapp.qrsignup', ['study'=>$study] );
	}
	
	
	//
}



