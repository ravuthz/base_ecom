<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">

                <h4><?php echo $form_header_text; ?></h4>

                <hr/>

                <form method="post" class="form" enctype="multipart/form-data">

                    <div class="row">

                        <div class="col-sm-4">
                            <br/>
                            <?php image($user->photo); ?>
                        </div>

                        <div class="col-sm-8">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Full Name:</label>
                                        <input name="name" class="form-control" type="text" id="name" size="150" value="<?php echo $user->name; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_card">ID Number:</label>
                                        <input name="id_card" class="form-control" type="text" id="id_card" size="150" value="<?php echo $user->id_card; ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone Number:</label>
                                        <input name="phone" class="form-control" type="text" id="phone" size="16" value="<?php echo $user->phone; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Address:</label>
                                        <input name="email" class="form-control" type="text" id="email" size="50" value="<?php echo $user->email; ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" name="address" class="form-control" id="address" value="<?php echo $user->address; ?>"/>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">City / Province:</label>
                                        <input name="city" class="form-control" type="text" id="city" size="16" value="<?php echo $user->city; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="district">District / Tambun:</label>
                                        <input name="district" class="form-control" type="text" id="district" size="50" value="<?php echo $user->district; ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Username:</label>
                                        <input name="username" class="form-control" type="text" id="username" size="50" value="<?php echo $user->username; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="post_station">Post Station:</label>
                                        <input name="post_station" class="form-control" type="text" id="post_station" size="50" value="<?php echo $user->post_station; ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input name="password" class="form-control" type="password" id="password" size="50" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wordpass">Password Again:</label>
                                        <input name="wordpass" class="form-control" type="password" id="wordpass" size="50" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            Gender: <br/>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" value="male"
                                                    <?php echo_if($user->gender == 'male', 'checked'); ?> /> Male
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="gender" value="female"
                                                    <?php echo_if($user->gender == 'gender', 'checked'); ?> /> Female
                                            </label>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            Create As: <br/>
                                            <label class="radio-inline">
                                                <input type="radio" name="role" value="seller" checked/> Seller
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="role" value="customer"/> Customer
                                            </label>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="photo">Photo: </label>
                                <input name="photo" type="file" class="form-control" value="<?php echo $user->photo; ?>"/>
                            </div>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-8">
                            <?php echo $form_footer_text; ?>
                        </div>
                        <div class="col-sm-2">
                            <?php form_submit($form_submit_name)?>
                        </div>
                        <div class="col-sm-2">
                            <?php form_cancel('Go Back', 'users')?>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
