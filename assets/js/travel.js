// Philippine Airports with coordinates
const AP = [
  ["MNL", "Manila", "Ninoy Aquino Intl", 14.51, 121.02],
  ["CRK", "Clark", "Clark Intl", 15.19, 120.56],
  ["CEB", "Cebu", "Mactan-Cebu Intl", 10.31, 123.98],
  ["DVO", "Davao", "Francisco Bangoy Intl", 7.13, 125.65],
  ["ILO", "Iloilo", "Iloilo Intl", 10.83, 122.49],
  ["BCD", "Bacolod", "Bacolod-Silay", 10.78, 123.01],
  ["KLO", "Kalibo (Boracay)", "Kalibo Intl", 11.68, 122.38],
  ["MPH", "Caticlan (Boracay)", "Godofredo Ramos", 11.92, 121.95],
  ["PPS", "Puerto Princesa", "Puerto Princesa Intl", 9.74, 118.76],
  ["USU", "Coron (Busuanga)", "Francisco B. Reyes", 12.12, 120.10],
  ["TAG", "Bohol (Panglao)", "Bohol-Panglao Intl", 9.57, 123.76],
  ["CGY", "Cagayan de Oro", "Laguindingan", 8.61, 124.46],
  ["ZAM", "Zamboanga", "Zamboanga Intl", 6.92, 122.06],
  ["TAC", "Tacloban", "Daniel Z. Romualdez", 11.23, 125.03],
  ["LAO", "Laoag", "Laoag Intl", 18.18, 120.53],
  ["IAO", "Siargao", "Sayak", 9.86, 126.01],
  ["BXU", "Butuan", "Bancasi", 8.95, 125.48],
  ["GES", "General Santos", "Gen. Santos Intl", 6.06, 125.10]
].map(([c, city, name, la, ln]) => ({ c, city, name, la, ln }));

// Airlines
const AL = [
  { c: "PR", n: "Philippine Airlines", f: 1.35, bag: "Meal + 23kg bag" },
  { c: "5J", n: "Cebu Pacific", f: 1.0, bag: "7kg carry-on" },
  { c: "Z2", n: "AirAsia Philippines", f: 0.93, bag: "7kg carry-on" },
  { c: "2P", n: "PAL Express", f: 1.12, bag: "Snack + 20kg bag" }
];

