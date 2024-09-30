<?php

namespace App\Service\V1;

use Illuminate\Http\Request;

class RoomQuery{
    protected $allowParms = [
        'roomId' => ['=', '>', '<'],
        'name' => ['='],
        'houseCode' => ['='],
        'houseId' => ['=', '>', '<'],
        'length' => ['=', '>', '<'],
        'width' => ['=', '>', '<'],
        'height' => ['=', '>', '<'],
        'outdoorPm25' => ['=', '>', '<']
    ];

    protected $columnMap = [
        'roomId' => 'room_id',
        'houseCode' => 'house_code',
        'houseId' => 'house_id',
        'outdoorPm25' => 'outdoor_pm25'
    ];


    public function transform(Request $request){
        $eloQuery = [];
    
        foreach($this->allowParms as $parm => $operators){
            $query = $request->query($parm);
            if(!isset($query)){
                continue;
            }
    
            $column = $this->columnMap[$parm] ?? $parm;
    
            if(is_array($query)) {
                foreach($query as $operator => $value) {
                    $eloQuery[] = [$column, $operator, $value];
                }
            } else {
                $eloQuery[] = [$column, '=', $query];
            }
        }

        return $eloQuery;
    }
}