<?php
	
	namespace App\Http\Controllers;
	
	use App\FSLog;
	use App\FSLogFood;
	use App\FSStudy;
	use App\User;
	use DateTime;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\View;
	
	use Illuminate\Support\Carbon;
	
	class FoodAppManager extends \TCG\Voyager\Http\Controllers\VoyagerBaseController{
		
		
		private function _generateCSV( $data, $delimiter = ',', $enclosure = '"', $header = true ){
			if( empty($data) )
				return '';
			
			$handle = fopen('php://memory', 'r+');
			
			if( $header )
				fputcsv($handle, array_keys($data[0]), $delimiter, $enclosure);
			
			
			foreach( $data as $line ){
				$line['data'] = json_encode($line['data']);
				fputcsv($handle, $line, $delimiter, $enclosure);
			}
			
			rewind($handle);
			$contents = '';
			while( !feof($handle) ){
				$contents .= fread($handle, 8192);
			}
			fclose($handle);
			return $contents;
		}
		
		
		private function _getLogs( $request ){
			$type = $request->input('type', 'food');
			
			if( !in_array($type, [ 'log', 'food' ]) )
				$type = 'food';
			
			$defaultDate = ( new DateTime() )->modify('-1 day');
			$datefrom = $request->input('from', $defaultDate->format('Y-m-d'));
			$dateuntil = $request->input('until', $defaultDate->format('Y-m-d'));
			$from = Carbon::parse($datefrom)->startOfDay();
			$until = Carbon::parse($dateuntil)->endOfDay();
			
			if( $until < $from )
				$until = $from;
			
			
			if( $type === 'food' )
				$logs = FSLogFood::whereBetween('date', [ $from->toDateTimeString(), $until->toDateTimeString() ])->get()->toArray();
			else
				$logs = FSLog::whereBetween('date', [ $from->toDateTimeString(), $until->toDateTimeString() ])->get()->toArray();
			
			
			$users = [];
			$participants = [];
			$studies = [];
			
			foreach( $logs as &$log ){
				unset($log['id']);
				unset($log['bls']);
				unset($log['bls_key']);
				
				if( !isset($users[ $log['user'] ]) ){
					$users[ $log['user'] ] = null;
					$participants[ $log['user'] ] = null;
				}
				
				$log['participant'] = &$participants[ $log['user'] ];
				$log['user'] = &$users[ $log['user'] ];
				
				if( $log['study'] ){
					if( !isset($studies[ $log['study'] ]) )
						$studies[ $log['study'] ] = null;
					
					$log['study'] = &$studies[ $log['study'] ];
				}
			}
			unset( $log );
			
			foreach( User::find(array_keys($users)) as $u ){
				$users[ $u['id'] ] = $u['name'];
				$participants[ $u['id'] ] = $u['fs_participant'];
			}
			
			foreach( FSStudy::find(array_keys($studies)) as $s ){
				$studies[ $s['id'] ] = $s['prefix'];
			}
			
			
			return [
				'type'      => $type,
				'datefrom'  => $from->format('Y-m-d'),
				'dateuntil' => $until->format('Y-m-d'),
				'logs'      => $logs,
			];
		}
		
		
		public function exportForm( Request $request ){
			
			$vars = $this->_getLogs($request);
			
			foreach( $vars['logs'] as &$log ){
				unset($log['received']);
			}
			
			
			return View('foodapp.managerform', $vars);
		}
		
		
		public function export( Request $request ){
			
			$vars = $this->_getLogs($request);
			
			
			$logs = $vars['logs'];
			
			
			return $this->_generateCSV($logs);
			
		}
		
		
	}
