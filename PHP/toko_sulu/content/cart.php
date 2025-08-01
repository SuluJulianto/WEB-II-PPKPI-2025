 <!-- Shoping Cart Section Begin -->
 <?php if (isset($_SESSION['cart'])): ?>
     <section class="shoping-cart spad">
         <div class="container">
             <div class="row">
                 <div class="col-lg-12">
                     <div class="shoping__cart__table">
                         <table>
                             <thead>
                                 <tr>
                                     <th class="shoping__product">Products</th>
                                     <th>Price</th>
                                     <th>Quantity</th>
                                     <th>Total</th>
                                     <th></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    $grandTotal = 0;
                                    $subtotal   = 0;
                                    foreach ($_SESSION['cart'] as $key => $val):
                                        $subtotal = $val['product_price'] * $val['product_qty'];
                                        $grandTotal += $subtotal;
                                    ?>
                                     <tr class="item-row-<?php echo $key ?>">
                                         <td class="shoping__cart__item">
                                             <img src="fe/img/cart/cart-1.jpg" alt="">
                                             <h5><?php echo $val['product_name'] ?></h5>
                                         </td>
                                         <td class="shoping__cart__price">
                                             <?php echo "Rp." .  number_format($val['product_price']) ?>
                                         </td>
                                         <td class="shoping__cart__quantity">
                                             <div class="quantity">
                                                 <div class="pro-qty">
                                                     <input type="text" value="<?php echo $val['product_qty'] ?>">
                                                 </div>
                                             </div>
                                         </td>
                                         <td class="shoping__cart__total">
                                             <?php
                                                $total = $val['product_price'] * $val['product_qty'];
                                                echo "Rp. " . number_format($total);
                                                ?>
                                         </td>
                                         <td class="shoping__cart__item__close">
                                             <span class="icon_close remove-cart" data-id="<?php echo $key ?>"></span>
                                         </td>
                                     </tr>
                                 <?php endforeach ?>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
             <div class="row">
                 <div class="col-lg-12">
                     <div class="shoping__cart__btns">
                         <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                         <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                             Upadate Cart</a>
                     </div>
                 </div>
                 <div class="col-lg-6">
                     <div class="shoping__continue">
                         <div class="shoping__discount">
                             <h5>Discount Codes</h5>
                             <form action="#">
                                 <input type="text" placeholder="Enter your coupon code">
                                 <button type="submit" class="site-btn">APPLY COUPON</button>
                             </form>
                         </div>
                     </div>
                 </div>
                 <?php ?>
                 <div class="col-lg-6">
                     <div class="shoping__checkout">
                         <h5>Cart Total</h5>
                         <ul>
                             <li>Subtotal <span id="subtotal"><?php echo "Rp." .  number_format($subtotal) ?></span></li>
                             <li>Total <span id="total"><?php echo "Rp." . $grandTotal ?></span></li>

                         </ul>
                         <a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>
                     </div>
                 </div>
             </div>
         </div>
     </section>
 <?php endif ?>

 <!-- Shoping Cart Section End -->