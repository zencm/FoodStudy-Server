<?php

namespace App\Http\Controllers;

use App\FSLog;
use App\FSLogFood;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Carbon;

class FoodAppManager extends \TCG\Voyager\Http\Controllers\VoyagerBaseController
{

    
    private function _generateCSV($data, $delimiter = ',', $enclosure = '"', $header = true){
        if( empty($data) )
            return '';

        $handle = fopen('php://memory', 'r+');

        if( $header )
            fputcsv($handle, array_keys($data[0]), $delimiter, $enclosure);


        foreach ($data as $line) {
            fputcsv($handle, $line, $delimiter, $enclosure);
        }
        rewind($handle);
        $contents = '';
        while (!feof($handle)) {
                $contents .= fread($handle, 8192);
        }
        fclose($handle);
        return $contents;
 }
 

    private function _getLogs( $request ){
        $type = $request->input('type','food');
        
        if( !in_array($type,['log','food']) )
            $type = 'food';

        $datefrom = $request->input('from', date('Y-m-d') );
        $dateuntil = $request->input('until', date('Y-m-d') );
        $from = Carbon::parse($datefrom)->startOfDay();
        $until = Carbon::parse($dateuntil)->endOfDay();

        if( $until < $from )
            $until = $from;

        
        if( $type === 'food' )
            $logs = FSLogFood::whereBetween('date', [$from->toDateTimeString(), $until->toDateTimeString()])->get()->toArray();
        else
            $logs = FSLog::whereBetween('date', [$from->toDateTimeString(), $until->toDateTimeString()])->get()->toArray();

        return [
            'type' => $type,
            'datefrom' => $from->format('Y-m-d'),
            'dateuntil' => $until->format('Y-m-d'),
            'logs' => $logs,
        ];
    }


    public function exportForm(Request $request){
        
        $vars = $this->_getLogs( $request );

        foreach( $vars['logs'] as &$log ){
            unset( $log['id'] );
            unset( $log['received'] );
            unset( $log['bls'] );
            unset( $log['bls_key'] );
        }

        
        return View('foodapp.managerform', $vars );
    }


    public function export(Request $request){
        
        $vars = $this->_getLogs( $request );

        $logs = $vars['logs'];

       
        return $this->_generateCSV( $logs );

        
    }


}
