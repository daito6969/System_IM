<?php 
require '../includes/auth.php'; 
require_role(['traveler', 'admin']); 
include '../includes/header.php'; 

// Fetch current user's profile and KYC data for 1st book vs 2nd autofill
$stmtKyc = $pdo->prepare('SELECT name, email, phone, id_type, id_number, kyc_verified FROM users WHERE id=?');
$stmtKyc->execute([user()['id']]);
$userKyc = $stmtKyc->fetch() ?: [];
?>
<link rel="stylesheet" href="../assets/css/travel.css">
<script>
window.USER_KYC = {
  name: <?= json_encode($userKyc['name'] ?? user()['name']) ?>,
  email: <?= json_encode($userKyc['email'] ?? '') ?>,
  phone: <?= json_encode($userKyc['phone'] ?? '') ?>,
  id_type: <?= json_encode($userKyc['id_type'] ?? '') ?>,
  id_number: <?= json_encode($userKyc['id_number'] ?? '') ?>,
  has_kyc: <?= !empty($userKyc['id_number']) ? 'true' : 'false' ?>
};
</script>

<section class="hero">
  <div class="wrap hero-inner">
    <div class="hero-content">
      <span class="hero-badge">✨ All-in-One Philippine Travel Planner</span>
      <h1>Plan your trip, flights &amp; bucket-list experiences.</h1>
      <p>Set your whole trip budget, pick where you're going, select must-see spots, customize your stay, and compare domestic flights — all in one place.</p>
    </div>
  </div>
</section>

