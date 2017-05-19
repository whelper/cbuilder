<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['google_recaptcha_sitekey'] = '';
$config['google_recaptcha_secret'] = '';
$config['ga_ids'] = ''; //google analytics ids
$config['ga_json'] = ''; //google analytics json

$config['title'] = 'KORUSTEC';
$config['theme'] = 'corp-009'; //테마코드
$config['email'] = '';
$config['email_name'] = '';
$config['tel'] = '';

$config['thd_path_html'] = APPPATH.'views/html/';
$config['thd_path_html_mobile'] = APPPATH.'views/html/mobile/';
$config['view_languge'] = array('kr'=>'국문','en'=>'영문');

/*상세이미지 업로드파일*/
$config['file_upload'] = array('상세설명');

/*이메일 도메인*/
$config['conf_mail_domain'] =  array('naver.com','daum.net','google.com','nate.com','paran.com','empal.com','yahoo.co.kr','hotmail.com','korea.com','lycos.co.kr');
$config['conf_local_num'] =  array('02','031','032','033','041','042','043','051','052','053','054','055','061','062','063','064','070','080','010','011');
$config['conf_hp_num'] =  array('010','011','017','016','018','019');

$config['week'] = array('일','월','화','수','목','금','토');

/*SMS Begin*/
//$config['sms_url'] = 'https://sslsms.cafe24.com/sms_sender.php'; //보안
$config['sms_url'] = 'http://sslsms.cafe24.com/sms_sender.php';
$config['sms_id'] = '';
$config['sms_key'] = '';
/*SMS End*/

//경력
$config['career'] = array('01' => '신입','02' => '경력','03' => '신입,경력');

//국가
$config['country'] = array(
						'01' => '한국',
						'02' => '러시아',
						'03' => '벨라루스',
						'04' => '카자흐스탄',
						'05' => '우즈베키스탄',
						'06' => '우크라이나',
						'07' => '키르키즈스탄',
						'08' => '투르크메니스탄',
						'09' => '아제르바이잔',
						'10' => '아르메니아',
						'11' => '그루지아',
						'12' => '몰도바',
						'13' => '타지키스탄',
						'14' => '기타국가',
					);

//기술매칭 > Approval status
$config['approval'] = array('00' => '대기','01' => '검토중','02' => '승인','03' => '비승인');
$config['stage_of_develop'] = array('01' =>'Funding needed' ,'02' =>'Available for demonstration' ,'03' =>'Already on the market');