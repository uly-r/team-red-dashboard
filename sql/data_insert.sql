USE team_red;

DELETE FROM users;
DELETE FROM tasks;
DELETE FROM notes;
DELETE FROM quick_links;
DELETE FROM predefined_icons;

INSERT INTO `users` (`username`, `email`, `password`) VALUES ('testUser', 'testUser@teamred.com', '$2y$10$XNeZ.O1J9ip.iENinbZdxOiqGU59il/1drfr.NUtNkUVPw2ESnr86'); -- The password is: TeamRed!
INSERT INTO `users` (`username`, `email`, `password`) VALUES ('studentBlah', 'studentBlah@teamred.com', '$2y$10$APymrhPl86Wq8sZF450r3uqDKi9pH7RZ18jMqFb8wCcckcdJyXb1q'); -- the password is: TotallyNotTeamRed!

INSERT INTO `tasks` (`user_id`, `title`, `description`, `due_date`, `is_completed`, `task_priority`) VALUES (1, 'Do laundry', 'Laundry for the week', '2025-05-29', 0, 2);
INSERT INTO `tasks` (`user_id`, `title`, `description`, `due_date`, `is_completed`, `task_priority`)VALUES (1, 'Final exam', 'Study for the final exam which is on Thursday', '2025-05-22', 1, 3);
INSERT INTO `tasks` (`user_id`, `title`, `description`, `due_date`, `is_completed`, `task_priority`)VALUES (1, 'Get food', 'Get food after the final exam to celebrate', '2025-05-22', 1, 1);
INSERT INTO `tasks` (`user_id`, `title`, `description`, `due_date`, `is_completed`, `task_priority`)VALUES (1, 'Take a nap', 'Take a nap before running', '2025-05-29', 0, 1);
INSERT INTO `tasks` (`user_id`, `title`, `description`, `due_date`, `is_completed`, `task_priority`)VALUES (1, 'Meet up at BMCC', 'Meet Team Red at Fitterman Hall', '2025-05-23', 1, 1);

INSERT INTO `quick_links` (`user_id`, `title`, `url`, `icon_class`) VALUES (1, 'playlist', 'https://www.youtube.com/watch?v=eacU_tjzyYM&ab_channel=TurkiAlalshikh', 'fa-brands fa-youtube');
INSERT INTO `quick_links` (`user_id`, `title`, `url`, `icon_class`) VALUES (1, 'reddit popular', 'https://www.reddit.com/r/popular/', 'fa-brands fa-reddit');

INSERT INTO `notes` (`user_id`, `title`, `content`)  VALUES (1, 'REMINDER', 'REMEMBER TO THROW THE TRASH OUT WHEN YOU GET HOME EVERYDAY');



INSERT INTO `tasks` (`user_id`, `title`, `description`, `due_date`, `is_completed`, `task_priority`) VALUES (2, 'Go to brunch', 'Meet team red for brunch', '2025-05-29', 0, 1);
INSERT INTO `tasks` (`user_id`, `title`, `description`, `due_date`, `is_completed`, `task_priority`) VALUES (2, 'CUNY DEADLINE', 'Remember to get all your documents done and completed before the deadline', '2025-05-29', 0, 3);
INSERT INTO `quick_links` (`user_id`, `title`, `url`, `icon_class`) VALUES (2, 'group project link', 'https://github.com/BMCC-CSC-350/team-red', 'fa-brands fa-github');
INSERT INTO `quick_links` (`user_id`, `title`, `url`, `icon_class`) VALUES (2, 'Microsoft Activation Scripts (MAS)', 'https://github.com/massgravel/Microsoft-Activation-Scripts', 'fa-brands fa-github');

INSERT INTO `notes` (`user_id`, `title`, `content`)  VALUES (2, 'REMINDER', 'REMEMBER ABOUT THE CUNY DEADLINE');
INSERT INTO `notes` (`user_id`, `title`, `content`)  VALUES (2, 'REMINDER', 'Check the weather before leaving');