<div class="wrap planner-container">
  <!-- Top Trip Configurator Form -->
  <form class="search-panel" id="search">
    <div class="panel-header">
      <div class="trip-type" role="radiogroup" aria-label="Trip type">
        <label class="radio-label">
          <input type="radio" name="tt" value="round" checked>
          Round Trip
        </label>
        <label class="radio-label">
          <input type="radio" name="tt" value="one">
          One-Way
        </label>
      </div>

      <div class="quick-budgets">
        <span class="budget-label">Quick Budget:</span>
        <button type="button" class="budget-pill" data-amt="30000">₱30K</button>
        <button type="button" class="budget-pill" data-amt="60000">₱60K</button>
        <button type="button" class="budget-pill active" data-amt="100000">₱100K</button>
        <button type="button" class="budget-pill" data-amt="150000">₱150K</button>
        <button type="button" class="budget-pill" data-amt="250000">₱250K</button>
      </div>
    </div>

    <div class="fields-grid">
      <label class="field-item">
        <span class="field-title">🛫 From</span>
        <select id="from"></select>
      </label>

      <button class="swap-btn" type="button" id="swap" aria-label="Swap airports" title="Swap">⇄</button>

      <label class="field-item">
        <span class="field-title">🛬 To</span>
        <select id="to"></select>
      </label>

      <label class="field-item">
        <span class="field-title">📅 Depart</span>
        <input type="date" id="date" required>
      </label>

      <label class="field-item" id="retLbl">
        <span class="field-title">📅 Return</span>
        <input type="date" id="ret">
      </label>

      <label class="field-item">
        <span class="field-title">👥 Pax</span>
        <input type="number" id="pax" min="1" max="9" value="2" required>
      </label>

      <label class="field-item budget-input-item">
        <span class="field-title">💰 Budget (₱)</span>
        <div class="currency-wrap">
          <span class="peso-sign">₱</span>
          <input type="number" id="budget" min="5000" step="1000" value="100000" placeholder="100,000" required>
        </div>
      </label>

      <button class="btn btn-primary submit-btn" type="submit">
        Search ➔
      </button>
    </div>
  </form>

  <!-- Main Planner Workspace -->
  <div class="planner-main">
    <div class="planner-left">
      <!-- Section 1: Destination Plans & Attractions -->
      <section class="planner-card activities-section">
        <div class="section-top">
          <div>
            <div class="destination-tag" id="destTag">🏝️ Destination Highlights: Cebu</div>
            <h2 id="actHeading">What are your plans in Cebu?</h2>
            <p class="section-sub">Select attractions to add to your itinerary, or add custom spots and day trips.</p>
          </div>
          <div class="act-counter-badge" id="actBadge">0 spots selected</div>
        </div>

        <div class="category-chips" id="actFilters">
          <button type="button" class="chip active" data-cat="all">All Plans</button>
          <button type="button" class="chip" data-cat="Sightseeing">Sightseeing</button>
          <button type="button" class="chip" data-cat="Day Trips">Day Trips</button>
          <button type="button" class="chip" data-cat="Adventure">Adventure</button>
          <button type="button" class="chip" data-cat="Nature & Wildlife">Nature & Beach</button>
          <button type="button" class="chip" data-cat="Food & Culture">Food & Culture</button>
        </div>

        <!-- Dynamic Grid of Destination Attractions -->
        <div class="activities-grid" id="actGrid"></div>

        <!-- Selected Plans & Custom Spots Tray -->
        <div class="selected-plans-tray" id="selectedPlansTray" style="display:none;">
          <div class="selected-plans-header">
            <h3><span>📋</span> Your Selected Itinerary</h3>
            <span class="selected-plans-count" id="selectedPlansCount">0 spots</span>
          </div>
          <div id="sideActivitiesList" class="selected-plans-list"></div>
        </div>

        <!-- Custom Activity Form -->
        <div class="custom-activity-box">
          <h3>➕ Add Custom Plan / Activity</h3>
          <p>Have specific restaurants, private tours, or friends to visit? Add them here:</p>
          <div class="custom-act-form">
            <input type="text" id="custName" placeholder="e.g. Dinner at Lantaw, Moalboal diving...">
            <input type="number" id="custCost" placeholder="Est. Cost ₱" min="0" step="100">
            <input type="number" id="custDay" placeholder="Day #" min="1" max="30" value="1" style="max-width:80px;">
            <button type="button" id="btnAddCustom" class="btn btn-secondary">+ Add</button>
          </div>
        </div>
      </section>

      <!-- Section 2: Stays & Accommodation -->
      <section class="planner-card stay-section">
        <div class="section-top">
          <div>
            <div class="destination-tag" style="background:var(--emerald-light);color:var(--emerald);">🏨 Accommodation & Meals</div>
            <h2>Where are you staying?</h2>
            <p class="section-sub">Select your accommodation type. Staying with relatives? Stays &amp; meals are set to ₱0.</p>
          </div>
          <div class="act-counter-badge" id="stayBadgeText" style="background:var(--emerald-light);color:var(--emerald);">Hotel Stay Selected</div>
        </div>

        <div class="stay-options-grid">
          <!-- Option 1: Hotel / Resort -->
          <div class="stay-option-card selected" id="optStayHotel" onclick="chooseStayType('hotel')">
            <input type="radio" name="stay_type" value="hotel" checked style="display:none;">
            <div class="stay-card-title">🏨 Hotel / Resort</div>
            <div class="stay-card-sub">Standard hotel room with daily meal estimate</div>
            <div class="adjuster-input">
              <span>₱</span>
              <input type="number" id="dailyHotel" value="3500" step="500" min="0">
              <small>/ day</small>
            </div>
          </div>

          <!-- Option 2: Relative's Place -->
          <div class="stay-option-card" id="optStayRelative" onclick="chooseStayType('relative')">
            <input type="radio" name="stay_type" value="relative" style="display:none;">
            <div class="stay-card-title">🏠 Relative's Place</div>
            <div class="stay-card-sub">Free accommodation &amp; home meals with family</div>
            <span class="stay-free-badge">₱0 Free Accommodation</span>
            <div id="relativeNotice" style="margin-top:8px;font-size:12px;color:var(--muted);display:none;">
              Meal &amp; stays cost set to <b>₱0</b> in your budget tracker!
            </div>
          </div>

          <!-- Option 3: Hostel -->
          <div class="stay-option-card" id="optStayHostel" onclick="chooseStayType('hostel')">
            <input type="radio" name="stay_type" value="hostel" style="display:none;">
            <div class="stay-card-title">⛺ Hostel / Guesthouse</div>
            <div class="stay-card-sub">Backpacker dorm or budget room</div>
            <div style="margin-top:10px;font-size:13px;font-weight:700;color:var(--ink);">
              Est. ₱1,200 / day
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Right Sidebar: Domestic Flights Board -->
    <aside class="planner-sidebar">
      <section class="planner-card flights-sidebar-section">
        <div class="section-top" style="margin-bottom:12px;">
          <div>
            <h2 id="heading" style="font-size:17px;">🛫 Domestic Flights</h2>
            <small id="sub" style="color:var(--muted);display:block;margin-top:2px;">Compare Philippine domestic airlines.</small>
          </div>
          <div class="sort-control">
            <select id="sort">
              <option value="price">Cheapest</option>
              <option value="dep">Earliest</option>
              <option value="dur">Shortest</option>
            </select>
          </div>
        </div>

        <!-- Selected Flights Pinned Card -->
        <div id="sideSelectedFlightsBanner" class="selected-flights-banner" style="display:none;">
          <div class="banner-title">✓ Selected Flights</div>
          <div id="sideSelectedFlightItems"></div>
        </div>

        <div class="chips airline-chips" id="chips" role="group" aria-label="Airline filter" style="margin-bottom:12px;"></div>

        <div class="board flight-sidebar-board" id="board" aria-live="polite">
          <div class="empty">Search above to view available domestic flights.</div>
        </div>

        <div class="sidebar-book-card" style="margin-top:14px;background:var(--surface-2);border:1px solid var(--line);border-radius:var(--radius-sm);padding:12px;text-align:center;">
          <button type="button" class="btn btn-primary btn-block" onclick="document.getElementById('plannerBottomBar').scrollIntoView({behavior:'smooth'});" style="font-size:13px;padding:9px 14px;">
            Review Complete Plan ➔
          </button>
        </div>
      </section>
    </aside>
  </div>

  <!-- Review & Book Summary Section (In-flow, NOT sticky) -->
  <section class="planner-summary-section" id="plannerBottomBar">
    <div class="summary-section-content">
      <div class="summary-main-info">
        <div class="summary-route-badge" id="botRouteText">Manila ➔ Cebu (4 days · 2 pax)</div>
        <div class="summary-breakdown-pills" id="botItemsSummary">
          <span class="breakdown-pill">✈️ Flights: <b id="botFlightsAmt">₱0</b></span>
          <span class="breakdown-pill">🏝️ Activities: <b id="botActsAmt">₱0</b></span>
          <span class="breakdown-pill">🏨 Stays &amp; Meals: <b id="botStayAmt">₱0</b></span>
        </div>
      </div>
      <div class="summary-actions-wrap">
        <div class="summary-total-block">
          <span class="summary-total-title">Total Estimated Trip Spend</span>
          <b class="summary-total-val" id="botTotalAmt">₱0</b>
          <small class="summary-balance-lbl" id="botRemainingLabel">₱100,000 balance</small>
        </div>
        <button type="button" class="btn btn-primary summary-book-btn" id="btnOpenConfirm">
          Review &amp; Book Complete Plan ➔
        </button>
      </div>
    </div>
  </section>
