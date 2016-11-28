<?php

    include '../config.php';

    if ($cid = input_get('cid')) {
        $category = $db->selectOneObject('categories', $cid);
    }

    $categories = $db->selectAllObject('categories');

?>

<?php include PAGE_HEADER;?>

<?php if (!empty($category)): ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">
                    <?php image($category->photo);?>
                </div>
                <div class="col-sm-8">
                    <h3><?php link_to("categories/?cid=$category->id", $category->name);?></h3>
                    <div class="">
                        <?php link_to('categories/update.php?id=' . $category->id, 'Update', 'class ="btn btn-sm btn-primary"');?>
<?php link_to('categories/delete.php?id=' . $category->id, 'Delete', 'class = "btn btn-sm btn-danger"');?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>


<?php if (!empty($categories)): ?>

    <?php foreach (array_chunk($categories, 3) as $col3): ?>
        <div class="row">
            <?php foreach ($col3 as $each): ?>
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php image($each->photo);?>
                            <h3><?php link_to("categories/?cid=$each->id", $each->name);?></h3>
                            <div class="btn-group btn-group-sm btn-group-justified">
                                <?php link_to('categories/update.php?id=' . $each->id, 'Update', 'class ="btn btn-primary"');?>
<?php link_to('categories/delete.php?id=' . $each->id, 'Delete', 'class = "btn btn-danger"');?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    <?php endforeach;?>

<?php else: ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger">
                There are no any categories in this application
            </div>
        </div>
    </div>

<?php endif;?>


<?php include PAGE_FOOTER;?>
