<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//路由返回 试图
// Route::get('/', function () {
//     return view('welcome');
// });

//路由返回字符串r
// Route::get('/', function () {
//        return '1902alaravle';
//  });
//路由返回页面
// Route::get('/user','UserController@index'

// );
//路由返回表单
//  Route::get('/user', function () {
//      return '<form action="useradd" method="post"><input type="text" name=username>'.csrf_field().'<button>提交</button></form>';
//  });
// Route::get('/user', function () {
//     return '<form action="useradd" method=""><input type="text" name=username><input type="hidden" name="_token" value='.csrf_token().'><button>提交</button></form>';
// });
//表单接受
//match接受
//  Route::match(['post'],'/useradd', function () {
//     dd(request()->username);
// });
//any接受
// Route::any('/useradd', function () {
//     dd(request()->username);
// });
//必选参数
// Route::get('user/{id}', function ($id) {
//     return $id;
// });
//可选参数
// Route::get('user/{id?}', function($id=0) {
//     return $id;
// });
//正则约束
// Route::get('user/{id?}', function($id=0) {
//     return $id;
// })->where('id','\d+');
//命名路由
//  Route::get('user/{id?}','UserController@index')->name('uid');
// //调用 前面的路由
// Route::get('aa', function () {
//     // 通过路由名称生成 URL
//     return redirect()->route('uid');
//    });

//引入视图
//  Route::get('/student/add','UserController@add' );
//  Route::any('/student/add_do','UserController@add_do' )->name('do');
//  Route::get('/student/list','UserController@lists' );

//考试
//路由分组
Route::prefix('wz')->middleware('checklogin')->group(function(){
  Route::get('index','admin\WzController@wz_add' );
  Route::post('wz_do','admin\WzController@wz_do' )->name('wz_do');
  Route::get('wz_list','admin\WzController@wz_list' )->name('wz_list');
  Route::get('wz_del/{id}','admin\WzController@wz_del' )->name('wz_del');
  Route::get('wz_upl/{id}','admin\WzController@wz_upl' )->name('wz_upl');
  Route::post('update/{id}','admin\WzController@update' )->name('update');



});



 //路由前缀
 Route::prefix('student')->middleware('checklogin')->group(function () {
    Route::get('add','UserController@add' );
    Route::any('add_do','UserController@add_do' )->name('do');
    Route::get('list','UserController@lists' );
    Route::get('edit/{id}','UserController@edit' );
    Route::post('update/{id}','UserController@update' );
    Route::get('del/{id}','UserController@del' );
    Route::any('checkName','UserController@checkName' );

   });
   Route::get('mail','MailController@index' );
   //路由返回表单
//    Route::get('/login', function () {
//      return '<form action="useradd" method="post"><input type="text" name=username>'.csrf_field().'<button>提交</button></form>';
//  });
//  Route::get('/', function () {
//   session(['user'=>['uid'=>1,'uname'=>'张三']]);

//   return 'hello';

// });

   //联系cookie
   Route::get('cookie/add', function () {
    $minutes = 24 * 60;
    return response('欢迎来到 Laravel 学院')->cookie('name', '学院君', $minutes);
   });
   Route::get('cookie/get', function(\Illuminate\Http\Request $request) {
    $cookie = $request->cookie('name');
    dd($cookie);
   });

 //项目 后台
 Route::get('goods/index','admin\GoodsController@index' );
 //头部
 Route::get('goods/head','admin\GoodsController@head' )->name('head');
 //左边
 Route::get('goods/left','admin\GoodsController@left' )->name('left');
 //
 Route::get('goods/main','admin\GoodsController@main' )->name('main');
 //品牌添加
 Route::get('brand/brand_add','admin\BrandController@brand_add' )->name('brand_add');
 Route::any('brand/brand_do','admin\BrandController@brand_do' )->name('brand_do');
 //品牌验证
 Route::any('brand/brandName','admin\BrandController@brandName' );

 //品牌列表
 Route::any('brand/brand_list','admin\BrandController@brand_list' )->name('brand_list');
 Route::any('brand/brand_update/{id}','admin\BrandController@brand_update' )->name('brand_update');
 Route::any('brand/brand_upd_do/{id}','admin\BrandController@brand_upd_do' )->name('brand_upd_do');
 Route::any('brand/brand_del','admin\BrandController@brand_del' );


 //管理员管理
 Route::get('goods/user_add','admin\GoodsController@user_add' )->name('user_add');
 Route::post('goods/add_do','admin\GoodsController@add_do' )->name('add_do');
 //商品分类
 Route::get('cat/cat_add','admin\CatController@cat_add' )->name('cat_add');
 Route::post('cat/cat_do','admin\CatController@cat_do' )->name('cat_do');
 //商品分来验证
 Route::any('cat/catName','admin\CatController@catName' );


 //商品分类列表
 Route::get('cat/cat_list','admin\CatController@cat_list' )->name('cat_list');
 Route::get('cat/cat_del/{id}','admin\CatController@cat_del')->name('cat_del');
 //商品添加
 Route::get('good/good_add','admin\GoodController@good_add')->name('good_add');
 Route::post('good/good_do','admin\GoodController@good_do')->name('good_do');
 //商品名称验证
 Route::any('good/goodName','admin\GoodController@goodName');
 //商品列表
 Route::get('good/good_list','admin\GoodController@good_list')->name('good_list');


 //前台 模板
 Route::get('/','index\IndexController@index')->name('index');
 Route::get('index/login','index\LoginController@index');
