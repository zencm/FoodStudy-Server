<?php
	
	
	namespace App\Actions;
	
	use TCG\Voyager\Actions\AbstractAction;
	
	class StudyQuestionCatalog extends AbstractAction{
		public function getTitle(){
			return 'Question Catalog';
		}
		
		public function getIcon(){
			return 'voyager-book';
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
			return route('admin.foodapp.questioncatalog', ['id'=>$this->data->{$this->data->getKeyName()} ] );
//			return '/admin/';
		}
		
		public function shouldActionDisplayOnDataType(){
			return $this->dataType->slug == 'fs-studies';
		}
		
	}
