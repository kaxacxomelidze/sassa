<?php
$auth = new AuthController();
$dashboard = new DashboardController();
$contacts = new ContactsController();
$inboxes = new InboxesController();
$integrations = new IntegrationsController();
$conversations = new ConversationsController();
$messages = new MessagesController();
$widget = new WidgetController();
$webhook = new WebhookController();

$router->add('GET', '', function () {
    if (!empty($_SESSION['user'])) {
        App::redirect('dashboard');
    }
    App::redirect('login');
});
$router->add('GET', 'login', [$auth, 'showLogin']);
$router->add('POST', 'login', [$auth, 'login']);
$router->add('GET', 'logout', [$auth, 'logout']);

$router->add('GET', 'dashboard', [$dashboard, 'index']);
$router->add('GET', 'contacts', [$contacts, 'index']);
$router->add('POST', 'contacts', [$contacts, 'store']);
$router->add('GET', 'inboxes', [$inboxes, 'index']);
$router->add('POST', 'inboxes', [$inboxes, 'store']);

$router->add('GET', 'integrations', [$integrations, 'index']);
$router->add('POST', 'integrations', [$integrations, 'store']);
$router->add('POST', 'integrations/{id}/update', [$integrations, 'update']);
$router->add('POST', 'integrations/{id}/delete', [$integrations, 'delete']);
$router->add('GET', 'conversations', [$conversations, 'index']);
$router->add('GET', 'conversations/{id}', [$conversations, 'show']);
$router->add('POST', 'messages/ajax', [$messages, 'storeAjax']);
$router->add('GET', 'messages/poll/{id}', [$messages, 'poll']);

$router->add('GET', 'widget', [$widget, 'embed']);
$router->add('POST', 'widget/start', [$widget, 'createConversation']);

$router->add('POST', 'webhooks/whatsapp', [$webhook, 'whatsapp']);
$router->add('POST', 'webhooks/messenger', [$webhook, 'messenger']);
$router->add('POST', 'webhooks/instagram', [$webhook, 'instagram']);
$router->add('POST', 'webhooks/telegram', [$webhook, 'telegram']);
$router->add('POST', 'webhooks/email-parser', [$webhook, 'emailParser']);