Route::any('index/push','index\LoginController@push');//活动提醒
Route::get('index/reg','index\LoginController@reg')->name('reg');
 Route::any('index/email','index\LoginController@email')->name('email');
 Route::any('index/reg_do','index\LoginController@reg_do')->name('reg_do');
 Route::any('index/login_do','index\LoginController@login_do')->name('login_do');
 //全部商品列表
 Route::any('index/prolist','index\IndexController@prolist')->name('prolist');
 //商品详情页
 Route::any('index/proinfo/{id}','index\IndexController@proinfo')->name('proinfo');
 //加入购物车
 Route::any('index/car','index\CarController@car');
 //无限极分类 列表
 Route::any('index/prolist_one/{id}','index\IndexController@prolist_one');


//登录9.3微信小程序

Route::any('wechat/event','wechat\EventController@event' );//接受微信发送过来的消息

Route::any('wechat/login','wechat\WechatController@wechat_login' );
Route::any('wechat/code','wechat\WechatController@code' );
Route::any('wechat/upload','wechat\UploadController@upload' );
Route::any('wechat/upload_do','wechat\UploadController@upload_do' );

Route::any('wechat/tag_list','Tags\TagController@tag_list' );//公众号标签列表
Route::any('wechat/tag_add','Tags\TagController@tag_add' );
Route::any('wechat/tag_add_do','Tags\TagController@tag_add_do' );
Route::any('wechat/tag_openid_list','Tags\TagController@tag_openid_list' );//标签下用户的openID列表
Route::any('wechat/tag_openid','Tags\TagController@tag_openid' );//为用户打标签
Route::any('wechat/uses_tag_list','Tags\TagController@uses_tag_list' );//用户下的标签列表
Route::any('wechat/push_tag_message','Tags\TagController@push_tag_message' );//推送标签群发消息
Route::any('wechat/do_push_tag_message','Tags\TagController@do_push_tag_message' );//执行推送标签群发消息
Route::any('wechat/push_template_message','wechat\WechatController@push_template_message' );//发送模板消息
Route::any('wechat/clear_api','wechat\WechatController@clear_api' );
Route::any('wechat/get_access_token','wechat\WechatController@get_access_token');
Route::any('wechat/get_user_list','wechat\WechatController@get_user_list');
Route::any('wechat/get_wechat_access_token','wechat\WechatController@get_wechat_access_token');
Route::any('wechat/add_msg/{openid}','wechat\WechatController@add_msg');

//9.16周测
Route::any('zhouce/login','wechat\ZhouceController@wechat_login' );//登录
Route::any('zhouce/code','wechat\ZhouceController@code' );//登录
Route::any('zhouce/user_list','wechat\ZhouceController@user_list' );//留言用户列表
Route::any('zhouce/message','wechat\ZhouceController@message' );//留言用户列表
Route::any('zhouce/message_do','wechat\ZhouceController@messaged_do' );//留言用户列表

//9.17微信二维码
Route::get('wechat/agent_list','wechat\AgentController@agent_list');//用户列表
Route::get('wechat/create_qrcode','wechat\AgentController@create_qrcode');//获取专属二维码
//9.18 自定义菜单
Route::post('wechat/menu_create','wechat\MenuController@menu_create');//创建菜单
Route::get('wechat/menu_list','wechat\MenuController@menu_list');//菜单列表
Route::get('wechat/load_menu','wechat\MenuController@load_menu');//根据数据库表数据 刷新菜单
Route::get('wechat/menu_del','wechat\MenuController@menu_del');//删除菜单

