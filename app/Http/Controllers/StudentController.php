<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){
        return view('/student');
    }

    public function SankeyData(){
        $nodes_data = array();
        $links_data = array();
        $c_number = 0;
        $w_number = 0;
        $all_data = DB::table('knowledge_u1')->get();
        for($i=0; $i<15; $i++){
            $item = $all_data[$i];
            $c_number += $item->c_numbers;
            $w_number += $item->w_numbers;
            $cur_node = array("name"=>(string)$item->knowledge, "value"=>$item->q_numbers, "depth"=>0);
            array_push($nodes_data, $cur_node);
            $cur_c_link = array("source"=>(string)$item->knowledge, "target"=>"Correct", "value"=>$item->c_numbers);
            $cur_w_link = array("source"=>(string)$item->knowledge, "target"=>"Wrong", "value"=>$item->w_numbers);
            array_push($links_data, $cur_c_link);
            array_push($links_data, $cur_w_link);
        }

        $c_node = array("name"=>"Correct", "value"=>$c_number, "depth"=>1);
        $w_node = array("name"=>"Wrong", "value"=>$w_number, "depth"=>1);
        $c_rate = $c_number / ($c_number + $w_number);
        $w_rate = $w_number / ($c_number + $w_number);
        array_push($nodes_data, $c_node);
        array_push($nodes_data, $w_node);

        $sankey_data = array("nodes"=>$nodes_data, "links"=>$links_data,"k_number"=>15, "q_number"=>($c_number + $w_number), "c_rate"=>$c_rate, "w_rate"=>$w_rate);
        return $sankey_data;

    }

    public function matrix(){
        $red_data = array();
        $yellow_data = array();
        $green_data = array();
        $k_list = array();
        $all_data = DB::table('knowledge_u1')->get("knowledge");
        foreach($all_data as $item){
            array_push($k_list, $item->knowledge);
        }

        $red_data_index = array_rand($k_list, 3);
        foreach($red_data_index as $r_index){
            array_push($red_data, $k_list[$r_index]);
        }
       
        $left_k_list = array_diff($k_list, $red_data);
        $green_data_index = array_rand($left_k_list, 5);
        foreach($green_data_index as $g_index){
            array_push($green_data, $k_list[$g_index]);
        }

        $right_k_list = array_diff($left_k_list, $green_data);
        $yellow_data_index = array_rand($right_k_list, 7);
        foreach($yellow_data_index as $y_index){
            array_push($yellow_data, $k_list[$y_index]);
        }
        // $yellow_data = array_rand($left_k_list, 7);
        // $green_data = array_rand(array_diff($left_k_list, $yellow_data), 5);

        // $res_data = array("red"=>$red_data);
        $res_data = array("red"=>$red_data, "green"=>$green_data, "yellow"=>$yellow_data);

        return $res_data;
    }

    public function PlanData(){
        $res_data = array();
        $k_list = array();
        $all_data = DB::table('knowledge_u1')->get("knowledge");
        foreach($all_data as $item){
            array_push($k_list, $item->knowledge);
        };
        $random_data_index = array_rand($k_list, 7);
        array_push($res_data, array("name"=>"2020-09-10", "knowledge"=>$k_list[$random_data_index[0]], "value"=>0));
        array_push($res_data, array("name"=>"2020-09-15", "knowledge"=>$k_list[$random_data_index[1]], "value"=>0));
        array_push($res_data, array("name"=>"2020-09-23", "knowledge"=>$k_list[$random_data_index[2]], "value"=>0));
        array_push($res_data, array("name"=>"2020-10-04", "knowledge"=>$k_list[$random_data_index[3]], "value"=>0));
        array_push($res_data, array("name"=>"2020-10-12", "knowledge"=>$k_list[$random_data_index[4]], "value"=>0));
        array_push($res_data, array("name"=>"2020-10-16", "knowledge"=>$k_list[$random_data_index[5]], "value"=>0));
        array_push($res_data, array("name"=>"2020-10-21", "knowledge"=>$k_list[$random_data_index[6]], "value"=>0));
        return $res_data;
    }
}
