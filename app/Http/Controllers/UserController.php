<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests\StoreBlogPost;
use Validator;
use Cookie;
use App\admin\StudentModel;
class UserController extends Controller
{
//     public function index($id=0){
//     dump('laravle欢迎你'.$id);
// }

    public function add()
    {

        $value = Cookie::get('name');
        //联系session
         //$user = ['uid'=>1,'name'=>'jmm'];
        //存session
        //session(['user'=>$user]);
       //request()->session()->put('user',$user);
       //request()->session()->save();
        //取session
        // $user = session('user');
        //$user = request()->session()->get('user',$user);
        //删除
        //session(['user'=>null]);
        //$user = session('user');

        // request()->session()->pull('user');
        // request()->session()->forget('user');
       // request()->session()->flush();
        //$user = request()->session()->get('user');
        //dd($user);
        return view('add');
    }
   // public function add_do(StoreBlogPost $Request)
    public function add_do(Request $Request)
    {
       // $post = $Request->post();
        // $post = Request()->post();
        //$post = Request()->all();
        //查询一条
        //$post = $Request->only('name');
        //去除一条
        $post = $Request->except(['_token']);
        //第一种验证
        //  $Request->validate([
        //     'name' => 'required|unique:student|max:50',
        //     'age' => 'required|numeric',
        // ],[
        //     'name.required'=>'姓名不能为空',
        //     'name.unique'=>'格式错误',
        //     'age.required'=>'年龄不能为空'
        // ]);
        //第三种验证
        $validator = Validator::make($post, [
            'name' => 'required|unique:student|max:50',
            'age' => 'required|numeric',
        ],[
            'name.required'=>'姓名不能为空',
             'name.unique'=>'格式错误',
             'age.required'=>'年龄不能为空'
        ]);
            if ($validator->fails()) {
            return redirect('student/add')
            ->withErrors($validator)
           ->withInput();
            }
            //调用文件上传方法
            // dd(request()->hasFile('headimg'));
           if(request()->hasFile('headimg'))
           {
            $post['headimg'] = upload('headimg');
           }
        $res = DB::table('student')->insert($post);
        if($res)
        {
            return redirect('student/list');
        }
    }
   //列表页
    public function lists()
    {
        $query = Request()->input();
        $name = $query['name']??'';
        $age = $query['age']??'';
        $where = [];
        if($name)
        {
            $where[] = ['name','like',$name.'%'];
        }
        if($age)
        {
            $where[] = ['age','=',$age];
        }
        $pagesize = config('app.pagesize');
        $data = DB::table('student')->where($where)->paginate($pagesize);
        // dd($data);
       return view('lists',compact(['data','name','age']));
    }
    public function edit($id)
    {
        $data = StudentModel::find($id);
        //dd($data);
       return view('edit',['data'=>$data]);
    }
    public function update($id)
    {
        $data = request()->except(['_token']);
        // dd($data);
        //判断有否文件上传
        if(request()->hasFile('headimg'))
           {
            //调用文件上传方法
            $data['headimg'] = $this->upload('headimg');
            //获取修改之前的图片
            $filename = storage_path('app/public').'/'.$data['oldimg'];
            //判断旧的文件是否存在 
            if(file_exists($filename)){
            //如存在 删除旧的图片
            unlink($filename);}
           }
           //删除隐藏域传过来的字段
           unset($data['oldimg']);
           //执行修改
        $res = StudentModel::where('stu_id',$id)->update($data);
       if($res)
       {
           return redirect('student/list');
       }
    }
    //删除
    public function del($id)
    {
        $stu=StudentModel::destroy($id);
        dd($stu);
    }
    //唯一性验证
    public function checkName()
    {
        $name = Request()->name;
        //dd($name);
        $count = StudentModel::where('name','=',$name)->count();
        return $count;
        
    }
}
