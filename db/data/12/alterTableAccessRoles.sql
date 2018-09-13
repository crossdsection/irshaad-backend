ALTER TABLE `access_roles` CHANGE `area_level` `area_level` ENUM('world','country','state','city','department') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'These will be prioritize as Wolrd &gt; Country &gt; State &gt; City &gt; Department';

ALTER TABLE `access_roles` DROP `name`;
