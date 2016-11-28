<?php
    $cart = session_get('cart', null);
    $count_cart_items = count($cart);

    $sql = 'SELECT count(*) AS `count_ower_products` FROM products WHERE user_id = :uid';
    $products = $db->query($sql, ['uid' => $auth->user()->id])->one();
    $count_ower_products = $products->count_ower_products;
?>
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <?php link_to('', '<strong>DIGI</strong> Shop', 'class = "navbar-brand"');?>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><?php link_to('categories', 'Categories');?></li>
                <li><?php link_to('products', 'Products');?></li>
                <?php if ($auth->isLoggedIn()): ?>
                    <li><?php link_to('products/order.php', 'Orders');?></li>
                <?php endif;?>
                <?php if ($auth->isAdmin()): ?>
                    <li><?php link_to('users', 'Users');?></li>
                <?php endif;?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if ($auth->isLoggedIn()): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            New
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><?php link_to('products/create.php', 'Product');?></li>
                            <?php if ($auth->isAdmin()): ?>
                                <li class="divider"></li>
                                <li><?php link_to('categories/create.php', 'Category');?></li>
                                <li><?php link_to('users/create.php', 'User');?></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif;?>
                <?php if($auth->isLoggedIn()): ?>
                  <li>
                      <a href="<?php base_link('products/cart.php'); ?>" id="nav-cart">
                          <span class="glyphicon glyphicon-shopping-cart"></span>
                          <span id="nav-cart-number" class="badge">
                              <?php echo $count_cart_items; ?>
                          </span>
                      </a>
                  </li>
                  <li>
                      <a href="<?php base_link('products/?mine'); ?>">
                          <span class="glyphicon glyphicon-gift"></span>
                          <span class="badge">
                              <?php echo $count_ower_products; ?>
                          </span>
                      </a>
                  </li>
                <?php endif;?>

                <?php if ($auth->isAdmin()): ?>
                    <li><?php link_to('payments/', 'All Payments');?></li>
                    <li class="divider"></li>
                <?php endif;?>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo $auth->isLoggedIn() ? ucfirst($auth->user()->username) : 'Account'; ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if ($auth->isLoggedIn()): ?>
                            <li><?php link_to('users/profile.php', 'Profile');?></li>
                            <li><?php link_to('account/logout.php', 'Logout');?></li>
                        <?php else: ?>
                            <li><?php link_to('account/login.php', 'Login');?></li>
                            <li><?php link_to('account/register.php', 'Register');?></li>
                        <?php endif;?>
                    </ul>
                </li>
            </ul>

<!--            <form class="navbar-form navbar-right" role="search">-->
<!--                <div class="form-group">-->
<!--                    <input type="text" placeholder="Enter Keyword Here ..." class="form-control">-->
<!--                </div>-->
<!--                &nbsp;-->
<!--                <button type="submit" class="btn btn-primary">Search</button>-->
<!--            </form>-->
        </div>
    </div>
</nav>
