<?php
	
	
	namespace App\Actions;
	
	use TCG\Voyager\Actions\AbstractAction;
	
	class StudyQRSignup extends AbstractAction{
		public function getTitle(){
			return 'QR Signup';
		}
		
		public function getIcon(){
			return 'voyager-phone';
		}
		
		public function getPolicy(){
			return 'read';
		}
		
		public function getAttributes(){
			return [
				'class' => 'btn btn-sm btn-primary pull-right',
			];
		}
		
		public function getDefaultRoute(){
			return route('admin.foodapp.qrsignup', ['id'=>$this->data->{$this->data->getKeyName()} ] );
//			return '/admin/';
		}
		
		public function shouldActionDisplayOnDataType(){
			return $this->dataType->slug == 'fs-studies';
		}
		
	}
