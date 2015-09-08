<?php
class controllers_category extends controllers_base{
    public $action_list;
    public $base_info;
    public $id;


    public function __construct(){
        parent::__construct();
        $this->layout = null;
        
    
    
    }
    public function top() {
      $this->layout = null;

    }

    public function main($id = null) {
        if(empty($id)) {
            exit('Error not exist');
        }
        $sql = "select * from taoyizhang_wbsd1415_resit_category";
      $this->category_list = $this->model->getAll($sql);
        $sql = "select * from taoyizhang_wbsd1415_resit_goods where category_id = $id";
        $this->goods_list = $this->model->getAll($sql);
        $this->cats = $this->model->table('taoyizhang_wbsd1415_resit_category')->fetchAll();

        
        // echo $this->goods;
        // print_r($this->goods_list);
    }
    
    public function categoryviews() {
      //
    }

    public function getList() {
    $filter = array('page_size'=>20,'page'=>1);
    if(!isset($_REQUEST['query'])) {
      $this->brands = $this->model->table('brand')->fetchAll();
      $this->cats = $this->model->table('category')->fetchAll();
    }

    if(isset($_REQUEST['query'])) {
      $this->layout = null;
      $filter['page_size'] = empty($_REQUEST['page_size'])?20:intval($_REQUEST['page_size']);
      $filter['page'] = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
      $this->query = 1;
      $filter['query'] = 1;
      $filter['goods_key'] = !empty($_REQUEST['goods_key'])?$_REQUEST['goods_key']:null;
      $filter['brand_id'] = !empty($_REQUEST['brand_id'])?$_REQUEST['brand_id']:null;
      $filter['cat_id'] = !empty($_REQUEST['cat_id'])?$_REQUEST['cat_id']:null;
      // $filter['is_sale'] = isset($_REQUEST['is_sale'])?$_REQUEST['is_sale']:null;
    }
    $filter = $this->add_magic($filter);
    
    $where = " ";
    if(!empty($filter['goods_key'])) {
      $where .= " and (g.goods_sn = '{$filter['goods_key']}' or g.goods_name like '%{$filter['goods_key']}%' )";
    }
    if(!empty($filter['brand_id'])) {
      $where .= " and g.brand_id = '{$filter['brand_id']}'";
    }
    if(!empty($filter['cat_id'])) {
      $where .= " and g.category_id = '{$filter['cat_id']}'";
    }
   
    $sql = "select count(*) from goods g where 1=1 $where";
    
    $num = $this->model->getOne($sql);

    $start = $filter['page_size'] * ($filter['page']-1);
    if($start > $num) {
      $start = 0;
    }
    

    $sql = "select g.* ,c.name as cat_name,b.name as brand_name
        from goods g,category c,brand b
        where g.category_id=c.id and g.brand_id = b.id
        $where 
        limit $start ,{$filter['page_size']}";
    
    $this->goods = $this->model->getAll($sql);

    $this->pageinfo = $this->set_page($this->goods,$num,$filter);
  //  print_r($this->goods);exit;
    $this->view = 'goods/list';

    if(isset($_REQUEST['query'])) {
      $this->make_json_exit('goods/list.php',$filter);
    }
  }

}