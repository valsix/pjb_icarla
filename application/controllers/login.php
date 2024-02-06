<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once("functions/image.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		//kauth
		// $this->load->library('session');

		$this->sessappinfopesan= $this->session->userdata("sessappinfopesan");
		$this->sessappinfouser= $this->session->userdata("sessappinfouser");
		$this->sessappinfopass= $this->session->userdata("sessappinfopass");
		$this->appuserid= $this->session->userdata("appuserid");
		$this->appusernama= $this->session->userdata("appusernama");
		$this->appusergroupid= $this->session->userdata("appusergroupid");
		$this->appuserpilihankodehak= $this->session->userdata("appuserpilihankodehak");
	}

	public function index()
	{
		if(!empty($this->appuserid))
		{
			redirect('app');
		}

		$this->session->set_userdata('sessappinfopesan', "");
		$this->session->set_userdata('sessappinfouser', "");
		$this->session->set_userdata('sessappinfopass', "");

		$data['pesan']="";
		$this->load->view('app/login', $data);
	}

	function action()
	{
		$this->load->library("crfs_protect"); $csrf = new crfs_protect('_crfs_login');
		if (!$csrf->isTokenValid($_POST['_crfs_login']))
		{
		?>
			<script language="javascript">
				alert('<?=$respon?>');
				document.location.href = 'logout';
			</script>
		<?
			exit();
		}

		$reqUser= $this->input->post("reqUser");
		$reqPasswd= $this->input->post("reqPasswd");

		$vcapcha= $this->session->userdata("capchalogin");
		$reqCapcha= $this->input->post("reqCapcha");

		// $configwsdl= $this->config;
		// $configwsdl= $configwsdl->config["ldap"];

		// $payload = array(
		// 	'username' => '9015051zjy',
		// 	'password' => 'password123!@#"}\n))'
		// );

		// $postdata = http_build_query($payload);
		// $opts = array('http' =>
		// 			array(
		// 				'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
		// 							"Content-Length: ".strlen($postdata)."\r\n".
		// 							"User-Agent:MyAgent/1.0\r\n",
		// 				'method'  => 'POST',
		// 				'content' => $postdata
		// 			)
		// 		);
		// $context  = stream_context_create($opts);
		// $result = file_get_contents($configwsdl, false, $context);
		// $check = json_decode($result,true);
		

		// var_dump($payload);exit;
		if ($vcapcha != $reqCapcha) 
		{
			$this->session->set_userdata('sessappinfouser', $reqUser);
			$this->session->set_userdata('sessappinfopass', $reqPasswd);
			$this->session->set_userdata('sessappinfopesan', "Kode captcha yang anda masukkan salah.");
			redirect ('login');
		}
		
		if(!empty($reqUser) AND !empty($reqPasswd))
		{

			// $payload = array(
			// 	'username' => $reqUser,
			// 	'password' => $reqPasswd
			// );

			// $postdata = http_build_query($payload);
			// $opts = array('http' =>
			// 			array(
			// 				'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
			// 							"Content-Length: ".strlen($postdata)."\r\n".
			// 							"User-Agent:MyAgent/1.0\r\n",
			// 				'method'  => 'POST',
			// 				'content' => $postdata
			// 			)
			// 		);
			// $context  = stream_context_create($opts);
			// $result = file_get_contents($configwsdl, false, $context);
			// $hasil = json_decode($result,true);
			// // print_r($hasil);exit;
			// $valid = $hasil["valid"];

			// // var_dump($valid);exit;

			// if($valid == 1)
			// {
			// 	$reqUser =  $hasil["nid"];
			// 	$reqPasswd=  $hasil["password"];
			// 	$this->load->model("base/Users");

			// 	$credential =  md5($reqPasswd);
			// 	$users = new Users();
			// 	$users->selectByCheckUser($reqUser, $credential);
			// 	// echo $users->query;exit;
			// 	if($users->firstRow())
			// 	{
			// 		$update = new Users();
			// 		$update->setField("USERNAME", $reqUser);
			// 		$update->setField("PASS", md5($reqPasswd));
			// 		$reqSimpan="";
			// 		if($update->update())
			// 		{
			// 			$reqSimpan=1;
			// 		}	
			// 	}
			// 	else
			// 	{
			// 		$check = new Users();
			// 		$check->selectByInternal($reqUser);
			// 		$check->firstRow();
			// 		// echo $check->query;exit;
			// 		$reqInternalId= $check->getField("PENGGUNA_INTERNAL_ID");
			// 		$reqNamaLengkap= $check->getField("NAMA_LENGKAP");
			// 		unset($check);

			// 		$insert = new Users();
			// 		$insert->setField("USERNAME", $reqUser);
			// 		$insert->setField("PASS", md5($reqPasswd));
			// 		$insert->setField("PENGGUNA_INTERNAL_ID", ValToNullDB($reqInternalId));
			// 		$insert->setField("NAMA", $reqNamaLengkap);
			// 		$reqSimpan="";
			// 		if($insert->insert())
			// 		{
			// 			$reqSimpan=1;
			// 		}	
			// 	}
			// }
			// print_r($reqSimpan);exit;
			$respon = $this->kauth->cekuserapp($reqUser,$reqPasswd);
			if($respon == "1")
			{
				redirect('app');
			}
			else if($respon == "multi")
			{
				redirect('app/gantirule');
			}
			else
			{
				$this->session->set_userdata('sessappinfouser', $reqUser);
				$this->session->set_userdata('sessappinfopass', $reqPasswd);
				$this->session->set_userdata('sessappinfopesan', "Username dan password tidak sesuai.");
				redirect ('login');
			}
		}
		else
		{
			$this->session->set_userdata('sessappinfouser', $reqUser);
			$this->session->set_userdata('sessappinfopass', $reqPasswd);
			$this->session->set_userdata('sessappinfopesan', "Masukkan username dan password.");
			redirect ('login');
		}
	}

	public function logout()
	{
		$this->kauth->unsetcekuserapp();
		redirect ('login');
	}

	public function getcapcha()
	{
		$this->kauth->settingcapcha($this->genertecapcha());
		echo $this->session->userdata("capchalogin");
	}

	function genertecapcha()
	{
		$color = substr(uniqid(), -2);
		$temuan_kode = strtoupper(substr(md5($color), 0, 5));
		return $temuan_kode;
	}

	function captcha()
	{
		session_start();
		$kode=$_GET["reqId"];
		$image = imagecreatefrompng("capcha/bg.png"); // Generating CAPTCHA

    	$foreground = imagecolorallocate($image, 13, 86, 117); // Font Color
    	$font = 'capcha/Raleway-Black.ttf';

		imagettftext($image, 20, 0, 20, 30, $foreground, $font,$kode);

		header('Content-type: image/png');
		imagepng($image);

		imagedestroy($image);

	}
}