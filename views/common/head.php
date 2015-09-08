<!DOCTYPE HTML>
<html>
<head>
    <title>Oh, shop!</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php echo lib_head::css('style.css');?>
    <?php echo lib_head::css('global.css');?>
    <?php echo lib_head::css('easy-responsive-tabs.css');?>
    <!--image slider-->
    <?php echo lib_head::script('jquery-1.7.2.min.js');?>
    <?php echo lib_head::script('jquery-slider.js');?>
    <?php echo lib_head::script('easyResponsiveTabs.js');?>
    <?php echo lib_head::script('slides.min.jquery.js');?>
    <link href='http://fonts.googleapis.com/css?family=Cabin+Condensed' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="wrap">
    <div class="header">
        <div class="logo">
            <a href="#"> </a>
        </div>
        <div class="header-right">
            <div class="menu">
                <ul class="nav">
                    <li class="active"><?php echo lib_functions::action('goods/index.php', 'Home');?></li>
                    <div class="clear"></div>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="hdr-btm">
        <div class="hdr-btm-bg"></div>
<!--        there maybe some problems-->
        <div class="hdr-btm-left">
            <form name="searchForm" action="<?php echo lib_functions::url('goods/search.php');?>" onsubmit="return query();">
                <div class="drp-dwn">
                    <select class="custom-select" id="select-1" name="cat_id">
                        <option value="" selected="selected">Catogories</option>
                        <?php foreach($response->cats as $h):?>
                            <option value='<?php echo $h['id'];?>'><?php echo $h['name'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>


            <div class="search">

                    <input type="text" name="goods_key" value="keyword here" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'keyword here';}">

                <input type="submit" name="submit" value="Search" class='button'/>

            </div>
            </form>


            <div class="clear"></div>
        </div>
    </div>