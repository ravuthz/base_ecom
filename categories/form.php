<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

                <h4><?php echo $form_header_text; ?></h4>

                <hr/>

                <form method="post" class="form" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="name">Name: </label>
                        <input name="name" type="text" class="form-control" value="<?php echo $category->name; ?>"/>
                    </div>

                    <div class="form-group">
                        <label for="photo">Photo: </label>
                        <input name="photo" type="file" class="form-control" value="<?php echo $category->photo; ?>"/>
                    </div>

                    <div class="form-group">
                        <label for="note">Note: </label>
                        <textarea name="note" type="text" class="form-control"><?php echo $category->note; ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">
                            <?php echo $form_footer_text; ?>
                        </div>
                        <div class="col-sm-2">
                            <?php form_submit($form_submit_name)?>
                        </div>
                        <div class="col-sm-2">
                            <?php form_cancel('Go Back', 'categories')?>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>