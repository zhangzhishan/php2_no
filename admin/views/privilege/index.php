<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."head.php";?>

    <div class="container-fluid">

    <div class="row-fluid">
        <div class="dialog span4">
            <div class="block">
                <div class="block-heading">Sign In</div>
                <div class="block-body">
                    <form method="post" action="<?php echo lib_functions::url('shop/index');?>" name='theForm' onsubmit="return validate();" >
                        <span id="error_tip" style="color:red"></span>

                        <label>Username</label>
                        <input type="text" class="span12" name="username">
                        <label>Password</label>
                        <input type="password" class="span12" name="password">
                        <input type="submit" value="Sign In" class="button" class="btn btn-primary pull-right" />
                        <label class="remember-me"><input type="checkbox" value="1" name="remember" id="remember" /> Remember me</label>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
            <p class="pull-right" style=""> <a href="../" target="blank">Front-end</a></p>


        </div>
    </div>
<script language="JavaScript">

  function validate()
  {
	  $ele = document.forms['theForm'].elements;
	  var username = $.trim($ele['username'].value);
	  var password = $.trim($ele['password'].value);

	  if(!username) {
		document.getElementById('error_tip').innerHTML = 'please input your username';
		return false;
	  }
	  if(!password) {
		document.getElementById('error_tip').innerHTML = 'please input your password';
		return false;
	  }
//	 alert('dd');
	  $.post("<?php echo lib_functions::url('privilege/login');?>",
			 {'username':username,'password':password},
          function(data) {
			   if(data.status == 0) {
				  // document.forms['theForm'].submit();
					window.location.href="<?php echo lib_functions::url('goods/getlist');?>";
			   }else {
					document.getElementById('error_tip').innerHTML = data.msg;
			   }

			},'json'
		);

		return false;
  }
  
//-->
</script>

<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."foot.php";?>