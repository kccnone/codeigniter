<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function index(){
		$this->load->library('session');
		
		$data['header'] = $this->info_model->getheader();
		$data['config'] = $this->info_model->getconfig();
		
		$data['wrongtip'] = $this->session->flashdata('wrongtip'); //获取提示信息
		$this->load->view('contact',$data);
	}
	
	public function message_save(){
		$this->load->library('session');
		$val = array(
			'nickname' => $this->input->post('nickname'),
			'contact' => $this->input->post('contact'),			
			'content' => $this->input->post('content'),
			'posttime' => time(),
			'checkinfo' => true
		);
		if($this->db->insert('message',$val)){			
			$this->session->set_flashdata('wrongtip', '留言成功'); //保存提示信息
			redirect('contact');
		}else{
			$this->session->set_flashdata('wrongtip', '留言失败'); //保存提示信息
			redirect('contact');
		}
	}

}
