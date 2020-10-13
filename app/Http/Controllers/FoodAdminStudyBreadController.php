<?php
	
	namespace App\Http\Controllers;
	
	use App\FSStudy;
	use App\Http\Controllers\Voyager\VoyagerBaseController;
	use App\Http\Controllers\Voyager\VoyagerBreadController;
	use Illuminate\Http\Request;
	
	class FoodAdminStudyBreadController extends VoyagerBaseController{
		public function getSlug( Request $request ){
			return 'fs-studies';
		}
		
		public function qrsignup( Request $request ){
			$study = FSStudy::findOrFail($request->get('id'));
			
			return View('foodapp.qrsignup', [ 'study' => $study ]);
		}
		
		
		public function questioncatalog( Request $request ){
			$study = FSStudy::findOrFail($request->get('id'));
			
			$catalog = is_string($study->question_catalog) ? json_decode($study->question_catalog, true) : $study->question_catalog;
			if( !isset($catalog['format'] ))
				$catalog['format'] = 0;
			
			if( !isset($catalog['groups']) || empty($catalog['groups']) )
				$catalog['groups'] = [
					[
						'name'      => '',
						'questions' => [
							[
								"key"      => "unique key",
								"question" => "Question",
								"type"     => "slider",
								"config"   => [ "min" => 1, "max" => 5, "minLabel" => "not at all", "maxLabel" => "completely" ],
								"rep"      => "daily"
							]
						]
					]
				];
			
			
			return View('foodapp.questioncatalog', [ 'study' => $study, 'catalog' => $catalog ]);
		}
		
		public function updatequestioncatalog( Request $request ){
			$study = FSStudy::findOrFail($request->get('id'));
			try{
				$catalog = $request->get('catalog');
				$catalog['format'] = 0;
				$catalog['version'] = (new \DateTime())->format(\DateTime::ATOM);
				
				
				if( !empty($catalog['groups']) )
		            foreach( $catalog['groups'] as &$group ){
		            	$groupQuestions = [];
		                foreach( $group['questions'] as $question ){
		                	$question['type'] = strtolower(trim($question['type']?:'slider'));
		                    if( $question['type'] === 'slider' ){
		                        if( $question['config'] ){
		                            if( isset($question['config']['min']))
		                                $question['config']['min'] = intval($question['config']['min']);
		                            if( isset($question['config']['max']))
		                                $question['config']['max'] = intval($question['config']['max']);
							    }
						    }
		                    array_push( $groupQuestions, $question );
					    }
					    $group['questions'] = $groupQuestions;
		                unset( $group );
				    }
				
				$study->question_catalog = json_encode($catalog);
				$study->save();
				
				return redirect()->route('admin.foodapp.questioncatalog', ['id'=>$study->id])
			                 ->with('status', 'update failed!');
				
			}catch( \Exception $e ){
				return redirect()->route('admin.foodapp.questioncatalog', ['id'=>$study->id])
			                 ->with('status', 'Question catalog saved');
			}
			
			
		}
		
		
		//
	}