//9.19JSSDK使用步骤
Route::get('wechat/location','wechat\WechatController@location');
//9.23练习题 授权登录 标签管理
Route::get('wechat/cront_login','wechat\CrontController@cront_login_do');//登录
Route::get('wechat/cront_code','wechat\CrontController@cront_code');//获取code
Route::get('wechat/cron_list','wechat\CrontController@cron_list');//标签管理列表
Route::get('wechat/user_list','wechat\CrontController@user_list');//粉丝列表
Route::get('wechat/cront_add','wechat\CrontController@cront_add');//添加标签
Route::post('wechat/add_do','wechat\CrontController@add_do');//添加标签执行页面
Route::any('wechat/cron_openid','wechat\CrontController@cron_openid');//批量为用户打标签
Route::any('wechat/quefa','wechat\CrontController@quefa');//通过标签群发消息
Route::any('wechat/quefa_do','wechat\CrontController@quefa_do');//通过标签群发消息
 //学生表8.21 练习
 Route::get('stud/add','stud\StudController@add');
 Route::any('stud/add_do','stud\StudController@add_do')->name('add_do');
 Route::any('stud/list','stud\StudController@list')->name('list');
 Route::any('stud/upl/{id}','stud\StudController@upl');
 Route::any('stud/upl_do/{id}','stud\StudController@upl_do');
 Route::any('stud/del/{id}','stud\StudController@del');
 //新闻标题8.26练习
 Route::get('title/add','title\TitleController@add');
 Route::post('title/add_do','title\TitleController@add_do')->name('add_do');
 Route::get('title/list','title\TitleController@list');
 Route::get('title/list_num','title\TitleController@list_num');

 Route::get('title/content/{id}','title\TitleController@content');
 Route::get('title/login','title\TitleController@login');
 Route::post('title/login_do','title\TitleController@login_do')->name('login_do');
//竞猜8.27练习

Route::prefix('team')->group(function () {
 Route::get('team_add','team\TeamController@team_add');
 Route::post('team_do','team\TeamController@team_do')->name('team_do');
 Route::get('team_list','team\TeamController@team_list');
 Route::get('team_comp/{id}','team\TeamController@team_comp')->name('team_comp');
 Route::get('ending/{id}','team\TeamController@ending')->name('ending');
 Route::post('comp_do/{id}','team\TeamController@comp_do');
 Route::get('jieguo/{id}','team\TeamController@jieguo');

});

//8.29考试货物管理
Route::prefix('cargo')->group(function () {
 Route::get('login','cargo\CargoController@login');
 Route::any('login_do','cargo\CargoController@login_do');

 Route::get('cargo_add','cargo\CargoController@cargo_add');
 Route::post('cargo_do','cargo\CargoController@cargo_do');
 Route::any('cargo_list','cargo\CargoController@cargo_list');
 Route::any('chu/{id}','cargo\CargoController@chu');
 Route::any('chu_do/{id}','cargo\CargoController@chu_do');
 Route::any('rizhi/{id}','cargo\CargoController@rizhi');
 Route::any('jilu/{id}','cargo\CargoController@jilu');
});

Route::any('wechat/get_access_token','wechat\WechatController@get_access_token');
Route::any('wechat/get_user_list','wechat\WechatController@get_user_list');
Route::any('wechat/get_wechat_access_token','wechat\WechatController@get_wechat_access_token');
Route::any('wechat/add_msg/{openid}','wechat\WechatController@add_msg');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/*
 * 第九月 接口
 * */
Route::get('admin/login','admins\LoginController@login');//登录
Route::any('admin/login_do','admins\LoginController@login_do');//登录
Route::any('admin/bang','admins\LoginController@bang');//登录绑定账号
Route::any('admin/bang_do','admins\LoginController@bang_do');//登录绑定账号
Route::any('admin/wechat','admins\LoginController@wechat');//扫码登录
Route::any('admin/mobileScan','admins\LoginController@mobileScan');
Route::any('admin/send','admins\LoginController@send');//登录点击按钮发送模板消息
Route::any('admin/checkwechatlogin','admins\LoginController@checkwechatlogin');
Route::any('admin/index','admins\IndexController@index');//后台首页
//10.15后台项目
Route::any('admin/category_add','admins\IndexController@category_add');//后台分类添加
Route::any('admin/cate_do','admins\IndexController@cate_do');//后台分类添加执行
Route::any('admin/Only','admins\IndexController@Only');//后台分类添加唯一性验证

