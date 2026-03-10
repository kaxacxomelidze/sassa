<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="row">
<div class="col-md-8">
<div class="card"><div class="card-header">Conversation #<?= $conversation['id'] ?> - <?= e($conversation['contact_name']) ?></div>
<div class="card-body chat-box" id="chatBox">
<?php foreach ($messages as $m): ?>
  <div class="msg <?= $m['sender_type'] === 'agent' ? 'outgoing' : 'incoming' ?>">
    <div><small class="text-muted"><?= e($m['sender_type']) ?> <?= e($m['agent_name'] ?? '') ?> • <?= e($m['created_at']) ?></small></div>
    <div><?= nl2br(e($m['body'])) ?></div>
  </div>
<?php endforeach; ?>
</div>
<div class="card-footer">
<form id="messageForm">
<input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
<input type="hidden" name="conversation_id" value="<?= $conversation['id'] ?>">
<input type="hidden" name="message_type" value="text">
<div class="input-group"><input class="form-control" name="body" required placeholder="Type a reply..."><button class="btn btn-primary">Send</button></div>
</form>
</div></div>
</div>
<div class="col-md-4"><div class="card"><div class="card-header">Customer Info</div>
<ul class="list-group list-group-flush"><li class="list-group-item">Name: <?= e($conversation['contact_name']) ?></li><li class="list-group-item">Email: <?= e($conversation['email']) ?></li><li class="list-group-item">Phone: <?= e($conversation['phone']) ?></li><li class="list-group-item">Inbox: <?= e($conversation['inbox_name']) ?></li></ul>
</div></div></div>
<script>window.conversationId = <?= (int)$conversation['id'] ?>;</script>
<?php require __DIR__ . '/../partials/footer.php'; ?>
