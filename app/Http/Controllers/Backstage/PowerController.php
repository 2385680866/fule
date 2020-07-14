<?php

namespace App\Http\Controllers\Backstage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PowerModel;
class PowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $powerData = PowerModel::get()->toArray();
        $powerData = $this->createTree($powerData);
        return view("backstage.power.index",['powerData'=>$powerData]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->isMethod('post')){
            $postData = $request->except("_token");
            $res = PowerModel::create($postData);
            if($res){
                return redirect("backstage/power/index");
            }else{
                return redirect("backstage/power/index");
            }
        }
        $powerData = PowerModel::get()->toArray();
        $powerData = $this->createTree($powerData);
        return view("backstage.power.create",['powerData'=>$powerData]);
    }
    public function createTree($data,$parent_id=0,$level=0)
	{
		//定义一个容器
		static $new_arr = [];
		//循环比对
		foreach ($data as $key => $value) {
			//判断 
			if($value['parent_id'] == $parent_id){
				//找到了
				$value['level'] = $level;
				$new_arr[] = $value;
				//找子分类 
				$this->createTree($data,$value['power_id'],$level+1);
			}
		}
		return $new_arr;
	}
    public function createTreeBySon($data,$parent_id=0)
	{	
		//定义一个容器
		$new_arr = [];
		//循环比对
		foreach ($data as $key => $value) {
			//判断 
			if($value['parent_id'] == $parent_id){
				//找到了
				$new_arr[$key] = $value;
				//找子分类 
				$new_arr[$key]['son'] = $this->createTreeBySon($data,$value['power_id']);
			}
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        if($request->isMethod('post')){
            $postData = $request->except("_token");
            $res = PowerModel::where(['power_id'=>$id])->update($postData);
            if($res){
                return redirect("backstage/power/index");
            }else{
                return redirect("backstage/power/index");
            }
        }
        $data = PowerModel::where(['power_id'=>$id])->first();
        $powerData = PowerModel::get()->toArray();
        $powerData = $this->createTree($powerData);
        return view("backstage.power.edit",[
            'powerData'=>$powerData,
            'data'=>$data
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = PowerModel::destroy($id);
        if($res){
            return redirect("backstage/power/index");
        }else{
            return redirect("backstage/power/index");
        }
    }
    public function powerName(Request $request)
    {
        $power_name = $request->power_name;
        $power_id = $request->power_id;
        if(empty($power_id)){
            $where = [
                'power_name','=',$power_name
            ];
        }else{
            $where = [
                ['power_name','=',$power_name],
                ['power_id','<>',$power_id]
            ];
        }
        $count = PowerModel::where(['power_name'=>$power_name])->count();
        if($count>=1){
            echo 1;
        }else{
            echo 0;
        }
       

    }
}