// Rich Destination Activities & Attractions database
const DEST_ACTIVITIES = {
  CEB: [
    {
      id: "ceb-1",
      name: "Tops Lookout & Busay Viewpoint",
      cat: "Sightseeing",
      cost: 150,
      dur: "3-4 hrs",
      desc: "Panoramic 360° views over Cebu City and Mactan Island. Best at golden hour sunset with mountain cafes."
    },
    {
      id: "ceb-2",
      name: "Day Tour to Bohol (Chocolate Hills & Tarsiers)",
      cat: "Day Trips",
      cost: 3800,
      dur: "Full Day (9h)",
      desc: "Fastcraft ocean ferry to Tagbilaran, world-famous Chocolate Hills, Loboc River Floating Buffet & Tarsier Sanctuary."
    },
    {
      id: "ceb-3",
      name: "Kawasan Falls & Canyoneering Adventure",
      cat: "Adventure",
      cost: 2500,
      dur: "6-8 hrs",
      desc: "Action-packed cliff jumps, turquoise swimming pools, jungle river trekking, and safety guides in Badian."
    },
    {
      id: "ceb-4",
      name: "Temple of Leah & Sirao Flower Terraces",
      cat: "Food & Culture",
      cost: 450,
      dur: "4 hrs",
      desc: "Visit Cebu's majestic Roman-inspired tribute temple followed by Little Amsterdam's vibrant flower terraces."
    },
    {
      id: "ceb-5",
      name: "Oslob Whale Shark Snorkel & Tumalog Falls",
      cat: "Nature & Wildlife",
      cost: 2200,
      dur: "7 hrs",
      desc: "Swim alongside gentle whale shark giants in open water, followed by the enchanting misty curtain of Tumalog Falls."
    },
    {
      id: "ceb-6",
      name: "Moalboal Sardine Run & Sea Turtle Haven",
      cat: "Nature & Wildlife",
      cost: 1800,
      dur: "5 hrs",
      desc: "Snorkel with millions of swirling sardines just meters off Panagsama Beach and encounter resident sea turtles."
    },
    {
      id: "ceb-7",
      name: "Cebu Heritage Walk & Lechon Food Trail",
      cat: "Food & Culture",
      cost: 800,
      dur: "3 hrs",
      desc: "Magellan's Cross, Basilica del Santo Niño, and an authentic feast of world-famous crispy Cebu lechon."
    }
  ],
  TAG: [
    {
      id: "tag-1",
      name: "Chocolate Hills & Tarsier Sanctuary",
      cat: "Nature & Wildlife",
      cost: 1500,
      dur: "5 hrs",
      desc: "See over 1,200 conical limestone hills and encounter the endangered world's smallest primates in Corella."
    },
    {
      id: "tag-2",
      name: "Loboc River Cruise with Floating Buffet",
      cat: "Food & Culture",
      cost: 1100,
      dur: "2.5 hrs",
      desc: "Relaxing cruise along the emerald Loboc River with live folk serenaders and an authentic Filipino lunch buffet."
    },
    {
      id: "tag-3",
      name: "Balicasag Island Dolphin & Turtle Snorkel",
      cat: "Adventure",
      cost: 2400,
      dur: "5 hrs",
      desc: "Early morning boat safari for wild dolphin watching followed by pristine coral reef turtle snorkeling."
    },
    {
      id: "tag-4",
      name: "Hinagdanan Cave & Panglao Beaches",
      cat: "Sightseeing",
      cost: 350,
      dur: "3 hrs",
      desc: "Natural sunlit limestone cave pool, followed by sunset cocktails on Alona Beach."
    }
  ],
  PPS: [
    {
      id: "pps-1",
      name: "Puerto Princesa Subterranean Underground River",
      cat: "Nature & Wildlife",
      cost: 2500,
      dur: "Full Day",
      desc: "UNESCO World Heritage wonder: paddle through majestic limestone karst caverns with audio guide & buffet."
    },
    {
      id: "pps-2",
      name: "Honda Bay Island Hopping & Snorkel",
      cat: "Day Trips",
      cost: 1800,
      dur: "6 hrs",
      desc: "Island hop across Starfish Island, Luli sandbar, and Cowrie Island with fresh seafood picnic."
    },
    {
      id: "pps-3",
      name: "Firefly Watching Mangrove Cruise",
      cat: "Sightseeing",
      cost: 1200,
      dur: "3 hrs",
      desc: "Magical night boat tour through tranquil mangrove rivers illuminated by thousands of synchronized fireflies."
    }
  ],
  USU: [
    {
      id: "usu-1",
      name: "Coron Ultimate Tour (Kayangan & Twin Lagoon)",
      cat: "Day Trips",
      cost: 2800,
      dur: "Full Day",
      desc: "The cleanest lake in Asia, crystal karst cliffs, Twin Lagoon swim-through, and Skeleton shipwreck snorkel."
    },
    {
      id: "usu-2",
      name: "Maquinit Hot Springs & Mt. Tapyas Sunset",
      cat: "Sightseeing",
      cost: 450,
      dur: "3.5 hrs",
      desc: "Climb 724 steps for panoramic sunset over Coron Bay, followed by relaxing saltwater thermal springs."
    },
    {
      id: "usu-3",
      name: "Calauit Safari Park & Black Island",
      cat: "Adventure",
      cost: 3200,
      dur: "Full Day",
      desc: "Unique African wildlife safari in Palawan with roaming giraffes, zebras, and secluded Black Island caves."
    }
  ],
  MPH: [
    {
      id: "mph-1",
      name: "White Beach Sunset Paraw Sailing",
      cat: "Sightseeing",
      cost: 1200,
      dur: "1 hr",
      desc: "Gliding across Boracay's sparkling azure waters on a traditional outrigger sailboat during iconic sunset."
    },
    {
      id: "mph-2",
      name: "Ariel's Point Cliff Diving & Beach Day",
      cat: "Adventure",
      cost: 2800,
      dur: "Full Day",
      desc: "5 cliff jumping platforms up to 15m, unlimited BBQ buffet, ocean kayaking, and party boat cruise."
    },
    {
      id: "mph-3",
      name: "Boracay Island Hopping & Puka Beach",
      cat: "Day Trips",
      cost: 1500,
      dur: "4 hrs",
      desc: "Snorkel Crocodile Island reefs, explore Crystal Cove, and walk the shell-strewn sands of Puka Beach."
    },
    {
      id: "mph-4",
      name: "Scuba Diving or Helmet Ocean Walk",
      cat: "Adventure",
      cost: 1800,
      dur: "2 hrs",
      desc: "Walk along the ocean floor or take your first discovery scuba dive with certified PADI divemasters."
    }
  ],
  KLO: [
    {
      id: "klo-1",
      name: "Boracay Island Hopping & Sunset Paraw",
      cat: "Day Trips",
      cost: 2200,
      dur: "Full Day",
      desc: "Transfer & island hopping package including Puka Beach, snorkeling, and sunset sailing."
    }
  ],
  IAO: [
    {
      id: "iao-1",
      name: "Cloud 9 Boardwalk & Surfing Lesson",
      cat: "Adventure",
      cost: 800,
      dur: "2 hrs",
      desc: "Iconic wooden surf walkway and private 1-on-1 surf lesson with accredited Siargao surf instructor."
    },
    {
      id: "iao-2",
      name: "Sugba Lagoon & Magpupungko Rock Pools",
      cat: "Nature & Wildlife",
      cost: 2200,
      dur: "Full Day",
      desc: "Paddleboard in brilliant emerald lagoon and swim in low-tide natural infinity rock tidal pools."
    },
    {
      id: "iao-3",
      name: "Siargao Tri-Island Tour (Guyam, Daku, Naked)",
      cat: "Day Trips",
      cost: 1600,
      dur: "6 hrs",
      desc: "Three tropical postcard islets with fresh grilled boodle fight feast prepared on Daku Island."
    },
    {
      id: "iao-4",
      name: "Sohoton Cove & Jellyfish Sanctuary",
      cat: "Adventure",
      cost: 3200,
      dur: "Full Day",
      desc: "Hidden tidal caves in Bucas Grande and swim with harmless, stingless golden jellyfish."
    }
  ],
  DVO: [
    {
      id: "dvo-1",
      name: "Eden Nature Park & Mountain Skycycle",
      cat: "Nature & Wildlife",
      cost: 1100,
      dur: "5 hrs",
      desc: "Pine tree highland reserve at Mt. Apo foothills with skycycle, bird sanctuary, and buffet lunch."
    },
    {
      id: "dvo-2",
      name: "Samal Island Beach Cruise & Vanishing Island",
      cat: "Day Trips",
      cost: 1800,
      dur: "6 hrs",
      desc: "Hop aboard a coastal catamaran for pristine white sand beaches and coral reef snorkeling."
    },
    {
      id: "dvo-3",
      name: "Malagos Chocolate Experience & Bird Show",
      cat: "Food & Culture",
      cost: 750,
      dur: "3.5 hrs",
      desc: "Bean-to-bar single-origin Philippine chocolate tasting, museum, and interactive park."
    }
  ],
  MNL: [
    {
      id: "mnl-1",
      name: "Intramuros Bamboo Bike Tour & Fort Santiago",
      cat: "Food & Culture",
      cost: 700,
      dur: "2.5 hrs",
      desc: "Pedal handcrafted bamboo bikes across 400-year-old Spanish fortress bastions, dungeons, and San Agustin."
    },
    {
      id: "mnl-2",
      name: "Binondo Chinatown Food Walking Crawl",
      cat: "Food & Culture",
      cost: 950,
      dur: "3 hrs",
      desc: "Sample fried siopao, soup dumplings, authentic lumpia, and sugar-crusted egg tarts in the world's oldest Chinatown."
    },
    {
      id: "mnl-3",
      name: "BGC Mind Museum & Night Market",
      cat: "Sightseeing",
      cost: 650,
      dur: "3 hrs",
      desc: "Explore modern interactive science galleries followed by open-air Bonifacio High Street dining."
    }
  ]
};

