<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Hyperf\Context\ApplicationContext;
use Hyperf\HttpServer\Router\Router;



Router::addGroup('/api/hrsystem',function (){

    Router::addGroup('/user/',function (){
        Router::post('login','App\Controller\UserController@login');
        Router::post('logout','App\Controller\UserController@logout');
        Router::post('user','App\Controller\UserController@user');
        Router::post('feishusignature','App\Controller\FeiShuController@signature');
        Router::post('ssoLogin','App\Controller\FeiShuController@ssoLogin');
        Router::post('syncAllUserAndDepartment','App\Controller\FeiShuController@syncAllUserAndDepartment');
        Router::post('getDepartmentAndUser','App\Controller\UserController@getDepartmentAndUser');
        Router::post('index','App\Controller\UserController@index');
        Router::post('getList','App\Controller\UserController@getList');
    });
    Router::addGroup('/talent/',function (){
        Router::post('create','App\Controller\TalentController@create');
        Router::post('update','App\Controller\TalentController@update');
        Router::post('delete','App\Controller\TalentController@delete');
        Router::post('view','App\Controller\TalentController@view');
        Router::post('index','App\Controller\TalentController@index');
        Router::post('curriculumRecognize','App\Controller\TalentController@curriculumRecognize'); //简历识别
        Router::post('getList','App\Controller\TalentController@getList');
        Router::post('uploadFile','App\Controller\TalentController@uploadFile'); //简历上传
        Router::post('evaluate','App\Controller\TalentController@evaluate');   //人才评价
        Router::post('addJob','App\Controller\TalentController@addJob');   //添加职位
        Router::post('removeJob','App\Controller\TalentController@removeJob');   //去除职位
        Router::post('changeJob','App\Controller\TalentController@changeJob');   //转移职位
        Router::post('getJob','App\Controller\TalentController@getJob');   //获得加入职位信息
        Router::post('updateJobRelation','App\Controller\TalentController@updateJobRelation');   //更新信息
        Router::post('setEvaluator','App\Controller\TalentController@setEvaluator');   //评价
        Router::post('removeEvaluator','App\Controller\TalentController@removeEvaluator');   //评价
        Router::post('stopDeliver','App\Controller\TalentController@stopDeliver');   //终止投递
        Router::post('recoverDeliver','App\Controller\TalentController@recoverDeliver');   //恢复投递
        Router::post('agg','App\Controller\TalentController@agg');   //候选人聚合数据
        Router::post('addWriteFile','App\Controller\TalentController@addWriteFile');   //新增笔试题
        Router::post('removeWriteFile','App\Controller\TalentController@removeWriteFile');   //移除笔试题
        Router::post('addResume','App\Controller\TalentController@addResume');   //新增简历
        Router::post('removeResume','App\Controller\TalentController@removeResume');   //移除简历
        Router::post('shareTalent','App\Controller\TalentController@shareTalent');   //分享候选人

    });
    Router::addGroup('/remark/',function (){    //人才备注
        Router::post('create','App\Controller\RemarkController@create');
        Router::post('update','App\Controller\RemarkController@update');
        Router::post('delete','App\Controller\RemarkController@delete');
        Router::post('getList','App\Controller\RemarkController@getList');
    });
    Router::addGroup('/job/',function (){
        Router::post('create','App\Controller\JobController@create');
        Router::post('update','App\Controller\JobController@update');
        Router::post('delete','App\Controller\JobController@delete');
        Router::post('view','App\Controller\JobController@view');
        Router::post('index','App\Controller\JobController@index');
        Router::post('getList','App\Controller\JobController@getList');

    });

    //offer管理
    Router::addGroup('/offer/',function (){
        Router::post('create','App\Controller\OfferController@create');
        Router::post('update','App\Controller\OfferController@update');
        Router::post('delete','App\Controller\OfferController@delete');
        Router::post('view','App\Controller\OfferController@view');
        Router::post('approve','App\Controller\OfferController@approve');//审核
        Router::post('sendApprove','App\Controller\OfferController@sendApprove');//发送审核通知
        Router::post('cancelApprove','App\Controller\OfferController@cancelApprove');//取消审核
        Router::post('sendOffer','App\Controller\OfferController@sendOffer');//发送offer
        Router::post('template','App\Controller\OfferController@template');
    });

    Router::addGroup('/hire/',function (){
        Router::post('index','App\Controller\HireController@index');
        Router::post('create','App\Controller\HireController@create');
        Router::post('update','App\Controller\HireController@update');
        Router::post('delete','App\Controller\HireController@delete');
        Router::post('view','App\Controller\HireController@view');
        Router::post('confirm','App\Controller\HireController@confirm');
        Router::post('indexAgg','App\Controller\HireController@indexAgg');

    });


    //面试管理
    Router::addGroup('/interview/',function (){
        Router::post('create','App\Controller\InterViewController@create');
        Router::post('update','App\Controller\InterViewController@update');
        Router::post('delete','App\Controller\InterViewController@delete');
        Router::post('view','App\Controller\InterViewController@view');
        Router::post('index','App\Controller\InterViewController@index');
        Router::post('cancel','App\Controller\InterViewController@cancel');
        Router::post('notification','App\Controller\InterViewController@notification');
        Router::post('download','App\Controller\InterViewController@download');
        Router::addGroup('assessment/',function (){    //面试结果
            Router::post('create','App\Controller\InterViewResultController@create');
            Router::post('update','App\Controller\InterViewResultController@update');
            Router::post('delete','App\Controller\InterViewResultController@delete');
        });




    });
    Router::addGroup('/feishu/',function (){
        Router::post('callback','App\Controller\FeiShuController@callback');
    });

    Router::addGroup('/open/',function (){
        Router::post('registration','App\Controller\Open\OpenController@registration');
        Router::post('registrationStatus','App\Controller\Open\OpenController@registrationStatus');
        Router::post('uploadFile','App\Controller\Open\OpenController@uploadFile'); //简历上传
        Router::post('dictionary','App\Controller\Open\OpenController@getDictionaryByType'); //字典
        Router::post('offer','App\Controller\Open\OpenController@getOffer'); //查看offer
        Router::post('approveOffer','App\Controller\Open\OpenController@approveOffer'); //同意offer

    });



    Router::post('/dictionary','App\Controller\DictionaryController@getDictionaryByType');
    Router::post('/company','App\Controller\DictionaryController@getCompanyInfo');
    Router::post('/menu','App\Controller\UserController@menu');
    Router::post('/actions','App\Controller\ActionRecordController@index');
    Router::post('/notificationTemplate','App\Controller\NotificationController@notificationTemplate');



//    Router::post('delete','App\Controller\UserController@delete');
});


Router::addRoute(['GET'], '/health', function () {
    return 'ok';
});
Router::addRoute(['GET'], '/api/hrsystem/health', function () {
    return 'ojbk44eee44';
});

Router::addRoute(['GET'], '/metrics', function () {
    $client = ApplicationContext::getContainer()->get(\Hyperf\Guzzle\ClientFactory::class)->create();
    $response = $client->request('GET', 'http://127.0.0.1:9502/metrics' , [
        'timeout' => 5,
        'headers' => [
            'Accept' => 'application/json',
        ],
    ]);

    return $response->getBody()->getContents();
//    $registry = Hyperf\Context\ApplicationContext::getContainer()->get(Prometheus\CollectorRegistry::class);
//    $renderer = new Prometheus\RenderTextFormat();
//    return $renderer->render($registry->getMetricFamilySamples());
});

Router::addRoute(['POST'], '/test', 'App\Controller\IndexController@test');


Router::get('/favicon.ico', function () {
    return '';
});
