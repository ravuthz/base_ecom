<?php
    $sql = "SELECT c.id, c.name, COUNT(p.id) count FROM categories c
            LEFT JOIN products p ON p.category_id = c.id GROUP BY c.id";
    $listCategories = $db->query($sql)->all();
    $labelColors = array('label-primary', 'label-success', 'label-danger', 'label-info');
?>

<?php if (!empty($listCategories)): ?>
    <div>
        <?php link_to('categories', 'All Categories', 'class = "list-group-item active"'); ?>
        <ul class="list-group">
            <?php foreach ($listCategories as $each): ?>
                <li class="list-group-item">
                    <?php link_to('products/?cid=' . $each->id, $each->name); ?>
                    <span class="label <?php echo $labelColors[rand(0,3)]; ?> pull-right">
                        <?php echo $each->count; ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div>
    <ul class="list-group">
        <li class="list-group-item list-group-item-success"><a href="#">New Offer's Coming </a></li>
        <li class="list-group-item list-group-item-info"><a href="#">New Products Added</a></li>
        <li class="list-group-item list-group-item-warning"><a href="#">Ending Soon Offers</a></li>
        <li class="list-group-item list-group-item-danger"><a href="#">Just Ended Offers</a></li>
    </ul>
</div>
