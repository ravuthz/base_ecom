<?php
    $listCategory = $db->query('SELECT id, name FROM categories')->all();
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

                <h4><?php echo $form_header_text; ?></h4>

                <hr/>

                <form method="post" class="form" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-sm-8">

                            <div class="form-group">
                                <label for="name">Name: </label>
                                <input name="name" type="text" class="form-control" value="<?php echo $product->name; ?>"/>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="unit_price">Price: </label>
                                        <input name="unit_price" type="text" class="form-control" value="<?php echo $product->unit_price; ?>"/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="category_id">Category: </label>
                                        <select name="category_id" class="form-control">
                                            <?php foreach($listCategory as $each): ?>
                                                <option value="<?php echo $each->id; ?>" <?php echo $product->category_id == $each->id ? 'selected' : ''; ?>>
                                                    <?php echo ucfirst($each->name); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="photo">Photo: </label>
                                <input name="photo" type="file" class="form-control" value="<?php echo $product->photo; ?>"/>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <br/>
                            <?php image($product->photo); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="note">Note: </label>
                        <textarea name="note" type="text" class="form-control"><?php echo $product->note; ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">
                            <?php echo $form_footer_text; ?>
                        </div>
                        <div class="col-sm-2">
                            <?php form_submit($form_submit_name)?>
                        </div>
                        <div class="col-sm-2">
                            <?php form_cancel('Go Back', 'products')?>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
