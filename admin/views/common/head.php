<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Oh, admin!</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php
    $head = new lib_head();
    echo $head->addCss('lib/bootstrap/css/bootstrap.css')
    ->addCss('lib/bootstrap/css/bootstrap-responsive.css')
    ->addCss('lib/font-awesome/css/font-awesome.css')
    ->addCss('theme.css')->getCss();
    echo $head
        ->addScript('jquery-1.8.1.min.js')
        ->addScript("utils.js")
        ->getScript();
    ?>

    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]> <body class="ie ie7"> <![endif]-->
<!--[if IE 8 ]> <body class="ie ie8"> <![endif]-->
<!--[if IE 9 ]> <body class="ie ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body>
<!--<![endif]-->

<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <?php $eAdmin = lib_functions::getSession('eAdmin');
            if(!empty($eAdmin)) { ?>
            <ul class="nav pull-right">
                <li id="fat-menu" class="dropdown">
                    <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i> <?php echo $eAdmin_user = lib_functions::getSession(eAdmin_admin_user);?>
                        <i class="icon-caret-down"></i>
                    </a>
                        <ul class="dropdown-menu">
                        <li>
                            <?php echo lib_functions::action("privilege/modif", "Settings"); ?>
                            </li>
                        <li class="divider"></li>
                        <li><?php echo lib_functions::action("privilege/logout", "Logout"); ?>
                            </li>
                    </ul>
                </li>
            </ul>
<!--                --><?php //var_dump($eAdmin);?>
            <?php } ?>
            <a class="brand" href="#"><span class="first">Oh</span> <span class="second">Shop </span></a>
        </div>
    </div>
</div>