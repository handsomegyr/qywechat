<?php

namespace Qyweixin\Manager;

use Qyweixin\Client;
use Qyweixin\Manager\ExternalContact\Moment;
use Qyweixin\Manager\ExternalContact\CorpTag;
use Qyweixin\Manager\ExternalContact\GroupMsg;
use Qyweixin\Manager\ExternalContact\GroupChat;
use Qyweixin\Manager\ExternalContact\ContactWay;
use Qyweixin\Manager\ExternalContact\StrategyTag;
use Qyweixin\Manager\ExternalContact\CustomerStrategy;
use Qyweixin\Manager\ExternalContact\GroupWelcomeTemplate;

/**
 * 外部企业的联系人管理
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class ExternalContact
{

	// 接口地址
	private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 获取客户群列消息发送对象
	 *
	 * @return \Qyweixin\Manager\ExternalContact\GroupChat
	 */
	public function getGroupChatManager()
	{
		return new GroupChat($this->_client);
	}

	/**
	 * 获取群欢迎语素材对象
	 *
	 * @return \Qyweixin\Manager\ExternalContact\GroupWelcomeTemplate
	 */
	public function getGroupWelcomeTemplateManager()
	{
		return new GroupWelcomeTemplate($this->_client);
	}

	/**
	 * 获取客户朋友圈对象
	 *
	 * @return \Qyweixin\Manager\ExternalContact\Moment
	 */
	public function getMomentManager()
	{
		return new Moment($this->_client);
	}

	/**
	 * 获取企业的全部群发对象
	 *
	 * @return \Qyweixin\Manager\ExternalContact\GroupMsg
	 */
	public function getGroupMsgManager()
	{
		return new GroupMsg($this->_client);
	}

	/**
	 * 获取客户联系规则组管理对象
	 *
	 * @return \Qyweixin\Manager\ExternalContact\CustomerStrategy
	 */
	public function getCustomerStrategyManager()
	{
		return new CustomerStrategy($this->_client);
	}
	/**
	 * 获取企业标签库对象
	 *
	 * @return \Qyweixin\Manager\ExternalContact\CorpTag
	 */
	public function getCorpTagManager()
	{
		return new CorpTag($this->_client);
	}

	/**
	 * 获取管理企业规则组下的客户标签对象
	 *
	 * @return \Qyweixin\Manager\ExternalContact\StrategyTag
	 */
	public function getStrategyTagManager()
	{
		return new StrategyTag($this->_client);
	}

	/**
	 * 获取客户联系「联系我」管理对象
	 *
	 * @return \Qyweixin\Manager\ExternalContact\ContactWay
	 */
	public function getContactWayManager()
	{
		return new ContactWay($this->_client);
	}
	/**
	 * 获取配置了客户联系功能的成员列表
	 * 调试工具
	 * 企业和第三方服务商可通过此接口获取配置了客户联系功能的成员列表。
	 *
	 * 请求方式：GET（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_follow_user_list?access_token=ACCESS_TOKEN
	 *
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * 权限说明：
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）；
	 * 第三方应用需拥有“企业客户”权限。
	 * 第三方/自建应用只能获取到可见范围内的配置了客户联系功能的成员。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "follow_user":[
	 * "zhangsan",
	 * "lissi"
	 * ]
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * follow_user 配置了客户联系功能的成员userid列表
	 */
	public function getFollowUserList()
	{
		$params = array();
		$rst = $this->_request->get($this->_url . 'get_follow_user_list', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 配置客户联系「联系我」方式
	 */
	public function addContactWay(\Qyweixin\Model\ExternalContact\ContactWay $contactWay)
	{
		return $this->getContactWayManager()->add($contactWay);
	}

	/**
	 * 获取企业已配置的「联系我」方式
	 */
	public function getContactWay($config_id)
	{
		return $this->getContactWayManager()->get($config_id);
	}

	/**
	 * 更新企业已配置的「联系我」方式
	 */
	public function updateContactWay(\Qyweixin\Model\ExternalContact\ContactWay $contactWay)
	{
		return $this->getContactWayManager()->update($contactWay);
	}

	/**
	 * 删除企业已配置的「联系我」方式
	 */
	public function deleteContactWay($config_id)
	{
		return $this->getContactWayManager()->del($config_id);
	}

	/**
	 * 结束临时会话
	 * 将指定的企业成员和客户之前的临时会话断开，断开前会自动下发已配置的结束语。
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/close_temp_chat?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "userid":"zhangyisheng",
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACHAAA"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * userid 是 企业成员的userid
	 * external_userid 是 客户的外部联系人userid
	 * 注意：请保证传入的企业成员和客户之间有仍然有效的临时会话, 通过其他方式的添加外部联系人无法通过此接口关闭会话。
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * 结束语定义
	 * 字段内容：
	 *
	 * "conclusions":
	 * {
	 * "text":
	 * {
	 * "content":"文本消息内容"
	 * },
	 * "image":
	 * {
	 * "media_id": "MEDIA_ID",
	 * "pic_url": "http://p.qpic.cn/pic_wework/XXXXX"
	 * },
	 * "link":
	 * {
	 * "title": "消息标题",
	 * "picurl": "https://example.pic.com/path",
	 * "desc": "消息描述",
	 * "url": "https://example.link.com/path"
	 * },
	 * "miniprogram":
	 * {
	 * "title": "消息标题",
	 * "pic_media_id": "MEDIA_ID",
	 * "appid": "wx8bd80126147dfAAA",
	 * "page": "/path/index"
	 * }
	 * }
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * text.content 消息文本内容,最长为4000字节
	 * image.media_id 图片的media_id
	 * image.pic_url 图片的url
	 * link.title 图文消息标题，最长为128字节
	 * link.picurl 图文消息封面的url
	 * link.desc 图文消息的描述，最长为512字节
	 * link.url 图文消息的链接
	 * miniprogram.title 小程序消息标题，最长为64字节
	 * miniprogram.pic_media_id 小程序消息封面的mediaid，封面图建议尺寸为520*416
	 * miniprogram.appid 小程序appid，必须是关联到企业的小程序应用
	 * miniprogram.page 小程序page路径
	 * text、image、link和miniprogram四者不能同时为空；
	 * text与另外三者可以同时发送，此时将会以两条消息的形式触达客户;
	 * image、link和miniprogram只能有一个，如果三者同时填，则按image、link、miniprogram的优先顺序取参，也就是说，如果image与link同时传值，则只有image生效;
	 * media_id可以通过素材管理接口获得;
	 * 构造结束语使用image消息时，只能填写meida_id字段,获取含有image结构的联系我方式时，返回pic_url字段。
	 */
	public function closeTempChat($userid, $external_userid)
	{
		$params = array();
		$params['userid'] = $userid;
		$params['external_userid'] = $external_userid;
		$rst = $this->_request->post($this->_url . 'close_temp_chat', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取客户列表
	 * 调试工具
	 * 企业可通过此接口获取指定成员添加的客户列表。客户是指配置了客户联系功能的成员所添加的外部联系人。没有配置客户联系功能的成员，所添加的外部联系人将不会作为客户返回。
	 *
	 * 请求方式：GET（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/list?access_token=ACCESS_TOKEN&userid=USERID
	 *
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * userid 是 企业成员的userid
	 * 权限说明：
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）；
	 * 第三方应用需拥有“企业客户”权限。
	 * 第三方/自建应用只能获取到可见范围内的配置了客户联系功能的成员。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "external_userid":
	 * [
	 * "woAJ2GCAAAXtWyujaWJHDDGi0mACAAA",
	 * "wmqfasd1e1927831291723123109rAAA"
	 * ]
	 * 　　
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * external_userid 外部联系人的userid列表
	 */
	public function getExternalcontactList($userid)
	{
		$params = array();
		$params['userid'] = $userid;
		$rst = $this->_request->get($this->_url . 'list', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 批量获取客户详情
	 * 企业/第三方可通过此接口获取指定成员添加的客户信息列表。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/batch/get_by_user?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "userid_list":
	 * [
	 * "zhangsan",
	 * "lisi"
	 * ],
	 * "cursor":"",
	 * "limit":100
	 * }
	 *
	 *
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * userid_list 是 企业成员的userid列表，字符串类型，最多支持100个
	 * cursor 否 用于分页查询的游标，字符串类型，由上一次调用返回，首次调用可不填
	 * limit 否 返回的最大记录数，整型，最大值100，默认值50，超过最大值时取最大值
	 *
	 *
	 * 权限说明：
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）；
	 * 第三方应用需具有“企业客户权限->客户基础信息”权限
	 * 第三方/自建应用调用此接口时，userid需要在相关应用的可见范围内。
	 * 规则组标签仅可通过“客户联系”获取。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "external_contact_list":
	 * [
	 * {
	 * "external_contact":
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACHAAA",
	 * "name":"李四",
	 * "position":"Manager",
	 * "avatar":"http://p.qlogo.cn/bizmail/IcsdgagqefergqerhewSdage/0",
	 * "corp_name":"腾讯",
	 * "corp_full_name":"腾讯科技有限公司",
	 * "type":2,
	 * "gender":1,
	 * "unionid":"ozynqsulJFCZ2z1aYeS8h-nuasdAAA",
	 * "external_profile":
	 * {
	 * "external_attr":
	 * [
	 * {
	 * "type":0,
	 * "name":"文本名称",
	 * "text":
	 * {
	 * "value":"文本"
	 * }
	 * },
	 * {
	 * "type":1,
	 * "name":"网页名称",
	 * "web":
	 * {
	 * "url":"http://www.test.com",
	 * "title":"标题"
	 * }
	 * },
	 * {
	 * "type":2,
	 * "name":"测试app",
	 * "miniprogram":
	 * {
	 * "appid": "wx8bd80126147df384",
	 * "pagepath": "/index",
	 * "title": "my miniprogram"
	 * }
	 * }
	 * ]
	 * }
	 * },
	 * "follow_info":
	 * {
	 * "userid":"rocky",
	 * "remark":"李部长",
	 * "description":"对接采购事务",
	 * "createtime":1525779812,
	 * "tag_id":["etAJ2GCAAAXtWyujaWJHDDGi0mACHAAA"],
	 * "remark_corp_name":"腾讯科技",
	 * "remark_mobiles":
	 * [
	 * "13800000001",
	 * "13000000002"
	 * ],
	 * "oper_userid":"rocky",
	 * "add_way":10,
	 * "wechat_channels": {
	 * "nickname": "视频号名称",
	 * "source": 1
	 * }
	 * }
	 * },
	 * {
	 * "external_contact":
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACHBBB",
	 * "name":"王五",
	 * "position":"Engineer",
	 * "avatar":"http://p.qlogo.cn/bizmail/IcsdgagqefergqerhewSdage/0",
	 * "corp_name":"腾讯",
	 * "corp_full_name":"腾讯科技有限公司",
	 * "type":2,
	 * "gender":1,
	 * "unionid":"ozynqsulJFCZ2asdaf8h-nuasdAAA"
	 * },
	 * "follow_info":
	 * {
	 * "userid":"lisi",
	 * "remark":"王助理",
	 * "description":"采购问题咨询",
	 * "createtime":1525881637,
	 * "tag_id":["etAJ2GCAAAXtWyujaWJHDDGi0mACHAAA","stJHDDGi0mAGi0mACHBBByujaW"],
	 * "state":"外联二维码1",
	 * "oper_userid":"woAJ2GCAAAd1asdasdjO4wKmE8AabjBBB",
	 * "add_way":3
	 * }
	 * }
	 * ],
	 * "next_cursor":"r9FqSqsI8fgNbHLHE5QoCP50UIg2cFQbfma3l2QsmwI"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * external_contact_list.external_contact 客户的基本信息，可以参考获取客户详情
	 * external_contact_list.follow_info 企业成员客户跟进信息，可以参考获取客户详情，但标签信息只会返回企业标签和规则组标签的tag_id，个人标签将不再返回
	 * next_cursor 分页游标，再下次请求时填写以获取之后分页的记录，如果已经没有更多的数据则返回空
	 */
	public function batchGetByUser(array $userid_list, $cursor = "", $limit = 100)
	{
		$params = array();
		$params['userid_list'] = $userid_list;
		$params['cursor'] = $cursor;
		$params['limit'] = $limit;

		$rst = $this->_request->post($this->_url . 'batch/get_by_user', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取客户详情
	 * 调试工具
	 * 企业可通过此接口，根据外部联系人的userid（如何获取?），拉取客户详情。
	 *
	 * 请求方式：GET（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get?access_token=ACCESS_TOKEN&external_userid=EXTERNAL_USERID
	 *
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * external_userid 是 外部联系人的userid，注意不是企业成员的帐号
	 * cursor 否 上次请求返回的next_cursor
	 * 权限说明：
	 *
	 * 企业需要使用系统应用“客户联系”或配置到“可调用应用”列表中的自建应用的secret所获取的accesstoken来调用（accesstoken如何获取？）；
	 * 第三方/自建应用调用时，返回的跟进人follow_user仅包含应用可见范围之内的成员。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "external_contact":
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACHAAA",
	 * "name":"李四",
	 * "position":"Mangaer",
	 * "avatar":"http://p.qlogo.cn/bizmail/IcsdgagqefergqerhewSdage/0",
	 * "corp_name":"腾讯",
	 * "corp_full_name":"腾讯科技有限公司",
	 * "type":2,
	 * "gender":1,
	 * "unionid":"ozynqsulJFCZ2z1aYeS8h-nuasdAAA",
	 * "external_profile":{
	 * "external_attr":[
	 * {
	 * "type":0,
	 * "name":"文本名称",
	 * "text":{
	 * "value":"文本"
	 * }
	 * },
	 * {
	 * "type":1,
	 * "name":"网页名称",
	 * "web":{
	 * "url":"http://www.test.com",
	 * "title":"标题"
	 * }
	 * 　　　　　　　　},
	 * 　　　　　　　　{
	 * 　　　　　　　　　　"type":2,
	 * 　　　　　　　　　　"name":"测试app",
	 * 　　　　　　　　　　"miniprogram":{
	 * "appid": "wx8bd80126147df384",
	 * "pagepath": "/index",
	 * "title": "my miniprogram"
	 * 　　　　　　　　　　}
	 * 　　　　　　　　}
	 * 　　　　　　]
	 * 　　　　}
	 * },
	 * "follow_user":
	 * [
	 * {
	 * "userid":"rocky",
	 * "remark":"李部长",
	 * "description":"对接采购事务",
	 * "createtime":1525779812,
	 * "tags":[
	 * {
	 * "group_name":"标签分组名称",
	 * "tag_name":"标签名称",
	 * "type":1
	 * }
	 * ],
	 * "remark_corp_name":"腾讯科技",
	 * "remark_mobiles":[
	 * "13800000001",
	 * "13000000002"
	 * ]
	 * },
	 * {
	 * "userid":"tommy",
	 * "remark":"李总",
	 * "description":"采购问题咨询",
	 * "createtime":1525881637,
	 * "state":"外联二维码1"
	 * }
	 * ],
	 * "next_cursor":"NEXT_CURSOR"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * external_userid 外部联系人的userid
	 * name 外部联系人的名称*
	 * avatar 外部联系人头像，第三方不可获取
	 * type 外部联系人的类型，1表示该外部联系人是微信用户，2表示该外部联系人是企业微信用户
	 * gender 外部联系人性别 0-未知 1-男性 2-女性
	 * unionid 外部联系人在微信开放平台的唯一身份标识（微信unionid），通过此字段企业可将外部联系人与公众号/小程序用户关联起来。仅当联系人类型是微信用户，且企业或第三方服务商绑定了微信开发者ID有此字段。查看绑定方法
	 * position 外部联系人的职位，如果外部企业或用户选择隐藏职位，则不返回，仅当联系人类型是企业微信用户时有此字段
	 * corp_name 外部联系人所在企业的简称，仅当联系人类型是企业微信用户时有此字段
	 * corp_full_name 外部联系人所在企业的主体名称，仅当联系人类型是企业微信用户时有此字段
	 * external_profile 外部联系人的自定义展示信息，可以有多个字段和多种类型，包括文本，网页和小程序，仅当联系人类型是企业微信用户时有此字段，字段详情见对外属性；
	 * follow_user.userid 添加了此外部联系人的企业成员userid
	 * follow_user.remark 该成员对此外部联系人的备注
	 * follow_user.description 该成员对此外部联系人的描述
	 * follow_user.createtime 该成员添加此外部联系人的时间
	 * follow_user.tags.group_name 该成员添加此外部联系人所打标签的分组名称（标签功能需要企业微信升级到2.7.5及以上版本）
	 * follow_user.tags.tag_name 该成员添加此外部联系人所打标签名称
	 * follow_user.tags.type 该成员添加此外部联系人所打标签类型, 1-企业设置, 2-用户自定义
	 * follow_user.remark_corp_name 该成员对此客户备注的企业名称
	 * follow_user.remark_mobiles 该成员对此客户备注的手机号码，第三方不可获取
	 * follow_user.state 该成员添加此客户的渠道，由用户通过创建「联系我」方式指定
	 * 如果外部联系人为微信用户，则返回外部联系人的名称为其微信昵称；如果外部联系人为企业微信用户，则会按照以下优先级顺序返回：此外部联系人或管理员设置的昵称、认证的实名和账号名称。
	 * 关于返回unionid，如果是第三方应用调用该接口，则返回的unionid是该第三方服务商所关联的微信开放者帐号下的unionid。也就是说，同一个企业客户，企业自己调用，与第三方服务商调用，所返回的unionid不同；不同的服务商调用，所返回的unionid也不同。
	 * next_cursor 分页的cursor，当跟进人多于500人时返回
	 */
	public function get($external_userid, $cursor = "")
	{
		$params = array();
		$params['external_userid'] = $external_userid;
		$params['cursor'] = $cursor;
		$rst = $this->_request->get($this->_url . 'get', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 修改客户备注信息
	 * 调试工具
	 * 企业可通过此接口修改指定用户添加的客户的备注信息。
	 *
	 * 请求方式: POST(HTTP)
	 *
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/remark?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "userid":"zhangsan",
	 * "external_userid":"woAJ2GCAAAd1asdasdjO4wKmE8Aabj9AAA",
	 * "remark":"备注信息",
	 * "description":"描述信息",
	 * "remark_company":"腾讯科技",
	 * "remark_mobiles":[
	 * "13800000001",
	 * "13800000002"
	 * ],
	 * "remark_pic_mediaid":"MEDIAID"
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * userid 是 企业成员的userid
	 * external_userid 是 外部联系人userid
	 * remark 否 此用户对外部联系人的备注
	 * description 否 此用户对外部联系人的描述
	 * remark_company 否 此用户对外部联系人备注的所属公司名称
	 * remark_mobiles 否 此用户对外部联系人备注的手机号
	 * remark_pic_mediaid 否 备注图片的mediaid，
	 * remark_company只在此外部联系人为微信用户时有效。
	 * remark，description，remark_company，remark_mobiles和remark_pic_mediaid不可同时为空。
	 * 如果填写了remark_mobiles，将会覆盖旧的备注手机号。
	 * 如果要清除所有备注手机号,请在remark_mobiles填写一个空字符串(“”)。
	 * remark_pic_mediaid可以通过素材管理接口获得。
	 *
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方调用时，应用需具有外部联系人管理权限。
	 * 返回结果:
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok"
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 */
	public function remark(\Qyweixin\Model\ExternalContact\Remark $remark)
	{
		$params = $remark->getParams();
		$rst = $this->_request->post($this->_url . 'remark', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取企业标签库
	 */
	public function getCorpTagList(array $tag_id = array(), array $group_id = array())
	{
		return $this->getCorpTagManager()->getList($tag_id, $group_id);
	}

	/**
	 * 添加企业客户标签
	 */
	public function addCorpTag(\Qyweixin\Model\ExternalContact\CorpTag $corpTag)
	{
		return $this->getCorpTagManager()->add($corpTag);
	}

	/**
	 * 编辑企业客户标签
	 */
	public function editCorpTag(\Qyweixin\Model\ExternalContact\CorpTag $corpTag)
	{
		return $this->getCorpTagManager()->edit($corpTag);
	}

	/**
	 * 删除企业客户标签
	 */
	public function deleteCorpTag($tag_id, $group_id, $agentid = "")
	{
		return $this->getCorpTagManager()->del($tag_id, $group_id, $agentid);
	}

	/**
	 * 编辑客户企业标签
	 * 调试工具
	 * 企业可通过此接口为指定成员的客户添加上由企业统一配置的标签。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/mark_tag?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "userid":"zhangsan",
	 * "external_userid":"woAJ2GCAAAd1NPGHKSD4wKmE8Aabj9AAA",
	 * "add_tag":["TAGID1","TAGID2"],
	 * "remove_tag":["TAGID3","TAGID4"]
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * userid 是 添加外部联系人的userid
	 * external_userid 是 外部联系人userid
	 * add_tag 否 要标记的标签列表
	 * remove_tag 否 要移除的标签列表
	 * 请确保external_userid是userid的外部联系人。
	 * add_tag和remove_tag不可同时为空。
	 * 同一个标签组下现已支持多个标签
	 *
	 * 权限说明：
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方调用时，应用需具有外部联系人管理权限。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 */
	public function markTag($userid, $external_userid, $add_tag, $remove_tag)
	{
		$params = array();
		$params['userid'] = $userid;
		$params['external_userid'] = $external_userid;
		if (empty($add_tag) && empty($remove_tag)) {
			throw new \Exception('add_tag和remove_tag不可同时为空');
		}
		if (!empty($add_tag)) {
			$params['add_tag'] = $add_tag;
		}
		if (!empty($remove_tag)) {
			$params['remove_tag'] = $remove_tag;
		}
		$rst = $this->_request->post($this->_url . 'mark_tag', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 添加企业群发消息任务
	 * 调试工具
	 * 企业可通过此接口添加企业群发消息的任务并通知客服人员发送给相关客户或客户群。（注：企业微信终端需升级到2.7.5版本及以上）
	 * 注意：调用该接口并不会直接发送消息给客户/客户群，需要相关的客服人员操作以后才会实际发送（客服人员的企业微信需要升级到2.7.5及以上版本）
	 * 同一个企业每个自然月内仅可针对一个客户/客户群发送4条消息，超过限制的用户将会被忽略。
	 *
	 * 请求方式: POST(HTTP)
	 *
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_msg_template?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "chat_type": "single",
	 * "external_userid": [
	 * "woAJ2GCAAAXtWyujaWJHDDGi0mACAAAA",
	 * "wmqfasd1e1927831123109rBAAAA"
	 * ],
	 * "sender": "zhangsan",
	 * "text": {
	 * "content": "文本消息内容"
	 * },
	 * "attachments": [{
	 * "msgtype": "image",
	 * "image": {
	 * "media_id": "MEDIA_ID",
	 * "pic_url": "http://p.qpic.cn/pic_wework/3474110808/7a6344sdadfwehe42060/0"
	 * }
	 * }, {
	 * "msgtype": "link",
	 * "link": {
	 * "title": "消息标题",
	 * "picurl": "https://example.pic.com/path",
	 * "desc": "消息描述",
	 * "url": "https://example.link.com/path"
	 * }
	 * }, {
	 * "msgtype": "miniprogram",
	 * "miniprogram": {
	 * "title": "消息标题",
	 * "pic_media_id": "MEDIA_ID",
	 * "appid": "wx8bd80126147dfAAA",
	 * "page": "/path/index.html"
	 * }
	 * }, {
	 * "msgtype": "video",
	 * "video": {
	 * "media_id": "MEDIA_ID"
	 * }
	 * }]
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * chat_type 否 群发任务的类型，默认为single，表示发送给客户，group表示发送给客户群
	 * external_userid 否 客户的外部联系人id列表，仅在chat_type为single时有效，不可与sender同时为空，最多可传入1万个客户
	 * sender 否 发送企业群发消息的成员userid，当类型为发送给客户群时必填
	 * text.content 否 消息文本内容，最多4000个字节
	 * attachments 否 附件，最多支持添加9个附件
	 * attachments.msgtype 是 附件类型，可选image、link、miniprogram或者video
	 * image.media_id 是 图片的media_id
	 * image.pic_url 否 图片的链接，仅可使用上传图片接口得到的链接
	 * link.title 是 图文消息标题
	 * link.picurl 否 图文消息封面的url
	 * link.desc 否 图文消息的描述，最多512个字节
	 * link.url 是 图文消息的链接
	 * miniprogram.title 是 小程序消息标题，最多64个字节
	 * miniprogram.pic_media_id 是 小程序消息封面的mediaid，封面图建议尺寸为520*416
	 * miniprogram.appid 是 小程序appid，必须是关联到企业的小程序应用
	 * miniprogram.page 是 小程序page路径
	 * video.media_id 是 视频的media_id，可以通过素材管理接口获得
	 * text和attachments不能同时为空；
	 * text与另外三者可以同时发送，此时将会以两条消息的形式触达客户
	 * attachments中每个附件信息必须与msgtype一致，例如，msgtype指定为image，则需要填写image.pic_url或者image.media_id，否则会报错。
	 * media_id和pic_url只需填写一个，两者同时填写时使用media_id，二者不可同时为空。
	 *
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 自建应用只能给应用可见范围内的成员进行推送。
	 * 第三方应用不可调用
	 * 当只提供sender参数时，相当于选取了这个成员所有的客户。
	 * 注意：2019-8-1之后，取消了 “无法向未回复消息的客户发送企业群发消息” 的限制。
	 */
	public function addMsgTemplate(\Qyweixin\Model\ExternalContact\MsgTemplate $msgTemplate)
	{
		$params = $msgTemplate->getParams();
		$rst = $this->_request->post($this->_url . 'add_msg_template', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取企业群发消息发送结果
	 * 调试工具
	 * 企业可通过该接口获取到添加企业群发消息任务的群发发送结果。
	 *
	 * 请求方式:POST(HTTPS)
	 *
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_group_msg_result?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "msgid": "msgGCAAAXtWyujaWJHDDGi0mACAAAA"
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * msgid 是 群发消息的id，通过添加企业群发消息模板接口返回
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用不可调用。
	 * 自建应用调用，只会返回应用可见范围内用户的发送情况。
	 * 返回结果:
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "check_status": 1,
	 * "detail_list": [
	 * {
	 * "external_userid": "wmqfasd1e19278asdasAAAA",
	 * "userid": "zhangsan",
	 * "status": 1,
	 * "send_time": 1552536375
	 * }
	 * ]
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * check_status 模板消息的审核状态 0-审核中 1-审核成功 2-审核失败
	 * detail_list.external_userid 外部联系人userid
	 * detail_list.userid 企业服务人员的userid
	 * detail_list.status 发送状态 0-未发送 1-已发送 2-因客户不是好友导致发送失败 3-因客户已经收到其他群发消息导致发送失败
	 * detail_list.send_time 发送时间，发送状态为1时返回
	 */
	public function getGroupMsgResult($msgid)
	{
		$params = array();
		$params['msgid'] = $msgid;
		$rst = $this->_request->post($this->_url . 'get_group_msg_result', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 发送新客户欢迎语
	 * 调试工具
	 * 企业微信在向企业推送添加外部联系人事件时，会额外返回一个welcome_code，企业以此为凭据调用接口，即可通过成员向新添加的客户发送个性化的欢迎语。
	 * 为了保证用户体验以及避免滥用，企业仅可在收到相关事件后20秒内调用，且只可调用一次。
	 * 如果企业已经在管理端为相关成员配置了可用的欢迎语，则推送添加外部联系人事件时不会返回welcome_code。
	 * 每次添加新客户时可能有多个企业自建应用/第三方应用收到带有welcome_code的回调事件，但仅有最先调用的可以发送成功。后续调用将返回41051（externaluser has started chatting）错误，请用户根据实际使用需求，合理设置应用可见范围，避免冲突。
	 * 请求方式: POST(HTTP)
	 *
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/send_welcome_msg?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "welcome_code": "CALLBACK_CODE",
	 * "text": {
	 * "content": "文本消息内容"
	 * },
	 * "attachments": [{
	 * "msgtype": "image",
	 * "image": {
	 * "media_id": "MEDIA_ID",
	 * "pic_url": "http://p.qpic.cn/pic_wework/3474110808/7a6344sdadfwehe42060/0"
	 * }
	 * }, {
	 * "msgtype": "link",
	 * "link": {
	 * "title": "消息标题",
	 * "picurl": "https://example.pic.com/path",
	 * "desc": "消息描述",
	 * "url": "https://example.link.com/path"
	 * }
	 * }, {
	 * "msgtype": "miniprogram",
	 * "miniprogram": {
	 * "title": "消息标题",
	 * "pic_media_id": "MEDIA_ID",
	 * "appid": "wx8bd80126147dfAAA",
	 * "page": "/path/index.html"
	 * }
	 * }, {
	 * "msgtype": "video",
	 * "video": {
	 * "media_id": "MEDIA_ID"
	 * }
	 * }]
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * welcome_code 是 通过添加外部联系人事件推送给企业的发送欢迎语的凭证，有效期为20秒
	 * text.content 否 消息文本内容,最长为4000字节
	 * attachments 否 附件，最多可添加9个附件
	 * attachments.msgtype 是 附件类型，可选image、link、miniprogram或者video
	 * image.media_id 是 图片的media_id
	 * image.pic_url 否 图片的链接，仅可使用上传图片接口得到的链接
	 * link.title 是 图文消息标题，最长为128字节
	 * link.picurl 否 图文消息封面的url
	 * link.desc 否 图文消息的描述，最长为512字节
	 * link.url 是 图文消息的链接
	 * miniprogram.title 是 小程序消息标题，最长为64字节
	 * miniprogram.pic_media_id 是 小程序消息封面的mediaid，封面图建议尺寸为520*416
	 * miniprogram.appid 是 小程序appid，必须是关联到企业的小程序应用
	 * miniprogram.page 是 小程序page路径
	 * video.media_id 是 视频的media_id，可以通过素材管理接口获得
	 * text和attachments不能同时为空；
	 * text与附件信息可以同时发送，此时将会以多条消息的形式触达客户
	 * attachments中每个附件信息必须与msgtype一致，例如，msgtype指定为image，则需要填写image.pic_url或者image.media_id，否则会报错。
	 * media_id和pic_url只需填写一个，两者同时填写时使用media_id，二者不可同时为空。
	 *
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需要拥有「企业客户」权限，且企业成员处于相关应用的可见范围内。
	 * 返回结果:
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 */
	public function sendWelcomeMsg(\Qyweixin\Model\ExternalContact\WelcomeMsg $welcomeMsg)
	{
		$params = $welcomeMsg->getParams();
		$rst = $this->_request->post($this->_url . 'send_welcome_msg', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取联系客户统计数据
	 * 调试工具
	 * 企业可通过此接口获取成员联系客户的数据，包括发起申请数、新增客户数、聊天数、发送消息数和删除/拉黑成员的客户数等指标。
	 *
	 * 请求方式: POST(HTTP)
	 *
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_user_behavior_data?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "userid": [
	 * "zhangsan",
	 * "lisi"
	 * ],
	 * "partyid":
	 * [
	 * 1001,
	 * 1002
	 * ],
	 * "start_time":1536508800,
	 * "end_time":1536940800
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * userid 否 用户ID列表
	 * partyid 否 部门ID列表
	 * start_time 是 数据起始时间
	 * end_time 是 数据结束时间
	 * userid和partyid不可同时为空;
	 * 此接口提供的数据以天为维度，查询的时间范围为[start_time,end_time]，即前后均为闭区间，支持的最大查询跨度为30天；
	 * 用户最多可获取最近60天内的数据；
	 * 当传入的时间不为0点时间戳时，会向下取整，如传入1554296400(Wed Apr 3 21:00:00 CST 2019)会被自动转换为1554220800（Wed Apr 3 00:00:00 CST 2019）;
	 * 如传入多个userid，则表示获取这些成员总体的联系客户数据。
	 *
	 * 权限说明:
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需拥有“企业客户”权限。
	 * 第三方/自建应用调用时传入的userid和partyid要在应用的可见范围内;
	 * 返回结果:
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "behavior_data":
	 * [
	 * {
	 * "stat_time":1536508800,
	 * "chat_cnt":100,
	 * "message_cnt":80,
	 * "reply_percentage":60.25,
	 * "avg_reply_time":1,
	 * "negative_feedback_cnt":0,
	 * "new_apply_cnt":6,
	 * "new_contact_cnt":5
	 * },
	 * {
	 * "stat_time":1536940800,
	 * "chat_cnt":20,
	 * "message_cnt":40,
	 * "reply_percentage":100,
	 * "avg_reply_time":1,
	 * "negative_feedback_cnt":0,
	 * "new_apply_cnt":6,
	 * "new_contact_cnt":5
	 * }
	 * ]
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * behavior_data.stat_time 数据日期，为当日0点的时间戳
	 * behavior_data.new_apply_cnt 发起申请数，成员通过「搜索手机号」、「扫一扫」、「从微信好友中添加」、「从群聊中添加」、「添加共享、分配给我的客户」、「添加单向、双向删除好友关系的好友」、「从新的联系人推荐中添加」等渠道主动向客户发起的好友申请数量。
	 * behavior_data.new_contact_cnt 新增客户数，成员新添加的客户数量。
	 * behavior_data.chat_cnt 聊天总数， 成员有主动发送过消息的聊天数，包括单聊和群聊。
	 * behavior_data.message_cnt 发送消息数，成员在单聊和群聊中发送的消息总数。
	 * behavior_data.reply_percentage 已回复聊天占比，客户主动发起聊天后，成员在一个自然日内有回复过消息的聊天数/客户主动发起的聊天数比例，不包括群聊，仅在确有回复时返回。
	 * behavior_data.avg_reply_time 平均首次回复时长，单位为分钟，即客户主动发起聊天后，成员在一个自然日内首次回复的时长间隔为首次回复时长，所有聊天的首次回复总时长/已回复的聊天总数即为平均首次回复时长，不包括群聊，仅在确有回复时返回。
	 * behavior_data.negative_feedback_cnt 删除/拉黑成员的客户数，即将成员删除或加入黑名单的客户数。
	 */
	public function getUserBehaviorData($userid, $partyid, $start_time, $end_time)
	{
		$params = array();
		$params['userid'] = $userid;
		$params['partyid'] = $partyid;
		$params['start_time'] = $start_time;
		$params['end_time'] = $end_time;
		$rst = $this->_request->post($this->_url . 'get_user_behavior_data', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 外部联系人openid转换
	 * 企业和服务商可通过此接口，将微信外部联系人的userid（如何获取?）转为微信openid，用于调用支付相关接口。暂不支持企业微信外部联系人（ExternalUserid为wo开头）的userid转openid。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/convert_to_openid?access_token=ACCESS_TOKEN
	 *
	 * 请求参数：
	 *
	 * {
	 * "external_userid":"wmAAAAAAA"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * external_userid 是 外部联系人的userid，注意不是企业成员的帐号
	 * 返回结果：
	 *
	 * ｛
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "openid":"ooAAAAAAAAAAA"
	 * ｝
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * openid 该企业的外部联系人openid
	 */
	public function convertToOpenid($external_userid)
	{
		$params = array();
		$params['external_userid'] = $external_userid;
		$rst = $this->_request->post($this->_url . 'convert_to_openid', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 家长openid拉取userid
	 * 服务商可通过此接口，可以通过家长的openid拉取external userid，以及家长在其关注企业中对应的userid。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/convert_to_external_userid?suite_access_token=SUITE_ACCESS_TOKEN
	 *
	 * 请求参数：
	 *
	 * {
	 * "openid":"oo2sbs-8dwPXXBbbPLXCkoAAAAA"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * suite_access_token 是 第三方应用的suite_access_token，参见“获取第三方应用凭证”
	 * openid 是 外部联系人的openid，注意不是企业成员的帐号
	 * 返回结果：
	 *
	 * ｛
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "external_userid":"wmAAAAAAA",
	 * "items":
	 * [
	 * {"corpid": "ww8dd8eb8dd40d92b2", "parent_userid":"lisi_parent_userid"},
	 * {"corpid": "ww9c71530db77f6cba", "parent_userid":"zhangsan_parent_userid"}
	 * ]
	 * ｝
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * external_userid 家长的external userid
	 * items 家长关注企业及其对应的userid关系列表
	 * corpid 家长关注的企业corpid
	 * parent_userid 家长在关注企业中对应的userid
	 */
	public function convertToExternalUserid($openid)
	{
		$params = array();
		$params['openid'] = $openid;
		$rst = $this->_request->post($this->_url . 'convert_to_external_userid', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 手机号转外部联系人ID
	 * 请求方式：POST（HTTPS）
	 *
	 * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/batch_to_external_userid?access_token=ACCESS_TOKEN
	 *
	 * 请求示例
	 *
	 * {
	 * "mobiles": [
	 * "10000000000",
	 * "10000000001"
	 * ]
	 * }
	 * 参数说明:
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * mobiles 是 家长手机号列表，最多支持100个
	 * 权限说明：
	 * 学校需要使用“家校沟通”secret所获取的accesstoken来调用（accesstoken如何获取？）；
	 * 第三方应用需拥有「家校沟通」使用权限。
	 *
	 * 返回结果:
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "success_list": [
	 * {
	 * "mobile": "18900000000",
	 * "external_userid": "aaabbbcccc",
	 * "foreign_key": "zhangsan"
	 * }
	 * ],
	 * "fail_list": [
	 * {
	 * "errcode": 60136,
	 * "errmsg": "record not found",
	 * "mobile": "10000000001"
	 * }
	 * ]
	 * }
	 * 参数说明:
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * success_list 转换成功列表
	 * success_list.mobile 手机号
	 * success_list.external_userid 外部联系人的userid(家长关注后才会返回该字段)
	 * success_list.foreign_key 由企业或服务商在导入家长时指定的关键字，也就是家校通讯录中的家长ID
	 * fail_list 转换失败列表
	 * fail_list.errcode 返回码
	 * fail_list.errmsg 对返回码的文本描述内容
	 * fail_list.mobile 手机号
	 */
	public function batchToExternalUserid(array $mobiles)
	{
		$params = array();
		$params['mobiles'] = $mobiles;
		$rst = $this->_request->post($this->_url . 'batch_to_external_userid', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取「学校通知」二维码
	 * 学校可通过此接口获取「学校通知」二维码，家长可通过扫描此二维码关注「学校通知」并接收学校推送的消息。
	 * 请求方式：GET（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_subscribe_qr_code?access_token=ACCESS_TOKEN
	 *
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * 权限说明：
	 *
	 * 学校需要使用“家校沟通”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）；
	 * 第三方应用需拥有「家校沟通」使用权限。
	 * 企业必须完成验证才可调用此接口，否则返回43009(企业需要验证)错误码。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "qrcode_big":"http://p.qpic.cn/wwhead/XXXX",
	 * "qrcode_middle":"http://p.qpic.cn/wwhead/XXXX",
	 * "qrcode_thumb":"http://p.qpic.cn/wwhead/XXXX"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * qrcode_big 1200px的大尺寸二维码
	 * qrcode_middle 430px的中尺寸二维码
	 * qrcode_thumb 258px的小尺寸二维码
	 */
	public function getSubscribeQrcode()
	{
		$params = array();
		$rst = $this->_request->get($this->_url . 'get_subscribe_qr_code', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 管理「学校通知」的关注模式
	 * 设置关注「学校通知」的模式
	 * 获取关注「学校通知」的模式
	 * 设置关注「学校通知」的模式
	 * 可通过此接口修改家长关注「学校通知」的模式：“可扫码填写资料加入”或“禁止扫码填写资料加入”
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/set_subscribe_mode?access_token=ACCESS_TOKEN
	 *
	 * 请求参数：
	 *
	 * {
	 * "subscribe_mode":1,
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * subscribe_mode 是 关注模式, 1:可扫码填写资料加入, 2:禁止扫码填写资料加入
	 * 权限说明：
	 *
	 * 企业需要使用“家校沟通”secret所获取的accesstoken来调用（accesstoken如何获取？）；
	 * 第三方应用需拥有「家校沟通」使用和编辑权限。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 */
	public function setSubscribeMode($subscribe_mode)
	{
		$params = array();
		$params['subscribe_mode'] = $subscribe_mode;
		$rst = $this->_request->post($this->_url . 'set_subscribe_mode', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取关注「学校通知」的模式
	 * 可通过此接口获取家长关注「学校通知」的模式：“可扫码填写资料加入”或“禁止扫码填写资料加入”
	 *
	 * 请求方式：GET（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_subscribe_mode?access_token=ACCESS_TOKEN
	 *
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * 权限说明：
	 *
	 * 企业需要使用“家校沟通”secret所获取的accesstoken来调用（accesstoken如何获取？）；
	 * 第三方应用需拥有「家校沟通」使用权限。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "subscribe_mode":1
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * subscribe_mode 关注模式, 1:可扫码填写资料加入, 2:禁止扫码填写资料加入
	 */
	public function getSubscribeMode()
	{
		$params = array();
		$rst = $this->_request->get($this->_url . 'get_subscribe_mode', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 分配在职成员的客户
	 * 企业可通过此接口，转接在职成员的客户给其他成员。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/transfer_customer?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "handover_userid": "zhangsan",
	 * "takeover_userid": "lisi",
	 * "external_userid":
	 * [
	 * "woAJ2GCAAAXtWyujaWJHDDGi0mACAAAA",
	 * "woAJ2GCAAAXtWyujaWJHDDGi0mACBBBB"
	 * ],
	 * "transfer_success_msg":"您好，您的服务已升级，后续将由我的同事李四@腾讯接替我的工作，继续为您服务。"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * handover_userid 是 原跟进成员的userid
	 * takeover_userid 是 接替成员的userid
	 * external_userid 是 客户的external_userid列表，每次最多分配100个客户
	 * transfer_success_msg 否 转移成功后发给客户的消息，最多200个字符，不填则使用默认文案
	 * external_userid必须是handover_userid的客户（即配置了客户联系功能的成员所添加的联系人）。
	 *
	 * 在职成员的每位客户最多被分配2次。客户被转接成功后，将有90个自然日的服务关系保护期，保护期内的客户无法再次被分配。
	 *
	 * 权限说明：
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需拥有“企业客户权限->客户联系->在职继承”权限
	 * 接替成员必须在此第三方应用或自建应用的可见范围内。
	 * 接替成员需要配置了客户联系功能。
	 * 接替成员需要在企业微信激活且已经过实名认证。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "customer":
	 * [
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACAAAA",
	 * "errcode":40096
	 * },
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACBBBB",
	 * "errcode":0
	 * }
	 * ]
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * customer.external_userid 客户的external_userid
	 * customer.errcode 对此客户进行分配的结果, 具体可参考全局错误码, 0表示成功发起接替,待24小时后自动接替,并不代表最终接替成功
	 * 原接口分配在职或离职成员的客户后续将不再更新维护，请使用新接口
	 */
	public function transferCustomer($handover_userid, $takeover_userid, $external_userid, $transfer_success_msg)
	{
		$params = array();
		if (empty($handover_userid)) {
			throw new \Exception('handover_userid 不可为空');
		}
		if (empty($takeover_userid)) {
			throw new \Exception('takeover_userid 不可为空');
		}
		if (empty($external_userid)) {
			throw new \Exception('external_userid 不可为空');
		}

		$params['handover_userid'] = $handover_userid;
		$params['takeover_userid'] = $takeover_userid;
		$params['external_userid'] = $external_userid;
		$params['transfer_success_msg'] = $transfer_success_msg;

		$rst = $this->_request->post($this->_url . 'transfer_customer', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 查询客户接替状态
	 * 企业和第三方可通过此接口查询在职成员的客户转接情况。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/transfer_result?access_token=ACCESS_TOKEN
	 * 请求示例：
	 * {
	 * "handover_userid": "zhangsan",
	 * "takeover_userid": "lisi",
	 * "cursor":"CURSOR"
	 * }
	 * 参数说明：
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * handover_userid 是 原添加成员的userid
	 * takeover_userid 是 接替成员的userid
	 * cursor 否 分页查询的cursor，每个分页返回的数据不会超过1000条；不填或为空表示获取第一个分页；
	 * 权限说明：
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需拥有“企业客户权限->客户联系->在职继承”权限
	 * 接替成员必须在此第三方应用或自建应用的可见范围内。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "customer":
	 * [
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACCCC",
	 * "status":1,
	 * "takeover_time":1588262400
	 * },
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACBBBB",
	 * "status":2,
	 * "takeover_time":1588482400
	 * },
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACAAAA",
	 * "status":3,
	 * "takeover_time":0
	 * }
	 * ],
	 * "next_cursor":"NEXT_CURSOR"
	 * }
	 * 参数说明：
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * customer.external_userid 转接客户的外部联系人userid
	 * customer.status 接替状态， 1-接替完毕 2-等待接替 3-客户拒绝 4-接替成员客户达到上限 5-无接替记录
	 * customer.takeover_time 接替客户的时间，如果是等待接替状态，则为未来的自动接替时间
	 * next_cursor 下个分页的起始cursor
	 * 原接口查询客户接替结果后续将不再更新维护，请使用新接口
	 */
	public function transferResult($handover_userid, $takeover_userid, $cursor = '')
	{
		$params = array();
		if (empty($handover_userid)) {
			throw new \Exception('handover_userid 不可为空');
		}
		if (empty($takeover_userid)) {
			throw new \Exception('takeover_userid 不可为空');
		}

		$params['handover_userid'] = $handover_userid;
		$params['takeover_userid'] = $takeover_userid;
		$params['cursor'] = $cursor;

		$rst = $this->_request->post($this->_url . 'transfer_result', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取离职成员的客户列表
	 * 调试工具
	 * 企业和第三方可通过此接口，获取所有离职成员的客户列表，并可进一步调用离职成员的外部联系人再分配接口将这些客户重新分配给其他企业成员。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_unassigned_list?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "page_id":0,
	 * "cursor":"",
	 * "page_size":100
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * page_id 否 分页查询，要查询页号，从0开始
	 * page_size 否 每次返回的最大记录数，默认为1000，最大值为1000
	 * 注意:返回数据按离职时间的降序排列，当page_id为1，page_size为100时，表示取第101到第200条记录
	 * cursor 否 分页查询游标，字符串类型，适用于数据量较大的情况，如果使用该参数则无需填写page_id，该参数由上一次调用返回
	 *
	 * 权限说明：
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）
	 * 第三方应用需拥有“企业客户权限”。
	 * 返回结果：
	 *
	 * {
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "info":[
	 * {
	 * "handover_userid":"zhangsan",
	 * "external_userid":"woAJ2GCAAAd4uL12hdfsdasassdDmAAAAA",
	 * "dimission_time":1550838571
	 * },
	 * {
	 * "handover_userid":"lisi",
	 * "external_userid":"wmAJ2GCAAAzLTI123ghsdfoGZNqqAAAA",
	 * "dimission_time":1550661468
	 * }
	 * ],
	 * "is_last":false,
	 * "next_cursor":"aSfwejksvhToiMMfFeIGZZ"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * info.handover_userid 离职成员的userid
	 * info.external_userid 外部联系人userid
	 * info.dimission_time 成员离职时间
	 * is_last 是否是最后一条记录
	 */
	public function getUnassignedList($page_id = 0, $page_size = 1000, $cursor = "")
	{
		$params = array();
		$params['page_id'] = $page_id;
		$params['page_size'] = $page_size;
		$params['cursor'] = $cursor;
		$rst = $this->_request->post($this->_url . 'get_unassigned_list', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 分配离职成员的客户
	 * 企业可通过此接口，分配离职成员的客户给其他成员。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/resigned/transfer_customer?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "handover_userid": "zhangsan",
	 * "takeover_userid": "lisi",
	 * "external_userid":
	 * [
	 * "woAJ2GCAAAXtWyujaWJHDDGi0mACBBBB",
	 * "woAJ2GCAAAXtWyujaWJHDDGi0mACAAAA"
	 * ]
	 *
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * handover_userid 是 原跟进成员的userid
	 * takeover_userid 是 接替成员的userid
	 * external_userid 是 客户的external_userid列表，最多一次转移100个客户
	 * handover_userid必须是已离职用户。
	 * external_userid必须是handover_userid的客户（即配置了客户联系功能的成员所添加的联系人）。
	 *
	 *
	 * 权限说明：
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需拥有“企业客户权限->客户联系->离职分配”权限
	 * 接替成员必须在此第三方应用或自建应用的可见范围内。
	 * 接替成员需要配置了客户联系功能。
	 * 接替成员需要在企业微信激活且已经过实名认证。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "customer":
	 * [
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACBBBB",
	 * "errcode":0
	 * },
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACAAAA",
	 * "errcode":40096
	 * }
	 * ]
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * customer.external_userid 客户的external_userid
	 * customer.errcode 对此客户进行分配的结果, 具体可参考全局错误码, 0表示开始分配流程,待24小时后自动接替,并不代表最终分配成功
	 */
	public function resignedTransferCustomer($external_userid, $handover_userid, $takeover_userid)
	{
		$params = array();
		$params['external_userid'] = $external_userid;
		$params['handover_userid'] = $handover_userid;
		$params['takeover_userid'] = $takeover_userid;
		$rst = $this->_request->post($this->_url . 'resigned/transfer_customer', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 查询客户接替状态
	 * 企业和第三方可通过此接口查询离职成员的客户分配情况。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/resigned/transfer_result?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "handover_userid": "zhangsan",
	 * "takeover_userid": "lisi",
	 * "cursor":"CURSOR"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * handover_userid 是 原添加成员的userid
	 * takeover_userid 是 接替成员的userid
	 * cursor 否 分页查询的cursor，每个分页返回的数据不会超过1000条；不填或为空表示获取第一个分页
	 * 权限说明：
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需拥有“企业客户权限->客户联系->在职继承”权限
	 * 接替成员必须在此第三方应用或自建应用的可见范围内。
	 *
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "customer":
	 * [
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACCCC",
	 * "status":1,
	 * "takeover_time":1588262400
	 * },
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACBBBB",
	 * "status":2,
	 * "takeover_time":1588482400
	 * },
	 * {
	 * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACAAAA",
	 * "status":3,
	 * "takeover_time":0
	 * }
	 * ],
	 * "next_cursor":"NEXT_CURSOR"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * customer.external_userid 转接客户的外部联系人userid
	 * customer.status 接替状态， 1-接替完毕 2-等待接替 3-客户拒绝 4-接替成员客户达到上限
	 * customer.takeover_time 接替客户的时间，如果是等待接替状态，则为未来的自动接替时间
	 * next_cursor 下个分页的起始cursor
	 * 原接口查询客户接替结果后续将不再更新维护，请使用新接口
	 */
	public function resignedTransferResult($handover_userid, $takeover_userid, $cursor = '')
	{
		$params = array();
		if (empty($handover_userid)) {
			throw new \Exception('handover_userid 不可为空');
		}
		if (empty($takeover_userid)) {
			throw new \Exception('takeover_userid 不可为空');
		}

		$params['handover_userid'] = $handover_userid;
		$params['takeover_userid'] = $takeover_userid;
		$params['cursor'] = $cursor;

		$rst = $this->_request->post($this->_url . 'resigned/transfer_result', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 离职成员的外部联系人再分配
	 * 调试工具
	 * 企业可通过此接口，将已离职成员的外部联系人分配给另一个成员接替联系。
	 *
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/transfer?access_token=ACCESS_TOKEN
	 *
	 * 请求示例：
	 *
	 * {
	 * "external_userid": "woAJ2GCAAAXtWyujaWJHDDGi0mACAAAA",
	 * "handover_userid": "zhangsan",
	 * "takeover_userid": "lisi"
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * external_userid 是 外部联系人的userid，注意不是企业成员的帐号
	 * handover_userid 是 离职成员的userid
	 * takeover_userid 是 接替成员的userid
	 * external_userid必须是handover_userid的客户（即配置了客户联系功能的成员所添加的联系人）。
	 *
	 * 权限说明：
	 *
	 * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
	 * 第三方应用需拥有“企业客户权限”。
	 * 相关接手的跟进用户必须在此第三方应用或自建应用的可见范围内。
	 * 接替成员需要配置了客户联系功能。
	 * 接替成员需要在企业微信激活且已经过实名认证。
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 */
	public function transfer($external_userid, $handover_userid, $takeover_userid)
	{
		$params = array();
		$params['external_userid'] = $external_userid;
		$params['handover_userid'] = $handover_userid;
		$params['takeover_userid'] = $takeover_userid;
		$rst = $this->_request->post($this->_url . 'transfer', $params);
		return $this->_client->rst($rst);
	}
}
