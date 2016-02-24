<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->library('tank_auth');
		$this->load->library('rd_func');
		$this->load->library('pagination');
		$this->load->library('table');
		if (!$this->tank_auth->is_logged_in())
		{
			redirect('/auth/login/');
		}
	}
	function index()
	{
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'home';
		$this->load->view('theme/containt', $data);
	}
	//*agent detail form */
	function agent_form()
	{
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'agent_detail';
		$this->load->view('theme/containt', $data);
	}
	function agent_detail_post()
	{
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->form_validation->set_rules('agent_name', 'Agent Name','trim|strip_tags');
		$this->form_validation->set_rules('agent_code', 'Agent Code','trim|strip_tags');
		$this->form_validation->set_rules('valid_up_to', 'Agent Name','trim|strip_tags');
		$this->form_validation->set_rules('limit', 'limit','trim|strip_tags|integer');
		$this->form_validation->set_rules('limit', 'limit','trim|strip_tags');
		if($this->form_validation->run() === false)
		{
			$this->agent_form();
		}
		else
		{
			$data = array(
				'userid' =>$this->tank_auth->get_user_id(),
			      'agent_name'=> $this->input->post('agent_name'),
			      'agent_code'=> $this->input->post('agent_code'),
			      'valid_up_to'=> $this->input->post('valid_up_to'),
			      'limit'=> (int)$this->input->post('limit'),
			      'pan'=> $this->input->post('pan'),
			      );
		$field_value = array(
				     'userid'=>$this->tank_auth->get_user_id()
				     );
			if($this->logic->global_where('agent_detail', $field_value) <=1)
			{
				$this->logic->global_insert('agent_detail', $data);
				redirect('welcome/agent_form?message=Agent detail successful insert!');
			}
			else
			{
				$this->logic->global_update('agent_detail',array('id'=>$this->tank_auth->get_user_id()),$data);
				redirect('welcome/agent_form?message=Agent detail successful update!');
			}
		}
	}
	//new account form display//
	function new_account_form()
	{
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'depositer';
		$this->load->view('theme/containt', $data);
	}
	//submit new account
	function new_account()
	{
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->form_validation->set_rules('name','Name','required|strtolower'); 
		$this->form_validation->set_rules('father_name',"Father's Name",'');
		$this->form_validation->set_rules('mobile_no','Mobile No.','integer|exact_length[10]');
		$this->form_validation->set_rules('deposit_date','Deposit Date','required|strtotime'); 
		$this->form_validation->set_rules('account_no', 'Account No', 'required|is_unique[account_holder.account_no]');
		$this->form_validation->set_rules('opening_amount','Opening Amount','required|integer');
		$this->form_validation->set_rules('rd_amount','RD Amount','required|integer');
		$this->form_validation->set_rules('remark','Remark','xss_clean');
		$this->form_validation->set_rules('dob','DOB','strtotime'); 
		
		if($this->form_validation->run() == false)
		{
			
			$this->new_account_form();
		}
		else
		{
			
			if(is_dir('./upload/agen_id_'.$this->tank_auth->get_user_id()) != 1)
			{
				mkdir('./upload/agen_id_'.$this->tank_auth->get_user_id());
				
			}
			if(is_dir('./upload/agen_id_'.$this->tank_auth->get_user_id().'/thumbs') != 1)
			{
				mkdir('./upload/agen_id_'.$this->tank_auth->get_user_id().'/thumbs');
			}
			$config['upload_path'] = "./upload/agen_id_".$this->tank_auth->get_user_id();
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '10000';
			$config['max_width']  = '1024';
			$config['max_height']  = '1028';
	
			$this->load->library('upload', $config);
	
			if ( ! $this->upload->do_upload())
			{
				$data['error'] = array('error' => $this->upload->display_errors());
				$data['user_id']	= $this->tank_auth->get_user_id();
				$data['username']	= $this->tank_auth->get_username();
				$data['page']		= 'depositer';
				
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
			}
			
			if(isset($data['upload_data']['file_name']))
			{
				
				$sign_path = "/upload/agen_id_".$this->tank_auth->get_user_id()."/";
				$sign_path .= $data['upload_data']['file_name'];
				
				
				$config1 = array(
					'source_image' 	=> '.'.$sign_path, //get original image
					'new_image' 	=> './upload/agen_id_'.$this->tank_auth->get_user_id().'/thumbs', //save as new image //need to create thumbs first
					'maintain_ratio' => true,
					'width' => 170,
					'height' => 140	       
					);
				$this->load->library('image_lib', $config1); //load library
				$this->image_lib->resize(); //generating thumb
				$thumb_file = 'upload/agen_id_'.$this->tank_auth->get_user_id().'/thumbs/'.$data['upload_data']['file_name'];
			}
			else
			{
				$thumb_file='/default_sign/signature5.jpg';
				$sign_path = '/default_sign/signature5.jpg';
			}
			
			$data = array(
					'agent_id' => $this->tank_auth->get_user_id(),
				      'name' => $this->input->post('name'),
				      'father_name' => $this->input->post('father_name'),
				      'husband_name'=>$this->input->post('husband_name'),
				      'mother_name' => $this->input->post('mother_name'),
				      'nominee_name' => $this->input->post('nominee_name'),
				      'dob' => $this->input->post('dob'),
				      'address' => $this->input->post('address'),
				      'mobile_no' => $this->input->post('mobile_no'),
				      'account_no'=>$this->input->post('account_no'),
				      'account_oping_date' => $this->input->post('deposit_date'),
					'rd_amount' => $this->input->post('rd_amount'),
					'remark' => $this->input->post('remark'),
					'sign_image' => $sign_path,
					'thumbs' => $thumb_file,
				      );
		
			$insert_id = $this->logic->global_insert('account_holder', $data);
			$opening_amount = array(
						'depositor_id' => $insert_id,
						'o_amount' =>$this->input->post('opening_amount'),
						);
			$open_account_insert_id = $this->logic->global_insert('opening_amount', $opening_amount);
			if(($insert_id <=0) AND ($open_account_insert_id  <=0))
			{
				echo "Not add";
				//$this->new_account_form();
			}
			else
			{
				$this->successful_add($insert_id, "<h3> Record have successful insert</h3>");
			}
		}
	}
	//submit new account
	function add_join_account()
	{
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->form_validation->set_rules('name','1st Account Holder Name','required|strtolower'); 
		$this->form_validation->set_rules('father_name',"1st Account Holder Father's Name",'');
		$this->form_validation->set_rules('husband_name',"1st Account Holder  Husband Name",'');
		$this->form_validation->set_rules('mobile_no','1st Account Holder Mobile No.','integer|exact_length[10]');
		$this->form_validation->set_rules('nominee_name','1st Account Holder nominee_name','xss_clean');
		$this->form_validation->set_rules('address','1st Account Holder Mobile No.','xss_clean');
		$this->form_validation->set_rules('dob','1st Account Holder DOB','strtotime|required');
		
		$this->form_validation->set_rules('name1','2nd Account Holder Name','required|strtolower'); 
		$this->form_validation->set_rules('father_name1',"2nd Account Holder Father's Name",'');
		$this->form_validation->set_rules('husband_name1',"2nd Account Holder Husband Name",'');
		$this->form_validation->set_rules('mobile_no1','2nd Account Holder Mobile No.','integer|exact_length[10]');
		$this->form_validation->set_rules('nominee_name1','2nd Account Holder nominee_name','xss_clean');
		$this->form_validation->set_rules('address1','2nd Account Holder Mobile No.','xss_clean');
		$this->form_validation->set_rules('dob1','2st Account Holder DOB','strtotime|required');
		
		$this->form_validation->set_rules('deposit_date','Deposit Date','required|strtotime'); 
		$this->form_validation->set_rules('account_no', 'Account No', 'required|is_unique[account_holder.account_no]');
		$this->form_validation->set_rules('opening_amount','Opening Amount','required|integer');
		$this->form_validation->set_rules('rd_amount','RD Amount','required|integer');
		$this->form_validation->set_rules('remark','Remark','xss_clean');
		
		
		if($this->form_validation->run() == false)
		{
			
			$this->join_account_depositer();
		}
		else
		{
			
			if(is_dir('./upload/agen_id_'.$this->tank_auth->get_user_id()) != 1)
			{
				mkdir('./upload/agen_id_'.$this->tank_auth->get_user_id());
				
			}
			if(is_dir('./upload/agen_id_'.$this->tank_auth->get_user_id().'/thumbs') != 1)
			{
				mkdir('./upload/agen_id_'.$this->tank_auth->get_user_id().'/thumbs');
			}
			$config['upload_path'] = "./upload/agen_id_".$this->tank_auth->get_user_id();
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '10000';
			$config['max_width']  = '1024';
			$config['max_height']  = '1028';
	
			$this->load->library('upload', $config);
	
			if ( ! $this->upload->do_upload())
			{
				$data['error'] = array('error' => $this->upload->display_errors());
				$data['user_id']	= $this->tank_auth->get_user_id();
				$data['username']	= $this->tank_auth->get_username();
				$data['page']		= 'depositer';
				
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
			}
			
			if(isset($data['upload_data']['file_name']))
			{
				
				$sign_path = "/upload/agen_id_".$this->tank_auth->get_user_id()."/";
				$sign_path .= $data['upload_data']['file_name'];
				
				
				$config1 = array(
					'source_image' 	=> '.'.$sign_path, //get original image
					'new_image' 	=> './upload/agen_id_'.$this->tank_auth->get_user_id().'/thumbs', //save as new image //need to create thumbs first
					'maintain_ratio' => true,
					'width' => 170,
					'height' => 140	       
					);
				$this->load->library('image_lib', $config1); //load library
				$this->image_lib->resize(); //generating thumb
				$thumb_file = 'upload/agen_id_'.$this->tank_auth->get_user_id().'/thumbs/'.$data['upload_data']['file_name'];
			}
			else
			{
				$thumb_file='/default_sign/signature5.jpg';
				$sign_path = '/default_sign/signature5.jpg';
			}
			
			$data = array(
					'agent_id' => $this->tank_auth->get_user_id(),
				      'name' => $this->input->post('name'),
				      'father_name' => $this->input->post('father_name'),
				      'husband_name'=>$this->input->post('husband_name'),
				      'mother_name' => $this->input->post('mother_name'),
				      'nominee_name' => $this->input->post('nominee_name'),
				      'dob' => $this->input->post('dob'),
				      'address' => $this->input->post('address'),
				      'mobile_no' => $this->input->post('mobile_no'),
				      
				      
				      'name1' => $this->input->post('name1'),
				      'father_name1' => $this->input->post('father_name1'),
				      'husband_name1'=>$this->input->post('husband_name1'),
				      'mother_name1' => $this->input->post('mother_name1'),
				      'nominee_name1' => $this->input->post('nominee_name1'),
				      'dob1' => $this->input->post('dob1'),
				      'join_account' =>1,
				      'address1' => $this->input->post('address1'),
				      'mobile_no1' => $this->input->post('mobile_no1'),
				      
				      'account_no'=>$this->input->post('account_no'),
				      'account_oping_date' => $this->input->post('deposit_date'),
					'rd_amount' => $this->input->post('rd_amount'),
					'remark' => $this->input->post('remark'),
					'sign_image' => $sign_path,
					'thumbs' => $thumb_file,
				      );
		
			$insert_id = $this->logic->global_insert('account_holder', $data);
			$opening_amount = array(
						'depositor_id' => $insert_id,
						'o_amount' =>$this->input->post('opening_amount'),
						);
			$open_account_insert_id = $this->logic->global_insert('opening_amount', $opening_amount);
			if(($insert_id <=0) AND ($open_account_insert_id  <=0))
			{
				echo "Not add";
				//$this->new_account_form();
			}
			else
			{
				$this->successful_join_account_insert($insert_id, "<h3> Record have successful insert</h3>");
			}
		}
	}
	
	//deposit date
	function deposit_date_form()
	{
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'deposit_date';
		$this->load->view('theme/containt', $data);
	}
	//deposit date
	function deposit_date()
	{
		
		$this->form_validation->set_rules('lot_date', 'Lot Date', 'callback_lot_date_check|trim');
		$this->form_validation->set_rules('lot_no', 'Lot No', 'integer|required||trim');
		$this->form_validation->set_rules('batch_no', 'Batch No', 'required|xss_clean|trim');
		if($this->form_validation->run() == false)
		{
			$this->deposit_form();
		}
		else
		{
			$field_value = array(
				'lot_no' => $this->input->post('lot_no'),
				'batch_no' => strtoupper($this->input->post('batch_no')),
				'lot_agent_code' =>$this->tank_auth->get_user_id(),
					     );
			$rows = $this->logic->global_where('lot_detail', $field_value);
			if($rows->num_rows() <= 0)
			{
				$data = array(
					'lot_no'=>$this->input->post('lot_no'), 
					'batch_no' => strtoupper($this->input->post('batch_no')),
				      'lot_date' =>strtotime($this->input->post('lot_date')),				      
				      'lot_agent_code' =>$this->tank_auth->get_user_id(),
				      );
				$this->logic->global_insert('lot_detail', $data);
				$this->session->set_userdata($data);
				redirect('welcome/deposit_form?message= Lot number and date successfully inserted!');
			}
			else
			{
				foreach($rows->result() as $get_row)
				{
					$data = array(
						      'lot_no' => $get_row->lot_no,
						      'batch_no' => strtoupper($get_row->batch_no),
							'lot_date'=>$get_row->lot_date,
						     );
					$this->session->set_userdata($data);
					redirect('welcome/deposit_form?message= This lot number is already exists!');
				}
			}
			
		}
		
	}
	function lot_date_check()
	{
		$field_where = array(
				     'lot_no'=> $this->input->post('lot_no'),
				     'batch_no'=> $this->input->post('batch_no'),
				     'lot_agent_code'=>$this->tank_auth->get_user_id(),
				     );
		if((($this->logic->global_where('lot_detail',$field_where)->num_rows())  >= 1) OR ($this->input->post('lot_date') != NULL))
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('lot_date_check', 'Lot date is required!');
			return false;
		}
	}
	//deposit amount form
	function deposit_form()
	{
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'deposit_amount';
		$data['total_deposit']	= $this->db_deposit_amount();
		if($data['total_deposit'] >= 1)
		{
			
			$data['commission'] = 0;
			$data['net_tendered_amt'] = $data['total_deposit'];
			$data['tds'] = 0;
			$data['net_amount'] =$data['total_deposit'];
			
			if($data['total_deposit'] >= 20000)
			{
				$data['commission'] = 800;
				$data['net_tendered_amt'] = ($data['total_deposit']-800);
				$data['tds'] = (800*10)/100;
				$data['net_amount'] =$data['total_deposit']-$data['commission']+$data['tds'];
			}
			/* New edit commission*/
			else
			{
				$data['commission'] = ($data['total_deposit']*4)/100;
				$data['net_tendered_amt'] = ($data['total_deposit']-$data['commission']);
				$data['tds'] = ($data['commission']*10)/100;
				$data['net_amount'] =$data['total_deposit']-$data['commission']+$data['tds'];
			}
		}
		$this->load->view('theme/containt', $data);
	}
	//join account depositer form //
	function join_account_depositer()
	{
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'join_account_depositer';
		$this->load->view('theme/containt', $data);
	}

	//deposit amount save
	function deposit()
	{
		
		if(($this->session->userdata('lot_no')) AND ($this->session->userdata('batch_no')) AND($this->input->post('month')))
		{
			$field_value = array(
					     'lot_no' => $this->session->userdata('lot_no'),
					     'batch_no' => $this->session->userdata('batch_no')
					     );
			$rows = $this->logic->global_where('lot_detail', $field_value);
			if($rows->num_rows() > 0)
			{
				foreach($rows->result() as $row)
				{
					$dblotid = $row->id;
				}
			}
			
			$this->form_validation->set_error_delimiters('<samp class="error">', '</samp>');
			$this->form_validation->set_rules('depositor_id', 'Depositor_id', 'required|trim|integer|callback_deplot_check');
			$this->form_validation->set_rules('amount_deposited', 'Amount Deposited', 'required|trim|integer');
			$this->form_validation->set_rules('def', 'Def', 'trim|integer');
			$this->form_validation->set_rules('remark', 'Remark', 'trim|integer|xss_clean');
			if($this->form_validation->run() == TRUE)
			{
				$start_month = '';
				$adv ='';
				if($this->input->post('adv') == 1)
				{
					$start_month = strtotime($this->input->post('adv_month'));
					$adv = $this->input->post('adv_calcul');
				}
				
				$data = array(
				'depositor_id' => $this->input->post('depositor_id'),
				'lot_id' => $dblotid,
				'amount_deposited' => $this->input->post('amount_deposited'),
				'balance' => $this->input->post('balance'),
				'month' => strtotime($this->input->post('month')),
				'def' => $this->input->post('def'),
				'start_month' => $start_month,
				'adv' =>$adv,
				//'open_date' => $this->input->post('open_date'),
				'remark' => $this->input->post('remark'),
				);
				$where_field = array(
					'depositor_id'=>$this->input->post('depositor_id')
						     );
				
				$get_deposit =	$this->logic->global_where('deposit_amount', $where_field);
				if($get_deposit->num_rows>0)
				{
					foreach($get_deposit->result() as $row)
					{
						$dbmonth = $row->month;
					}
				}
				else
				{
					$dbmonth 	= 	strtotime($this->input->post('month'));
				}
					$def_query 	=	$this->logic->global_where('def', array('account_no'=>$this->input->post('depositor_id'), 'last_insert'=>1));
					$dep_id 	= 	$this->logic->global_insert('deposit_amount', $data);
					
					if($this->input->post('adv_calcul')>0)
					{
						$adv = $this->input->post('adv_calcul');
						$end_date = strtotime(date('d-m-Y',strtotime($this->input->post('month')))."+1 month"); 
						$end_date = strtotime($this->input->post('month'));
					}
					else
					{
						$end_date = strtotime($this->input->post('month'));
					}
				
					
					if($def_query->num_rows()>0)
					{
						$start_date ='';
						foreach($def_query->result() as $row)
						{
							$start_date = $row->end_date;
						}
						$start_date = strtotime(date('d-m-Y',$start_date)."+1 month");
						$this->logic->global_update('def',array('account_no'=>$this->input->post('depositor_id'), 'last_insert'=>1), array('last_insert'=>0));
						$db_def = array(
						'lot_id'=>$dblotid,
						'dep_id'=>$dep_id,
						'account_no'=>$this->input->post('depositor_id'),
						'start_date'=>$start_date,
						'end_date'=>$end_date,
						'def' => $this->input->post('def'),
						'adv_amount'=>$adv,
						'last_insert'=>1
						);
						$this->logic->global_insert('def', $db_def);						
					}
					else
					{
						$db_def = array(
						'lot_id'=>$dblotid,
						'dep_id'=>$dep_id,
						'account_no'=>$this->input->post('depositor_id'),
						'start_date'=>$dbmonth,
						'end_date'=>$end_date,
						'def' => $this->input->post('def'),
						'adv_amount'=>$adv,
						'last_insert'=>1
						);
						$this->logic->global_insert('def', $db_def);
					}		
					$this->deposit_form();
			}
			else
			{
				$this->deposit_form();
			}
		}
		else
		{
			redirect('welcome/deposit_form?message= Please select Lot no and Lot date!');
		}
	}
	
	/*deposit lot check */
	function deplot_check()
	{
			$field_value = array(
					     'lot_no' => $this->session->userdata('lot_no'),
					     'batch_no' => $this->session->userdata('batch_no')
					     );
			$rows = $this->logic->global_where('lot_detail', $field_value);
			$dblotid = '';
			if($rows->num_rows() > 0)
			{
				foreach($rows->result() as $row)
				{
					$dblotid = $row->id;
				}
			}
		
		$field_value = array(
					     'lot_id' => $dblotid,
					     'depositor_id' =>$this->input->post('depositor_id')
					     );
		$rows = $this->logic->global_where('deposit_amount', $field_value);
		if($rows->num_rows()<=0)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('deplot_check', 'Amount already deposit!');
			return false;
		}
	}
	/**/
	function successful_add($insert_id = NULL, $user_message= NULL)
	{
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'successfull_enter';
		$field_where 		= array(
						'id' => $insert_id
						);
		$data['user_message'] = $user_message;
		$data['add_record']     = $this->logic->global_where('account_holder', $field_where);
		$this->load->view('theme/containt', $data);	
	}
	/* successful join account insert*/
	function successful_join_account_insert($insert_id = NULL, $user_message= NULL)
	{
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'successful_join_account_insert';
		$field_where 		= array(
						'id' => $insert_id
						);
		$data['user_message'] = $user_message;
		$data['add_record']     = $this->logic->global_where('account_holder', $field_where);
		$this->load->view('theme/containt', $data);	
	}
	
	//edit depositer detail //
	function edit_depositer()
	{
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->form_validation->set_rules('name','Name','required|strtolower'); 
		$this->form_validation->set_rules('father_name',"Father's Name",'');
		$this->form_validation->set_rules('mobile_no','Mobile No.','integer|exact_length[10]');
		$this->form_validation->set_rules('deposit_date','Deposit Date','required|strtotime'); 
		//$this->form_validation->set_rules('account_no', 'Account No', 'required|is_unique[account_holder.account_no]');
		//$this->form_validation->set_rules('opening_amount','Opening Amount','required|integer');
		$this->form_validation->set_rules('rd_amount','RD Amount','required|integer');
		$this->form_validation->set_rules('remark','Remark','xss_clean');
		$this->form_validation->set_rules('dob','DOB','strtotime');
		if($this->form_validation->run() == false)
		{
			$this->successful_add((int)$this->input->post('id'));
		}
		else
		{
			$field_where = array(
			'id'=>$this->input->post('id'),
				     );
			$data_update = array(
				
					'agent_id' => $this->tank_auth->get_user_id(),
				      'name' => $this->input->post('name'),
				      'father_name' => $this->input->post('father_name'),
				      'husband_name'=>$this->input->post('husband_name'),
				      'mother_name' => $this->input->post('mother_name'),
				      'nominee_name' => $this->input->post('nominee_name'),
				      'dob' => strtotime($this->input->post('dob')),
				      'address' => $this->input->post('address'),
				      'mobile_no' => $this->input->post('mobile_no'),
				      //'account_no'=>$this->input->post('account_no'),
				      'account_oping_date' => strtotime($this->input->post('deposit_date')),
					'rd_amount' => $this->input->post('rd_amount'),
					'remark' => $this->input->post('remark'),
					//'sign_image' => $sign_path,
					//'thumbs' => $thumb_file,
				      );
			$this->logic->global_set('account_holder', $field_where, $data_update);
			$this->successful_add($this->input->post('id'), "<h3> Record have successful insert</h3>");
		}
		/*
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->form_validation->set_rules('name','Name','required|strtolower'); 
		$this->form_validation->set_rules('father_name',"Father's Name",'');
		$this->form_validation->set_rules('mobile_no','Mobile No.','integer|exact_length[10]');
		$this->form_validation->set_rules('deposit_date','Deposit Date','required|strtotime'); 
		//$this->form_validation->set_rules('account_no', 'Account No', 'required|is_unique[account_holder.account_no]');
		$this->form_validation->set_rules('opening_amount','Opening Amount','required|integer');
		$this->form_validation->set_rules('rd_amount','RD Amount','required|integer');
		$this->form_validation->set_rules('remark','Remark','xss_clean');
		$this->form_validation->set_rules('dob','DOB','strtotime'); 
		
		if($this->form_validation->run() == false)
		{
			
			$this->edit_depositer();
		}
		else
		{
			
			if(is_dir('./upload/agen_id_'.$this->tank_auth->get_user_id()) != 1)
			{
				mkdir('./upload/agen_id_'.$this->tank_auth->get_user_id());
				
			}
			if(is_dir('./upload/agen_id_'.$this->tank_auth->get_user_id().'/thumbs') != 1)
			{
				mkdir('./upload/agen_id_'.$this->tank_auth->get_user_id().'/thumbs');
			}
			$config['upload_path'] = "./upload/agen_id_".$this->tank_auth->get_user_id();
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '10000';
			$config['max_width']  = '1024';
			$config['max_height']  = '1028';
	
			$this->load->library('upload', $config);
	
			if ( ! $this->upload->do_upload())
			{
				$data['error'] = array('error' => $this->upload->display_errors());
				$data['user_id']	= $this->tank_auth->get_user_id();
				$data['username']	= $this->tank_auth->get_username();
				$data['page']		= 'successfull_enter';
				
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
			}
			
			if(isset($data['upload_data']['file_name']))
			{
				
				$sign_path = "/upload/agen_id_".$this->tank_auth->get_user_id()."/";
				$sign_path .= $data['upload_data']['file_name'];
				
				
				$config1 = array(
					'source_image' 	=> '.'.$sign_path, //get original image
					'new_image' 	=> './upload/agen_id_'.$this->tank_auth->get_user_id().'/thumbs', //save as new image //need to create thumbs first
					'maintain_ratio' => true,
					'width' => 170,
					'height' => 140	       
					);
				$this->load->library('image_lib', $config1); //load library
				$this->image_lib->resize(); //generating thumb
				$thumb_file = 'upload/agen_id_'.$this->tank_auth->get_user_id().'/thumbs/'.$data['upload_data']['file_name'];
			}
			else
			{
				$thumb_file='/default_sign/signature5.jpg';
				$sign_path = '/default_sign/signature5.jpg';
			}
			
				
		}
			*/
		
		
	}
	/* Edit join Account */
	function edit_join_account()
	{
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->form_validation->set_rules('name','1st Account Holder Name','required|strtolower'); 
		$this->form_validation->set_rules('father_name',"1st Account Holder Father's Name",'');
		$this->form_validation->set_rules('husband_name',"1st Account Holder  Husband Name",'');
		$this->form_validation->set_rules('mobile_no','1st Account Holder Mobile No.','integer|exact_length[10]');
		$this->form_validation->set_rules('nominee_name','1st Account Holder nominee_name','xss_clean');
		$this->form_validation->set_rules('address','1st Account Holder Mobile No.','xss_clean');
		$this->form_validation->set_rules('dob','1st Account Holder DOB','strtotime|required');
		
		$this->form_validation->set_rules('name1','2nd Account Holder Name','required|strtolower'); 
		$this->form_validation->set_rules('father_name1',"2nd Account Holder Father's Name",'');
		$this->form_validation->set_rules('husband_name1',"2nd Account Holder Husband Name",'');
		$this->form_validation->set_rules('mobile_no1','2nd Account Holder Mobile No.','integer|exact_length[10]');
		$this->form_validation->set_rules('nominee_name1','2nd Account Holder nominee_name','xss_clean');
		$this->form_validation->set_rules('address1','2nd Account Holder Mobile No.','xss_clean');
		$this->form_validation->set_rules('dob1','2st Account Holder DOB','strtotime|required');
		
		$this->form_validation->set_rules('deposit_date','Deposit Date','required|strtotime'); 
		//$this->form_validation->set_rules('account_no', 'Account No', 'required|is_unique[account_holder.account_no]');
		//$this->form_validation->set_rules('opening_amount','Opening Amount','required|integer');
		$this->form_validation->set_rules('rd_amount','RD Amount','required|integer');
		$this->form_validation->set_rules('remark','Remark','xss_clean');
		
		
		if($this->form_validation->run() == false)
		{
			$this->successful_join_account_insert($this->input->post('id'), "<h3>Please Update Again!</h3>");
		}
		else
		{
			$field_where = array(
			'id'=>$this->input->post('id'),
				     );
			$data_update = array(
				
				'agent_id' => $this->tank_auth->get_user_id(),
				      'name' => $this->input->post('name'),
				      'father_name' => $this->input->post('father_name'),
				      'husband_name'=>$this->input->post('husband_name'),
				      'mother_name' => $this->input->post('mother_name'),
				      'nominee_name' => $this->input->post('nominee_name'),
				      'dob' => $this->input->post('dob'),
				      'address' => $this->input->post('address'),
				      'mobile_no' => $this->input->post('mobile_no'),
				      
				      
				      'name1' => $this->input->post('name1'),
				      'father_name1' => $this->input->post('father_name1'),
				      'husband_name1'=>$this->input->post('husband_name1'),
				      'mother_name1' => $this->input->post('mother_name1'),
				      'nominee_name1' => $this->input->post('nominee_name1'),
				      'dob1' => $this->input->post('dob1'),
				      'join_account' =>1,
				      'address1' => $this->input->post('address1'),
				      'mobile_no1' => $this->input->post('mobile_no1'),
				      
				      //'account_no'=>$this->input->post('account_no'),
				      'account_oping_date' => $this->input->post('deposit_date'),
					'rd_amount' => $this->input->post('rd_amount'),
					'remark' => $this->input->post('remark'),
					//'sign_image' => $sign_path,
					//'thumbs' => $thumb_file,
				      );
			$this->logic->global_set('account_holder', $field_where, $data_update);
			$this->successful_join_account_insert($this->input->post('id'), "<h3> Record have successful insert</h3>");
		}
	}
	//deposit record form
	function deposit_record_form()
	{
		
	}
	//deposit record
	function deposit_record()
	{
		
	}
	//how many account close
	function account_close()
	{
		
	}
	
	
	//other function
	
	function geting_depositor_name()
	{
		$field_value = array(
				     'account_no' => $this->input->post('account_number'),
				     'agent_id' =>$this->tank_auth->get_user_id(),
				     );
		$record = $this->logic->global_where('account_holder', $field_value);
		$join_where = array(
				    'account_no' =>$this->input->post('account_number')
				    );
		$join_record = $this->logic->where_join($join_where);
		if($record->num_rows()<=0)
		{
			echo json_encode(array(
				  'name'=>'',
				  'account_opening_date'=>'',
				  'rd_amount'=>'',
				  ));
		}
		else
		{
			foreach($record->result() as $row)
			{
				$name = $row->name;
				$account_oping_date = $row->account_oping_date;
				$rd_amount = $row->rd_amount;
			}
			foreach($join_record->result() as $row)
			{
				$opening_amount = $row->o_amount;
				$depositor_id  = $row->depositor_id;
			}
			/* code for calculate total balance of account*/
			$get_amount = $this->logic->get_amount('opening_amount.depositor_id', $depositor_id, 'amount_deposited');
			foreach($get_amount->result() as $row)
			{
				$balance = $row->amount_deposited;
			}
			/*End of total balace of account*/
			
			
			/*panalty calculation call method*/
			 $penalty_cal= $this->penalty_cal($depositor_id, $this->session->userdata('lot_date'));
			 $def = $penalty_cal['interval'];
			/*end panalty calculation method */
			
			if($def >= 6)
			{
				echo json_encode(array(
				  'name'=>$name."( A/c is close)",
				 // 'account_opening_date'=>date('d-m-Y',$account_oping_date),
				  'balance'=>'',
				  'rd_amount'=>'',
				  'depositor_id'=> $depositor_id,
				  'def'=>'',
				  'month'=>'',
				  ));
			}
			else
			{
				
				/*this code i will change */
				$data['total_deposit']	= $this->db_deposit_amount();
					$data['commission'] = '';
					$data['net_tendered_amt'] = '';
					$data['tds'] = '';
					$data['net_amount'] = '';
				if($data['total_deposit'] >= 1)
				{
					$data['commission'] = 0;
					$data['net_tendered_amt'] = $data['total_deposit']+$rd_amount;
					$data['tds'] = 0;
					$data['net_amount'] =$data['total_deposit']+$rd_amount;
					if($data['total_deposit'] >= 20000)
					{
						$data['commission'] = 800;
						$data['net_tendered_amt'] = (($data['total_deposit']+$rd_amount)-800);
						$data['tds'] = (800*10)/100;
						$data['net_amount'] =$data['net_tendered_amt']+$data['tds'];
					}
					else
					{
						$data['commission'] = ($data['total_deposit']*4)/100;
						$data['net_tendered_amt'] = (($data['total_deposit']+$rd_amount)-800);
						$data['tds'] = ($data['commission']*10)/100;
						$data['net_amount'] =$data['net_tendered_amt']+$data['tds'];
					}
				}
				
				/************************/
								
				$def_amount = 0;
				for($n=1;$n<=$def;$n++)
				{
					$def_amount = $def_amount+($rd_amount*2/100)*$n;
				}
				
				echo json_encode(array(
				  'name'=>ucwords($name),
				  'account_opening_date'=>date('d-m-Y',$account_oping_date),
				  'balance'=>$opening_amount+$balance+(($rd_amount*$def)+$rd_amount),
				  'rd_amount'=> ($rd_amount*$def)+$rd_amount,
				  'depositor_id'=> $depositor_id,
				  'def'=>$def_amount,       //($rd_amount*($def*2))/100,
				  'adv_amount'=> $penalty_cal['adv_amount'],
				  'start_month'=> date('d-M-Y',$penalty_cal['dbmonth']),
				  'month'=>date('d-M-Y',$penalty_cal['dbmonth']),//date('d-M-Y', $this->session->userdata('lot_date')),
				  'total_deposit_amount' => ($this->db_deposit_amount()+$rd_amount),
				  'commision'=> $data['commission'],
				  'net_tendered_amt'=> $data['net_tendered_amt'],
				  'tds'=>$data['tds'],
				  'net_amount'=>$data['net_amount'],
				  ));
			}
			//echo $_POST['account_number'];
		}
	}
	private function penalty_cal($depositor_id, $lot_date =NULL, $find_adv=0)
	{
		$dbmonth ='';
		$adv_amount ='';
		$get_row = $this->logic->global_where('def', array('account_no'=>$depositor_id,'last_insert'=>1));
		if($get_row->num_rows >0)
		{
			foreach($get_row->result() as $row)
			{
				 $dbmonth = $row->end_date;
				 $adv_amount = $row->adv_amount;
			}
			if($adv_amount>0)
			{
				$db_start_month = $dbmonth; 
				$db_end_month = $lot_date;
				$d1 = $db_start_month ;
				$d2 = $db_end_month;
				$db_start_month = strtotime(date('d-m-Y',$dbmonth)."+1 month");
				$interval = abs((date('Y', $d2) - date('Y', $d1))*12 + (date('m', $d2) - date('m', $d1)));
				if($dbmonth>$lot_date)
				{
					return array('interval'=>0, 'dbmonth'=>$db_start_month, 'adv_amount'=>1);	
				}
				else
				{
					return array('interval'=>$interval-1, 'dbmonth'=>$lot_date, 'adv_amount'=>0);
				}
			}
			else
			{
				$db_start_month = $dbmonth; 
				$db_end_month = $lot_date;
				$d1 = $db_start_month ;
				$d2 = $db_end_month;
				$interval = abs((date('Y', $d2) - date('Y', $d1))*12 + (date('m', $d2) - date('m', $d1)));
				$db_start_month = strtotime(date('d-m-Y',$db_start_month)."+1 month");				
				if($interval >= 1)
				{
					return array('interval'=>$interval-1, 'dbmonth'=>$lot_date,  'adv_amount'=>0);
				}
				else
				{
					return array('interval'=>$interval-1, 'dbmonth'=>$db_start_month, 'adv_amount'=>0);
				}
			}
		}
		else
		{
			return array('interval'=>0, 'dbmonth'=>$lot_date, 'adv_amount'=>0);
		}
		
		//return array('interval'=>$interval-1, 'dbmonth'=>$get_row->num_rows);
	}
	
	
	function change_month()
	{
		                $field_value = array(
				     'account_no' => $this->input->post('account_number'),
				     'agent_id' =>$this->tank_auth->get_user_id(),
				     );
		$record = $this->logic->global_where('account_holder', $field_value);
		$join_where = array(
				    'account_no' =>$this->input->post('account_number')
				    );
		$join_record = $this->logic->where_join($join_where);
		if($record->num_rows()<=0)
		{
			echo json_encode(array(
				  'name'=>'',
				  'account_opening_date'=>'',
				  'rd_amount'=>'',
				  ));
		}
		else
		{
			foreach($record->result() as $row)
			{
				$name = $row->name;
				$account_oping_date = $row->account_oping_date;
				$rd_amount = $row->rd_amount;
			}
			foreach($join_record->result() as $row)
			{
				$opening_amount = $row->o_amount;
				$depositor_id  = $row->depositor_id;
			}
			/* code for calculate total balance of account*/
			$get_amount = $this->logic->get_amount('opening_amount.depositor_id', $depositor_id, 'amount_deposited');
			foreach($get_amount->result() as $row)
			{
				$balance = $row->amount_deposited;
			}
			/*End of total balace of account*/
			/*panalty calculation call method*/
			 $penalty_cal= $this->penalty_cal($this->input->post('depositor_id'), strtotime($this->input->post('month')));
			 $total_month_session= $this->penalty_cal($this->input->post('depositor_id'), $this->session->userdata('lot_date'));
			 
			 $total_month = $total_month_session['interval'];
			 
			 $def = $penalty_cal['interval'];
			/*end panalty calculation method */
			
			if($def >= 6)
			{
				echo json_encode(array(
				  'name'=>$name."( A/c is close)",
				  'account_opening_date'=>date('d-m-Y',$account_oping_date),
				  'balance'=>'',
				  'rd_amount'=>'',
				  'depositor_id'=> $depositor_id,
				  'def'=>'',
				  'month'=>'',
				  ));
			}
			else
			{
				/*this code i will change */
				$data['total_deposit']	= $this->db_deposit_amount();
					$data['commission'] = '';
					$data['net_tendered_amt'] = '';
					$data['tds'] = '';
					$data['net_amount'] = '';
				if($data['total_deposit'] >= 1)
				{
					$data['commission'] = 0;
					$data['net_tendered_amt'] = $data['total_deposit']+$rd_amount;
					$data['tds'] = 0;
					$data['net_amount'] =$data['total_deposit']+$rd_amount;
					if($data['total_deposit'] >= 20000)
					{
						$data['commission'] = 800;
						$data['net_tendered_amt'] = (($data['total_deposit']+$rd_amount)-800);
						$data['tds'] = (800*10)/100;
						$data['net_amount'] =$data['net_tendered_amt']+$data['tds'];
					}
					else
					{
						$data['commission'] = ($data['total_deposit']*4)/100;
						$data['net_tendered_amt'] = (($data['total_deposit']+$rd_amount)-800);
						$data['tds'] = ($data['commission']*10)/100;
						$data['net_amount'] =$data['net_tendered_amt']+$data['tds'];
					}
				}
				
				/************************/
				
				$def_amount = 0;
				for($n=$total_month;$n>=($total_month-$def);$n--)
				{
					$def_amount = $def_amount+($rd_amount*2/100)*$n;
				}
				/*deposit amount */
				$trd_amount =($rd_amount*$def)+$rd_amount;
				/*for adv calculation */
				if($this->input->post('find_adv') == 1)
				{
					$def_amount =0;
				}
				echo json_encode(array(
				  'depositor_id'=>$depositor_id,	
				  'rd_amount'=> $trd_amount,
				  'def'=>$def_amount,
				  'start_month'=>date('d-M-Y',$penalty_cal['dbmonth']),
				  'month'=>date('d-M-Y', strtotime($this->input->post('month'))),
				  'balance'=>$opening_amount+$balance+$trd_amount,
				  'total_deposit_amount' =>($this->db_deposit_amount()+$rd_amount),
				  'adv_calcul'=>$def+1,
				  'commision'=> $data['commission'],
				  'net_tendered_amt'=> $data['net_tendered_amt'],
				  'tds'=>$data['tds'],
				  'net_amount'=>$data['net_amount'],
				  ));
			}
			//echo $_POST['account_number'];
		}
	}
	
	private function penalty_cal1($depositor_id, $lot_date =NULL)
	{
		$dbmonth ='';
		$deposit_amount_record = $this->logic->cal_month("deposit_amount.depositor_id", $depositor_id);
		$d = date('d', $lot_date);
		if($d<=15)
		{
			$d = 1;
		}
		else
		{
			$d = 16;
		}
		$m = date('m', $lot_date);
		$y = date('Y', $lot_date);
		
		$session_date = strtotime($d.'-'.$m.'-'.$y);
		if($deposit_amount_record->num_rows() <=0)
		{
			return 0;
		}
		else
		{
			$deposit_amount = $this->logic->cal_month("account_holder.id", $depositor_id);
			
			foreach($deposit_amount->result() as $row)
			{
				$dbmonth = $row->month;
			}
			foreach($deposit_amount ->result() as $row)
			{
				$db_opening_date =  $row->account_oping_date;
				$d = date('d', $db_opening_date);
				$m = date('m', $db_opening_date);
				$y = date('Y', $db_opening_date);
				$db_opening_date = strtotime($d.'-'.$m.'-'.$y);
			}
			
				$datetime1 = new DateTime(date('Y-m-d', $dbmonth));
				$datetime2 = new DateTime(date('Y-m-d', $session_date));
				$interval = $datetime1->diff($datetime2)->m;
				$dbmonth1 = strtotime(date('dmy',strtotime($dbmonth))."+1 month");
				if($interval >= 1)
				{
					return array('interval'=>$interval, 'dbmonth'=>$dbmonth1);
				}
				else
				{
					return array('interval'=>$interval, 'dbmonth'=>$dbmonth1);
				}
		}
	}
	
	private function db_deposit_amount()
	{
		
		if((($this->session->userdata('lot_no')) AND ($this->session->userdata('lot_date') AND ($this->session->userdata('batch_no')) OR ($this->input->post('month')) )) )
		{
			
			$field_value = array(
					     'lot_no' => $this->session->userdata('lot_no'),
					     'lot_agent_code'=>$this->tank_auth->get_user_id(),
					     'batch_no'=>$this->session->userdata('batch_no')
					     );
			$rows = $this->logic->global_where('lot_detail', $field_value);
			if($rows->num_rows() > 0)
			{
				foreach($rows->result() as $row)
				{
					$dblotid = $row->id;
				}
			}
			if($dblotid >= 1)
			{
				$db_deposit_amount = $this->logic->get_lot_amount('lot_id', $dblotid);
			}
			if($db_deposit_amount->num_rows() >=1)
			{
				foreach($db_deposit_amount->result() as $row)
				{
					$get_deposit_amount = $row->amount_deposited;
					return $get_deposit_amount;
				}
			}
		}
		return 0;
	}
	function batch_list()
	{
		$field_where = array(
				     'lot_agent_code' => $this->tank_auth->get_user_id()
				     );
		$config['base_url'] = base_url().'welcome/lot_list/';
		$config['total_rows'] = $this->logic->get_total_batch($field_where)->num_rows();
		$config['per_page'] 	= 20; 
		$config["uri_segment"] = 3;
		$config["num_links"] = 3;
		$page_segment = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['lot_list'] = $this->logic->get_batch( $field_where, $config['per_page'], $page_segment);
		$config['full_tag_open'] 	= "<nav> <ul class='pagination'>";
		$config['full_tag_close'] 	= '</ul> </nav>';
		$config['cur_tag_open'] 	= '<li class="active"><a>';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['next_tag_open']	 = '<li>';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '</li>';
		$config['first_link'] 		= 'First';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['last_link'] 		= 'Last';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';
		$this->pagination->initialize($config); 
		$data['create_link'] = $this->pagination->create_links();
		
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'batch_list';
		$this->load->view('theme/containt', $data);
	}
	function lot_list($batch_no = NULL)
	{
		$field_where = array(
				     'lot_agent_code' => $this->tank_auth->get_user_id(),
				     'batch_no'=>$batch_no,
				     );
		$config['base_url'] = base_url().'welcome/lot_list/';
		$config['total_rows'] = $this->logic->global_where('lot_detail',$field_where)->num_rows();
		$config['per_page'] 	= 200; 
		$config["uri_segment"] = 3;
		$config["num_links"] = 3;
		$page_segment = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['lot_list'] = $this->logic->global_where_limit('lot_detail', $field_where, $config['per_page'], $page_segment);
		$config['full_tag_open'] 	= "<nav> <ul class='pagination'>";
		$config['full_tag_close'] 	= '</ul> </nav>';
		$config['cur_tag_open'] 	= '<li class="active"><a>';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['next_tag_open']	 = '<li>';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '</li>';
		$config['first_link'] 		= 'First';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['last_link'] 		= 'Last';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';
		$this->pagination->initialize($config); 
		$data['create_link'] = $this->pagination->create_links();
		$data['batch_no']	= $batch_no;	
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'lot_list';
		$this->load->view('theme/containt', $data);
	}
	function account_list()
	{
		$field_where = array(
				     'agent_id' => $this->tank_auth->get_user_id()
				     );
		$config['base_url'] = base_url().'welcome/account_list/';
		$config['total_rows'] = $this->logic->global_where('account_holder',$field_where)->num_rows();
		$config['per_page'] 	= 5; 
		$config["uri_segment"] = 3;
		$config["num_links"] = 3;
		$page_segment = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['lot_list'] = $this->logic->global_where_limit('account_holder',$field_where, $config['per_page'], $page_segment);
		$config['full_tag_open'] 	= "<nav> <ul class='pagination'>";
		$config['full_tag_close'] 	= '</ul> </nav>';
		$config['cur_tag_open'] 	= '<li class="active"><a>';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['next_tag_open']	 = '<li>';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '</li>';
		$config['first_link'] 		= 'First';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['last_link'] 		= 'Last';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';
		$this->pagination->initialize($config); 
		$data['create_link'] = $this->pagination->create_links();
		
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'account_holder';
		$this->load->view('theme/containt', $data);
	}
	function depositer_detail($account_number = NULL)
	{
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'depositer_detail';
		$field_where = array(
					'agent_id' =>$this->tank_auth->get_user_id(),
				     'account_no'=>$account_number,
				     );
		$data['get_record']	= $this->logic->global_where('account_holder', $field_where);
		$this->load->view('theme/containt', $data);
	}
	function join_account_detail($account_number = NULL)
	{
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'join_account_detail';
		$field_where = array(
					'agent_id' =>$this->tank_auth->get_user_id(),
				     'account_no'=>$account_number,
				     );
		$data['add_record']	= $this->logic->global_where('account_holder', $field_where);
		$this->load->view('theme/containt', $data);
	}
	function find_account_holder()
	{
		$field_where = array(
				     'agent_id' => $this->tank_auth->get_user_id()
				     );
		$config['base_url'] = base_url().'welcome/account_list/';
		if($this->input->post($this->input->post('account_holder')))
		{
			$session_data = array('account_holder'=>strip_tags($this->input->post('account_holder')));
			$this->session->set_userdata($session_data);
		}
		if($this->session->userdata('account_holder'))
		{
			$account_holder = $this->session->userdata('account_holder');
		}
		else
		{
			$account_holder =$this->input->post('account_holder');
		}
		
		$config['total_rows'] = $this->logic->global_like('account_holder',$field_where, 'name', $account_holder)->num_rows();
		$config['per_page'] 	= 5; 
		$config["uri_segment"] = 3;
		$config["num_links"] = 3;
		$page_segment = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		
		$data['lot_list'] = $this->logic->global_like_limit('account_holder',$field_where, $config['per_page'], $page_segment, 'name', $account_holder);
		$config['full_tag_open'] 	= "<nav> <ul class='pagination'>";
		$config['full_tag_close'] 	= '</ul> </nav>';
		$config['cur_tag_open'] 	= '<li class="active"><a>';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['next_tag_open']	 = '<li>';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '</li>';
		$config['first_link'] 		= 'First';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['last_link'] 		= 'Last';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';
		$this->pagination->initialize($config); 
		$data['create_link'] = $this->pagination->create_links();
		
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'account_holder';
		$this->load->view('theme/containt', $data);
	}
	function delete_amount($dep_id = NULL, $depositor_id=NULL)
	{
		$get =  $this->logic->global_get_desc('def',array('account_no'=>$depositor_id), 'dep_id');
		
		if($get->num_rows() == 1)
		{
			foreach($get->result() as $row)
			{
				echo $def_id = $row->id;
			}		
			$this->logic->global_update('def',array('id'=>$def_id), array('last_insert'=>1));
		}
		
		$field_where = array(
				     'id'=> (int)$dep_id,
				     );
		$this->logic->global_delete('def', $field_where);
		$this->logic->global_delete('deposit_amount', $field_where);
		redirect('/welcome/deposit_form');
		
	}
	function statement($dep_id= NULL)
	{
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'statement';
		$field_value 		= array(
						'depositor_id'=>$dep_id
						);
		$data['statement']	= $this->logic->global_where('deposit_amount', $field_value);
		$data['total']		= $this->logic->get_lot_amount('depositor_id', $dep_id);
		$data['total_def']	= $this->logic->get_total_def($field_value);
		$this->load->view('theme/containt', $data);
	}
	
	function default_amount()
	{
		$today = strtotime(date('d-m-y'));
		$back_six_months = strtotime(date('d-M-Y',strtotime("-5 months")));
		$field_where = array(
				     'lot_agent_code' => $this->tank_auth->get_user_id()
				     );
		$config['base_url'] = base_url().'welcome/default_amount/';
		$config['total_rows'] = $this->logic->total_default_data(array('last_insert'=>1,'end_date >'=> $back_six_months))->num_rows();
		$config['per_page'] 	= 20; 
		$config["uri_segment"] = 3;
		$config["num_links"] = 3;
		$page_segment = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['get_default'] = $this->logic->default_data(array('last_insert'=>1, 'end_date >'=> $back_six_months), $config['per_page'], $page_segment);
		$config['full_tag_open'] 	= "<nav> <ul class='pagination'>";
		$config['full_tag_close'] 	= '</ul> </nav>';
		$config['cur_tag_open'] 	= '<li class="active"><a>';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['next_tag_open']	 = '<li>';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '</li>';
		$config['first_link'] 		= 'First';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['last_link'] 		= 'Last';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';
		$this->pagination->initialize($config); 
		$data['create_link'] = $this->pagination->create_links();
		
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		$data['page']		= 'default_amount';
		$this->load->view('theme/containt', $data);
	}
	
	function is_join_account($account_no)
	{
		return $this->rd_func->is_join_account($account_no);
	}
	
	function test()
	{
		$datetime1 = new DateTime('27-10-2015');
				$datetime2 = new DateTime('3-11-2015');
				echo $interval = $datetime1->diff($datetime2)->m;
			
	}
	function test_return()
	{
		echo $this->test();
	}
	
	function table_alter()
	{
		$sql = "ALTER TABLE `account_holder` ADD `father_name1` VARCHAR(100) NOT NULL AFTER `address`, ADD `join_account` INT NOT NULL, ADD `name1` VARCHAR(100) NOT NULL AFTER `father_name1`, ADD `husband_name1` VARCHAR(100) NOT NULL AFTER `name1`, ADD `mother_name1` VARCHAR(100) NOT NULL AFTER `husband_name1`, ADD `nominee_name1` VARCHAR(100) NOT NULL AFTER `mother_name1`, ADD `dob1` VARCHAR(25) NOT NULL AFTER `nominee_name1`, ADD `mobile_no1` BIGINT NOT NULL AFTER `dob1`, ADD `address1` VARCHAR(200) NOT NULL AFTER `mobile_no1`;";
		$this->db->query($sql);
		$sql = "ALTER TABLE `deposit_amount` ADD `start_month` VARCHAR(25) NOT NULL AFTER `balance`";
		$this->db->query($sql);
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */