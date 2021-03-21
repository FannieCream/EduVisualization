<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GraphController extends Controller
{
    public function index(){
        return view('/graph');
    }

    public function GraphData(){
        $graph_data = array();
        $all_data = DB::table('all_t_k_relations')->get();
        foreach($all_data as $item){
            $cur_node = array("name"=>$item->knowledge, "value"=>$item->q_numbers, "symbolSize"=>round(($item->q_numbers)/10), "c_rate"=>(float)$item->correct_rate);
            array_push($graph_data, $cur_node);
        }
        return $graph_data;
    }
}
