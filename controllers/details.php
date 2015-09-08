<?php
class controllers_details extends controllers_base{
    public $action_list;
    public $base_info;
    public $goods = array();

    public function __construct(){
        parent::__construct();
        $this->layout = null;
    }
    
    /**
     *home
     */
    public function index() {
        if(!isset($_REQUEST['query'])) {
            $this->brands = $this->model->table('taoyizhang_wbsd1415_resit_brand')->fetchAll();
            $this->cats = $this->model->table('taoyizhang_wbsd1415_resit_category')->fetchAll();
        }

        //
    }


    public function main($id = null) {
        if(empty($id)) {
            exit('Error not exist');
        }
        
        $this->goods = $this->model->table('taoyizhang_wbsd1415_resit_goods')->fetch(array('where'=>array('id'=>$id)));
        $sql = "select gc.*,c.name as color_name from taoyizhang_wbsd1415_resit_goods_color gc ,taoyizhang_wbsd1415_resit_color c where gc.color_id=c.id and gc.goods_id='{$id}'";
        $this->colors = $this->model->getAll($sql);

        $sql = "select gs.*,s.name as size_name from taoyizhang_wbsd1415_resit_goods_size gs ,taoyizhang_wbsd1415_resit_size s where gs.size_id=s.id and gs.goods_id='{$id}'";
        $this->sizes = $this->model->getAll($sql);

        $sql = "select * from taoyizhang_wbsd1415_resit_category";
        $this->category_list = $this->model->getAll($sql);
        $this->cats = $this->model->table('taoyizhang_wbsd1415_resit_category')->fetchAll();
        // echo $this->goods;
        // print_r($this->goods);
    }

    /**
     *head
     */
    public function top() {
        $this->layout = null;
        $this->model->query('set names utf8');
        $sql = "select * from taoyizhang_wbsd1415_resit_categoryaction where type='cote'";
        
        $this->action_list = $this->model->getAll($sql);
        // var_dump($this->model);
        // print_r($this->action_list);exit;
    }

    /**
     *nav
     */
     public function menu() {
        $main_menu = $this->model->table('taoyizhang_wbsd1415_resit_categoryaction')->fetchAll(array('where'=>array('type'=>'group')));
        foreach($main_menu as $n=>$value) {
            $sql = "select id,action_code,action_name from taoyizhang_wbsd1415_resit_categoryaction where parent_id='{$value['id']}'";
            $main_menu[$n]['child_menu'] = $this->model->getAll($sql);
        }
        $this->action_list = $main_menu;
    //  print_r($this->action_list);exit;

     }

     public function drag() {
        
        
     }

     /**
      *contents
      */


     public function insert_acl_action() {
        if(isset($_REQUEST['submit'])) {
            $arr = array(
                'parent_id'=>$this->_request('parent_id'),
                'type'=>$this->_request('type'),
                'action_name'=>$this->_request('action_name'),
                'action_code'=>$this->_request('action_code'),
                'sort_by' =>$this->_request('sort_by')
            );

            $this->model->table('taoyizhang_wbsd1415_resit_categoryaction')->insert($arr);
        }

        $this->action_list = $this->model->table('taoyizhang_wbsd1415_resit_categoryaction')->fetchAll();

     }
}