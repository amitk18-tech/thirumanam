<!-- 19-06-2020 -->

ALTER TABLE `users` ADD `manual_profile_id` VARCHAR(200) NOT NULL AFTER `user_type`, ADD `file_id` VARCHAR(200) NOT NULL AFTER `manual_profile_id`;

<!-- 20-06-2020 -->

ALTER TABLE `users` ADD `birth_time` VARCHAR(100) NOT NULL AFTER `dob`;