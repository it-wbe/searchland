<?php

namespace Wbe\Searchland\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Wbe\Searchland\Classes\SearchHelper;

class SearchController extends Controller
{
    public function index()
    {
        return 'asdasd';
//        return view('');
    }

    public function result($search)
    {

        $aa = new SearchHelper();
        $sql = $aa->generateSQL(quotemeta(strtolower($search)));
        $config_search = config('search');
        $arr['urlname']=$config_search['urlname'];
        $arr['datacol'] = $config_search['datacol'];
        $data = \DB::select($sql.' limit '.$config_search['count']);
        $arr['data'] = $data;
        return json_encode($arr);
    }
}