Route::any('admin/category_list','admins\IndexController@category_list');//后台分类列表
Route::any('admin/type_add','admins\IndexController@type_add');//后台类型添加
Route::any('admin/type_do','admins\IndexController@type_do');//后台类型添加
Route::any('admin/type_list','admins\IndexController@type_list');//后台类型列表
Route::any('admin/attribute_add','admins\IndexController@attribute_add');//后台属性模块添加
Route::any('admin/attr_do','admins\IndexController@attr_do');//后台属性模块添加执行
Route::any('admin/del','admins\IndexController@del');//后台属性模块批量删除
Route::any('admin/attribute_list','admins\IndexController@attribute_list');//后台属性模块添加执行
Route::any('admin/attrData','admins\IndexController@attrData');//后台根据类型id获取属性

Route::any('admin/comm_add','admins\IndexController@comm_add');//后台商品添加
Route::any('admin/add','admins\IndexController@add');//后台商品添加执行页面
Route::any('admin/comm_list','admins\IndexController@comm_list');//后台商品列表
Route::any('admin/clickhere','admins\IndexController@clickhere');//后台商品列表商品名即点击该

Route::any('admin/goods','admins\IndexController@goods');//后台货品添加
Route::any('admin/product_do','admins\IndexController@product_do');//后台货品添加执行页面



//10.10接口
//返回试图
Route::get('/test/add', function () {
    return view('test/add');
});//添加页面
Route::get('/test/show', function () {
    return view('test/show');
});//展示页面
Route::get('/test/update', function () {
    return view('test/update');
});//修改页面
Route::any('/api/test/add','Api\TesterController@add');//接口添加
Route::any('/api/test/show','Api\TesterController@show');//展示
Route::any('/api/test/find','Api\TesterController@find');//修改获取值
Route::any('/api/test/upl','Api\TesterController@upl');//修改执行
Route::any('/api/test/del','Api\TesterController@del');//修改执行
Route::any('/api/test/send','Api\TesterController@send');//修改执行

Route::any('/api/test/weather','Api\TesterController@weather');//10.14测试天气接口


//10.11
Route::resource('/api/usr','PostController');
//10.14测试
Route::resource('/api/test','test\TestController');
Route::get('/good/add', function () {
    return view('good/add');
});//添加
Route::get('/good/index', function () {
    return view('good/index');
});//展示

Route::get('/day/weather', function () {
    return view('good/weather');
});
//10.21前台项目
Route::prefix('api')->middleware('apiheader')->group(function () {
    Route::any('index/login','admins\UserController@login');//前台登录
    Route::any('index/getUser','admins\UserController@getUser');//前台登录验证token
    Route::get('index/news','admins\AdminController@news');//新品展示
    Route::get('index/detail','admins\AdminController@detail');//商品详情
    Route::any('index/listing','admins\AdminController@listing');//商品列表
    Route::any('index/cate','admins\AdminController@cate');//商品分类查询
    //验证token中间件
    Route::middleware('apitoken')->group(function(){
        Route::any('index/shopping','admins\AdminController@shopping');//商品前台加入购物车
        Route::any('index/cart_list','admins\AdminController@cart_list');//商品前台购物车列表
    });
});
    //sign加密  10.25
    Route::any('api/sign','admins\AdminController@sign');//前台登录
   //10.26数据处理测试练习
    Route::any('api/class_show','admins\UserController@class_show');
    Route::any('api/stu_show','admins\UserController@stu_show');
    Route::any('api/aes','admins\UserController@aes');//10.28练习对称加密
    Route::any('api/rsa','admins\UserController@rsa');//10.28练习对称加密
//10.29测试
    Route::any('api/news','admins\TestController@news');//10.29获取时事新闻
    Route::get('/api/regist', function () {
        return view('login/register');
    });//注册
    Route::get('/api/login', function () {
    return view('login/logins');
    });//登录
    Route::get('/api/new_show', function () {
        return view('login/new_show');
    });//列表
    Route::any('api/register','admins\TestController@register');//10.29注册执行页面
    Route::any('api/login_do','admins\TestController@login_do');//10.29登录页面
    Route::any('show','admins\TestController@show');//10.29列表页面

