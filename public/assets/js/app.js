document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('messageForm');
  if (!form) return;

  const refresh = async () => {
    const res = await fetch(`../messages/poll/${window.conversationId}`);
    if (!res.ok) return;
    const data = await res.json();
    const box = document.getElementById('chatBox');
    box.innerHTML = data.map(m => `
      <div class="msg ${m.sender_type === 'agent' ? 'outgoing' : 'incoming'}">
        <div><small class="text-muted">${m.sender_type} ${m.agent_name ?? ''} • ${m.created_at}</small></div>
        <div>${m.body.replace(/</g, '&lt;')}</div>
      </div>`).join('');
    box.scrollTop = box.scrollHeight;
  };

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const res = await fetch('../messages/ajax', { method: 'POST', body: formData });
    const json = await res.json();
    if (json.ok) {
      form.reset();
      refresh();
    }
  });

  setInterval(refresh, 4000);
});
