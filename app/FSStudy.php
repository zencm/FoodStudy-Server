<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	
	function slugify( $text ){
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);
		
		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		
		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);
		
		// trim
		$text = trim($text, '-');
		
		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);
		
		// lowercase
		$text = strtolower($text);
		
		if( empty($text) ){
			return 'n-a';
		}
		
		return $text;
	}
	
	function guidv4(){
		$data = random_bytes(16);
		
		$data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
		
		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}
	
	
	class FSStudy extends Model{
		protected $table = 'fs_studies';
		
		public $timestamps = false;
		
		
		protected $fillable = [ 'from', 'until', 'name', 'prefix', 'reg_public', 'reg_key', 'reg_limit', 'user_count' ];
		
		protected $casts = [
			// 'sleep' => 'integer',
			// 'mood' => 'integer',
			// 'digestion' => 'integer'
		];
		
		protected $dates = [
			'from',
			'until'
		];
		
		public function fill( array $attributes ){
			if( empty($attributes['reg_key']) )
				$attributes['reg_key'] = guidv4();
			
			if( empty($attributes['user_count']) )
				$attributes['user_count'] = 0;
			
			return parent::fill($attributes);
		}
		
		
		protected static function boot(){
			parent::boot();
			static::saving(
				function( $model ){
					if( empty($model->prefix) )
						$model->prefix = !empty($model->name) ? $model->name : time();
					
					$model->prefix = slugify($model->prefix);
				}
			);
		}
		
		
	}
