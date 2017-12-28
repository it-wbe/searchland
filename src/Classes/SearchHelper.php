<?php
/**
 * Created by PhpStorm.
 * User: bnC-seRVIS
 * Date: 28.12.2017
 * Time: 12:42
 */
namespace Wbe\Searchland\Classes;

class SearchHelper
{
    /**
     * @param $table array config table
     * @return bool or join
     */
    function getJoin($table){
        if(isset($table['join']))
            return $table['join'];
        return false;
    }
    /**
     * GenerateSQL for all tables
     *
     */
   public function generateSQL($search_val){
        $search_table = config('search_tables');
        //dd($search_table);
        $search_str = "";
        $max_count_columns = null;
        foreach ($search_table as $table ) {
                if (count($max_count_columns) < count($table['columns'])) {
                    $max_count_columns = $table['columns'];
            }
        }
        $numItems = count($search_table);
        $i = 0;
        foreach ($search_table as $table_name =>$table) {
            $search_str .= '(SELECT ' . $this->generColumn($table,$max_count_columns) . ' FROM '.$table_name;
                // add join if needed
            if(isset($table['join'])){
                $search_str.=$this->generateJoin($table);
            }
                $search_str .=' WHERE '.$this->generWhere($table,$search_val).')';
            if (++$i != $numItems) { /// if last don't add union
                $search_str .= ' union ';
            }
        }
        return $search_str;
    }

    /**
     * Generate sql string for columns
     * @return string
     */
    function generColumn($table,$columns_template){
        $temp = "";
        $temp_max_chars = 0;
        for ($i=0, $count = count($columns_template);$i< $count;++$i) {
            if(isset($table['columns'][$i])){
                    if($table['columns'][$i]!=$table['link']['column'])
                    { // some data column
                        $temp.=' LEFT( '.$table['columns'][$i].', '.config('search.max_char_result').' ) as \''.$columns_template[$i].'\' ';
                    }
                    else{ // if column is link and need to concate some
                        if(isset($table['link']['url_add'])){
                            $temp.=' CONCAT("'.$table['link']['url_add'].'",'.$table['columns'][$i].') as \''.$columns_template[$i].'\' ';
                        }else{
                            $temp.=' '.$table['columns'][$i].' as \''.$columns_template[$i].'\' ';
                        }
                    }
            }else{
                $temp.=' null as \''.$columns_template[$i].'\' ';
            }
            if($i!= $count-1){
                $temp.=' , ';
            }
        }
        return $temp;
    }


    /**
     * Generate Where from columns
     * @return string
     */
    function generWhere($table,$search_val){
        $search_temp = "";
        for($i=0,$a=count($table['columns']);$i<$a;$i++) {
            if($table['columns'][$i]!=$table['link']['column']) {
                $search_temp .= ' ' . $table['columns'][$i]. ' LIKE \'%' . $search_val . '%\'';
                $t = $i;
                $t++;
                if (end($table['columns']) != $table['columns'][$i] && $table['columns'][$t] !=  $table['link']['column']) {
                        $search_temp .= ' OR ';
                }
            }
        }
        return $search_temp;
    }

    /**
     * Generate Left Join
     *
     * @return string
     */
    function generateJoin($table){
//        dd($table['join']);
        return " join ".key($table['join'])." on ".$table['join'][key($table['join'])][0]." = ".$table['join'][key($table['join'])][1];
    }

}