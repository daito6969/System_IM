<?php 
require '../includes/auth.php'; 
require_role(['traveler', 'admin']); 
include '../includes/header.php'; 

$uid = user()['id'];
// Fetch itineraries mapped by trip destination or user trips for quick inline preview
$stmtItin = $pdo->prepare('SELECT i.id, i.trip_id, t.destination, t.title, i.day_no, i.activity 
                           FROM itineraries i 
                           JOIN trips t ON t.id = i.trip_id 
                           WHERE t.user_id = ? 
                           ORDER BY i.trip_id, i.day_no');
$stmtItin->execute([$uid]);
$allItins = $stmtItin->fetchAll();
$itinsByTrip = [];
foreach ($allItins as $it) {
  $itinsByTrip[$it['trip_id']][] = $it;
}
?>

<h1>My Bookings & Reservations</h1>
<p style="color:var(--muted);margin-bottom:24px;">
  Manage your confirmed domestic flights, traveler KYC credentials, and destination packages.
</p>

<!-- Section 1: Booked Flights (Moved from Travel Planner) -->
<section style="margin-bottom: 38px;">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
    <h2>🎟️ Domestic Flight Reservations (Live)</h2>
    <a href="travel.php" class="btn" style="font-size:12.5px;padding:7px 14px;text-decoration:none;">+ Book More Flights</a>
  </div>

  <div id="flightTicketsContainer" class="ticket-grid">
    <div style="color:var(--muted);padding:16px;">Loading your confirmed flight reservations...</div>
  </div>
</section>

<!-- Section 2: Destination Package Bookings -->
<section style="margin-bottom: 38px;">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
    <h2>🏝️ Destination Package Bookings (Live)</h2>
    <a href="destinations.php" class="btn" style="font-size:12.5px;padding:7px 14px;text-decoration:none;">Browse Tour Packages</a>
  </div>

  <table data-live="bookings" data-api="../api/poll.php" data-cols="id,destination,travel_date,pax,total,status">
    <thead>
      <tr>
        <th>ID</th>
        <th>Destination Package</th>
        <th>Travel Date</th>
        <th>Travelers</th>
        <th>Total Amount</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</section>

<!-- Section 3: Linked Trip Itinerary Reference -->
<?php if (!empty($itinsByTrip)): ?>
<section style="background:var(--surface);border:1px solid var(--line);border-radius:var(--radius-md);padding:22px;margin-bottom:32px;">
  <h3 style="margin-top:0;">📋 My Trip Itineraries at a Glance</h3>
  <p style="color:var(--muted);font-size:13.5px;margin-bottom:16px;">Day-by-day scheduled spots and tours planned across your saved trips:</p>

  <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));gap:16px;">
    <?php foreach ($itinsByTrip as $tripId => $acts): ?>
      <div style="background:var(--surface-2);border:1px solid var(--line);border-radius:var(--radius-sm);padding:14px;">
        <b style="color:var(--primary);font-size:14px;display:block;margin-bottom:8px;">
          <?= e($acts[0]['title']) ?> (<?= e($acts[0]['destination']) ?>)
        </b>
        <div style="display:grid;gap:6px;">
          <?php foreach ($acts as $a): ?>
            <div style="font-size:12.5px;padding:4px 0;border-bottom:1px dashed var(--line);">
              <span style="font-weight:700;color:var(--muted);">Day <?= $a['day_no'] ?>:</span> <?= e($a['activity']) ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<script>
let lastFlightV = '';
async function pollFlightTickets() {
  try {
    const res = await fetch('../api/poll.php?t=flight_bookings', { cache: 'no-store' });
    const data = await res.json();
    if (data.v !== lastFlightV) {
      lastFlightV = data.v;
      renderFlightTickets(data.rows || []);
    }
  } catch (err) {}
}

function pesoFormat(num) {
  return '₱' + Math.round(num).toLocaleString('en-PH');
}

