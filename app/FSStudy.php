<?php
	
	namespace App;
	
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Facades\Hash;
	
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
	
	function random_str(
		$length,
		$keyspace = '123456789abcdefghjklmnpqrstuvwxyzABCDEFGHLJKMNPQRSTUVWXYZ'
	){
		$str = '';
		$max = mb_strlen($keyspace, '8bit') - 1;
		if( $max < 1 ){
			throw new Exception('$keyspace must be at least two characters long');
		}
		for( $i = 0 ; $i < $length ; ++$i ){
			$str .= $keyspace[ random_int(0, $max) ];
		}
		return $str;
	}
	
	
	class FSStudy extends Model{
		protected $table = 'fs_studies';
		
		public $timestamps = false;
		
		
		protected $fillable = [ 'from', 'until', 'name', 'prefix', 'reg_public', 'reg_key', 'reg_pass', 'reg_limit', 'user_count', 'question_catalog' ];
		
		protected $casts = [
			'question_catalog' => 'json'
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
			
			if( empty($attributes['reg_pass']) )
				$attributes['reg_pass'] = random_str(8);
			
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
		
		
		public function createCredentials( $extraData = null ){
			FSStudy::where('id', $this->id)
			       ->increment('user_count')
			;
			
			$fs_participant = $extraData['fs_participant'] ?: null;
			
			
			$username = $this->prefix . '_' . $this->user_count;
			$password = random_str(8);
			
			$user = User::create(
				[
					'fs_study'      => $this->id,
					'name'          => $username,
					'username'      => $username,
					'password'      => Hash::make($password),
					'fs_participant' => $fs_participant
				]
			);
			
			return compact('username', 'password', 'fs_participant');
			
		}
		
	}
