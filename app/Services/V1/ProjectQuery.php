<?php

namespace App\Services\V1;

use Illuminate\Http\Request;

class ProjectQuery {
    protected $allowParms = [
        'date' => ['=', '>', '<'],
        'houseCode' => ['='],
        'houseId' => ['='],
        'client' => ['='],
        'phone' => ['='],
        'sales' => ['='],
        'installer' => ['='],
        'location' => ['='],
        'amounts' => ['=', '>', '<'],
        'progress' => ['=', '>', '<'],
        'completed' => ['='],
        'clientSatisfaction' => ['=', '>', '<'],
        'currency' => ['=']
    ];

    protected $columnMap = [
        'houseCode' => 'house_code',
        'houseId' => 'house_id',
        'clientSatisfaction' => 'client_satisfaction'
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