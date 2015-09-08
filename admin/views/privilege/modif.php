<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."head.php";?>

<div class="container-fluid">

	<div class="row-fluid">
		<div class="span3">
			<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."menu.php";?>
		</div>
		<div class="span9">
            <form name="theForm" method="post" action="<?php echo lib_functions::url('privilege/save');?>" enctype="multipart/form-data" onsubmit="return form_submit();">
			<h1 class="page-title">Edit User</h1>
			<div class="btn-toolbar">
                <input type="submit" value=" Save " class="btn btn-primary" />
                <input type="reset" value="Reset" class="btn" data-toggle="modal" />
                <input type="hidden" name="act" value="update_self" />
                <input type="hidden" name="id" value="1" />
				<div class="btn-group">
				</div>
			</div>
			<div class="well">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#home" data-toggle="tab">Profile</a></li>
					<li><a href="#profile" data-toggle="tab">Password</a></li>
				</ul>
				<div id="myTabContent" class="tab-content">
					<div class="tab-pane active in" id="home">
							<label>Username</label>
                        <input type="text" readonly class="input-xlarge" name="user_name" maxlength="20" value="<?php echo $response->user_name;?>" size="34"/>
							<label>Email</label>
                        <input type="text" class="input-xlarge" name="email" value="<?php echo $response->admin_user['email'];?>" size="34" /><span class="require-field">*</span>



					</div>
					<div class="tab-pane fade" id="profile">
                        <label>Old Password</label>
                        <input type="password" name="old_password" class="input-xlarge">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="input-xlarge">
                        <label>Confirm Password</label>
                        <input type="password" name="pwd_confirm" class="input-xlarge">
					</div>
				</div>

			</div>
            </form>

		</div>
	</div>


<script type="text/javascript">


function toggleButtonSatus() {
	document.getElementById('btnMoveUp').disabled = false;
	document.getElementById('btnMoveDown').disabled = false;
	document.getElementById('btnRemove').disabled = false;
}

/**
 *nav
 */
function moveOptions(way)  {
	var selected_options = getSelectedOptions('menus_navlist');
	var list = document.getElementById('menus_navlist');
	var index;
	
	
	switch(way){

		//
		case 'up':
			for(var i=0;i<selected_options.length;i++) {
				index = selected_options[i].index;
				var value = selected_options[i].value;
				var text = selected_options[i].text;
				if(index >=1 ) {
					list.options[index].value = list.options[index-1].value;
					list.options[index].text = list.options[index-1].text;
					list.options[index].selected = false;
					list.options[index-1].value = value;
					list.options[index-1].text = text;
					list.options[index-1].selected = true;
				}
		
			}
			break;
		case 'down':
			for(var i=0;i<selected_options.length;i++) {
				index = selected_options[i].index;
				var value = selected_options[i].value;
				var text = selected_options[i].text;
				
				if(index <= (list.options.length-2)) {
					list.options[index].value = list.options[index+1].value;
					list.options[index].text = list.options[index+1].text;
					list.options[index].selected = false;
					list.options[index+1].value = value;
					list.options[index+1].text = text;
					list.options[index+1].selected = true;
				}
		
			}
			break;

	}

}

function getSelectedOptions(id) {
	var all_options = document.getElementById(id).options;
	var selected_options = new Array();
	for(var i=0;i<all_options.length;i++) {
		if(all_options[i].selected) {
			selected_options.push(all_options[i]);
		}
	}
	return selected_options;
}

function toggleAddButton() {
	document.getElementById('btnAdd').disabled = false;
	document.getElementById('btnRemove').disabled = false;
}

function addItem() {
	var add_options = getSelectedOptions('all_menu_list');
	var nav_options = document.getElementById('menus_navlist').options;
//	alert(typeof nav_options);return;
	for(var i=0;i<add_options.length;i++) {
	//	nav_options.push(add_options[i]);
		nav_options[nav_options.length+i] = add_options[i];
		add_options[i].text = add_options[i].text.replace(/^-*/,'');
	}
}

function delItem() {
	var selected_options = getSelectedOptions('menus_navlist');
	var list = document.getElementById('menus_navlist');
	for(var i=0;i<selected_options.length;i++) {
		list.remove(selected_options[i].index);
	}
}

/**
 * table submit
 */
function form_submit() {
	
	var ele = document.forms['theForm'].elements;
	var user_name = $.trim(ele['user_name'].value);
	var pass = $.trim(ele['new_password'].value);
	var email = $.trim(ele['email'].value);
	var old_pass = $.trim(ele['old_password'].value);
	var pwd_confirm = $.trim(ele['pwd_confirm'].value);
//	alert(old_pass);
	

//	if(!pass) {
//		alert('password cannot be empty');
//		return false;
//	}
//
	if(pass !=  pwd_confirm ) {
		alert('password and confirmed password are not the same');
		return false;
	}

	var url = "<?php echo lib_functions::url('privilege/save');?>";
	$.post(url,
	{'user_name':user_name,
	 'old_pass':old_pass,
	 'pass':pass,
	 'email':email
    },function(data) {
		alert(data.msg);
            window.location.reload();
	},'json');



//	return false;
	 
}
</script>


<?php include DS.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."foot.php";?>