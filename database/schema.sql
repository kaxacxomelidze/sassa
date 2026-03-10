CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(30) UNIQUE NOT NULL
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  role_id INT NOT NULL,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  is_active TINYINT(1) DEFAULT 1,
  avatar VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  phone VARCHAR(40),
  email VARCHAR(190),
  external_id VARCHAR(190),
  channel_source VARCHAR(60) DEFAULT 'website_chat',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE inboxes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  channel_type VARCHAR(50) NOT NULL,
  credentials_json JSON NULL,
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE conversations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  contact_id INT NOT NULL,
  inbox_id INT NOT NULL,
  assigned_user_id INT NULL,
  subject VARCHAR(190),
  status ENUM('open','pending','resolved','closed') DEFAULT 'open',
  priority ENUM('low','normal','high','urgent') DEFAULT 'normal',
  unread_count INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (contact_id) REFERENCES contacts(id),
  FOREIGN KEY (inbox_id) REFERENCES inboxes(id),
  FOREIGN KEY (assigned_user_id) REFERENCES users(id)
);

CREATE TABLE conversation_assignments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  conversation_id INT NOT NULL,
  user_id INT NOT NULL,
  assigned_by INT NULL,
  assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (conversation_id) REFERENCES conversations(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  conversation_id INT NOT NULL,
  sender_type ENUM('agent','contact','system') NOT NULL,
  sender_user_id INT NULL,
  body TEXT NOT NULL,
  message_type ENUM('text','internal_note','attachment') DEFAULT 'text',
  delivery_status ENUM('queued','sent','delivered','failed','received') DEFAULT 'sent',
  read_status ENUM('unread','read') DEFAULT 'unread',
  metadata JSON NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (conversation_id) REFERENCES conversations(id),
  FOREIGN KEY (sender_user_id) REFERENCES users(id)
);

CREATE TABLE message_attachments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  message_id INT NOT NULL,
  file_name VARCHAR(190),
  file_path VARCHAR(255),
  mime_type VARCHAR(120),
  file_size INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (message_id) REFERENCES messages(id)
);

CREATE TABLE tags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(60) UNIQUE NOT NULL,
  color VARCHAR(10) DEFAULT '#0d6efd'
);

CREATE TABLE conversation_tags (
  conversation_id INT NOT NULL,
  tag_id INT NOT NULL,
  PRIMARY KEY (conversation_id, tag_id),
  FOREIGN KEY (conversation_id) REFERENCES conversations(id),
  FOREIGN KEY (tag_id) REFERENCES tags(id)
);

CREATE TABLE notes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  conversation_id INT NOT NULL,
  user_id INT NOT NULL,
  note_text TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (conversation_id) REFERENCES conversations(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(80) UNIQUE NOT NULL,
  setting_value TEXT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE audit_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  action VARCHAR(120) NOT NULL,
  entity_type VARCHAR(80),
  entity_id INT NULL,
  ip_address VARCHAR(45),
  user_agent VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE webhooks_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  source VARCHAR(50) NOT NULL,
  payload LONGTEXT,
  headers LONGTEXT,
  status VARCHAR(30) DEFAULT 'received',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE channel_integrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  channel_type VARCHAR(50) NOT NULL,
  name VARCHAR(120) NOT NULL,
  inbox_id INT NULL,
  api_base_url VARCHAR(255) NULL,
  api_key VARCHAR(255) NULL,
  api_secret VARCHAR(255) NULL,
  access_token TEXT NULL,
  webhook_verify_token VARCHAR(255) NULL,
  webhook_url VARCHAR(255) NULL,
  config_json JSON NULL,
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (inbox_id) REFERENCES inboxes(id)
);
