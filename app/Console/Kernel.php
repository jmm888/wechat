<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
use App\Tools\Tools;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function(){
            DB::table('regist')->insert(['useremail'=>'fghj@qq.com','userpwd'=>'123']);
        })->cron('* * * * *');

        $schedule->call(function(){
            $tools = new Tools;
            $user_url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$tools->get_wechat_access_token().'&next_openid=';
            $user_info = file_get_contents($user_url);
            $result = json_decode($user_info,1);
            foreach ($result['data']['openid'] as $v){
                //openid拿到用户基本信息
                $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$tools->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN';
                $re = file_get_contents($url);
                $user_info = json_decode($re,1);
                //存入数据库
                $db_user = DB::table('wechat_openid')->where(['openid'=>$v])->first();
                if(empty($db_user)){
                    //没有数据，存入数据库
                    DB::table('wechat_openid')->insert([
                        'openid'=>$v,
                        'add_time'=>time(),
                    ]);
                    //就是未签到
                    $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$tools->get_wechat_access_token();
                    $data =[
                        'touser'=>$v,
                        'template_id'=>'z1mPoREmWYofw8eskCyG2aMmpSl__6fD1ZFj3Cpe4Lw',
                        'data'=>[
                            'keyword1'=>[
                                'value'=>$user_info['nickname'],
                                'color'=>'',
                            ],
                            'keyword2'=>[
                                'value'=>'未签到',
                                'color'=>'',
                            ],
                            'keyword3'=>[
                                'value'=>'0',
                                'color'=>'',
                            ],
                            'keyword4'=>[
                                'value'=>'',
                                'color'=>'',
                            ],
                        ]
                    ];
                    $tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
                }else{
                    //判断是否签到
                    $today =date('Y-m-d',time());
                    if($db_user->sign_day == $today){
                        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$tools->get_wechat_access_token();
                        $data =[
                            'touser'=>$v,
                            'template_id'=>'z1mPoREmWYofw8eskCyG2aMmpSl__6fD1ZFj3Cpe4Lw',
                            'data'=>[
                                'keyword1'=>[
                                    'value'=>$user_info['nickname'],
                                    'color'=>'',
                                ],
                                'keyword2'=>[
                                    'value'=>'已签到',
                                    'color'=>'',
                                ],
                                'keyword3'=>[
                                    'value'=>$db_user->score,
                                    'color'=>'',
                                ],
                                'keyword4'=>[
                                    'value'=>$today,
                                    'color'=>'',
                                ],
                            ]
                        ];
                        $tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
                    }else{
                        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$tools->get_wechat_access_token();
                        $data =[
                            'touser'=>$v,
                            'template_id'=>'z1mPoREmWYofw8eskCyG2aMmpSl__6fD1ZFj3Cpe4Lw',
                            'data'=>[
                                'keyword1'=>[
                                    'value'=>$user_info['nickname'],
                                    'color'=>'',
                                ],
                                'keyword2'=>[
                                    'value'=>'已签到',
                                    'color'=>'',
                                ],
                                'keyword3'=>[
                                    'value'=>$db_user->score,
                                    'color'=>'',
                                ],
                                'keyword4'=>[
                                    'value'=>$today,
                                    'color'=>'',
                                ],
                            ]
                        ];
                        $tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
                    }
                }
            }
        })->dailyAt('16:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
