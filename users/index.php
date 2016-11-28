<?php
    include '../config.php';
    include PAGE_HEADER;

    if ($id = input_get('id')) {
        $user = $db->selectOneObject('users', $id);
    }

    $users = $db->selectAllObject('users');
?>

<?php if (!empty($user)): ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">
                    <?php image($user->photo);?>
                </div>
                <div class="col-sm-8">
                    <h3><?php echo ucwords($user->name); ?></h3>
                    <p><strong>Username: </strong><?php echo $user->username; ?></p>
                    <p><strong>Phone: </strong><?php echo $user->phone; ?></p>
                    <p><strong>Email: </strong><?php echo $user->email; ?></p>
                    <p>
                        <strong>Address: </strong>
                        <?php
                            echo $user->address, ", ";
                            echo $user->city ? "City $user->city, " : "";
                            echo $user->district ? "District $user->district" : "";
                        ?>
                    </p>
                    <p><strong>ID: </strong><?php echo $user->id_card; ?></p>
                    <div class="">
                        <?php link_to('users/update.php?id=' . $user->id, 'Update', 'class ="btn btn-sm btn-success"');?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>


<?php if (!empty($users)): ?>

    <?php foreach (array_chunk($users, 3) as $col3): ?>
        <div class="row">
            <?php foreach ($col3 as $each): ?>
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php image($each->photo);?>
                            <h3>
                                <?php link_to('users/?uid=' . $each->id, ucwords($each->name));?>
                            </h3>
                            <p><strong>Phone: </strong><?php echo $each->phone; ?></p>
                            <p><strong>Email: </strong><?php echo $each->email; ?></p>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="btn-group btn-group-sm btn-group-justified">
                                        <?php link_to('users/update.php?id=' . $each->id, 'Update', 'class ="btn btn-success"');?>
<?php link_to('users/delete.php?id=' . $each->id, 'Delete', 'class = "btn btn-danger"');?>
                                    </div>
                                </div>
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
                There are no any users registered
            </div>
        </div>
    </div>

<?php endif;?>


<?php include PAGE_FOOTER;?>
