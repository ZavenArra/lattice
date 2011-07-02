CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `objects_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `tagbuckets` (
	`id` int(11) NOT NULL,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tags_tagbuckets` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`tag_id` int(11) NOT NULL,
	`tagbucket_id` int(11) NOT NULL,
	PRIMARY KEY (`id`),
	KEY `tagbucket_id` (`tagbucket_id`),
	KEY `tag_id` (`tag_id`),
	CONSTRAINT `tags_tagbuckets_tag_id_fk` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`),
	CONSTRAINT `tags_tagbuckets_tagbucket_id_fk` FOREIGN KEY (`tagbucket_id`) REFERENCES `tagbuckets` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
