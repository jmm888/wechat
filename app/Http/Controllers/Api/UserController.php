<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Curl;
use App\Model\News;
use Illuminate\Support\Facades\Redis;
class UserController extends Controller
{
    //获取新闻
    public function news()
    {
        //最新资讯
        $url = "http://api.avatardata.cn/ActNews/LookUp?key=03f559ae29d6499880f48609091b1143";
        $hotData = Curl::get($url);
        $hotData = json_decode($hotData,1);
        $keyword = [];
        //for 循环取出前两条
        for($i=0;$i<=1;$i++)
        {
            $keyword[] = $hotData['result'][$i];
        }
        //循环查出来的最新新闻
        foreach($keyword as $k=>$v)
        {
            //调用接口查询数据
            $url = 'http://api.avatardata.cn/ActNews/Query?key=03f559ae29d6499880f48609091b1143&keyword='.$v;
            $data = Curl::get($url);
            $newsData = json_decode($data,1);
            //循环入库
            foreach($newsData['result'] as $key=>$val)
            {
                //查询数据库是否有相同的数据
                $result = News::where(['title'=>$val['title']])->first();
                //如果没有就入库
                if(!$result)
                {
                    $result = News::create([
                        'title'=>$val['title'],
                        'content'=>$val['content'],
                        'full_title'=>$val['full_title'],
                        'pdate'=>$val['pdate'],
                        'src'=>$val['src'],
                        'img'=>$val['img'],
                        'pdate_src'=>$val['pdate_src'],
                    ]);
                }
                //存储redis
                $newredis = Redis::set('news',$result);
            }
        }
        return json_encode(['ret'=>1,'msg'=>'查询成功']);
    }
    //读取数据列表
    public function news_show()
    {
        $data = Redis::get('news');
        $newsData = json_decode($data,1);
        return json_encode(['ret'=>1,'msg'=>'查询成功','data'=>$newsData]);
    }
}