// Utilities
const $ = s => document.querySelector(s);
const $$ = s => document.querySelectorAll(s);
const peso = n => "₱" + Math.round(n).toLocaleString("en-PH");
const byC = c => AP.find(a => a.c === c);
const dmy = d => d ? new Date(d + "T00:00").toLocaleDateString("en-PH", { weekday: "short", day: "numeric", month: "short" }) : "";
const hhmm = m => {
  m %= 1440;
  return String(Math.floor(m / 60)).padStart(2, "0") + ":" + String(m % 60).padStart(2, "0");
};

// Application State
let airline = "All";
let stage = "out";
let round = true;
let outFlight = null;
let retFlight = null;
let curFlights = [];
let query = {};
let selectedActivities = [];
let customActivities = [];
let activeCat = "all";
let bookings = [];
let lastV = "";

// Toast notification helper
const toast = m => {
  const t = $("#toast");
  t.textContent = m;
  t.classList.add("on");
  setTimeout(() => t.classList.remove("on"), 2600);
};

// Populate Airport dropdowns
const opts = AP.map(a => `<option value="${a.c}">${a.city} (${a.c}) - ${a.name}</option>`).join("");
$("#from").innerHTML = opts;
$("#to").innerHTML = opts;
$("#from").value = "MNL";
$("#to").value = "CEB";

