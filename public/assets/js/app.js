document.addEventListener('DOMContentLoaded', () => {
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
});
