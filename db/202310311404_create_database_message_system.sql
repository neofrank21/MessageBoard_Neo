CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthdate` varchar(10) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `hobby` text DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `conversation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sender_user_id` int(11) unsigned NOT NULL,
  `recipient_user_id` int(11) unsigned NOT NULL,
  `create_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_conversation_sender_id` (`sender_user_id`),
  KEY `fk_conversation_recipient_id` (`recipient_user_id`),
  CONSTRAINT `fk_conversation_recipient_id` FOREIGN KEY (`recipient_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_conversation_sender_id` FOREIGN KEY (`sender_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message` text DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `sender_id` int(11) unsigned NOT NULL,
  `convo_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_message_sender_id` (`sender_id`),
  KEY `fk_message_convo_id` (`convo_id`),
  CONSTRAINT `fk_message_convo_id` FOREIGN KEY (`convo_id`) REFERENCES `conversation` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_message_sender_id` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;