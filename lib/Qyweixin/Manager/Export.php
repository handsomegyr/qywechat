<?php

namespace Qyweixin\Manager;

use Qyweixin\Client;

/**
 * 异步导出
 * https://developer.work.weixin.qq.com/document/path/94850
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Export
{

	// 接口地址
	private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/export/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 导出成员
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/export/simple_user?access_token=ACCESS_TOKEN
	 *
	 * 请求示例:
	 *
	 * {
	 * "encoding_aeskey": "IJUiXNpvGbODwKEBSEsAeOAPAhkqHqNCF6g19t9wfg2",
	 * "block_size": 1000000
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * encoding_aeskey 是 base64encode的加密密钥，长度固定为43，base64decode之后即得到AESKey。加密方式采用AES-256-CBC方式，数据采用PKCS#7填充至32字节的倍数；IV初始向量大小为16字节，取AESKey前16字节，详见：https://datatracker.ietf.org/doc/html/rfc2315
	 * block_size 否 每块数据的人员数，支持范围[104,106]，默认值为106
	 *
	 *
	 * 权限说明：
	 *
	 * 仅会返回有权限的人员列表
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "jobid": "jobid_xxxxxxxxx"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * jobid 任务ID，可通过获取导出结果接口查询任务结果
	 */
	public function simpleUser($encoding_aeskey, $block_size)
	{
		$params = array();
		$params['encoding_aeskey'] = $encoding_aeskey;
		$params['block_size'] = $block_size;
		$rst = $this->_request->post($this->_url . 'simple_user', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 导出成员详情
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/export/user?access_token=ACCESS_TOKEN
	 *
	 * 请求示例:
	 *
	 * {
	 * "encoding_aeskey": "IJUiXNpvGbODwKEBSEsAeOAPAhkqHqNCF6g19t9wfg2",
	 * "block_size": 1000000
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * encoding_aeskey 是 base64encode的加密密钥，长度固定为43，base64decode之后即得到AESKey。加密方式采用AES-256-CBC方式，数据采用PKCS#7填充至32字节的倍数；IV初始向量大小为16字节，取AESKey前16字节，详见：https://datatracker.ietf.org/doc/html/rfc2315
	 * block_size 否 每块数据的人员数，支持范围[104,106]，默认值为106
	 * 权限说明：
	 *
	 * 仅会返回有权限的人员列表
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok"，
	 * "jobid": "jobid_xxxxxxxxxxxxxxx"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * jobid 任务ID，可通过获取导出结果接口查询任务结果
	 */
	public function user($encoding_aeskey, $block_size)
	{
		$params = array();
		$params['encoding_aeskey'] = $encoding_aeskey;
		$params['block_size'] = $block_size;
		$rst = $this->_request->post($this->_url . 'user', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 导出部门
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/export/department?access_token=ACCESS_TOKEN
	 *
	 * 请求示例:
	 *
	 * {
	 * "encoding_aeskey": "IJUiXNpvGbODwKEBSEsAeOAPAhkqHqNCF6g19t9wfg2",
	 * "block_size": 1000000
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * encoding_aeskey 是 base64encode的加密密钥，长度固定为43，base64decode之后即得到AESKey。加密方式采用AES-256-CBC方式，数据采用PKCS#7填充至32字节的倍数；IV初始向量大小为16字节，取AESKey前16字节，详见：https://datatracker.ietf.org/doc/html/rfc2315
	 * block_size 否 每块数据的部门数，支持范围[104,106]，默认值为106
	 * 权限说明：
	 *
	 * 仅返回有权限的部门列表
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "jobid": "jobid_xxxxxxxxx"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * jobid 任务ID，可通过获取导出结果接口查询任务结果
	 */
	public function department($encoding_aeskey, $block_size)
	{
		$params = array();
		$params['encoding_aeskey'] = $encoding_aeskey;
		$params['block_size'] = $block_size;
		$rst = $this->_request->post($this->_url . 'department', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 导出标签成员
	 * 请求方式：POST（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/export/taguser?access_token=ACCESS_TOKEN
	 *
	 * 请求示例:
	 *
	 * {
	 * "tagid": 1,
	 * "encoding_aeskey": "IJUiXNpvGbODwKEBSEsAeOAPAhkqHqNCF6g19t9wfg2",
	 * "block_size": 1000000
	 * }
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * tagid 是 需要导出的标签
	 * encoding_aeskey 是 base64encode的加密密钥，长度固定为43，base64decode之后即得到AESKey。加密方式采用AES-256-CBC方式，数据采用PKCS#7填充至32字节的倍数；IV初始向量大小为16字节，取AESKey前16字节，详见：https://datatracker.ietf.org/doc/html/rfc2315
	 * block_size 否 每块数据的人员数和部门数之和，支持范围[104,106]，默认值为106
	 * 权限说明：
	 *
	 * 要求对标签有读取权限
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "jobid": "jobid_xxxxxxxxx"
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * jobid 任务ID，可通过获取导出结果接口查询任务结果
	 */
	public function taguser($tagid, $encoding_aeskey, $block_size)
	{
		$params = array();
		$params['tagid'] = $tagid;
		$params['encoding_aeskey'] = $encoding_aeskey;
		$params['block_size'] = $block_size;
		$rst = $this->_request->post($this->_url . 'taguser', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 获取导出结果
	 * 接口定义
	 * 请求方式：GET（HTTPS）
	 * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/export/get_result?access_token=ACCESS_TOKEN&jobid=jobid_xxxxxxxxxxxxxxx
	 *
	 * 参数说明：
	 *
	 * 参数 必须 说明
	 * access_token 是 调用接口凭证
	 * jobid 是 导出任务接口成功后返回
	 * 权限说明：
	 *
	 * 获取任务结果的调用身份需要与提交任务的一致
	 *
	 * 返回结果：
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "status": 2,
	 * "data_list": [
	 * {
	 * "url": "https://xxxxx",
	 * "size": xxx,
	 * "md5": "xxxxxxxxx"
	 * },
	 * {
	 * "url": "https://xxxxx",
	 * "size": xxx,
	 * "md5": "xxxxxxxx"
	 * }
	 * ]
	 * }
	 * 参数说明：
	 *
	 * 参数 说明
	 * errcode 返回码
	 * errmsg 对返回码的文本描述内容
	 * status 任务状态:0-未处理，1-处理中，2-完成，3-异常失败
	 * data_list 数据文件列表
	 * data_list.url 数据下载链接,支持指定Range头部分段下载。有效期2个小时
	 * data_list.size 密文数据大小
	 * data_list.md5 密文数据md5
	 *
	 *
	 * 数据格式
	 * 成员
	 * userlist内容与获取部门成员接口一致
	 *
	 * {
	 * "userlist": [
	 * {
	 * "userid": "zhangsan",
	 * "name": "张三",
	 * "department": [1, 2],
	 * "open_userid": "xxxxxx"
	 * },
	 * {
	 * "userid": "lisi",
	 * "name": "李四",
	 * "department": [1, 2],
	 * "open_userid": "xxxxxx"
	 * }
	 * ]
	 * }
	 * 成员详情
	 * userlist内容与获取部门成员详情接口一致
	 *
	 * {
	 * "userlist": [{
	 * "userid": "zhangsan",
	 * "name": "李四",
	 * "department": [1, 2],
	 * "order": [1, 2],
	 * "position": "后台工程师",
	 * "mobile": "13800000000",
	 * "gender": "1",
	 * "email": "zhangsan@gzdev.com",
	 * .....其他字段省略.....
	 * }]
	 * }
	 * 部门
	 * department内容与获取部门列表接口一致
	 *
	 * {
	 * "department": [
	 * {
	 * "id": 2,
	 * "name": "广州研发中心",
	 * "name_en": "RDGZ",
	 * "parentid": 1,
	 * "order": 10
	 * },
	 * {
	 * "id": 3,
	 * "name": "邮箱产品部",
	 * "name_en": "mail",
	 * "parentid": 2,
	 * "order": 40
	 * }
	 * ]
	 * }
	 * 标签成员
	 * userlist和partylist内容与获取标签成员接口一致
	 *
	 * {
	 * "tagname": "乒乓球协会",
	 * "userlist": [
	 * {
	 * "userid": "zhangsan",
	 * "name": "李四"
	 * }
	 * ],
	 * "partylist": [2]
	 * }
	 */
	public function getResult($jobid)
	{
		$params = array();
		$params['jobid'] = $jobid;
		$rst = $this->_request->post($this->_url . 'get_result', $params);
		return $this->_client->rst($rst);
	}
}