// Date defaults
const today = new Date();
const iso = n => new Date(today.getTime() + 864e5 * n).toISOString().slice(0, 10);
$("#date").min = $("#ret").min = iso(0);
$("#date").value = iso(14);
$("#ret").value = iso(18);

// Swap button
$("#swap").onclick = () => {
  const f = $("#from").value;
  $("#from").value = $("#to").value;
  $("#to").value = f;
  onDestinationChange();
};

// Trip Type switcher (Round trip / One way)
$$("[name=tt]").forEach(r =>
  r.addEventListener("change", () => {
    round = document.querySelector("[name=tt]:checked").value === "round";
    $("#retLbl").style.display = round ? "grid" : "none";
    updateBudgetCalculations();
  })
);

// Quick Budget Preset Pills
$$(".budget-pill").forEach(b => {
  b.addEventListener("click", () => {
    $$(".budget-pill").forEach(p => p.classList.remove("active"));
    b.classList.add("active");
    $("#budget").value = b.dataset.amt;
    updateBudgetCalculations();
  });
});

$("#budget").addEventListener("input", () => {
  const currentVal = +$("#budget").value;
  $$(".budget-pill").forEach(p => {
    p.classList.toggle("active", +p.dataset.amt === currentVal);
  });
  updateBudgetCalculations();
});

$("#pax").addEventListener("input", updateBudgetCalculations);
$("#dailyHotel").addEventListener("input", updateBudgetCalculations);

// Airline chips filter
function renderAirlineChips() {
  $("#chips").innerHTML = ["All", ...AL.map(a => a.n)]
    .map(n => `<button type="button" class="chip ${n === airline ? "active" : ""}" data-a="${n}">${n}</button>`)
    .join("");
}

$("#chips").addEventListener("click", e => {
  const b = e.target.closest(".chip");
  if (b) {
    airline = b.dataset.a;
    renderAirlineChips();
    renderFlights();
  }
});

// Category filter chips for Activities
$("#actFilters").addEventListener("click", e => {
  const b = e.target.closest(".chip");
  if (!b) return;
  $$("#actFilters .chip").forEach(c => c.classList.remove("active"));
  b.classList.add("active");
  activeCat = b.dataset.cat;
  renderActivitiesGrid();
});

// Destination change handler
function onDestinationChange() {
  const destCode = $("#to").value;
  const destCity = byC(destCode)?.city || destCode;
  $("#destTag").textContent = `🏝️ Destination Highlights: ${destCity}`;
  $("#actHeading").textContent = `What are your plans in ${destCity}?`;
  renderActivitiesGrid();
  updateBudgetCalculations();
}

$("#to").addEventListener("change", onDestinationChange);

// Render activities grid for currently selected destination
function renderActivitiesGrid() {
  const destCode = $("#to").value;
  let list = DEST_ACTIVITIES[destCode] || [];

  if (activeCat !== "all") {
    list = list.filter(a => a.cat === activeCat);
  }

  if (!list.length) {
    $("#actGrid").innerHTML = `
      <div class="empty" style="grid-column: 1 / -1; padding: 24px; background: var(--surface-2); border-radius: var(--radius-md);">
        No pre-listed activities under this category for ${byC(destCode)?.city || destCode}. You can add custom plans below!
      </div>`;
    return;
  }

  $("#actGrid").innerHTML = list
    .map(act => {
      const isSelected = selectedActivities.some(a => a.id === act.id);
      return `
      <div class="act-card ${isSelected ? "selected" : ""}" data-id="${act.id}">
        <div class="act-card-top">
          <span class="act-cat-tag" data-cat="${act.cat}">${act.cat}</span>
          <span class="act-duration">⏱️ ${act.dur}</span>
        </div>
        <h4>${act.name}</h4>
        <p>${act.desc}</p>
        <div class="act-card-bottom">
          <div class="act-price">
            <b>${peso(act.cost)}</b>
            <small>per traveler</small>
          </div>
          <button type="button" class="act-toggle-btn" data-act-id="${act.id}">
            ${isSelected ? "✓ In My Plan" : "+ Add to Plan"}
          </button>
        </div>
      </div>
    `;
    })
    .join("");
}

