<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Voyager\VoyagerBaseController;
use App\Http\Controllers\Voyager\VoyagerBreadController;
use Illuminate\Http\Request;

class FoodAdminStudyBreadController extends VoyagerBaseController
{
	public function getSlug( Request $request ){
		return 'fs-studies';
	}
	
	
	//
}



