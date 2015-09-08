<?php
class controllers_privilege extends controllers_base {
	public $user_name;
	public $admin_info;
	public $cote_action_list;
	public $group_action_list;

	public function __construct() {
		$this->layout = null;
		parent::__construct();
	
	}
	
	/**
	 *sign in pages
	 */
	public function index() {
		//If session exists, jump to the home page
		$eAdmin = lib_functions::getSession('eAdmin');
		if(!empty($eAdmin)) {
			lib_functions::redirect('goods/getlist');
		}
	}

	/**
	 *sign in
	 */
	 public function login() {
		
		$username = $this->_request('username');
		$pass = $this->_request('password');
		$params = array('cols'=>array('*'),'where'=>array('user_name' => $username ,'password' => md5($pass)));
		$result = $this->model->table('taoyizhang_wbsd1415_resit_admin_user')->fetch($params);
		
		// users name，password 
		if(!$result) {
			exit(json_encode(array('status'=>'-1','msg'=>'username or password error')));
		}else {  //sign in 

			//session
			lib_functions::setSession('eAdmin','1');
			lib_functions::setSession('eAdmin_admin_user',$username);
			lib_functions::setSession('eAdmin_admin_id',$result['id']);
			
			//
			$params = array('last_ip'=>$_SERVER['REMOTE_ADDR'],'last_login'=>time(),'active'=>1);
			$this->model->table('taoyizhang_wbsd1415_resit_admin_user')->update(array('user_name'=>$username),
				$params);
		
			exit(json_encode(array('status'=>0,'msg'=>'sign in success')));
		}
	 }

	/**
	 *
	 */
	 public function logout() {
		lib_functions::unsetSession('eAdmin');
		lib_functions::redirect('privilege/index');
	 }

	 /**
	  * setting nav
	  *
	  */
	  public function modif() {
			$this->user_name = lib_functions::getSession('eAdmin_admin_user');
			$this->admin_user = $this->model->table('taoyizhang_wbsd1415_resit_admin_user')->fetch(
				array('cols'=>array('email'),
						'where'=>array('user_name'=>$this->user_name)
				)
				);

			$this->cote_action_list = $this->model->table('taoyizhang_wbsd1415_resit_acl_action')->fetchAll(
				array('cols'=>array('action_name','action_code'),
					  'where'=>array('type'=>'cote'))
				);

			
			/**
			 * group acl_action 
			 */
			$sql = "select id,action_code,action_name from taoyizhang_wbsd1415_resit_acl_action where type='group'";
			$groups = $this->model->getAll($sql);

			foreach($groups as $n=>$data) {
				$sql = "select id,action_code,action_name from taoyizhang_wbsd1415_resit_acl_action where type='url' and parent_id = '{$data['id']}'";
			
				$groups[$n]['children'] = $this->model->getAll($sql);
			}

			$this->groups_action_list = $groups;
	  }

	  /**
	   *  save
	   */
	   public function save() {
			$user_name = $this->_request('user_name');
			$pass = $_REQUEST['new_password'];
			$pass = md5($pass);

			$old_pass = $_REQUEST['old_password'];
//           print_r($_REQUEST);
//           var_dump($this->_request('old_password'));
//           var_dump($this->_requ
//           est('user_name'));
			$old_pass = md5($old_pass);
			$email = $this->_request('email');

//		   print_r($user_name);
//           print_r($old_pass);
            $sql = "update taoyizhang_wbsd1415_resit_admin_user set email = '{$email}' where user_name ='{$user_name}'";
           $ret = $this->model->query($sql);

			if($old_pass != md5(''))
            {
                $sql = "select count(*) as num from taoyizhang_wbsd1415_resit_admin_user where user_name ='{$user_name}'
					and password = '{$old_pass}'";
                $ret = $this->model->getRow($sql);
                if(empty($ret['num'])) {
                    $result = array('status'=>'-1','msg'=>'password wrong');
                    exit(json_encode($result));
                }else {
                    $sql = "update taoyizhang_wbsd1415_resit_admin_user set password = '{$pass}' where user_name ='{$user_name}'";
                    $ret = $this->model->query($sql);
//                    print_r($ret);
                }
                if(!$ret) {
                    $result = array('status'=>'-1','msg'=>'Update Failed');
                }
                else {
                    $result = array('status'=>'0', 'msg'=>'Password update sucessfully!');
                }
                exit(json_encode($result));
            }

           if(!$ret) {
               $result = array('status'=>'-1','msg'=>'Update Failed');
           }
           else {
               $result = array('status'=>'0', 'msg'=>'Update sucessfully!');
           }
			exit(json_encode($result));
			
	   }
}