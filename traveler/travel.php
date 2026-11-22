<?php require '../includes/auth.php'; require_role(['traveler']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Wayfarer PH – Smart Trip Planner, Flights & Experience Hub</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/travel.css">
</head>
<body>

<header>
  <div class="wrap header-wrap">
    <div class="brand-group">
      <a href="dashboard.php" class="brand">
        <span class="brand-badge">PH</span>
        <span>WAYFARER</span>
      </a>
      <span class="brand-tag">Trip & Experience Planner</span>
    </div>
    <nav class="nav-links">
      <a href="dashboard.php">Dashboard</a>
      <a href="travel.php" class="active">Plan Trip & Flights</a>
      <a href="my_trips.php">My Trips</a>
      <a href="itinerary.php">Itinerary</a>
      <a href="expenses.php">Expenses</a>
      <button id="theme" type="button" class="theme-btn" aria-label="Toggle theme">🌓 Theme</button>
      <a href="../account.php" class="user-chip">
        <span class="avatar-dot"></span>
        <span><?= e(user()['name']) ?></span>
      </a>
    </nav>
  </div>
</header>

<section class="hero">
  <div class="wrap hero-inner">
    <div class="hero-content">
      <span class="hero-badge">✨ All-in-One Philippine Travel Planner</span>
      <h1>Plan your trip, flights & bucket-list experiences.</h1>
      <p>Set your whole trip budget (e.g. ₱100,000), pick where you're going, select must-see spots (like Tops Lookout or a day tour to Bohol in Cebu), and book your domestic flights seamlessly.</p>
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
          <span class="radio-custom"></span> Round Trip
        </label>
        <label class="radio-label">
          <input type="radio" name="tt" value="one">
          <span class="radio-custom"></span> One-Way
        </label>
      </div>

      <!-- Quick Preset Budget Pills -->
      <div class="quick-budgets">
        <span class="budget-label">Quick Budget:</span>
        <button type="button" class="budget-pill" data-amt="30000">₱30,000</button>
        <button type="button" class="budget-pill" data-amt="60000">₱60,000</button>
        <button type="button" class="budget-pill active" data-amt="100000">₱100,000</button>
        <button type="button" class="budget-pill" data-amt="150000">₱150,000</button>
        <button type="button" class="budget-pill" data-amt="250000">₱250,000</button>
      </div>
    </div>

    <div class="fields-grid">
      <label class="field-item">
        <span class="field-title">🛫 Origin (From)</span>
        <select id="from"></select>
      </label>

      <button class="swap-btn" type="button" id="swap" aria-label="Swap origin and destination" title="Swap airports">⇄</button>

      <label class="field-item">
        <span class="field-title">🛬 Destination (Going to)</span>
        <select id="to"></select>
      </label>

      <label class="field-item">
        <span class="field-title">📅 Departure Date</span>
        <input type="date" id="date" required>
      </label>

      <label class="field-item" id="retLbl">
        <span class="field-title">📅 Return Date</span>
        <input type="date" id="ret">
      </label>

      <label class="field-item">
        <span class="field-title">👥 Travelers</span>
        <input type="number" id="pax" min="1" max="9" value="2" required>
      </label>

      <label class="field-item budget-input-item">
        <span class="field-title">💰 Whole Trip Budget (₱)</span>
        <div class="currency-wrap">
          <span class="peso-sign">₱</span>
          <input type="number" id="budget" min="5000" step="1000" value="100000" placeholder="100,000" required>
        </div>
      </label>

      <button class="btn btn-primary submit-btn" type="submit">
        <span>Search Flights & Activities</span> ➔
      </button>
    </div>
  </form>

  <!-- Main Planner Workspace -->
  <main class="planner-main">
    <div class="planner-left">
      <!-- Section 1: Destination Plans & Attractions -->
      <section class="planner-card activities-section">
        <div class="section-top">
          <div>
            <div class="destination-tag" id="destTag">🏝️ Destination Highlights: Cebu</div>
            <h2 id="actHeading">What are your plans in Cebu?</h2>
            <p class="section-sub">Select attractions to add to your itinerary, or add custom spots and day trips.</p>
          </div>
          <div class="act-counter-badge" id="actBadge">0 activities selected</div>
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

        <!-- Custom Activity Form -->
        <div class="custom-activity-box">
          <h3>➕ Add Custom Plan / Activity</h3>
          <p>Have specific restaurants, private tours, or friends to visit? Add them here:</p>
          <div class="custom-act-form">
            <input type="text" id="custName" placeholder="e.g. Dinner at Lantaw Floating Resto, Moalboal diving...">
            <input type="number" id="custCost" placeholder="Est. Cost ₱ (optional)" min="0" step="100">
            <input type="number" id="custDay" placeholder="Day #" min="1" max="30" value="1" style="max-width:90px;">
            <button type="button" id="btnAddCustom" class="btn btn-secondary">+ Add to Plan</button>
          </div>
        </div>
      </section>

      <!-- Section 2: Flights Board -->
      <section class="planner-card flights-section">
        <div class="section-top">
          <div>
            <h2 id="heading">Domestic Flights</h2>
            <small id="sub">Choose your route and dates above to compare Philippine airlines.</small>
          </div>
          <div class="sort-control">
            <span>Sort by:</span>
            <select id="sort">
              <option value="price">Cheapest Price</option>
              <option value="dep">Earliest Departure</option>
              <option value="dur">Shortest Flight</option>
            </select>
          </div>
        </div>

        <div class="chips airline-chips" id="chips" role="group" aria-label="Airline filter"></div>

        <div class="board" id="board" aria-live="polite">
          <div class="empty">Click "Search Flights & Activities" to view live scheduled flights.</div>
        </div>
      </section>
    </div>

    <!-- Right Sidebar: Live Budget & Trip Summary -->
    <aside class="planner-sidebar">
      <!-- Live Budget Health Card -->
      <div class="budget-card">
        <div class="budget-header">
          <h3>💰 Trip Budget Tracker</h3>
          <span class="budget-status-pill" id="budgetStatusPill">Healthy</span>
        </div>

        <div class="budget-meter-wrap">
          <div class="budget-gauge">
            <div class="gauge-bar" id="gaugeBar" style="width: 0%;"></div>
          </div>
          <div class="gauge-labels">
            <span id="gaugeAlloc">₱0 used</span>
            <span id="gaugeTotal">of ₱100,000</span>
          </div>
        </div>

        <div class="budget-summary-box">
          <div class="sum-row total-row">
            <span>Total Trip Budget:</span>
            <b id="sideBudget">₱100,000</b>
          </div>

          <hr class="sum-divider">

          <div class="sum-row">
            <span>✈️ Domestic Flights:</span>
            <span id="sideFlightsCost">₱0</span>
          </div>
          <div class="sum-row">
            <span>🏝️ Attractions & Tours:</span>
            <span id="sideActivitiesCost">₱0</span>
          </div>
          <div class="sum-row">
            <span>🏨 Est. Stays & Meals:</span>
            <span id="sideHotelCost">₱0</span>
          </div>

          <hr class="sum-divider">

          <div class="sum-row remaining-row">
            <span>Remaining Balance:</span>
            <b id="sideRemaining">₱100,000</b>
          </div>
        </div>

        <div class="hotel-budget-adjuster">
          <label>
            <span>Estimated hotel & dining daily per room:</span>
            <div class="adjuster-input">
              <span>₱</span>
              <input type="number" id="dailyHotel" value="3500" step="500" min="0">
              <small>/ day</small>
            </div>
          </label>
        </div>
      </div>

      <!-- Current Planned Itinerary Card -->
      <div class="itinerary-preview-card">
        <h3>📋 Trip Plan Summary</h3>
        <div class="trip-route-badge" id="sideRouteBadge">Manila ➔ Cebu</div>
        
        <div class="plan-section">
          <h4 class="plan-sec-title">Selected Flights</h4>
          <div id="sideFlightsList" class="side-flight-items">
            <p class="empty-hint">No flights selected yet.</p>
          </div>
        </div>

        <div class="plan-section">
          <h4 class="plan-sec-title">Planned Places & Activities</h4>
          <div id="sideActivitiesList" class="side-activities-items">
            <p class="empty-hint">No activities selected yet. Check the boxes on the left to add.</p>
          </div>
        </div>

        <button type="button" class="btn btn-primary btn-block confirm-plan-btn" id="btnOpenConfirm">
          <span>Book & Save Complete Trip Plan</span> ➔
        </button>
      </div>

      <!-- Live Previous Bookings -->
      <div class="history-card">
        <h3>🎟️ My Booked Flights</h3>
        <div id="trips" class="tickets-container"></div>
      </div>
    </aside>
  </main>
</div>

<!-- Modal: Complete Trip Plan Confirmation -->
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
        <h3>💰 Budget Allocation Overview</h3>
        <div class="sum-details" id="dSumBudget"></div>
      </div>
    </div>

    <div class="dialog-footer">
      <button class="btn btn-ghost" value="cancel" formnovalidate>Go Back</button>
      <button class="btn btn-primary" value="ok" id="btnConfirmBooking">Confirm Booking & Save Trip</button>
    </div>
  </form>
</dialog>

<div id="toast" role="status"></div>

<script src="../assets/js/travel.js"></script>
</body>
</html>