// Toggle an activity into or out of the plan
$("#actGrid").addEventListener("click", e => {
  const btn = e.target.closest("[data-act-id]");
  if (!btn) return;
  const actId = btn.dataset.actId;
  const destCode = $("#to").value;
  const catalog = DEST_ACTIVITIES[destCode] || [];
  const item = catalog.find(x => x.id === actId);
  if (!item) return;

  const idx = selectedActivities.findIndex(x => x.id === actId);
  if (idx >= 0) {
    selectedActivities.splice(idx, 1);
  } else {
    selectedActivities.push({ ...item, day: selectedActivities.length + 1 });
  }

  renderActivitiesGrid();
  updateBudgetCalculations();
});

// Add custom activity
$("#btnAddCustom").addEventListener("click", () => {
  const name = $("#custName").value.trim();
  const cost = +$("#custCost").value || 0;
  const day = +$("#custDay").value || 1;

  if (!name) {
    toast("Please enter an activity or spot name");
    return;
  }

  const customItem = {
    id: "custom-" + Date.now(),
    name,
    cat: "Custom Plan",
    cost,
    dur: "Custom",
    day,
    desc: "Custom user-planned spot"
  };

  selectedActivities.push(customItem);
  $("#custName").value = "";
  $("#custCost").value = "";
  toast(`Added "${name}" to your plan`);
  updateBudgetCalculations();
});

// Remove activity from sidebar
$("#sideActivitiesList").addEventListener("click", e => {
  const remBtn = e.target.closest("[data-rem-id]");
  if (!remBtn) return;
  const id = remBtn.dataset.remId;
  selectedActivities = selectedActivities.filter(a => a.id !== id);
  renderActivitiesGrid();
  updateBudgetCalculations();
});

// Fetch Flights from DB / API
async function fetchFlights(o, d, date) {
  const r = await fetch(`../api/flights.php?o=${o}&d=${d}&date=${date}`, { cache: "no-store" });
  let data;
  try {
    data = JSON.parse(await r.text());
  } catch (e) {
    throw new Error("Could not retrieve flight schedules. Check that XAMPP/MySQL is running.");
  }
  return data.map(f => ({
    id: f.id,
    o: f.o,
    d: f.d,
    date: f.date,
    al: { n: f.airline, bag: f.seats + " seats left" },
    no: f.no,
    dep: f.dep,
    arr: f.dep + f.dur,
    dur: f.dur,
    price: f.price
  }));
}

// Search Form submit
$("#search").addEventListener("submit", async e => {
  e.preventDefault();
  const o = $("#from").value;
  const d = $("#to").value;
  if (o === d) {
    toast("Please choose two different airports");
    return;
  }

  round = document.querySelector("[name=tt]:checked").value === "round";
  if (round && $("#ret").value < $("#date").value) {
    toast("Return date must be on or after departure date");
    return;
  }

  query = {
    o,
    d,
    date: $("#date").value,
    ret: $("#ret").value,
    pax: +$("#pax").value || 1,
    budget: +$("#budget").value || 100000
  };

  stage = "out";
  outFlight = null;
  retFlight = null;

  try {
    curFlights = await fetchFlights(o, d, query.date);
  } catch (err) {
    $("#board").innerHTML = `<div class="empty">${err.message}</div>`;
    return;
  }

  renderFlights();
  updateBudgetCalculations();
  toast("Flight board and destination plans updated!");
  $("#board").scrollIntoView({ behavior: "smooth", block: "nearest" });
});

