<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->load->view('login/login');
	}

	public function auth()
	{
		$response = array();
		if( isset($_POST['username']) )
		{					
			
			$val = $this->form_validation;  

			$val->set_rules('username', 'Username', 'trim|required|xss_clean');  
			$val->set_rules('password', 'Password', 'trim|required|xss_clean');  
			$val->set_rules('remember', 'Remember me', 'integer');
			
			if( $val->run() == false )
			{
				$msg = validation_errors("<font color=\"red\">","</font><br>");
				
				if( IS_AJAX == 1 )
				{
					$response['status'] = 0;
					$response['msg'] = $msg;
				}
				else
				{					
					set_msg( $msg );
					redirect("admin");
					exit();
				}
			}else{			
			
				if( $this->dx_auth->is_banned() )
				{
					$msg = error("Username Anda telah dibanned. Silahkan kontak administrator");
					set_log("Error login with message : $msg");
					if( IS_AJAX == 1 )
					{
						$response['status'] = 0;
						$response['msg'] = $msg;
					}
					else
					{
						set_msg( $msg );
						redirect("admin");
						exit();
					}
						
				}
				else
				{
					$username = $this->input->post('username',true);
					$password = $this->input->post('password',true);
					$remember = $this->input->post('remember');
					
					$login = $this->dx_auth->login($username, $password, $remember);
					if( $login )
					{
						set_log("User ID $username Success Login");
						if( IS_AJAX == 1 )
						{
							$response['status'] = 1;
							$response['msg'] = "Login berhasil. Mohon tunggu";
							$response['redirect'] = site_url('main');
						}
						else
						{
							redirect('dashboard');
							exit();	
						}
					}
					else
					{
						$msg = "<font color=\"red\">Username atau password Anda tidak benar</font><br>";
						set_log("User ID $username Failed login. MSG : $msg");
						if( IS_AJAX == 1 )
						{
							$response['status'] = 0;
							$response['msg'] = $msg;
						}
						else
						{
							
							set_msg( $msg );
							redirect("login");
							exit();	
						}
					}
				}
			}
			

			
			if( IS_AJAX == 1 ){
				$this->output->set_content_type('application/json')->set_output(json_encode($response));	
			}			  	
		}
		else
		{
			show_404();	
		}
	}

	public function done()
	{
		if( $this->dx_auth->is_logged_in() )
		{			
			$userid = $this->session->userdata['DX_username'];
			set_log("USER ID $userid LOGOUT");
			$this->dx_auth->logout();
		}
		redirect( _URL );
		exit();
	}
}