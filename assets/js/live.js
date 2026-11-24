// Auto-refreshing live tables with MD5 change detection and modern formatting
document.querySelectorAll('table[data-live]').forEach(table => {
  const cols = table.dataset.cols.split(','), tbody = table.tBodies[0] || table.createTBody();
  let last = '';
  const esc = s => String(s ?? '').replace(/[&<>"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]));
  
  const formatCell = (col, val) => {
    const clean = esc(val);
    if (col === 'status') {
      const s = String(val).toLowerCase();
      let bg = '#fef3c7', fg = '#92400e', icon = '•';
      if (s === 'confirmed') {
        bg = '#d1fae5'; fg = '#065f46'; icon = '✓';
      } else if (s === 'delayed') {
        bg = '#fef3c7'; fg = '#92400e'; icon = '⏳';
      } else if (s === 'cancelled') {
        bg = '#fee2e2'; fg = '#991b1b'; icon = '✕';
      } else if (s === 'pending') {
        bg = '#e0f2fe'; fg = '#0369a1'; icon = '⏱️';
      }
      return `<span class="status-badge status-badge-${s}" style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:9999px;font-size:11px;font-weight:700;text-transform:uppercase;background:${bg};color:${fg};letter-spacing:0.04em;"><span>${icon}</span><span>${clean}</span></span>`;
    }
    if ((col === 'total' || col === 'budget' || col === 'price' || col === 'amount' || col === 'revenue') && val !== null && val !== '') {
      const num = parseFloat(val);
      if (!isNaN(num)) return '<b>₱' + Math.round(num).toLocaleString('en-PH') + '</b>';
    }
    return clean;
  };

  const buttons = row => {
    let h = '';
    if (table.dataset.actions) {
      const current = String(row.status || '').toLowerCase();
      h += ['confirmed', 'delayed', 'cancelled'].map(s => {
        const isCurrent = current === s;
        return `<button type="button" class="status-btn status-btn-${s} ${isCurrent ? 'active' : ''}" data-act="${table.dataset.actions}" data-id="${row.id}" data-status="${s}">${isCurrent ? '✓ ' : ''}${s}</button>`;
      }).join('');
    }
    if (table.dataset.delete) {
      h += `<button type="button" class="del" data-act="${table.dataset.delete}" data-id="${row.id}" data-del="1">Delete</button>`;
    }
    return h ? '<td style="white-space:nowrap;">' + h + '</td>' : '';
  };

  async function tick() {
    try {
      const r = await fetch(table.dataset.api + '?t=' + table.dataset.live + (table.dataset.query || ''), {cache: 'no-store'});
      const d = await r.json();
      if (d.v !== last) {                       // only redraw when the data changed
        last = d.v;
        if (!d.rows || !d.rows.length) {
          tbody.innerHTML = `<tr><td colspan="${cols.length + 1}" style="text-align:center;color:#94a3b8;padding:24px;">No records found.</td></tr>`;
        } else {
          tbody.innerHTML = d.rows.map(row => 
            '<tr>' + cols.map(c => '<td>' + formatCell(c, row[c]) + '</td>').join('') + buttons(row) + '</tr>'
          ).join('');
        }
      }
    } catch (e) {}
  }

  table.addEventListener('click', async e => {   // one listener handles every button in the table
    const b = e.target.closest('button[data-act]'); if (!b) return;
    if (b.dataset.del && !confirm('Are you sure you want to delete this item?')) return;
    const data = new URLSearchParams(b.dataset.del ? {action: 'delete', id: b.dataset.id} : {action: 'status', id: b.dataset.id, status: b.dataset.status});
    await fetch(b.dataset.act, {method: 'POST', body: data});
    last = ''; tick();
  });

  tick();
  setInterval(tick, 3000);
});

// Live Theme Switcher Engine (Instant without page reload)
function initLiveTheme() {
  const btn = document.getElementById('themeToggleBtn');
  if (!btn) return;
  function updateState() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const icon = btn.querySelector('.theme-icon');
    const text = btn.querySelector('.theme-text');
    if (icon) icon.textContent = isDark ? '☀️' : '🌙';
    if (text) text.textContent = isDark ? 'Light' : 'Dark';
  }
  btn.addEventListener('click', () => {
    const current = document.documentElement.getAttribute('data-theme') || 'light';
    const next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('wayfarer_theme', next);
    updateState();
  });
  updateState();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initLiveTheme);
} else {
  initLiveTheme();
}