// Render Flights board
function renderFlights() {
  if (!curFlights.length && !query.o) return;

  const from = stage === "out" ? query.o : query.d;
  const to = stage === "out" ? query.d : query.o;
  const date = stage === "out" ? query.date : query.ret;

  $("#heading").textContent = `${from} ➔ ${to}`;
  $("#sub").textContent =
    (round
      ? stage === "out"
        ? "Step 1 of 2: Select your Outbound flight · "
        : "Step 2 of 2: Select your Return flight · "
      : "") +
    dmy(date) +
    " · " +
    query.pax +
    " traveler" +
    (query.pax > 1 ? "s" : "");

  const s = $("#sort").value;
  const list = curFlights
    .filter(f => airline === "All" || f.al.n === airline)
    .sort((a, b) => (s === "price" ? a.price - b.price : s === "dep" ? a.dep - b.dep : a.dur - b.dur));

  $("#board").innerHTML = list.length
    ? list
        .map(
          f => `
      <div class="flight-row">
        <div class="flight-times">${hhmm(f.dep)}<span>›</span>${hhmm(f.arr)}</div>
        <div class="flight-details">
          <h3>${f.al.n} · ${f.no}</h3>
          <small>${Math.floor(f.dur / 60)}h ${f.dur % 60}m · Nonstop · ${f.al.bag}</small>
        </div>
        <div class="flight-price">
          ${peso(f.price * query.pax)}
          <small>${query.pax > 1 ? peso(f.price) + " / pax" : "per passenger"}</small>
        </div>
        <div class="flight-action">
          <button type="button" class="btn btn-primary" data-fid="${f.id}">Select</button>
        </div>
      </div>
    `
        )
        .join("")
    : `<div class="empty">
        ${
          curFlights.length
            ? "No flights found for " + airline + ". Try selecting 'All' airlines."
            : "No flights scheduled on this route yet. You can generate sample flights in Admin > Flights, or select another route."
        }
      </div>`;
}

$("#sort").addEventListener("input", renderFlights);

// Handle Flight Selection
$("#board").addEventListener("click", async e => {
  const btn = e.target.closest("[data-fid]");
  if (!btn) return;
  const f = curFlights.find(x => x.id === btn.dataset.fid);

  if (round && stage === "out") {
    outFlight = f;
    stage = "ret";
    toast("Outbound flight chosen! Now choose your return flight.");
    try {
      curFlights = await fetchFlights(query.d, query.o, query.ret);
    } catch (err) {
      toast(err.message);
      return;
    }
    renderFlights();
    updateBudgetCalculations();
    return;
  }

  if (round && stage === "ret") {
    retFlight = f;
    toast("Return flight chosen!");
  } else {
    outFlight = f;
    toast("Flight chosen!");
  }

  updateBudgetCalculations();
});

