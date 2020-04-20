<?php
	
	namespace App\Http\Controllers;
	
	use App\FSStudy;
	use Illuminate\Http\Request;
	
	class StudySignup extends Controller{
		
		
		
		public function signup( Request $request ){
			
			$data = $request->only(['key', 'response']);
	        if( empty($data) )
	            throw new Exception('no data',422);
			
			
			$study = FSStudy::where('reg_key', $data['key'])->firstOrFail();
			
			
			
			
			if( !$study->reg_public
			    || ($study->reg_limit && $study->user_count > $study->reg_limit)
				|| ( $study->from && date_create($study->from) > date_create() )
				|| ( $study->until && date_create($study->until) < date_create() )
			){
				
				return response()->json(['code'=> 503 , 'message'=> 'study signup not available']);
//				throw new \Exception('study signup not available', 503);
//				abort( 503, 'study signup not available');
			}
			
			
			if( !empty($study->reg_pass) && $study->reg_pass !== $data['response'] )
				return response()->json(['code'=> 403 , 'message'=> 'invalid signup key/pass']);
//				throw new \Exception('invalid signup key/pass', 403);

			
			
			$credentials = $study->createCredentials();
			
			return $credentials;
		}
		
	}
