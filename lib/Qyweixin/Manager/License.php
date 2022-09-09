<?php

namespace Qyweixin\Manager;

use Qyweixin\Client;

/**
 * 接口调用许可
 * https://developer.work.weixin.qq.com/document/path/95652
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class License
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/license/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取应用的接口许可状态
最后更新：2022/08/04
服务商可获取某个授权企业的应用接口许可试用期，免费试用期为企业首次安装应用后的90天。

请求方式： POST（HTTPS）
请求地址： https://qyapi.weixin.qq.com/cgi-bin/license/get_app_license_info?provider_access_token=ACCESS_TOKEN

请求包体：

{
	"corpid" : "xxxx",
	"suite_id": "xxxx",
	"appid": 1
}
参数说明：

参数	是否必须	说明
provider_access_token	是	调用接口凭证
corpid	是	企业id
suite_id	是	套件id
appid	否	旧的多应用套件中的应用id，新开发者请忽略
权限说明： 
企业必须已安装了该第三方应用才允许调用

返回结果：

{
	"errcode":0,
	"errmsg":"ok",
	"license_status":1
	"trail_info":
	{
		"start_time": 1651752000,
		"end_time": 1659700800
	}
}
参数说明：

参数	说明
errcode	错误码
errmsg	错误码说明
license_status	license检查开启状态。
0：未开启license检查状态（未迁移的历史授权应用一般是这种状态） 
1：已开启license检查状态。若开启且已过试用期，则需要为企业购买license帐号才可以使用
trail_info	应用license试用期信息。仅当license_status为1且应用有试用期时返回该字段。服务商测试企业、历史迁移应用无试用期。
trail_info.start_time	接口许可试用开始时间
trail_info.end_time	接口许可试用到期时间。若企业多次安装卸载同一个第三方应用，以第一次安装的时间为试用期开始时间，第一次安装完90天后为结束试用时间
     */
    public function getAppLicenseInfo($provider_access_token, $corpid, $suite_id, $appid = 0)
    {
        $params = array();
        $params['corpid'] = $corpid;
        $params['suite_id'] = $suite_id;
        if (!empty($appid)) {
            $params['appid'] = $appid;
        }
        $queryParams = array(
            'provider_access_token' => $provider_access_token
        );
        $rst = $this->_request->post($this->_url . "get_app_license_info", $params, array(), '', $queryParams);
        return $this->_client->rst($rst);
    }
}
