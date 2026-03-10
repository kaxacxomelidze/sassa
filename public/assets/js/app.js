document.addEventListener('DOMContentLoaded', () => {
  initConversationChat();
  initIntegrationFormEnhancements();
});

function initConversationChat() {
  const form = document.getElementById('messageForm');
  if (!form) return;

  const pollUrl = form.dataset.pollUrl;
  const sendUrl = form.dataset.sendUrl;
  const box = document.getElementById('chatBox');

  const escapeHtml = (str) => String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;');

  const render = (messages) => {
    box.innerHTML = messages.map((m) => `
      <div class="msg ${m.sender_type === 'agent' ? 'outgoing' : 'incoming'}">
        <div><small class="text-muted text-capitalize">${escapeHtml(m.sender_type)} ${escapeHtml(m.agent_name ?? '')} · ${escapeHtml(m.created_at)}</small></div>
        <div>${escapeHtml(m.body)}</div>
      </div>`).join('');
    box.scrollTop = box.scrollHeight;
  };

  const refresh = async () => {
    const res = await fetch(pollUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    if (res.ok) render(await res.json());
  };

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const res = await fetch(sendUrl, { method: 'POST', body: formData });
    if (!res.ok) return;
    const json = await res.json();
    if (json.ok) {
      form.querySelector('input[name="body"]').value = '';
      refresh();
    }
  });

  refresh();
  setInterval(refresh, 4000);
}

function initIntegrationFormEnhancements() {
  const presets = {
    whatsapp: { apiBase: 'https://graph.facebook.com', webhookSuffix: '/webhooks/whatsapp', hint: 'Use Meta App ID/Secret + WhatsApp access token.' },
    messenger: { apiBase: 'https://graph.facebook.com', webhookSuffix: '/webhooks/messenger', hint: 'Use Meta Page Access Token + App ID/Secret.' },
    instagram: { apiBase: 'https://graph.facebook.com', webhookSuffix: '/webhooks/instagram', hint: 'Use Instagram Graph API token.' },
    telegram: { apiBase: 'https://api.telegram.org', webhookSuffix: '/webhooks/telegram', hint: 'Use BotFather token as Access Token.' },
    email: { apiBase: 'https://api.mailgun.net', webhookSuffix: '/webhooks/email-parser', hint: 'Use inbound email parser credentials.' },
    website_chat: { apiBase: window.location.origin, webhookSuffix: '/widget/start', hint: 'Website chat works locally without external API.' },
  };

  const forms = document.querySelectorAll('.integration-form');
  forms.forEach((form) => {
    const channel = form.querySelector('.integration-channel');
    const apiBase = form.querySelector('.integration-api-base');
    const webhookUrl = form.querySelector('.integration-webhook-url');
    const hint = form.querySelector('.integration-hint');
    if (!channel || !apiBase || !webhookUrl) return;

    const applyPreset = () => {
      const preset = presets[channel.value] || presets.whatsapp;
      if (!apiBase.value) apiBase.value = preset.apiBase;
      if (!webhookUrl.value) webhookUrl.value = `${window.location.origin}${preset.webhookSuffix}`;
      if (hint) hint.textContent = preset.hint;
    };

    channel.addEventListener('change', applyPreset);
    applyPreset();
  });
}
