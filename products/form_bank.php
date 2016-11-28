<div class="panel panel-default">
    <div class="panel-body">
        <form method="post">
            <h3>Billing Information</h3>
            <hr/>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name">Bank Name: </label>
                        <input class="form-control" type="text" name="name" value="<?php echo $auth_bank->name; ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="account_name">Account Name: </label>
                        <input class="form-control" type="text" name="account_name" value="<?php echo $auth_bank->account_name; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="book_no">Book Number: </label>
                        <input class="form-control" type="text" name="book_no" value="<?php echo $auth_bank->book_no; ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="card_no">Card Number: </label>
                        <input class="form-control" type="text" name="card_no" value="<?php echo $auth_bank->card_no; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="note">Note: </label>
                <textarea class="form-control" name="note"><?php echo $auth_bank->note; ?>"</textarea>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <?php form_submit('Checkout Now');?>
                </div>
                <div class="col-sm-4">

                </div>
                <div class="col-sm-4">
                    <?php form_cancel('Back to product', 'products');?>
                </div>
            </div>

        </form>
    </div>
</div>