// Master Budget & Plan Calculation Engine
function updateBudgetCalculations() {
  const pax = Math.max(1, +$("#pax").value || 1);
  const totalBudget = Math.max(0, +$("#budget").value || 100000);
  const dailyHotel = Math.max(0, +$("#dailyHotel").value || 3500);

  // Calculate Days
  let days = 4;
  if ($("#date").value && $("#ret").value && round) {
    const d1 = new Date($("#date").value);
    const d2 = new Date($("#ret").value);
    const diff = Math.round((d2 - d1) / 864e5);
    days = Math.max(1, diff || 1);
  }

  // 1. Flights Cost
  let flightsCost = 0;
  if (outFlight) flightsCost += outFlight.price * pax;
  if (retFlight) flightsCost += retFlight.price * pax;

  // 2. Activities Cost
  const activitiesCost = selectedActivities.reduce((acc, a) => acc + (a.cost || 0) * pax, 0);

  // 3. Hotel & Meals Cost
  const hotelCost = dailyHotel * days;

  // Totals
  const totalAllocated = flightsCost + activitiesCost + hotelCost;
  const remaining = totalBudget - totalAllocated;

  // Update Sidebar Numbers
  $("#sideBudget").textContent = peso(totalBudget);
  $("#sideFlightsCost").textContent = peso(flightsCost);
  $("#sideActivitiesCost").textContent = peso(activitiesCost);
  $("#sideHotelCost").textContent = peso(hotelCost);
  $("#sideRemaining").textContent = peso(remaining);

  const remainingRow = $("#sideRemaining").parentElement;
  remainingRow.classList.toggle("negative", remaining < 0);

  // Gauge Meter
  const pct = totalBudget > 0 ? Math.min(100, Math.round((totalAllocated / totalBudget) * 100)) : 0;
  const gaugeBar = $("#gaugeBar");
  gaugeBar.style.width = pct + "%";
  gaugeBar.classList.toggle("over", remaining < 0);

  $("#gaugeAlloc").textContent = `${peso(totalAllocated)} (${pct}%) used`;
  $("#gaugeTotal").textContent = `of ${peso(totalBudget)}`;

  // Budget Status Pill
  const pill = $("#budgetStatusPill");
  if (remaining < 0) {
    pill.textContent = "Over Budget";
    pill.className = "budget-status-pill danger";
  } else if (pct > 80) {
    pill.textContent = "Nearing Limit";
    pill.className = "budget-status-pill warning";
  } else {
    pill.textContent = "Healthy";
    pill.className = "budget-status-pill";
  }

  // Route & Destination tags
  const fromCity = byC($("#from").value)?.city || $("#from").value;
  const toCity = byC($("#to").value)?.city || $("#to").value;
  $("#sideRouteBadge").textContent = `${fromCity} ➔ ${toCity} (${days} days · ${pax} pax)`;
  $("#actBadge").textContent = `${selectedActivities.length} spot${selectedActivities.length === 1 ? "" : "s"} selected`;

  // Render Selected Flights preview
  if (outFlight || retFlight) {
    let flHtml = "";
    if (outFlight) {
      flHtml += `
        <div class="side-item">
          <div class="side-item-info">
            <b>🛫 ${outFlight.o} ➔ ${outFlight.d}</b>
            <span>${outFlight.al.n} · ${dmy(outFlight.date)} (${hhmm(outFlight.dep)})</span>
          </div>
          <b>${peso(outFlight.price * pax)}</b>
        </div>
      `;
    }
    if (retFlight) {
      flHtml += `
        <div class="side-item">
          <div class="side-item-info">
            <b>🛬 ${retFlight.o} ➔ ${retFlight.d}</b>
            <span>${retFlight.al.n} · ${dmy(retFlight.date)} (${hhmm(retFlight.dep)})</span>
          </div>
          <b>${peso(retFlight.price * pax)}</b>
        </div>
      `;
    }
    $("#sideFlightsList").innerHTML = flHtml;
  } else {
    $("#sideFlightsList").innerHTML = `<p class="empty-hint">No flights selected yet.</p>`;
  }

  // Render Selected Activities in Sidebar
  if (selectedActivities.length) {
    $("#sideActivitiesList").innerHTML = selectedActivities
      .map(
        a => `
      <div class="side-item">
        <div class="side-item-info">
          <b>${a.name}</b>
          <span>Day ${a.day || 1} · ${a.cat} · ${peso(a.cost)}/pax</span>
        </div>
        <div style="display:flex;align-items:center;gap:6px">
          <b>${peso(a.cost * pax)}</b>
          <button type="button" class="side-item-remove" data-rem-id="${a.id}" title="Remove">✕</button>
        </div>
      </div>
    `
      )
      .join("");
  } else {
    $("#sideActivitiesList").innerHTML = `<p class="empty-hint">No activities selected yet. Check boxes on the left to add.</p>`;
  }
}

// Open Confirmation Modal
$("#btnOpenConfirm").addEventListener("click", () => {
  const pax = Math.max(1, +$("#pax").value || 1);
  const totalBudget = Math.max(0, +$("#budget").value || 100000);
  const toCity = byC($("#to").value)?.city || $("#to").value;
  const fromCity = byC($("#from").value)?.city || $("#from").value;

  $("#modalBanner").textContent = `${fromCity} ➔ ${toCity} · ${peso(totalBudget)} Target Budget (${pax} Traveler${pax > 1 ? "s" : ""})`;

  // Flights summary
  const legs = [outFlight, retFlight].filter(Boolean);
  if (legs.length) {
    $("#dSumFlights").innerHTML = legs
      .map(
        l => `
      <div>
        <span>${l.o} ➔ ${l.d} (${l.al.n} ${l.no})</span>
        <b>${dmy(l.date)} ${hhmm(l.dep)}–${hhmm(l.arr)}</b>
      </div>
    `
      )
      .join("");
  } else {
    $("#dSumFlights").innerHTML = `<div><span>No flights selected</span><em>Optional (can be booked later)</em></div>`;
  }

  // Activities summary
  if (selectedActivities.length) {
    $("#dSumActivities").innerHTML = selectedActivities
      .map(
        a => `
      <div>
        <span>${a.name} (Day ${a.day || 1})</span>
        <b>${peso(a.cost * pax)}</b>
      </div>
    `
      )
      .join("");
  } else {
    $("#dSumActivities").innerHTML = `<div><span>No activities added yet</span><em>Add spots like Tops Lookout or Bohol tours</em></div>`;
  }

  // Budget summary
  const flightsCost = legs.reduce((acc, l) => acc + l.price * pax, 0);
  const actsCost = selectedActivities.reduce((acc, a) => acc + a.cost * pax, 0);
  const hotelCost = (+$("#dailyHotel").value || 3500) * 4;
  const totalSpend = flightsCost + actsCost + hotelCost;
  const remaining = totalBudget - totalSpend;

  $("#dSumBudget").innerHTML = `
    <div><span>Flights (${legs.length} legs × ${pax} pax):</span><b>${peso(flightsCost)}</b></div>
    <div><span>Activities & Sightseeing:</span><b>${peso(actsCost)}</b></div>
    <div><span>Est. Hotel & Meals:</span><b>${peso(hotelCost)}</b></div>
    <div style="border-top:1px dashed var(--line);padding-top:4px"><span>Total Estimated Trip Cost:</span><b>${peso(totalSpend)}</b></div>
    <div><span>Remaining Balance:</span><b style="color:${remaining >= 0 ? "var(--emerald)" : "var(--danger)"}">${peso(remaining)}</b></div>
  `;

  $("#dlg").showModal();
});