</div>

<!-- Modal: Complete Trip Plan Confirmation with Passenger KYC -->
<dialog id="dlg">
  <form method="dialog" id="bookForm" class="dialog-card">
    <div class="dialog-header">
      <h2>🎉 Confirm Your Trip Plan</h2>
      <button type="button" class="close-x" onclick="document.getElementById('dlg').close()">✕</button>
    </div>

    <div class="dialog-body">
      <div class="dialog-route-banner" id="modalBanner">
        Manila ➔ Cebu · ₱100,000 Target Budget
      </div>

      <div class="modal-summary-section">
        <h3>✈️ Flight Reservation</h3>
        <div class="sum-details" id="dSumFlights"></div>
      </div>

      <div class="modal-summary-section">
        <h3>🏝️ Planned Activities & Itinerary</h3>
        <div class="sum-details" id="dSumActivities"></div>
      </div>

      <div class="modal-summary-section">
        <h3>🏨 Stay & Accommodation</h3>
        <div class="sum-details" id="dSumStay"></div>
      </div>

      <div class="modal-summary-section">
        <h3>💰 Budget Allocation</h3>
        <div class="sum-details" id="dSumBudget"></div>
      </div>

      <!-- KYC & Passenger Details Section -->
      <div class="kyc-section">
        <div class="kyc-header">
          <h3>👤 Passenger Contact & KYC</h3>
          <span id="kycAutofillBadge" class="kyc-verified-badge" style="display:none;">✓ Autofilled</span>
        </div>

        <div id="kycHintText" class="kyc-hint"></div>

        <div class="kyc-fields" style="margin-bottom:12px;">
          <label>Contact Phone <span id="kycPhoneReq" style="color:var(--accent);">*</span>
            <input type="tel" id="kycPhone" placeholder="0917-xxx-xxxx" required>
          </label>
          <label>Contact Email <span id="kycEmailReq" style="color:var(--accent);">*</span>
            <input type="email" id="kycEmail" required>
          </label>
        </div>

        <div class="kyc-fields">
          <label>Government ID Type <span id="kycIdTypeReq" style="color:var(--accent);">*</span>
            <select id="kycIdType" required>
              <option value="">Select ID Type...</option>
              <option value="Philippine Passport">Philippine Passport</option>
              <option value="Driver's License">Driver's License (LTO)</option>
              <option value="PhilSys National ID">PhilSys National ID</option>
              <option value="UMID">UMID</option>
              <option value="Postal ID">Postal ID</option>
              <option value="PRC ID">PRC Professional ID</option>
              <option value="Voter's ID">Voter's ID / Certification</option>
            </select>
          </label>
          <label>ID Number <span id="kycIdNumReq" style="color:var(--accent);">*</span>
            <input type="text" id="kycIdNumber" placeholder="e.g. P1234567A" required>
          </label>
        </div>
      </div>
    </div>

    <div class="dialog-footer">
      <button class="btn btn-ghost" value="cancel" formnovalidate>Go Back</button>
      <button class="btn btn-primary" value="ok" id="btnConfirmBooking">Confirm & Save Trip</button>
    </div>
  </form>
</dialog>

<div id="toast" role="status"></div>

<script src="../assets/js/travel.js"></script>
<?php include '../includes/footer.php'; ?>
