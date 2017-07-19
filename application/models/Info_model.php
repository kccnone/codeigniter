<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function insertn($tablename,$val){
		$tablename = $this->db->dbprefix($tablename);
		return $this->db->insert($tablename,$val);
	}
	
	public function update($tablename,$val,$id){
		$tablename = $this->db->dbprefix($tablename);
		$where="id = ".$id;
		$str=$this->db->update_string($tablename, $val, $where);
		return $this->db->query($str);
	}

	public function getconfig($varname=""){
		$tablename = $this->db->dbprefix("webconfig");
		if(""==$varname){
	        $sql = "SELECT * FROM $tablename";
	        $query = $this->db->query( $sql);
	        $result = $query->result_array();
	        foreach ($result as $row) {
	        	$webconfig[$row['varname']] = $row['varvalue'];
	        }
	        return $webconfig; 	
		}
		else{
	        $sql = "SELECT * FROM $tablename WHERE varname = '".$varname."'";
	        $query = $this->db->query( $sql);
	        $row = $query->row_array();
	        $row['varvalue'];
		}
	}
	
	//中文版header标题、SEO内容
	public function getheader($cid="",$id=""){
		$t = array('0'=>'info','1'=>'infolist','2'=>'infoimg','3'=>'soft','4'=>'goods','5'=>'vedio','6'=>'spring','7'=>'summer','8'=>'autumn','9'=>'winter');
        $webconfig = $this->getconfig(); 
        $cfg_webname = $webconfig['cfg_webname']; 
        $cfg_generator = $webconfig['cfg_generator']; 
        $cfg_author = $webconfig['cfg_author']; 
        $cfg_keyword = $webconfig['cfg_keyword']; 
        $cfg_description = $webconfig['cfg_description']; 

        //显示详细信息
		if(!empty($cid) && !empty($id))
		{
        	$tablename = $this->db->dbprefix('infoclass');
        	$sql = "SELECT * FROM $tablename WHERE id = $cid";
        	$query = $this->db->query($sql);
        	$r = $query->row_array();
        	if(is_array($r))
			{
        		$tbname = $t[$r['infotype']];
        		$tablename = $this->db->dbprefix($tbname);
				$query = $this->db->query("SELECT * FROM $tablename WHERE id=$id");
				$r2 = $query->row_array();

				$header_str = '<title>';
				if(isset($r2['title'])){
					$header_str .= $r2['title'];			
				}
				else{
					$header_str .= $cfg_webname;
				}
				$header_str .= '</title>'."\n";

				$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
				$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";

				$header_str .= '<meta name="keywords" content="';
				if(isset($r2['keywords'])){
					$header_str .= $r2['keywords'];
				}
				else{
					$header_str .= $cfg_keyword;
				}
				$header_str .= '" />'."\n";

				$header_str .= '<meta name="description" content="';
				if(isset($r2['description'])){
					$header_str .= $r2['description'];
				}
				else{
					$header_str .= $cfg_description;
				}
				$header_str .= '" />'."\n";
			}
			else
			{
				$header_str  = '<title>'.$cfg_webname.'</title>'."\n";
				$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
				$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
				$header_str .= '<meta name="keywords" content="'.$cfg_keyword.'" />'."\n";
				$header_str .= '<meta name="description" content="'.$cfg_description.'" />'."\n";
			}
		}
		
		//显示栏目信息
		else if(!empty($cid))
		{
			$tablename = $this->db->dbprefix('infoclass');
        	$sql = "SELECT * FROM $tablename WHERE id = $cid";
        	$query = $this->db->query($sql);
        	$r = $query->row_array();

			$header_str = '<title>';
			if(!empty($r['seotitle']))
				$header_str .= $r['seotitle'];
			else if(!empty($r['classname']))
				$header_str .= $r['classname'].' - '.$cfg_webname;
			else
				$header_str .= $cfg_webname;
			$header_str .= '</title>'."\n";

			$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
			$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";

			$header_str .= '<meta name="keywords" content="';
			if(!empty($r['keywords']))
				$header_str .= $r['keywords'];
			else
				$header_str .= $cfg_keyword;
			$header_str .= '" />'."\n";

			$header_str .= '<meta name="description" content="';
			if(!empty($r['description']))
				$header_str .= $r['description'];
			else
				$header_str .= $cfg_description;
			$header_str .= '" />'."\n";
		}
		
		//显示站点信息
		else
		{
			$header_str  = '<title>'.$cfg_webname.'</title>'."\n";
			$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
			$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
			$header_str .= '<meta name="keywords" content="'.$cfg_keyword.'" />'."\n";
			$header_str .= '<meta name="description" content="'.$cfg_description.'" />'."\n";
		}		
		return $header_str;
	}

	//英文版header标题、SEO内容
	public function engetheader($cid="",$id=""){
		$t = array('0'=>'info','1'=>'infolist','2'=>'infoimg','3'=>'soft','4'=>'goods','5'=>'vedio','6'=>'spring','7'=>'summer','8'=>'autumn','9'=>'winter');
        $webconfig = $this->getconfig(); 
        $cfg_webname = $webconfig['cfg_webnameen']; 
        $cfg_generator = $webconfig['cfg_generator']; 
        $cfg_author = $webconfig['cfg_author']; 
        $cfg_keyword = $webconfig['cfg_keyworden']; 
        $cfg_description = $webconfig['cfg_descriptionen']; 

        //显示详细信息
		if(!empty($cid) && !empty($id))
		{
        	$tablename = $this->db->dbprefix('infoclass');
        	$sql = "SELECT * FROM $tablename WHERE id = $cid";
        	$query = $this->db->query($sql);
        	$r = $query->row_array();
        	if(is_array($r))
			{
        		$tbname = $t[$r['infotype']];
        		$tablename = $this->db->dbprefix($tbname);
				$query = $this->db->query("SELECT * FROM $tablename WHERE id=$id");
				$r2 = $query->row_array();

				$header_str = '<title>';
				if(isset($r2['enname'])){
					$header_str .= $r2['enname'];			
				}
				else{
					$header_str .= $cfg_webname;
				}
				$header_str .= '</title>'."\n";

				$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
				$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";

				$header_str .= '<meta name="keywords" content="';
				if(isset($r2['keywords'])){
					$header_str .= $r2['keywords'];
				}
				else{
					$header_str .= $cfg_keyword;
				}
				$header_str .= '" />'."\n";

				$header_str .= '<meta name="description" content="';
				if(isset($r2['description'])){
					$header_str .= $r2['description'];
				}
				else{
					$header_str .= $cfg_description;
				}
				$header_str .= '" />'."\n";
			}
			else
			{
				$header_str  = '<title>'.$cfg_webname.'</title>'."\n";
				$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
				$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
				$header_str .= '<meta name="keywords" content="'.$cfg_keyword.'" />'."\n";
				$header_str .= '<meta name="description" content="'.$cfg_description.'" />'."\n";
			}
		}
		
		//显示栏目信息
		else if(!empty($cid))
		{
			$tablename = $this->db->dbprefix('infoclass');
        	$sql = "SELECT * FROM $tablename WHERE id = $cid";
        	$query = $this->db->query($sql);
        	$r = $query->row_array();

			$header_str = '<title>';
			if(!empty($r['seotitle']))
				$header_str .= $r['seotitle'];
			else if(!empty($r['enname']))
				$header_str .= $r['enname'].' - '.$cfg_webname;
			else
				$header_str .= $cfg_webname;
			$header_str .= '</title>'."\n";

			$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
			$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";

			$header_str .= '<meta name="keywords" content="';
			if(!empty($r['keywords']))
				$header_str .= $r['keywords'];
			else
				$header_str .= $cfg_keyword;
			$header_str .= '" />'."\n";

			$header_str .= '<meta name="description" content="';
			if(!empty($r['description']))
				$header_str .= $r['description'];
			else
				$header_str .= $cfg_description;
			$header_str .= '" />'."\n";
		}
		
		//显示站点信息
		else
		{
			$header_str  = '<title>'.$cfg_webname.'</title>'."\n";
			$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
			$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
			$header_str .= '<meta name="keywords" content="'.$cfg_keyword.'" />'."\n";
			$header_str .= '<meta name="description" content="'.$cfg_description.'" />'."\n";
		}		
		return $header_str;
	}

    public function info($cid,$ziduan=""){
		$tablename = $this->db->dbprefix('info');
		$sql = "SELECT * FROM $tablename WHERE classid = $cid";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		if(is_array($row)){		
			if(""==$ziduan){
		        return $row;
			}
			else if(array_key_exists($ziduan,$row)){
				return $row[$ziduan];	
			}
			else{
				return ;	
			}
		}
		return ;
    }

    public function info_list($tablename,$where=""){
        $tablename = $this->db->dbprefix($tablename);
        $sql = "SELECT * FROM $tablename $where";
        $query = $this->db->query($sql);
        return  $query->result_array();
    }

    public function info_limit($tablename,$where="",$start=0,$per=0){
        $tablename = $this->db->dbprefix($tablename);
        $sql = "SELECT * FROM $tablename $where LIMIT $start ,$per";
        $query = $this->db->query($sql);
        return  $query->result_array();
    }

    public function info_detail($tablename,$where=""){
        $tablename = $this->db->dbprefix($tablename);
        $sql = "SELECT * FROM $tablename $where";
        $query = $this->db->query($sql);
        return  $query->row_array();
    }

	//分页样式修改，最多显示10个页码，超出的显示 '...'
	public function create_links($config)
	{
		$base_url = $config['base_url']; 
		$total_rows = $config['total_rows']; 
		$per_page = $config['per_page']; 
		$cur_page = $config['cur_page']; 

		$pagelinks = "";

		if($total_rows==0)
		{
			return $pagelinks; 
		}

		$total_page = ceil($total_rows/$per_page);
		
		if($cur_page==1)
		{
			$pagelinks .= '<span class="span am_page_first"></span>';	
		}
		else
		{
			$pagelinks .= '<a class="span am_page_first" href="'.$base_url.'/1"></a>';	
		}


		if($total_page<=10){
			for($i=1;$i<=$total_page;$i++)
			{
				if($cur_page==$i)
				{
					$pagelinks .= '<span class="span am_page_color">'.$i.'</span>';	
				}
				else
				{
					$pagelinks .= '<a class="span" href="'.$base_url.'/'.$i.'">'.$i.'</a>';	
				}
			}
		}else{
			if($cur_page<=5){
				for($i=1;$i<=10;$i++)
				{
					if($cur_page==$i)
					{
						$pagelinks .= '<span class="span am_page_color">'.$i.'</span>';	
					}
					else
					{
						$pagelinks .= '<a class="span" href="'.$base_url.'/'.$i.'">'.$i.'</a>';	
					}
				}
				if($i<=$total_page){
					$pagelinks .= '<a class="span" href="'.$base_url.'/'.$i.'">...</a>';
				}
			}else if($cur_page>=($total_page-4)){
				$pagelinks .= '<a class="span" href="'.$base_url.'/'.($total_page-9).'">...</a>';
				for($i=$total_page-8;$i<=$total_page;$i++)
				{
					if($cur_page==$i)
					{
						$pagelinks .= '<span class="span am_page_color">'.$i.'</span>';	
					}
					else
					{
						$pagelinks .= '<a class="span" href="'.$base_url.'/'.$i.'">'.$i.'</a>';	
					}
				}
				
			}else{
				
				$pagelinks .= '<a class="span" href="'.$base_url.'/'.($cur_page-5).'">...</a>';
				for($i=$cur_page-4;$i<=$cur_page+4;$i++)
				{
					if($cur_page==$i)
					{
						$pagelinks .= '<span class="span am_page_color">'.$i.'</span>';	
					}
					else
					{
						if($i<=$total_page){
							$pagelinks .= '<a class="span" href="'.$base_url.'/'.$i.'">'.$i.'</a>';	
						}
					}
				}
				if($i<=$total_page){
					$pagelinks .= '<a class="span" href="'.$base_url.'/'.$i.'">...</a>';
				}
			}
		}
		
		if($cur_page==$total_page)
		{
			$pagelinks .= '<span class="span am_page_last"></span>';
		}
		else
		{
			$pagelinks .= '<a class="span am_page_last" href="'.$base_url.'/'.$total_page.'"></a>';	
		}
		return $pagelinks; 
	}
}
?>