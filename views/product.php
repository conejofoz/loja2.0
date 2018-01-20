<div class="row">
    <div class="col-sm-5"></div> 
    <div class="col-sm-7">
        <h2><?php echo $product_info['name']; ?></h2>
        <small><?php echo $product_info['brand_name']; ?></small>
        <?php if ($product_info['rating'] != '0'): ?>
            <?php for ($q = 0; $q < intval($product_info['rating']); $q++): ?>
                <img src="<?php echo BASE_URL; ?>/assets/images/star.png" border="0" height="15px">
            <?php endfor; ?>
        <?php endif; ?>
        <hr>
        <p><?php echo $product_info['description']; ?></p>
    </div> 
</div>