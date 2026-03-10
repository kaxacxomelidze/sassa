<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Conversation #<?= $conversation['id'] ?></h3>
  <span class="badge text-bg-secondary"><?= e($conversation['status']) ?></span>
</div>

<div class="row g-3">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-transparent d-flex justify-content-between">
        <strong><?= e($conversation['contact_name']) ?></strong>
        <small class="text-muted">Inbox: <?= e($conversation['inbox_name']) ?></small>
      </div>
      <div class="card-body chat-box" id="chatBox">
      <?php foreach ($messages as $m): ?>
        <div class="msg <?= $m['sender_type'] === 'agent' ? 'outgoing' : 'incoming' ?>">
          <div><small class="text-muted text-capitalize"><?= e($m['sender_type']) ?> <?= e($m['agent_name'] ?? '') ?> · <?= e($m['created_at']) ?></small></div>
          <div><?= nl2br(e($m['body'])) ?></div>
        </div>
      <?php endforeach; ?>
      </div>
      <div class="card-footer bg-white">
        <form id="messageForm" data-poll-url="<?= App::url('messages/poll/' . (int)$conversation['id']) ?>" data-send-url="<?= App::url('messages/ajax') ?>">
          <input type="hidden" name="_csrf" value="<?= csrf_token() ?>">
          <input type="hidden" name="conversation_id" value="<?= $conversation['id'] ?>">
          <div class="row g-2">
            <div class="col-md-3">
              <select class="form-select" name="message_type">
                <option value="text">Reply</option>
                <option value="internal_note">Internal Note</option>
              </select>
            </div>
            <div class="col-md-9">
              <div class="input-group">
                <input class="form-control" name="body" required placeholder="Type message or note...">
                <button class="btn btn-primary"><i class="bi bi-send"></i></button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card border-0 shadow-sm sticky-top" style="top:1rem;">
      <div class="card-header bg-transparent"><strong>Customer Profile</strong></div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><small class="text-muted d-block">Name</small><strong><?= e($conversation['contact_name']) ?></strong></li>
        <li class="list-group-item"><small class="text-muted d-block">Email</small><?= e($conversation['email']) ?></li>
        <li class="list-group-item"><small class="text-muted d-block">Phone</small><?= e($conversation['phone']) ?></li>
      </ul>
    </div>
  </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
