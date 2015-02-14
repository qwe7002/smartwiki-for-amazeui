<?php
include("conf.php");
spl_autoload_register(function($class){
  require preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});

use \Michelf\MarkdownExtra;
if(isset($_GET['page'])){
$pages=$_GET['page'];
}else{
  $pages="index";
}
if(!file_exists("file/".$pages.".md")){
die("404 Not Found");
}else{
 //$text = file_get_contents("file/".$pages.".md");
$handle = @fopen("file/".$pages.".md", "r");
if($handle){
  $havehr=0;
while(!feof($handle)){
    $texttemp = fgets($handle, 4096);
  if(substr($texttemp, 0,3)=="***"){
    $havehr=1;
   break;
  }else{
   $temparray[]=$texttemp;
  }
}
  $heading="";
  $temptext="";
if($havehr==1){
  foreach ($temparray as $key => $val)
  {
$temptext=$temptext."\n".$val;
  }
 $heading = MarkdownExtra::defaultTransform($temptext);
}else{$heading="无标题";}
$text="";
    while (!feof($handle)) {
        $text = $text.fgets($handle, 4096);
    }
    fclose($handle);
}
 $html = MarkdownExtra::defaultTransform($text);
     }
?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $filesetting[$pages] ?> - <?php echo $Gsetting["title"]?>  - Powered by SmartWiki</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <meta name="apple-mobile-web-app-title" content="" />
  <link rel="stylesheet" href="assets/css/amazeui.min.css"/>
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar admin-header">
  <div class="am-topbar-brand">
<strong><?php echo $Gsetting["title"]?></strong>
  </div>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
    </ul>
  </div>
</header>

<div class="am-cf admin-main">
  <!-- sidebar start -->
  <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">
      <ul class="am-list admin-sidebar-list">
        <?PHP
            foreach ($filesetting as $key => $val)
            { if(is_array($val)){
              echo '<li class="admin-parent">
        <a class="am-cf" data-am-collapse="{target: \'#collapse-nav\'}"> '.$val['标题'].'<span class="am-icon-angle-right am-fr am-margin-right"></span></a>
        <ul class="am-list am-collapse admin-sidebar-sub am-in" id="collapse-nav">';
              foreach ($val as $id => $return)
                {
                  if($id!="标题"){
                echo '<li><a href="?page='.$key."_".$id.'" class="am-cf">'.$return.'</a></li>';
            
                                }
                }
                echo '</ul>
      </li>';
              }else{
              echo '<li><a href="?page='.$key.'">'.$val.'</a></li>';
              }
            }
            ?>
      </ul>

    </div>
  </div>
  <!-- sidebar end -->

  <!-- content start -->
  <div class="admin-content">

    <div class="am-cf am-padding">
      <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg"><?php echo $heading;?></strong></div>
    </div>

    <div class="am-g">
      <div class="am-u-sm-12">
       <?php echo $html; ?>
      </div>
    </div>
  </div>
  <!-- content end -->
</div>

<a class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<footer>
  <hr>
  <p class="am-padding-left"><?php echo $Gsetting['foottitle']?></p>
</footer>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/polyfill/rem.min.js"></script>
<script src="assets/js/polyfill/respond.min.js"></script>
<script src="assets/js/amazeui.legacy.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/amazeui.min.js"></script>
<!--<![endif]-->
<script src="assets/js/app.js"></script>
</body>
</html>