function renderFlightTickets(list) {
  const container = document.getElementById('flightTicketsContainer');
  if (!list.length) {
    container.innerHTML = `
      <div style="grid-column: 1 / -1; background:var(--surface); border:1px solid var(--line); border-radius:var(--radius-md); padding:28px; text-align:center;">
        <p style="color:var(--muted); margin:0 0 12px;">No active flight reservations yet.</p>
        <a href="travel.php" class="btn" style="text-decoration:none;">Search & Book Flights</a>
      </div>`;
    return;
  }

  container.innerHTML = list.map(t => {
    const isCancelled = t.status === 'cancelled';
    const isDelayed = t.status === 'delayed';
    const kycHtml = (t.kyc_id_type || t.contact_phone) ? `
      <div class="ticket-kyc-box">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px;">
          <b style="color:var(--ink);">👤 Passenger KYC & Contact:</b>
          <span class="kyc-verified-badge">✓ KYC Verified</span>
        </div>
        ${t.contact_phone ? `<span>📱 Phone: <b>${t.contact_phone}</b></span>` : ''}
        ${t.contact_email ? `<span>✉️ Email: <b>${t.contact_email}</b></span>` : ''}
        ${t.kyc_id_type ? `<span>🪪 ID: <b>${t.kyc_id_type}</b> (${t.kyc_id_number || 'On File'})</span>` : ''}
      </div>
    ` : `
      <div class="ticket-kyc-box" style="color:var(--muted);">
        <span>Contact: Standard Passenger Profile</span>
      </div>
    `;

    return `
      <div class="ticket-card ${isCancelled ? 'cancelled' : ''} ${isDelayed ? 'delayed' : ''}">
        <div class="ticket-card-header">
          <span class="ticket-ref-badge">REF: ${t.ref}</span>
          <span class="ticket-status ${t.status}">${isDelayed ? '⏳ Delayed' : t.status}</span>
        </div>

        <div class="ticket-route">🛫 ${t.outbound}</div>
        ${t.inbound ? `<div class="ticket-route" style="color:var(--ink-secondary);font-size:14px;margin-top:-4px;">🛬 ${t.inbound}</div>` : ''}

        ${isDelayed ? `
          <div style="background:var(--accent-light);color:var(--accent-ink);padding:7px 12px;border-radius:6px;font-size:12px;font-weight:700;margin:8px 0;display:flex;align-items:center;gap:6px;border:1px solid rgba(245,158,11,0.3);">
            <span>⚠️ Flight schedule delayed. Please check airport monitors or arrival gate for departure updates.</span>
          </div>
        ` : ''}

        <div style="display:flex;justify-content:space-between;font-size:13px;color:var(--muted);margin:10px 0;">
          <span>👥 ${t.pax} Traveler${t.pax > 1 ? 's' : ''}</span>
          <b style="color:var(--ink);font-size:15px;">${pesoFormat(+t.total)}</b>
        </div>

        ${kycHtml}

        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:12px;">
          <small style="color:var(--muted);">${t.created_at || 'Confirmed'}</small>
          ${!isCancelled ? `
            <button type="button" class="btn btn-danger" data-cancel-fid="${t.id}" style="font-size:12px;padding:5px 12px;background:var(--danger-light);color:var(--danger);border:1px solid rgba(239,68,68,0.3);box-shadow:none;">
              Cancel Reservation
            </button>
          ` : '<span style="color:var(--danger);font-size:12px;font-weight:700;">Cancelled</span>'}
        </div>
      </div>
    `;
  }).join('');
}

// Cancel Booking Handler
document.getElementById('flightTicketsContainer').addEventListener('click', async e => {
  const btn = e.target.closest('[data-cancel-fid]');
  if (!btn) return;
  if (!confirm('Are you sure you want to cancel this flight reservation? Seats will be returned to inventory.')) return;

  btn.disabled = true;
  btn.textContent = 'Cancelling...';
  try {
    await fetch('../actions/flight_booking_process.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ cancel: +btn.dataset.cancelFid })
    });
    lastFlightV = '';
    pollFlightTickets();
  } catch (err) {
    alert('Failed to cancel flight.');
  }
});

pollFlightTickets();
setInterval(pollFlightTickets, 3500);
</script>

<?php include '../includes/footer.php'; ?>
