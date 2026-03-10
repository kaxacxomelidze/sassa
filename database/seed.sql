INSERT INTO roles(name) VALUES ('Admin'),('Supervisor'),('Agent');
INSERT INTO users(role_id,name,email,password_hash,is_active) VALUES
(1,'System Admin','admin@sassa.local','$2y$12$ZDT05TrZgvY1UvGaqCkh3O/DTLX5vBRO6222N9wl9.3Ki6HzOCabi',1),
(2,'Support Lead','lead@sassa.local','$2y$12$ZDT05TrZgvY1UvGaqCkh3O/DTLX5vBRO6222N9wl9.3Ki6HzOCabi',1),
(3,'Agent One','agent@sassa.local','$2y$12$ZDT05TrZgvY1UvGaqCkh3O/DTLX5vBRO6222N9wl9.3Ki6HzOCabi',1);

INSERT INTO inboxes(name,channel_type,is_active) VALUES
('Website Chat','website_chat',1),('WhatsApp Inbox','whatsapp',1),('Messenger Inbox','messenger',1),('Instagram DM','instagram',1),('Telegram Support','telegram',1),('Email Support','email',1);

INSERT INTO contacts(name,email,phone,external_id,channel_source) VALUES
('John Customer','john@example.com','+621111','c_001','website_chat'),
('Maria Buyer','maria@example.com','+622222','c_002','whatsapp');

INSERT INTO conversations(contact_id,inbox_id,assigned_user_id,subject,status,priority) VALUES
(1,1,3,'Website order help','open','normal'),
(2,2,3,'Payment confirmation','pending','high');

INSERT INTO messages(conversation_id,sender_type,sender_user_id,body,message_type,delivery_status,read_status) VALUES
(1,'contact',NULL,'Hi, I need help with my order.','text','received','unread'),
(1,'agent',3,'Sure, I can help. Please share your order number.','text','sent','read'),
(2,'contact',NULL,'Can you check my payment status?','text','received','unread');

INSERT INTO tags(name,color) VALUES ('vip','#6f42c1'),('refund','#dc3545'),('billing','#0dcaf0');
INSERT INTO conversation_tags(conversation_id,tag_id) VALUES (1,1),(2,3);

INSERT INTO settings(setting_key,setting_value) VALUES
('system_name','Sassa Support'),
('logo_path','public/assets/img/logo.png'),
('timezone','UTC'),
('default_language','en'),
('theme','light');


INSERT INTO channel_integrations(channel_type,name,inbox_id,api_base_url,api_key,api_secret,access_token,webhook_verify_token,webhook_url,config_json,is_active) VALUES
('whatsapp','WhatsApp Cloud API',2,'https://graph.facebook.com','WHATSAPP_APP_ID','WHATSAPP_APP_SECRET','WHATSAPP_ACCESS_TOKEN','WHATSAPP_VERIFY_TOKEN','/webhooks/whatsapp','{"phone_number_id":"123456"}',1),
('messenger','Facebook Messenger API',3,'https://graph.facebook.com','FB_APP_ID','FB_APP_SECRET','FB_PAGE_TOKEN','FB_VERIFY_TOKEN','/webhooks/messenger','{"page_id":"987654"}',1);
