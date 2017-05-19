<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 */
/*function set_pagination()
{
	$config['first_link'] = '<img src="/theme/'.$this->config->item('ch_theme').'/images/common/btn_prev2.gif" alt="처음" />';
	$config['prev_link'] = '<img src="/theme/'.$this->config->item('ch_theme').'/images/common/btn_prev.gif" class="ml6" alt="이전" />';
	$config['next_link'] = '<img src="/theme/'.$this->config->item('ch_theme').'/images/common/btn_next.gif" alt="다음"  />';
	$config['last_link'] = '<img src="/theme/'.$this->config->item('ch_theme').'/images/common/btn_next2.gif" class="ml6" alt="마지막" />';
	return $config;
}*/


class THD_Pagination {
	var $total_rows = '';
	var $total_page = '';
	var $cur_no = '';
	var $page = '';
	var $pagenum = 10;
	var $total_block = '';
	var $listnum = '';
	var $block = '';
	var $first = '';
	var $last = '';
	var $go_page = '';
	var $url='';
	var $paglnk = '';
	var $querystring = '';
	var $theme = '';
	
	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	public function __construct($params = array())
	{
		if (count($params) > 0)
		{
			$this->initialize($params);
		}

		
		//추가
		$this->CI =& get_instance();
		
		log_message('debug', "Pagination Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	function initialize($params = array())
	{
		
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}

		$this->total_page=ceil($this->total_rows / $this->listnum);
		$this->cur_no=$this->total_rows - $this->listnum*($this->page-1);
		$this->total_block=ceil($this->total_page / $this->pagenum);
		$this->block=ceil($this->page / $this->pagenum);
		$this->first=($this->block-1)*$this->pagenum;
		$this->last=$this->block*$this->pagenum;		
		if($this->block >= $this->total_block){
			$this->last = $this->total_page;
		}
	}
	
	
	function create_links_admin(){
		$output = '';
		if($this->page>1){
			$this->go_page=$this->page-1;
			$output .= '<li class="paginate_button previous"><a href="'.$this->url.'?page='.$this->go_page.$this->querystring.'">Previous</a></li>'.chr(10);
		}else{
			$output .= '<li class="paginate_button previous"><a href="#">Previous</a></li>'.chr(10);
		}
		
		$pgNum = '';
		for($this->pagelnk=$this->first+1; $this->pagelnk <= $this->last; $this->pagelnk++)
		{
			if($this->first+1 < $this->pagelnk) $pgNum .= "	"; 
			if($this->pagelnk==$this->page){
				$pgNum .='<li class="paginate_button active" aria-controls="dataTables-example" tabindex="0"><a href="#">'.$this->pagelnk.'</a></li>'.chr(10);
			}else{
				$pgNum .='<li class="paginate_button" aria-controls="dataTables-example" tabindex="0"><a href="'.$this->url.'?page='.$this->pagelnk.$this->querystring.'">'.$this->pagelnk.'</a></li>'.chr(10);
			}
            
            if($this->paglnk!=$this->first+1 && $this->paglnk!=$this->last){
                $pgNum .= '';
            }
		}
		
        $output .= $pgNum;

		if($this->total_page>$this->page){
			$this->go_page=$this->page+1;
			$output .= '<li class="paginate_button next"><a href="'.$this->url.'?page='.$this->go_page.$this->querystring.'">Next</a></li>'.chr(10);		  
		}else{
			$output .= '<li class="paginate_button next"><a href="#">Next</a></li>'.chr(10);		  
		}
		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Generate the pagination links
	 *
	 * @access	public
	 * @return	string
	 */
	
	function create_links()
	{
		$output = '';
		
		/*if($this->block > 1){
			$this->prev = $this->first-1; 
			$output .= '<a href="'.$this->url.'/page/1" class="pBtn prev2">처음</a>'.chr(10);
		}else{
			$output .= '<a href="javascript:void(0);"class="pBtn prev2">처음</a>'.chr(10);
        }*/

		if($this->page>1){
			$this->go_page=$this->page-1;
			$output .= '<a href="'.$this->url.'/page/'.$this->go_page.$this->querystring.'"><img src="'.$this->theme.'/images/prev1.gif" alt="Prev" /></a>'.chr(10);
		}else{
			$output .= '<a href="javascript:void(0);"><img src="'.$this->theme.'/images/prev1.gif" alt="Prev" /></a>'.chr(10);
		}
		
		$pgNum = '';
		for($this->pagelnk=$this->first+1; $this->pagelnk <= $this->last; $this->pagelnk++)
		{
			if($this->first+1 < $this->pagelnk) $pgNum .= "	"; 
			if($this->pagelnk==$this->page){
				$pgNum .='<strong>'.$this->pagelnk.'</strong>'.chr(10);
			}else{
				$pgNum .='<a href="'.$this->url.'/page/'.$this->pagelnk.$this->querystring.'">'.$this->pagelnk.'</a>'.chr(10);
			}
            
            if($this->paglnk!=$this->first+1 && $this->paglnk!=$this->last){
                $pgNum .= '';
            }
		}
		
		//$output .= $pgNum;
        $output .= '<span class="num">'.$pgNum.'</span>';

		if($this->total_page>$this->page){
			$this->go_page=$this->page+1;
			$output .= '<a href="'.$this->url.'/page/'.$this->go_page.$this->querystring.'"><img src="'.$this->theme.'/images/next1.gif" alt="Next" /></a>'.chr(10);
		}else{
			$output .= '<a href="javascript:void(0);"><img src="'.$this->theme.'/images/next1.gif" alt="Next" /></a>'.chr(10);
		}

		/*if($this->block < $this->total_block){
			$this->next=$this->last+1;
			$output .= '<a href="'.$this->url.'/page/'.$this->total_page.'" class="pBtn next2">마지막</a>';
		}else{
            $output .= '<a href="javascript:void(0);" class="pBtn next2">마지막</a>';
        }*/
		
		if($this->total_page <= 1) $output =null;

		return $output;
	}
}
// END Pagination Class

/* End of file Pagination.php */
/* Location: ./system/libraries/Pagination.php */