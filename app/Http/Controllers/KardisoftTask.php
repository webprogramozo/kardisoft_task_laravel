<?php

namespace App\Http\Controllers;

use App\Kardisoft\MalformedDateStringException;
use App\Kardisoft\MedLoader;
use App\Kardisoft\MissingMedicineDataException;
use App\Kardisoft\MissingMedicineNameException;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class KardisoftTask extends Controller
{
    public function list(): View{
        return view('kardisoft.task.list');
    }
    public function search(Request $request): JsonResponse{
        $qStr = $request->post('qstr');
        $result = [];
        if(count($qStr)){
            $parameters = [];
            $wheres = [];
            foreach($qStr as $queryString){
                $queryString = "%{$queryString}%";
                $wheres[] = "med_name LIKE ? OR med_active_ingredient LIKE ? OR med_atc_code LIKE ?";
                array_push($parameters, $queryString, $queryString, $queryString);
            }
            $query = "SELECT * FROM medicines WHERE " . (implode(" AND ", $wheres));
            $result = array_map(function ($row){
                $row->med_auth_date = Carbon::parse($row->med_auth_date)->format("Y.m.d");
                return $row;
            }, DB::select($query, $parameters));
        }
        return response()->json($result);
    }

    /**
     * @throws MissingMedicineDataException
     * @throws MissingMedicineNameException
     * @throws MalformedDateStringException
     */
    public function loadMeds(): JsonResponse{
        DB::statement("TRUNCATE TABLE medicines;");
        $items = MedLoader::loadAllItems();
        $itemCount = count($items);
        $errorCount = 0;
        foreach ($items as $item){
            if(!DB::insert('INSERT INTO medicines (med_id, med_name, med_reg_number, med_active_ingredient, med_atc_code, med_auth_date) VALUES (?,?,?,?,?,?)', array_values($item))){
                $errorCount++;
            }
        }
        return response()->json([
            'item_count' => $itemCount,
            'error_count' => $errorCount,
        ]);
    }
}
