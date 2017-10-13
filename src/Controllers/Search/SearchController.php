<?php

namespace Wbe\Searchland\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return 'asdasd';
//        return view('');
    }

    public function result($search)
    {
        $config_search = config('search');
        $arr['urlname']=$config_search['urlname'];
        $arr['datacol'] = $config_search['datacol'];
        $search = quotemeta(strtolower($search));
        $data = \DB::select($this->MakeSearchString($search).' limit '.$config_search['count']);
        $arr['data'] = $data;
        return json_encode($arr);
    }


    /**
     * @param $search_val what we whant to find
     * @return string  SQL string
     */
    function MakeSearchString($search_val)
    {
        $search_table = config('search_tables');
        $search_str = "";
        $max_count_columns = null;
        foreach ($search_table as $table => $columns) {
            if(count($max_count_columns) <count($columns)){
                $max_count_columns = $columns;
            }
        }

        foreach ($search_table as $table => $columns) {

            $search_str .= '(SELECT ' . $this->MakeColumns($columns,$max_count_columns) . ' FROM '.$table .' WHERE '.$this->MakeWhere($columns,$search_val).')';
            if (end($search_table) != $columns) { /// if last don't add union
                $search_str .= ' union ';
            }
        }
        return $search_str;
    }

    function MakeWhere($columns,$search_val){
        $search_temp = "";
        foreach ($columns as $column) {
            $search_temp .=' '.$column.' LIKE \'%'.$search_val.'%\'';
            if(end($columns)!=$column){
                $search_temp .=' OR ';
            }
        }
        return $search_temp;
    }

    /**
     * @param $columns columns from this table
     * @param $columns_template   template name for clumns for union
     */
    function MakeColumns($columns,$columns_template){
        $temp = "";
        for ($i=0, $count = count($columns_template);$i< $count;++$i) {
            if(isset($columns[$i])){
                $temp.=' LEFT( '.$columns[$i].', 20) as \''.$columns_template[$i].'\' ';
            }else{
                $temp.=' null as \''.$columns_template[$i].'\' ';
            }
            if($i!= $count-1){
             $temp.=' , ';
            }
        }
        return $temp;
    }
}
