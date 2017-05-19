<?php
	/*function human_readable_bytes($var) {
		$human_readable_unit = array('K', 'M', 'G', 'T', 'P');
		$i = 0;
		while($var >= 1000 && $i < 5) {
			$var /= 1000;
			$i ++;
		}
		return (round((ceil($var * 100) / 100),0)).$human_readable_unit[$i].'B';
	}

	$quota = exec("quota");
	$arr = preg_split("/[\s-]+/", $quota);
	$rate = ceil(($arr[2]/$arr[4]) * 100);
	$disk_info = array('use' => human_readable_bytes($arr[2]),'limit' => human_readable_bytes($arr[4]),'rate'=> $rate);
*/
  $disk_info = array('use' => 0,'limit' => 0,'rate'=> 0); //temp value
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$_title?></title>

    <!-- Bootstrap Core CSS -->
    <link href="/common/thdadmin/assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="/common/thdadmin/assets/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="/common/thdadmin/dist/css/timeline.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/common/thdadmin/dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="/common/thdadmin/assets/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="/common/thdadmin/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="/common/thdadmin/dist/css/jquery-ui.min.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<!-- jQuery -->
    <script src="/common/thdadmin/assets/jquery/dist/jquery.min.js"></script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top admin-top"  role="navigation" style="margin-bottom: 0;">
            <div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="logopanel">
					<a class="navbar-brand" href="/thdadmin/"><strong>Administration Panels</strong></a>
				</div>
            </div>
			<!-- /.navbar-header -->
			<ul class="nav navbar-top-links navbar-right">
				<li style="font-size:18px;line-height:20px;font-weight:bold;color:#ffffff">
				  <?
					$_lang = $this->config->item("view_languge");
					//echo $_lang[$_language];
				  ?>
				</li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> <?=$this->session->userdata('username')?></a></li>
                        <!-- <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li> -->
                        <li class="divider"></li>
                        <li><a href="/thdadmin/logout?return_url=/thdadmin"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
				 <!-- <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-gear fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/thdadmin/dashboard?language=kr"><i class="fa fa-_language fa-fw"></i>국문</a></li>
						<li class="divider"></li>
						<li><a href="/thdadmin/dashboard?language=en"><i class="fa fa-_language fa-fw"></i>영문</a></li>
                    </ul>
                </li> -->
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
                    <ul class="nav left-menu" id="side-menu">
                        <li class="disk-info">
							<div class="plainwidget">
								<small>사용 <?=$disk_info['use']?> / 총 <?=$disk_info['limit']?> </small>
								<div class="progress progress-info" title="<?=$disk_info['rate']?>%">
									<div class="bar" style="width: <?=$disk_info['rate']?>%"></div>
								</div>
								<small><strong><?=$disk_info['rate']?>% 사용중</strong></small>
							</div>
                        </li>
                        <li>
                            <a href="/thdadmin/dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>

                        <!-- <li>
                            <a href="/thdadmin/menu"><i class="fa fa-sitemap fa-fw"></i> 메뉴관리</a>
                        </li> -->
						<li class="drop-menu gp-member">
                            <a href="#"><i class="fa fa-asterisk fa-fw"></i> 기본관리<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/thdadmin/popup_list">- 팝업관리</a>
                                </li>
								<li>
                                    <a href="/thdadmin/member_list">- 관리자관리</a>
                                </li>
								<li>
                                    <a href="/thdadmin/visual_list">- 메인이미지관리</a>
                                </li>
								<li>
                                    <a href="/thdadmin/main_contents">- 메인컨텐츠관리</a>
                                </li>
                            </ul>
                        </li>

						<li class="drop-menu gp-member">
                            <a href="#"><i class="fa fa-asterisk fa-fw"></i> 과학기술협력<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/thdadmin/board_list?menu_id=1">- 과학기술 동향뉴스</a>
                                </li>
								<li>
                                    <a href="/thdadmin/matching_list">- 기술매칭</a>
                                </li>
                            </ul>
                        </li>

						<li class="drop-menu gp-member">
                            <a href="#"><i class="fa fa-asterisk fa-fw"></i> 자료실<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/thdadmin/board_list?menu_id=2">- 자료실</a>
                                </li>
                            </ul>
                        </li>

						<li class="drop-menu gp-member">
                            <a href="#"><i class="fa fa-asterisk fa-fw"></i> News & Info<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/thdadmin/board_list?menu_id=3&">- 공지사항</a>
                                </li>
								<li>
                                    <a href="/thdadmin/seminar_list">- 세미나 & 행사</a>
                                </li>
								<li>
                                    <a href="/thdadmin/board_list?menu_id=4">- 사진갤러리</a>
                                </li>
								<li>
                                    <a href="/thdadmin/newsletter_list">- 뉴스레터 구독신청</a>
                                </li>
								<li>
                                    <a href="/thdadmin/recruit_list">- 채용정보</a>
                                </li>

                            </ul>
                        </li>

						<!-- <li class="drop-menu gp-board">
                            <a href="javascript:void(0);"><i class="fa fa-table fa-fw"></i> 게시판관리<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/thdadmin/menu_board"><i class="fa fa-gear fa-fw"></i> 전체게시판관리</a>
                                </li>
								<?php
									foreach($_menu_board as $k => $v){
								?>
								<li>
                                    <a href="/thdadmin/board_list?menu_id=<?=$k?>">- <?=$v['title']?></a>
                                </li>
								<?php
									}
								?>

                            </ul>
                        </li> -->


                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
		<div class="nav-info">
			<div class="wiget-time" style="float:left;width:220px">

				Today is <?=date("l, M d, Y g:ia")?>
				<!-- Today is Tuesday, Dec 25, 2012 5:30pm -->
			</div>

		</div>
        <div id="page-wrapper">
			<div class="row">
				<ul class="breadcrumb">
					<li><a href="dashboard.html">Home</a></li>
					<li class="active"><?=$_title?></li>
				</ul>
			</div>
			<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?=$_title?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php
				$this->load->view($_content);
			?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap Core JavaScript -->
    <script src="/common/thdadmin/assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="/common/thdadmin/assets/metisMenu/dist/metisMenu.min.js"></script>
    <!-- Morris Charts JavaScript -->
    <script src="/common/thdadmin/assets/raphael/raphael-min.js"></script>
    <script src="/common/thdadmin/assets/morrisjs/morris.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="/common/thdadmin/dist/js/sb-admin-2.js"></script>
	<script src="/common/thdadmin/dist/js/jquery-ui.min.js"></script>

<script type="text/javascript">
	$(function(){
		/*$('.drop-menu').addClass("active");
		$("ul.collapse ").show();
		$(".drop-menu>a").unbind("click");*/
	});
</script>
<iframe name="ifrm_proc" id="ifrm_proc" style="display:none"></iframe>
</body>

</html>