// Confirm and Save Complete Trip
$("#bookForm").addEventListener("submit", async e => {
  if (!e.submitter || e.submitter.value !== "ok") return;

  const pax = Math.max(1, +$("#pax").value || 1);
  const totalBudget = Math.max(0, +$("#budget").value || 100000);
  const toCity = byC($("#to").value)?.city || $("#to").value;
  const legs = [outFlight, retFlight].filter(Boolean).map(l => l.id);
  const dailyHotel = +$("#dailyHotel").value || 3500;

  const payload = {
    title: `Trip to ${toCity} (${peso(totalBudget)} Budget)`,
    destination: toCity,
    budget: totalBudget,
    start_date: $("#date").value,
    end_date: round ? $("#ret").value : $("#date").value,
    pax,
    legs,
    activities: selectedActivities.map(a => ({
      name: a.name,
      day: a.day || 1,
      cost: a.cost || 0
    })),
    hotel_est: dailyHotel * 4
  };

  try {
    const res = await fetch("../actions/trip_plan_process.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload)
    });
    const d = await res.json();

    if (d.ok) {
      toast("🎉 Trip, planned activities & flights successfully saved!");
      $("#dlg").close();
      outFlight = null;
      retFlight = null;
      stage = "out";
      loadBookings();
      setTimeout(() => {
        window.location.href = "my_trips.php";
      }, 1500);
    } else {
      toast(d.error || "Failed to save trip plan.");
    }
  } catch (err) {
    toast("Server error. Please ensure local Apache & MySQL are running.");
  }
});

// Load Previous Bookings via live polling
async function loadBookings() {
  try {
    const r = await fetch("../api/poll.php?t=flight_bookings", { cache: "no-store" });
    const d = await r.json();
    if (d.v !== lastV) {
      lastV = d.v;
      bookings = d.rows;
      drawBookings();
    }
  } catch (e) {}
}

function drawBookings() {
  $("#trips").innerHTML = bookings.length
    ? bookings
        .map(
          t => `
      <div class="ticket">
        <b>${t.outbound}</b>
        ${t.inbound ? `<div>${t.inbound}</div>` : ""}
        <div class="ticket-meta">${t.pax} pax · ${peso(+t.total)} · <span class="ticket-status">${t.status}</span></div>
        <div>Ref: <span class="ticket-ref">${t.ref}</span></div>
        ${
          t.status !== "cancelled"
            ? `<button type="button" class="btn btn-danger" data-cancel-id="${t.id}" style="margin-top:6px;font-size:12px;padding:4px 10px;">Cancel Flight</button>`
            : ""
        }
      </div>
    `
        )
        .join("")
    : `<p class="empty-hint">No active bookings yet.</p>`;
}

// Cancel Booking
$("#trips").addEventListener("click", async e => {
  const b = e.target.closest("[data-cancel-id]");
  if (!b) return;
  if (!confirm("Are you sure you want to cancel this flight reservation?")) return;

  await fetch("../actions/flight_booking_process.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ cancel: +b.dataset.cancelId })
  });
  lastV = "";
  loadBookings();
  toast("Flight reservation cancelled.");
});

// Dark / Light Theme Toggle
$("#theme").addEventListener("click", () => {
  const r = document.documentElement;
  const isDark = r.dataset.theme ? r.dataset.theme === "dark" : matchMedia("(prefers-color-scheme:dark)").matches;
  r.dataset.theme = isDark ? "light" : "dark";
});

// Initialization
renderAirlineChips();
onDestinationChange();
loadBookings();
setInterval(loadBookings, 4000);
