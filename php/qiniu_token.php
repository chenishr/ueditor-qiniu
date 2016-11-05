<?php 
/*************************************************************************
 * File Name:		qiniu_token.php
 * Author:			chenishr
 * Mail: 			chenishr@gmail.com 
 * Created Time:	2016年10月28日 星期五 11时26分25秒
 ************************************************************************/

use Qiniu\Http\Client;
use Qiniu\Auth;
use Qiniu\Config;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class qntoken{
	protected $ak	= '';
	protected $sk	= '';

	protected $ueditorBucket	= '';
	protected $ueditorHost	= '';

	public function __construct(){
		$config = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);
		$this->ak	= $config['qiniu-accesskey'];
		$this->sk	= $config['qiniu-secretkey'];

		$this->ueditorBucket = $config['qiniu-bucket'];
		$this->ueditorHost   = $config['qiniu-host'];
	}

	public function get_token(){
		require_once("qiniu/autoload.php");
		$auth			= new Auth($this->ak,$this->sk);
		$upload			= new UploadManager();
		$bucketManager	= new BucketManager($auth);

		$returnData		= array(
			'state'	=> 'SUCCESS',
			'key'	=> '$(key)',
			'url'	=> '$(key)',
		);
		$policy	= array(
			'returnBody'	=> json_encode($returnData),
		);

		// 生成上传 Token
		$token = $auth->uploadToken($this->ueditorBucket,null,3600,$policy);

		return $token;
	}

}
//$tk	= new qntoken();
//echo $tk->get_token();

