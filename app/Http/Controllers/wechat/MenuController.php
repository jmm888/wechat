<?php

namespace App\Http\Controllers\wechat;

use App\Tools\Tools;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class MenuController extends Controller
{
    public $tools;
    public $client;
    public function __construct(Tools $tools,Client $client)
    {
        $this->tools = $tools;
        $this->client = $client;
    }
    //删除菜单
    public function menu_del(Request $request)
    {
        $id = $request->id;
        $res = DB::table('menu')->delete($id);
        $this->load_menu();
    }
    //菜单列表
    public function menu_list()
    {
        $info = DB::table('menu')->get();
        //dd($info);
        return view('menu.menulist',['info'=>$info]);
    }
    //创建菜单 添加执行页面
    public function menu_create(Request $request)
    {
        $req= $request->all();
        $button_type = !empty($req['name2'])?2:1;
        $result = DB::table('menu')->insert([
            'name1'=>$req['name1'],
            'name2'=>$req['name2'],
            'type'=>$req['type'],
            'button_type'=>$button_type,
            'event_value'=>$req['event_value']
        ]);
        if(!$result){
            dd('插入失败');
        //根据表数据翻译成菜单结构
            $this->load_menu();
        }
    }
    /**
     *根据数据库表数据 刷新菜单
     */
    public function load_menu()
    {
        $data = [];
        $event_arr = [1=>'click',2=>'view'];
        $menu_list = DB::table('menu')->select(['name1'])->groupBy('name1')->get();
        foreach($menu_list as $vv){
            $menu_info = DB::table('menu')->where(['name1'=>$vv->name1])->get();
            $menu = [];
            foreach($menu_info as $v){
                $menu[] = (array)$v;
            }
            $arr= [];
            foreach($menu as $v){
                if($v['button_type']==1)//普通一级菜单
                {
                    if($v['type']==1){//click
                        $arr = [
                            'type'=>'click',
                            'name'=>$v['name1'],
                            'key'=>$v['event_value'],
                        ];
                    }elseif($v['type']==2){//view
                        $arr = [
                            'type'=>'view',
                            'name'=>$v['name1'],
                            'url'=>$v['event_value'],
                        ];
                    }
                }elseif($v['button_type']==2){//带有二级菜单的一级菜单
                    $arr['name'] = $v['name1'];
                    if($v['type']==1){//click
                        $button_arr = [
                            'type'=>'click',
                            'name'=>$v['name2'],
                            'key'=>$v['event_value'],
                        ];
                    }elseif($v['type']==2){//view
                        $button_arr = [
                            'type'=>'view',
                            'name'=>$v['name2'],
                            'url'=>$v['event_value'],
                        ];
                    }
                $arr['sub_button'][]=$button_arr;
                }
        }
            $data['button'][]= $arr;
    }
    // dd($data);
////        dd();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->tools->get_wechat_access_token();
        /*$data = [
            'button' => [
                [
                    'type' => 'click',
                    'name' => '今日歌曲',
                    'key' => 'V1001_TODAY_MUSIC'
                ],
                [
                    'name' => 'jmm菜单',
                    'sub_button' => [
                        [
                            'type' => 'view',
                            'name' => '搜索',
                            'url'  => 'http://www.soso.com/'
                        ],
                        [
                            'type' => 'miniprogram',
                            'name' => 'wxa',
                            'url' => 'http://mp.weixin.qq.com',
                            'appid' => 'wx286b93c14bbf93aa',
                            'pagepath' => 'pages/lunar/index'
                        ],
                        [
                            'type' => 'click',
                            'name' => '赞一下我们',
                            'key'  => 'V1001_GOOD'
                        ]
                    ]
                ]
            ]
        ];
        */
        //dd($data);
        $re = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        //dd($re);
        $result = json_decode($re,1);
        dd($result);
    }
}
