INSERT INTO `user_user_auth_item`(`name`, `type`, `description`, `bizrule`, `data`) VALUES
  ('backend', 0, 'Панель управления', NULL, NULL),
  ('editNews', 0, 'Редактировать новости', NULL, NULL),
  ('editUsers', 1, 'Управление пользователями', NULL, NULL),
  ('guest', 2, 'гость', NULL, NULL),
  ('user', 2, 'Сотрудник компании', NULL, NULL);

INSERT INTO `user_user_auth_assignment`(`itemname`, `userid`, `bizrule`, data) VALUES
  ('backend', 1, NULL, NULL),
  ('editNews', 1, NULL, NULL),
  ('editUsers', 1, NULL, NULL),
  ('guest', 1, NULL, NULL),
  ('user', 1, NULL, NULL);