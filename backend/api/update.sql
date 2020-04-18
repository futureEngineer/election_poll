ALTER TABLE `category` ADD `slug` VARCHAR(200) NOT NULL AFTER `name`;


CREATE TABLE `inventory` (
  `id` bigint(20) NOT NULL,
  `title` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `original_dimension` varchar(100) NOT NULL,
  `painting_medium` varchar(150) NOT NULL,
  `painting_surface` varchar(150) NOT NULL,
  `original_painting_cost` decimal(15,2) NOT NULL,
  `created_date` datetime NOT NULL,
  `activated_date` datetime NOT NULL,
  `is_limited_edition` tinyint(1) NOT NULL,
  `no_of_copies` int(20) NOT NULL,
  `art_status` tinyint(1) NOT NULL,
  `is_special` tinyint(1) NOT NULL,
  `A4_paper_print_cost` decimal(15,2) NOT NULL,
  `A3_paper_print_cost` decimal(15,2) NOT NULL,
  `A2_paper_print_cost` decimal(15,2) NOT NULL,
  `A8_paper_print_cost` decimal(15,2) NOT NULL,
  `A4_canvas_paper_print_cost` decimal(15,2) NOT NULL,
  `A3_canvas_paper_print_cost` decimal(15,2) NOT NULL,
  `A2_canvas_paper_print_cost` decimal(15,2) NOT NULL,
  `A8_canvas_paper_print_cost` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `inventory`  ADD PRIMARY KEY (`id`);

ALTER TABLE `inventory` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inventory` ADD `large_imagepath` TEXT NOT NULL AFTER `A8_canvas_paper_print_cost`, ADD `medium_imagepath` TEXT NOT NULL AFTER `large_imagepath`, ADD `small_imagepath` TEXT NOT NULL AFTER `medium_imagepath`;

ALTER TABLE `category` ADD `created_by` INT(20) NOT NULL AFTER `created_date`;

ALTER TABLE `inventory` ADD `created_by` INT(20) NOT NULL AFTER `small_imagepath`;


//print_medium


CREATE TABLE `print_medium` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(20) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `print_medium` ADD PRIMARY KEY (`id`);

ALTER TABLE `print_medium`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

INSERT INTO `print_medium` (`id`, `name`, `slug`, `created_date`, `created_by`, `status`) VALUES
(1, 'paper', '', '2019-07-22 00:00:00', 1, 1),
(2, 'canvas', '', '2019-07-22 00:00:00', 1, 1);


//print_medium_size

CREATE TABLE `print_medium_size` (
  `id` bigint(20) NOT NULL,
  `medium_id` int(20) NOT NULL,
  `size` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(20) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `print_medium_size` ADD PRIMARY KEY (`id`);

ALTER TABLE `print_medium_size`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

INSERT INTO `print_medium_size` (`id`, `medium_id`, `size`, `created_date`, `created_by`, `status`) VALUES
(1, 1, 'A2', '2019-07-22 00:00:00', 1, 1),
(2, 1, 'A3', '2019-07-22 00:00:00', 1, 1),
(3, 1, 'A4', '2019-07-22 00:00:00', 1, 1),
(4, 2, 'A2', '2019-07-22 00:00:00', 1, 1),
(5, 2, 'A3', '2019-07-22 00:00:00', 1, 1),
(6, 2, 'A4', '2019-07-22 00:00:00', 1, 1);



// adding somefields in category

ALTER TABLE `category` ADD `description` TEXT NOT NULL AFTER `slug`;

ALTER TABLE `category` ADD `is_special` TINYINT(1) NOT NULL AFTER `description`;
ALTER TABLE `category` ADD `from_date` DATETIME NOT NULL AFTER `is_special`;
ALTER TABLE `category`ADD `to_date` DATETIME NOT NULL AFTER `from_date`;

// art_medium_table

CREATE TABLE `art_medium` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `art_medium` ADD PRIMARY KEY (`id`);

ALTER TABLE `art_medium` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;


// art_surface_table

CREATE TABLE `art_surface` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `art_surface` ADD PRIMARY KEY (`id`);

ALTER TABLE `art_surface`  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;


// permission_table

CREATE TABLE `permissions` (
  `permissionid` bigint(20) NOT NULL,
  `controller` text NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `permissions` (`permissionid`, `controller`, `active`) VALUES
(1, 'admin/art/addMedium', 1),
(2, 'admin/art/mediumList', 1),
(3, 'admin/art/editMedium', 1),
(4, 'admin/art/deleteMedium', 1),
(5, 'admin/inventory/addCategory', 1),
(6, 'admin/inventory/editCategory', 1),
(7, 'admin/inventory/categoryList', 1),
(8, 'admin/inventory/deleteCategory', 1),
(9, 'admin/inventory/add', 1),
(10, 'admin/inventory/lists', 1),
(11, 'admin/medium/add', 1),
(12, 'admin/medium/delete', 1),
(13, 'admin/medium/edit', 1),
(14, 'admin/medium/lists', 1),
(15, 'admin/medium/addSize', 1),
(16, 'admin/medium/sizeList', 1),
(17, 'admin/medium/editSize', 1),
(18, 'admin/medium/deleteSize', 1),
(19, 'admin/medium/getSizeListByMedium', 1),
(20, 'admin/art/addSurface', 1),
(21, 'admin/art/surfaceList', 1),
(22, 'admin/art/editSurface', 1),
(23, 'admin/art/deleteSurface', 1);


ALTER TABLE `permissions` ADD PRIMARY KEY (`permissionid`);

ALTER TABLE `permissions` MODIFY `permissionid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;


// role_permission_table_data


INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 1, 21),
(22, 1, 22),
(23, 1, 23);
COMMIT;

