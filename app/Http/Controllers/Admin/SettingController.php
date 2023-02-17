<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;

class SettingController extends Controller
{
    public function publish(Request $request){
        if($request->table AND $request->type AND $request->id){
            $update = \DB::table($request->table)
            ->where('id', $request->id);

            if($update->update([$request->type => ($request->value)?$request->value:0])){

                $d = \DB::table($request->table)->where('id', $request->id)->first();
                $action = ($request->value)?"TRUE":"FALSE";
                $action = ucfirst($request->type).' - '.$action;
                $item = 'unKnown';
                if($d){
                    $item = isset($d->title)?$d->title:$d->name;
                }
                // Log
                logThis(['type'=>ucfirst($request->table), 'action'=>$action, 'item'=>$item]);
            }
        }
    }

    public function export(Request $request)
    {
        if($request->table){
            $table = $request->table;
            $columns = \Schema::getColumnListing($table);
            $data = "";

            foreach($columns as $k => $v){
                $data .= $v.',';
            }
            
            if($table == 'items'){
                foreach(Warehouse::all() as $w){
                    $data .=$w->name.',';
                }
                $data .='Total Stocks,';
            }

            $data .= "\n";

            
            $data_table = \DB::table($request->table)->where([
                ['id', '!=', Null],
                [function($query) use ($request, $columns){
                    foreach($request->all() as $k => $v){
                        if(in_array($k, $columns)){
                            if(!is_null($v))
                                $query->where($k, 'LIKE', '%'.$v.'%');
                        }
                    }
                
                }]
            ]);
            
            $data_table = $data_table->get()->toArray();

            foreach($data_table as $a){
                $a = (array) $a;
                
                foreach($columns as $k => $v){
                    $clm = isset($a[$v])?$a[$v]:'';
                    // if($clm != ''){
                        $data .= '"'.$clm.'",';
                    // }
                }

                if($table == 'items'){
                    foreach(Warehouse::all() as $w){
                        $data .= getStock($a['id'], $w->id).',';
                    }
                    $data .= getStock($a['id']).',';
                }
                $data .= "\n";
                
            }

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename='.date('Y-m-d').'-'.strtoupper($table).'.csv');
            
            echo $data;
        }

    }

    public function select_type(Request $request){
        $result = '';
        if($request->type){
            if($request->type == 'article_category'){
                $result = ArticleCategory::all();
            }
            else if($request->type == 'article'){
                $result = Article::all();

            }
            else if($request->type == 'disclosure_category'){
                $result = DisclosureCategory::all();

            }
            else if($request->type == 'disclosure_file'){
                $result = DisclosureFile::all();
            }
        }

        return response($result);
    }

}
