<?php
namespace Home\Controller;
use Common\Controller\BaseController;
use Think\Controller;
use Mailgun\Mailgun;
class EmailinfoController extends Controller {
	public function send(){
		$tomail = $_POST['tomail'];
		$curtime = time();
		$_SESSION['eladevp']['mailsession'] = rand('100000','999999');
		/* if(isset($_SESSION['eladevp']['mailtime'])){
			if(($curtime-$_SESSION['eladevp']['mailtime'])>18000){
				$_SESSION['eladevp']['mailtime'] = time();
				$_SESSION['eladevp']['mailsession'] = rand('100000','999999');
			}else{
				echo 2;
			}
		}else{
			
		} */
		$_SESSION['eladevp']['restmail'] = $_POST['tomail'];
		$this->sendmail($tomail);
		echo 1;
	}
	//发送邮件
	public function sendmailing(){
		$tomail = $_POST['tomail'];
		$curtime = time();
		$_SESSION['eladevp']['mailsession'] = rand('100000','999999');
		$this->sendmail($tomail);
		echo 1;
	}
	
	public function sendgun(){
		$tomail = $_POST['tomail'];
		$curtime = time();
		$_SESSION['eladevp']['mailsession'] = rand('100000','999999');
		/* if(isset($_SESSION['eladevp']['mailtime'])){
			if(($curtime-$_SESSION['eladevp']['mailtime'])>18000){
				$_SESSION['eladevp']['mailtime'] = time();
				$_SESSION['eladevp']['mailsession'] = rand('100000','999999');
			}else{
				echo 2;
			}
		}else{
			
		} */
		$_SESSION['eladevp']['restmail'] = $_POST['tomail'];
		$this->sendmailgun($tomail);
		echo 1;
	}
	//验证是否被注册，没注册发送邮箱mailgun
	public function checkusersendgun(){
		$user = M("user");
		$where['userid'] = $_POST['tomail'];
		$rs = $user->where($where)->find();
		if($rs){
			echo 0;
		}else{
			$_SESSION['eladevp']['mailsession'] = rand('100000','999999');
			$this->sendmailgun($_POST['tomail']);
			echo 1;
		}
	}
	//验证是否被注册，没注册发送邮箱
	public function checkusersend(){
		$user = M("user");
		$where['userid'] = $_POST['tomail'];
		$rs = $user->where($where)->find();
		if($rs){
			echo 0;
		}else{
			//$curtime = time();
			//$_SESSION['eladevp']['mailsession'] = rand('100000','999999');
			//$this->sendmail($_POST['tomail']);
			echo 1;
		}
	}
	//直接发送邮件
	//public function 
	public function sendmailgun($tomail){
	/* 	var_dump(C('MAILGUN_KEY'));
		var_dump(C('MAIlGUN_DOMAIN'));
		var_dump(C('FROM_MAIlGUN_DOMAIN')); 
		var_dump($tomail); */
		$mg = Mailgun::create(C('MAILGUN_KEY'));
		$mg->messages()->send(C('MAIlGUN_DOMAIN'), [
		  'from'    => C('FROM_MAIlGUN_DOMAIN'),
		  'to'      => $tomail,
		  'subject' => 'Elastos developer reset password code',
		  'text'    => 'The code:'.$_SESSION['eladevp']['mailsession']
		]);
	}
	public function sendmail($tomail){
		/* $mg = Mailgun::create(C('MAILGUN_KEY'));
		$mg->messages()->send(C('MAIlGUN_DOMAIN'), [
		  'from'    => C('FROM_MAIlGUN_DOMAIN'),
		  'to'      => $tomail,
		  'subject' => 'Elastos developer reset password code',
		  'text'    => 'The code:'.$_SESSION['eladevp']['mailsession']
		]);
		
		$email = new \SendGrid\Mail\Mail(); 
		$email->setFrom(C('FROM_SENDGRID_MAIL'), "F User");
		$email->setSubject("Elastos developer Email code");
		$email->addTo($tomail, "T User");
		$email->addContent("text/plain", "The code:".$_SESSION['eladevp']['mailsession']);
		$sendgrid = new \SendGrid(getenv(C('SENDGRID_KEY')));
		try {
			$response = $sendgrid->send($email);
		} catch (Exception $e) {
		}*/
		$rs = SendMail($tomail,"Confirmation Code","Confirmation Code：".$_SESSION['eladevp']['mailsession']."<p></p><p></p><p>Thanks<br>Elastos team</p>");
	}
	public function checkmailcode(){
		$mailcode = $_POST['mailcode'];
		if($_SESSION['eladevp']['mailsession']==$mailcode){
			echo 1;
		}else{
			echo 0;
		}
	}
	//验证码且加入用户表
	public function checkmailcodeandadd(){
		$mailcode = $_POST['mailcode'];
		$uid = $_POST['uid'];
		$upwd = $_POST['upwd'];
		if($_SESSION['eladevp']['mailsession']==$mailcode){
			$data['userid'] = $uid;
			$data['userpwd'] = md5($upwd);
			$data['logintime'] = time();
			$data['addtime'] = time();
			$data['subucate'] = 1;
			$data['email'] = $uid;
			$user = M("user");
			$rs = $user->add($data);
			if($rs){
				$userrelation = M("userrelation");
				$dataa['mainuser'] = $uid;
				$dataa['reguserid'] = $uid;
				$dataa['ustatus'] = 1;
				$rsc = $userrelation->add($dataa);
				if($rsc){
					$_SESSION ['eladevp']['logincate'] = 1;
					$_SESSION ['eladevp']['userid'] = $uid;	
					$_SESSION['eladevp']['userheadimg'] = "";
					echo 1;				
				}else{
					echo 0;
				}
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
	}
	//重置密码
	public function resetpwd(){
		$where['userid'] = $_SESSION['eladevp']['restmail'];
		$data['userpwd'] = md5($_POST['npwd']);
		$user = M("user");
		$rs = $user->where($where)->save($data);
		if($rs){
			echo 1;
		}else{
			echo 0;
		}
	}
}