
    <div class="sidebar-nav">

        <?php foreach($response->groups_action_list as $data) :?>
        <div class="nav-header" data-toggle="collapse" data-target="#accounts-menu"><i class="icon-briefcase"></i><?php echo $data['action_name'];?></div>
        <ul id="accounts-menu" class="nav nav-list collapse in">
            <?php if(is_array($data['children']) && count($data['children']) > 0) :?>
            <?php foreach($data['children'] as $url) :?>
                <li ><a href="<?php echo lib_functions::url($url['action_code']);?>"><?php echo $url['action_name'];?></a></li>
            <?php endforeach;?>
        </ul>
            <?php endif;?>
        <?php endforeach;?>
    </div>




