<?
/*테마별 view 경로 변경*/
$this->load->file('./theme/'.$this->config->item("theme").'/'.$_language.$_folder.'/'.$_view.'.php');
?>