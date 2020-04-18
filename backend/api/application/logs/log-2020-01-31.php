<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-01-31 10:58:21 --> The session cookie data did not match what was expected. This could be a possible hacking attempt.
ERROR - 2020-01-31 12:29:55 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE
                                  c.cart_id = (SELECT p.cart_id FROM payme' at line 2 - Invalid query: SELECT COUNT(c.cart_id) as total FROM user_cart_details c 
                                   WHERE c.user_id = 68 WHERE
                                  c.cart_id = (SELECT p.cart_id FROM payment_details p WHERE 
                                  p.cart_id = c.cart_id AND p.status = 1)
ERROR - 2020-01-31 12:30:07 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE
                                  c.cart_id IN (SELECT p.cart_id FROM paym' at line 2 - Invalid query: SELECT COUNT(c.cart_id) as total FROM user_cart_details c 
                                   WHERE c.user_id = 68 WHERE
                                  c.cart_id IN (SELECT p.cart_id FROM payment_details p WHERE 
                                  p.cart_id = c.cart_id AND p.status = 1)
