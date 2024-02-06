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

		if ($vcapcha != $reqCapcha) 
		{
			$this->session->set_userdata('sessappinfouser', $reqUser);
			$this->session->set_userdata('sessappinfopass', $reqPasswd);
			$this->session->set_userdata('sessappinfopesan', "Kode captcha yang anda masukkan salah.");
			redirect ('login');
		}
		
		if(!empty($reqUser) AND !empty($reqPasswd))
		{
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