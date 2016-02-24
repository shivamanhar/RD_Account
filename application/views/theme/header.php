<html>
    <head>
        <title></title>
        <link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url();?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url();?>css/font-awesome.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url();?>css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url();?>css/op_style.css" rel="stylesheet" type="text/css">
        <!-- date picker css -->
        <link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap_cal.css" type="text/css">
        
        <script src="<?php echo base_url();?>js/jquery-2.1.1.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>js/towords.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>js/bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>js/rd_account.js" type="text/javascript"></script>
        
        <!-- date picker -->
        <script type="text/javascript" src="<?php echo base_url();?>js/zebra_datepicker.js"></script>
        
    </head>
    <body>
        
        <div class="container">
            <div class="row">
                <div class="print_block">
                <div class="col-md-12"><center> <h1> POST OFFICE RECURRING DEPOSIT MANAGEMENT </h1> </center></div>
                <div class="col-md-3 user_name"><?php echo $username; ?></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3 sign_out"><?php echo anchor('/auth/logout/', 'Logout'); ?></div>
                </div>
                <div class="clear">
                    
                </div>
          
                <hr class="print_block"/>
<!-- Static navbar -->
  <div class="container">
            <div class="row">
    <nav class="navbar navbar-default navbar-static-top rd_nav print_block">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">RD Deposit</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo base_url();?>welcome/"> <i class="fa fa-home"></i>Home</a></li>
            <li class="dropdown"><a href="<?php echo base_url();?>welcome/new_account_form" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-user-plus"></i> Add Account</a>
            <ul class="dropdown-menu op_drop_down" role="menu">
                <li><a href="<?php echo base_url();?>welcome/new_account_form"><i class="fa fa-user-plus"></i> New Account</a></li>
                <li><a href="<?php echo base_url();?>welcome/join_account_depositer"><i class="fa fa-user-plus"></i> New Join Account</a></li>
            </ul>
            </li>
            <li><a href="<?php echo base_url();?>welcome/deposit_form"> <i class="fa fa-inr"></i> Deposit</a> </li>
            
            <li><a href="<?php echo base_url();?>welcome/agent_form"> <i class="fa fa-user" ></i> My Profile</a>  </li>
            <li class="dropdown">
                <a href="<?php echo base_url();?>welcome/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <i class="fa fa-database" ></i>  Deposit Record</a>
                <ul class="dropdown-menu op_drop_down" role="menu">
                    <li><a href="<?php echo base_url();?>welcome/batch_list">Batch List</a></li>
                    <li><a href="<?php echo base_url();?>welcome/account_list">Account List</a></li>
                    <li><a href="<?php echo base_url();?>welcome/default_amount">Default</a></li>
                </ul>
            </li>
            <li><a href="<?php echo base_url();?>welcome/"> <i class="fa fa-user-times" ></i> Close Account</a></li>
            <!--<li><a href="<?php// echo base_url();?>welcome/"> <i class="fa fa-check" ></i></a></li>-->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
         </div>
        </div>
            </div></div>