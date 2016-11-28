<?php

    include '../config.php';

    $user = $db->selectOneObject('users', $auth->user()->id);

?>

<?php include PAGE_HEADER;?>

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
                    <div class="btn-group btn-group-sm btn-group-justified">
                        <?php
                            link_button("users/update.php?id=$user->id", 'Edit your profile', 'btn-primary');
                            link_button('products', 'Back to products');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>

<?php include PAGE_FOOTER;?>
