<div class="sidebar">
    <div class="s-main">
        <div class="s_hdr">
            <h2>Catogories</h2>
        </div>
        <div class="text1-nav">
            <ul>
                <?php foreach($response->category_list as $list): ?>
                <li><?php echo lib_functions::action('category/main/'.$list['id'],$list['name']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>