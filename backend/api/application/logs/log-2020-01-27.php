<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-01-27 16:38:00 --> Severity: Warning --> Illegal string offset 'cart_id' /opt/lampp/htdocs/kft/api/application/modules/v1/controllers/Payment.php 146
ERROR - 2020-01-27 16:38:00 --> Severity: Notice --> Uninitialized string offset: 0 /opt/lampp/htdocs/kft/api/application/modules/v1/controllers/Payment.php 146
ERROR - 2020-01-27 16:38:00 --> Severity: Warning --> Illegal string offset 'order_no' /opt/lampp/htdocs/kft/api/application/modules/v1/controllers/Payment.php 147
ERROR - 2020-01-27 16:38:00 --> Severity: Notice --> Uninitialized string offset: 0 /opt/lampp/htdocs/kft/api/application/modules/v1/controllers/Payment.php 147
ERROR - 2020-01-27 16:38:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 16 - Invalid query: SELECT c.cart_id,c.user_id,c.cart_data,c.cgst,c.sgst,c.igst,c.shipping_fee,
                                         CASE WHEN c.currency_id = 1 THEN 'INR'
                                              WHEN c.currency_id = 2 THEN 'USD'
                                              WHEN c.currency_id = 3 THEN ''
                                              WHEN c.currency_id = 4 THEN '' END AS currency,
                                         c.sub_total,c.total,p.order_no,p.payment_response,p.status,p.created_date,
                                         CASE WHEN p.status = 1 THEN 'Success'
                                              WHEN p.status = 1 THEN 'Aborted'
                                              WHEN p.status = 1 THEN 'Failure'
                                              WHEN p.status = 1 THEN 'Illegal access'
                                         END AS payment_status,
                                         u.first_name,u.last_name,u.mobile,u.email
                                         FROM user_cart_details c 
                                         LEFT JOIN payment_details p ON p.cart_id = c.cart_id
                                         LEFT JOIN users u ON u.id = c.user_id
                                         WHERE c.cart_id = 
ERROR - 2020-01-27 12:11:44 --> Severity: error --> Exception: syntax error, unexpected 'public' (T_PUBLIC) /opt/lampp/htdocs/kft/api/application/modules/v1/controllers/Payment.php 389
ERROR - 2020-01-27 16:48:43 --> The session cookie data did not match what was expected. This could be a possible hacking attempt.
ERROR - 2020-01-27 17:08:54 --> Severity: Notice --> Undefined index: cartid /opt/lampp/htdocs/kft/api/application/modules/admin/controllers/Order.php 192
ERROR - 2020-01-27 17:08:54 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 - Invalid query: SELECT order_no,payment_response FROM payment_details WHERE cart_id = 
ERROR - 2020-01-27 17:28:59 --> Severity: Notice --> Undefined index: name /opt/lampp/htdocs/kft/api/application/modules/admin/controllers/Order.php 202
ERROR - 2020-01-27 17:28:59 --> Severity: Notice --> Undefined index: awb /opt/lampp/htdocs/kft/api/application/modules/admin/controllers/Order.php 203
ERROR - 2020-01-27 18:23:30 --> Severity: Warning --> money_format() expects exactly 2 parameters, 1 given /opt/lampp/htdocs/kft/api/application/modules/v1/controllers/Payment.php 200
ERROR - 2020-01-27 18:23:30 --> Severity: Warning --> money_format() expects exactly 2 parameters, 1 given /opt/lampp/htdocs/kft/api/application/modules/v1/controllers/Payment.php 201