ALTER TABLE `category` ADD `homepage` TINYINT(1) NOT NULL AFTER `is_special`;

ALTER TABLE `inventory`
  DROP `is_special`,
  DROP `A4_paper_print_cost`,
  DROP `A3_paper_print_cost`,
  DROP `A2_paper_print_cost`,
  DROP `A8_paper_print_cost`,
  DROP `A4_canvas_paper_print_cost`,
  DROP `A3_canvas_paper_print_cost`,
  DROP `A2_canvas_paper_print_cost`,
  DROP `A8_canvas_paper_print_cost`;



ALTER TABLE `inventory` CHANGE `original_painting_cost` `original_painting_cost_dollars` DECIMAL(15,2) NOT NULL;

ALTER TABLE `inventory` ADD `original_painting_cost_rs` DECIMAL(15,2) NOT NULL AFTER `original_painting_cost_dollars`;



//create_inventory_cost_table

CREATE TABLE `inventory_cost` (
  `id` bigint(20) NOT NULL,
  `inventory_id` int(20) NOT NULL,
  `medium_id` int(20) NOT NULL,
  `medium_name` varchar(200) NOT NULL,
  `medium_size_id` int(20) NOT NULL,
  `medium_size_name` varchar(200) NOT NULL,
  `cost_in_dollars` decimal(15,2) NOT NULL,
  `cost_in_rupees` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `inventory_cost` ADD PRIMARY KEY (`id`);

ALTER TABLE `inventory_cost` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inventory` DROP `activated_date`;


ALTER TABLE `users` ADD `facebookid` BIGINT(25) NOT NULL AFTER `status`, ADD `provider` VARCHAR(20) NOT NULL AFTER `facebookid`;
ALTER TABLE `users` ADD `token` TEXT NOT NULL AFTER `provider`;

CREATE TABLE `users_profile` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `profile` text NOT NULL,
  `thumburl` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `users_profile`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `users_profile`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inventory` CHANGE `original_dimension` `original_height` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `inventory` ADD `original_width` VARCHAR(100) NOT NULL AFTER `original_height`;


ALTER TABLE `inventory` ADD `art_date` DATE NOT NULL AFTER `title`, ADD `suffix` VARCHAR(100) NOT NULL AFTER `art_date`, ADD `internal_name` VARCHAR(200) NOT NULL AFTER `suffix`;


ALTER TABLE `inventory` ADD `internal_notes` text NOT NULL AFTER `description`;
ALTER TABLE `inventory` ADD `display_homepage` tinyint(1) NOT NULL AFTER `is_limited_edition`;


************Aug_12_updates************

ALTER TABLE `category` ADD `cover_photo` VARCHAR(500) NOT NULL AFTER `status`;

create_folders-> uploads -> 1.coverphoto -> 2.banner ->3. author

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_by` int(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(20) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `banner` ADD PRIMARY KEY (`id`);

ALTER TABLE `banner` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


INSERT INTO `permissions` (`permissionid`, `controller`, `active`)
VALUES (NULL, 'admin/banner/addBanner', '1'), (NULL, 'admin/banner/bannerList', '1'), (NULL, 'admin/banner/editBanner', '1');

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '24'), (NULL, '1', '25'), (NULL, '1', '26');


CREATE TABLE `about_author` (
  `id` bigint(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `profile` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `about_author`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `about_author`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

INSERT INTO `permissions` (`permissionid`, `controller`, `active`)
VALUES (NULL, 'admin/homepage/addAuthorDetails', '1'), (NULL, 'admin/homepage/authorList', '1'), (NULL, 'admin/homepage/editAuthorDetails', '1');

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '27'), (NULL, '1', '28'), (NULL, '1', '29');

ALTER TABLE `inventory` CHANGE `category_id` `category_id` VARCHAR(200) NOT NULL;


CREATE TABLE `homepage_content` (
  `id` bigint(20) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `created_by` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `homepage_content`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `homepage_content`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;


INSERT INTO `permissions` (`permissionid`, `controller`, `active`) VALUES
(NULL, 'admin/homepage/addContent', '1'), (NULL, 'admin/homepage/contentList', '1'), (NULL, 'admin/homepage/editContent', '1');

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '30'), (NULL, '1', '31'), (NULL, '1', '32');

INSERT INTO `permissions` (`permissionid`, `controller`, `active`) VALUES
(NULL, 'v1/homepage/bannerList', '1'),
(NULL, 'v1/homepage/authorList', '1'),
(NULL, 'v1/homepage/contentList', '1'),
(NULL, 'v1/homepage/artList', '1'),
(NULL, 'v1/homepage/specialSeriesList', '1'),
(NULL, 'v1/homepage/seriesList', '1');

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES
(NULL, '1', '33'),
(NULL, '1', '34'),
(NULL, '1', '35'),
(NULL, '1', '36'),
(NULL, '1', '37'),
(NULL, '1', '38');


//2019_08_19

ALTER TABLE `inventory` ADD `cover_imagepath` TEXT NOT NULL AFTER `small_imagepath`;

INSERT INTO `permissions` (`permissionid`, `controller`, `active`) VALUES
(NULL, 'admin/inventory/coverImageUrlList', '1'),
(NULL, 'admin/inventory/updateCoverImage', '1');

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES
(NULL, '1', '39'),
(NULL, '1', '40');

ALTER TABLE `inventory` ADD `modified_date` TIMESTAMP NOT NULL AFTER `created_by`;
INSERT INTO `permissions` (`permissionid`, `controller`, `active`) VALUES (NULL, 'v1/homepage/art', '1');
INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '41');

INSERT INTO `permissions` (`permissionid`, `controller`, `active`) VALUES (NULL, 'v1/homepage/getInventoryBySeries', '1');
INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '42');


//2019_08_20

INSERT INTO `permissions` (`permissionid`, `controller`, `active`) VALUES (NULL, 'admin/inventory/seriesList', '1');
INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '43');

ALTER TABLE `category` ADD `type` INT(2) NOT NULL AFTER `cover_photo`;


// above_are_updated



//2019_09_22

ALTER TABLE `inventory` ADD `size` VARCHAR(20) NOT NULL AFTER `original_width`;
ALTER TABLE `inventory` DROP `original_painting_cost_dollars`;
ALTER TABLE `inventory` ADD `availability` INT(2) NOT NULL AFTER `art_status`;
ALTER TABLE `inventory` ADD `premium_rating` VARCHAR(20) NOT NULL AFTER `availability`,
ADD `keywords` TEXT NOT NULL AFTER `premium_rating`;
 INSERT INTO `permissions` (`permissionid`, `controller`, `active`) VALUES
 (NULL, 'admin/currency/add', '1'), (NULL, 'admin/currency/edit', '1'),
 (NULL, 'admin/currency/delete', '1'), (NULL, 'admin/currency/lists', '1');
 INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`)
 VALUES (NULL, '1', '47'), (NULL, '1', '48'),
 (NULL, '1', '49'), (NULL, '1', '50');

 ALTER TABLE `inventory` DROP `premium_rating`;


 // add_curency

 // add_print_quality


 INSERT INTO `permissions` (`permissionid`, `controller`, `active`) VALUES
 (NULL, 'admin/medium/addQuality', '1'),
 (NULL, 'admin/medium/qualityList', '1'),
 (NULL, 'admin/medium/deleteQuality', '1'),
 (NULL, 'admin/medium/editQuality', '1');


 INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES
 (NULL, '1', '51'),
 (NULL, '1', '52'),
 (NULL, '1', '53'),
 (NULL, '1', '54');


 ALTER TABLE `inventory_cost` DROP `cost_in_dollars`;

 ALTER TABLE `inventory_cost` ADD `medium_quality_id` INT(20) NOT NULL AFTER `medium_size_name`;
 ALTER TABLE `inventory_cost` ADD `medium_quality_name` VARCHAR(200) NOT NULL AFTER `medium_quality_id`;


 //above_are_updated**
