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
  doSearch(true);
};

// Trip Type switcher (Round trip / One way)
$$("[name=tt]").forEach(r =>
  r.addEventListener("change", () => {
    round = document.querySelector("[name=tt]:checked").value === "round";
    $("#retLbl").style.display = round ? "" : "none";
    if (!round) {
      retFlight = null;
      if (stage === "ret") stage = "out";
    }
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

$("#to").addEventListener("change", () => {
  onDestinationChange();
  doSearch(true);
});

$("#from").addEventListener("change", () => {
  doSearch(true);
});

$("#date").addEventListener("change", () => {
  $("#ret").min = $("#date").value;
  if ($("#ret").value < $("#date").value) {
    $("#ret").value = $("#date").value;
  }
  updateBudgetCalculations();
  doSearch(true);
});

$("#ret").addEventListener("change", () => {
  updateBudgetCalculations();
  if (round && stage === "ret") {
    doSearch(true);
  }
});

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

// Render Selected Plans & Custom Spots Tray
function renderSelectedPlans() {
  const container = $("#selectedPlansTray");
  const list = $("#sideActivitiesList");
  const countBadge = $("#selectedPlansCount");
  const pax = Math.max(1, +$("#pax").value || 1);

  if (!container || !list) return;

  if (!selectedActivities.length) {
    container.style.display = "none";
    list.innerHTML = "";
    return;
  }

  container.style.display = "block";
  const totalActsSpend = selectedActivities.reduce((acc, a) => acc + (a.cost || 0) * pax, 0);
  if (countBadge) {
    countBadge.textContent = `${selectedActivities.length} spot${selectedActivities.length === 1 ? "" : "s"} · Total ${peso(totalActsSpend)}`;
  }

  list.innerHTML = selectedActivities
    .map(
      a => `
    <div class="selected-plan-card">
      <div class="plan-info">
        <span class="plan-day-tag">Day ${a.day || 1}</span>
        <span class="plan-name">${a.name}</span>
      </div>
      <div style="display:flex;align-items:center;gap:12px;">
        <span class="plan-cost">${peso((a.cost || 0) * pax)}${pax > 1 ? ` <small style="color:var(--muted);font-weight:normal;">(${peso(a.cost)}/pax)</small>` : ""}</span>
        <button type="button" class="plan-rem-btn" data-rem-id="${a.id}" title="Remove this spot">✕</button>
      </div>
    </div>
  `
    )
    .join("");
}

// Remove activity from tray or list
const sideActList = $("#sideActivitiesList");
if (sideActList) {
  sideActList.addEventListener("click", e => {
    const remBtn = e.target.closest("[data-rem-id]");
    if (!remBtn) return;
    const id = remBtn.dataset.remId;
    selectedActivities = selectedActivities.filter(a => a.id !== id);
    renderActivitiesGrid();
    updateBudgetCalculations();
  });
}

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
    id: String(f.id),
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

// Master Flight & Itinerary Search
async function doSearch(silent = false) {
  const o = $("#from").value;
  const d = $("#to").value;
  if (o === d) {
    if (!silent) toast("Please choose two different airports");
    return;
  }

  round = document.querySelector("[name=tt]:checked").value === "round";
  if (round && $("#ret").value < $("#date").value) {
    if (!silent) toast("Return date must be on or after departure date");
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
  if (!silent) {
    toast("Flight board and destination plans updated!");
    $("#board").scrollIntoView({ behavior: "smooth", block: "nearest" });
  }
}

// Search Form submit
$("#search").addEventListener("submit", async e => {
  e.preventDefault();
  await doSearch(false);
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
        ? "Step 1 of 2: Select Outbound flight · "
        : "Step 2 of 2: Select Return flight · "
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

  const activeSelectedId = stage === "out" ? outFlight?.id : retFlight?.id;

  $("#board").innerHTML = list.length
    ? list
        .map(f => {
          const isSel = String(f.id) === String(activeSelectedId);
          return `
      <div class="flight-row ${isSel ? "selected" : ""}">
        <div class="flight-row-top">
          <div class="flight-times">${hhmm(f.dep)}<span>›</span>${hhmm(f.arr)}</div>
          <div class="flight-details" style="text-align:right;">
            <h3>${f.al.n}</h3>
            <small>${f.no} · ${Math.floor(f.dur / 60)}h ${f.dur % 60}m</small>
          </div>
        </div>
        <div class="flight-row-bottom">
          <div class="flight-price">
            ${peso(f.price * query.pax)}
            <small>${query.pax > 1 ? peso(f.price) + " / pax" : "total fare"}</small>
          </div>
          <div class="flight-action">
            <button type="button" class="btn ${isSel ? "btn-selected" : "btn-primary"}" data-fid="${f.id}">
              ${isSel ? "✓ Selected" : "Select"}
            </button>
          </div>
        </div>
      </div>
    `;
        })
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
  const f = curFlights.find(x => String(x.id) === String(btn.dataset.fid));
  if (!f) return;

  if (round && stage === "out") {
    outFlight = f;
    stage = "ret";
    toast("Outbound flight chosen! Loading return flights...");
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

  renderFlights();
  updateBudgetCalculations();
});

// Re-select / change flight helper
async function reselectFlight(which) {
  if (which === "out") {
    stage = "out";
    try {
      curFlights = await fetchFlights(query.o, query.d, query.date);
    } catch (err) {
      toast(err.message);
      return;
    }
    renderFlights();
    toast("Showing outbound flights to re-select");
  } else if (which === "ret") {
    stage = "ret";
    try {
      curFlights = await fetchFlights(query.d, query.o, query.ret);
    } catch (err) {
      toast(err.message);
      return;
    }
    renderFlights();
    toast("Showing return flights to re-select");
  }
}
window.reselectFlight = reselectFlight;

// Stay arrangement state (Hotel vs Relative vs Hostel)
let currentStayType = "hotel";

function chooseStayType(type) {
  currentStayType = type;
  const hotelCard = $("#optStayHotel");
  const relCard = $("#optStayRelative");
  const hostelCard = $("#optStayHostel");
  const badge = $("#stayBadgeText");
  const relNotice = $("#relativeNotice");

  [hotelCard, relCard, hostelCard].forEach(c => c && c.classList.remove("selected"));

  if (type === "relative") {
    if (relCard) relCard.classList.add("selected");
    if (badge) {
      badge.textContent = "Relative's Place (₱0 Stays & Meals)";
      badge.style.background = "var(--emerald-light)";
      badge.style.color = "var(--emerald)";
    }
    if (relNotice) relNotice.style.display = "block";
    toast("🏠 Stays & Meals set to ₱0 (Staying with Relatives/Friends)");
  } else if (type === "hostel") {
    if (hostelCard) hostelCard.classList.add("selected");
    if (badge) {
      badge.textContent = "Hostel / Budget Stay (₱1,200/day)";
      badge.style.background = "var(--accent-light)";
      badge.style.color = "var(--accent-ink)";
    }
    if (relNotice) relNotice.style.display = "none";
  } else {
    if (hotelCard) hotelCard.classList.add("selected");
    if (badge) {
      badge.textContent = "Hotel Stay Selected";
      badge.style.background = "rgba(2, 132, 199, 0.1)";
      badge.style.color = "var(--primary)";
    }
    if (relNotice) relNotice.style.display = "none";
  }

  updateBudgetCalculations();
}
window.chooseStayType = chooseStayType;

// Calculate trip duration in days
function getTripDays() {
  if ($("#date").value && $("#ret").value && round) {
    const d1 = new Date($("#date").value);
    const d2 = new Date($("#ret").value);
    const diff = Math.round((d2 - d1) / 864e5);
    return Math.max(1, diff || 1);
  }
  return 1;
}

// Master Budget & Plan Calculation Engine
function updateBudgetCalculations() {
  const pax = Math.max(1, +$("#pax").value || 1);
  const totalBudget = Math.max(0, +$("#budget").value || 100000);
  const dailyHotel = Math.max(0, +$("#dailyHotel")?.value || 3500);

  // Calculate Days
  const days = getTripDays();

  // 1. Flights Cost
  let flightsCost = 0;
  if (outFlight) flightsCost += outFlight.price * pax;
  if (retFlight) flightsCost += retFlight.price * pax;

  // 2. Activities Cost
  const activitiesCost = selectedActivities.reduce((acc, a) => acc + (a.cost || 0) * pax, 0);

  // 3. Hotel & Meals Cost (₱0 if staying with relatives!)
  let hotelCost = 0;
  if (currentStayType === "relative") {
    hotelCost = 0; // Free stay and meals at relatives' place
  } else if (currentStayType === "hostel") {
    hotelCost = 1200 * days;
  } else {
    hotelCost = dailyHotel * days;
  }

  // Totals
  const totalAllocated = flightsCost + activitiesCost + hotelCost;
  const remaining = totalBudget - totalAllocated;

  // Update Route and Counters
  const fromCity = byC($("#from").value)?.city || $("#from").value;
  const toCity = byC($("#to").value)?.city || $("#to").value;
  const actBadge = $("#actBadge");
  if (actBadge) actBadge.textContent = `${selectedActivities.length} spot${selectedActivities.length === 1 ? "" : "s"} selected`;

  // Update Selected Plans Tray
  renderSelectedPlans();

  // Update Bottom Sticky Plan Bar
  const botRoute = $("#botRouteText");
  if (botRoute) botRoute.textContent = `${fromCity} ➔ ${toCity} (${days} days · ${pax} pax)`;
  if ($("#botFlightsAmt")) $("#botFlightsAmt").textContent = peso(flightsCost);
  if ($("#botActsAmt")) $("#botActsAmt").textContent = peso(activitiesCost);
  if ($("#botStayAmt")) {
    $("#botStayAmt").textContent = currentStayType === "relative" ? "₱0 (Free with Relatives)" : peso(hotelCost);
  }
  if ($("#botTotalAmt")) $("#botTotalAmt").textContent = peso(totalAllocated);
  if ($("#botRemainingLabel")) {
    const remElem = $("#botRemainingLabel");
    if (remaining >= 0) {
      remElem.textContent = `${peso(remaining)} balance`;
      remElem.style.color = "var(--emerald)";
    } else {
      remElem.textContent = `${peso(Math.abs(remaining))} OVER budget`;
      remElem.style.color = "var(--danger)";
    }
  }

  // Update Pinned Selected Flights on Right Sidebar
  const pinnedBanner = $("#sideSelectedFlightsBanner");
  const pinnedItems = $("#sideSelectedFlightItems");
  if (pinnedBanner && pinnedItems) {
    if (outFlight || retFlight) {
      pinnedBanner.style.display = "block";
      let pHtml = "";
      if (outFlight) {
        pHtml += `
          <div class="flight-pick">
            <div><b>🛫 Out:</b> ${outFlight.al.n} (${hhmm(outFlight.dep)}) · ${peso(outFlight.price * pax)}</div>
            <button type="button" class="flight-change-btn" onclick="reselectFlight('out')">Change</button>
          </div>`;
      }
      if (retFlight) {
        pHtml += `
          <div class="flight-pick">
            <div><b>🛬 Ret:</b> ${retFlight.al.n} (${hhmm(retFlight.dep)}) · ${peso(retFlight.price * pax)}</div>
            <button type="button" class="flight-change-btn" onclick="reselectFlight('ret')">Change</button>
          </div>`;
      }
      pinnedItems.innerHTML = pHtml;
    } else {
      pinnedBanner.style.display = "none";
    }
  }
}

// Open Confirmation Modal with KYC Autofill
$("#btnOpenConfirm").addEventListener("click", () => {
  const pax = Math.max(1, +$("#pax").value || 1);
  const totalBudget = Math.max(0, +$("#budget").value || 100000);
  const toCity = byC($("#to").value)?.city || $("#to").value;
  const fromCity = byC($("#from").value)?.city || $("#from").value;
  const days = getTripDays();

  $("#modalBanner").textContent = `${fromCity} ➔ ${toCity} · ${peso(totalBudget)} Target Budget (${days} Days · ${pax} Traveler${pax > 1 ? "s" : ""})`;

  // Flights summary
  const legs = [outFlight, retFlight].filter(Boolean);
  const hasFlights = legs.length > 0;

  if (hasFlights) {
    $("#dSumFlights").innerHTML = legs
      .map(
        l => `
      <div>
        <span>${l.o} ➔ ${l.d} (${l.al.n} ${l.no})</span>
        <b>${dmy(l.date)} ${hhmm(l.dep)}–${hhmm(l.arr)} (${peso(l.price * pax)})</b>
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

  // Stay summary
  let hotelCost = 0;
  if (currentStayType === "relative") {
    hotelCost = 0;
    $("#dSumStay").innerHTML = `<div><span>Accommodation & Meals:</span><b style="color:var(--emerald);">🏠 Relative's / Friend's Place (₱0 Free Stay & Meals)</b></div>`;
  } else if (currentStayType === "hostel") {
    hotelCost = 1200 * days;
    $("#dSumStay").innerHTML = `<div><span>Hostel / Budget Stay (${days} days):</span><b>${peso(hotelCost)}</b></div>`;
  } else {
    hotelCost = (+$("#dailyHotel").value || 3500) * days;
    $("#dSumStay").innerHTML = `<div><span>Hotel / Resort Stay (${days} days):</span><b>${peso(hotelCost)}</b></div>`;
  }

  // Budget summary
  const flightsCost = legs.reduce((acc, l) => acc + l.price * pax, 0);
  const actsCost = selectedActivities.reduce((acc, a) => acc + a.cost * pax, 0);
  const totalSpend = flightsCost + actsCost + hotelCost;
  const remaining = totalBudget - totalSpend;

  $("#dSumBudget").innerHTML = `
    <div><span>Domestic Flights:</span><b>${peso(flightsCost)}</b></div>
    <div><span>Activities & Sightseeing:</span><b>${peso(actsCost)}</b></div>
    <div><span>Stay & Accommodation:</span><b>${peso(hotelCost)}</b></div>
    <div style="border-top:1px dashed var(--line);padding-top:4px"><span>Total Estimated Trip Cost:</span><b>${peso(totalSpend)}</b></div>
    <div><span>Remaining Balance:</span><b style="color:${remaining >= 0 ? "var(--emerald)" : "var(--danger)"}">${peso(remaining)}</b></div>
  `;

  // KYC (Know Your Customer) Autofill Logic (1st book requires ID, 2nd Autofill)
  const kyc = window.USER_KYC || {};
  if ($("#kycPhone")) $("#kycPhone").value = kyc.phone || "";
  if ($("#kycEmail")) $("#kycEmail").value = kyc.email || "";
  if ($("#kycIdType") && kyc.id_type) $("#kycIdType").value = kyc.id_type;
  if ($("#kycIdNumber")) $("#kycIdNumber").value = kyc.id_number || "";

  // Dynamic KYC requirements based on flights
  const phoneReq = $("#kycPhoneReq");
  const emailReq = $("#kycEmailReq");
  const idTypeReq = $("#kycIdTypeReq");
  const idNumReq = $("#kycIdNumReq");

  if (hasFlights) {
    if ($("#kycIdType")) $("#kycIdType").required = true;
    if ($("#kycIdNumber")) $("#kycIdNumber").required = true;
    if (idTypeReq) idTypeReq.style.display = "inline";
    if (idNumReq) idNumReq.style.display = "inline";
  } else {
    if ($("#kycIdType")) $("#kycIdType").required = false;
    if ($("#kycIdNumber")) $("#kycIdNumber").required = false;
    if (idTypeReq) idTypeReq.style.display = "none";
    if (idNumReq) idNumReq.style.display = "none";
  }

  const autoBadge = $("#kycAutofillBadge");
  const hintText = $("#kycHintText");

  if (kyc.has_kyc) {
    if (autoBadge) autoBadge.style.display = "inline-flex";
    if (hintText) {
      hintText.innerHTML = `<span style="color:var(--emerald);font-weight:700;">✓ Verified ID on File</span> · Passenger details and Government ID have been automatically filled from your profile for 1-click fast booking.`;
    }
  } else {
    if (autoBadge) autoBadge.style.display = "none";
    if (hintText) {
      hintText.innerHTML = hasFlights
        ? `<span style="color:var(--accent);font-weight:700;">⚠️ 1st-Time Flight Booking KYC</span> · Government ID is required for first-time domestic flight ticket issuance. Your details will be saved to your traveler profile for 1-click autofill on future bookings!`
        : `Passenger details will be saved to your traveler profile for fast autofill on future bookings.`;
    }
  }

  $("#dlg").showModal();
});

// Confirm and Save Complete Trip
$("#bookForm").addEventListener("submit", async e => {
  e.preventDefault();
  if (e.submitter && e.submitter.value === "cancel") {
    $("#dlg").close();
    return;
  }

  const pax = Math.max(1, +$("#pax").value || 1);
  const totalBudget = Math.max(0, +$("#budget").value || 100000);
  const toCity = byC($("#to").value)?.city || $("#to").value;
  const legs = [outFlight, retFlight].filter(Boolean).map(l => l.id);
  const days = getTripDays();

  // Accommodation Cost calculation
  let hotelCost = 0;
  if (currentStayType === "relative") {
    hotelCost = 0;
  } else if (currentStayType === "hostel") {
    hotelCost = 1200 * days;
  } else {
    hotelCost = (+$("#dailyHotel")?.value || 3500) * days;
  }

  // KYC Information
  const contact_phone = $("#kycPhone") ? $("#kycPhone").value.trim() : "";
  const contact_email = $("#kycEmail") ? $("#kycEmail").value.trim() : "";
  const kyc_id_type = $("#kycIdType") ? $("#kycIdType").value.trim() : "";
  const kyc_id_number = $("#kycIdNumber") ? $("#kycIdNumber").value.trim() : "";

  if (legs.length > 0 && (!contact_phone || !kyc_id_type || !kyc_id_number)) {
    toast("Please provide contact phone and Government ID for flight issuance.");
    return;
  }

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
    stay_type: currentStayType,
    hotel_est: hotelCost,
    contact_phone,
    contact_email,
    kyc_id_type,
    kyc_id_number
  };

  const btnConfirm = $("#btnConfirmBooking");
  btnConfirm.disabled = true;
  btnConfirm.textContent = "Confirming & Saving...";

  try {
    const res = await fetch("../actions/trip_plan_process.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload)
    });
    const d = await res.json();

    if (d.ok) {
      toast("🎉 Complete Trip Plan, Stays & Flights Booked Successfully!");
      $("#dlg").close();
      outFlight = null;
      retFlight = null;
      stage = "out";

      // If user provided KYC, update local memory so subsequent modal opens autofill immediately
      if (kyc_id_number) {
        window.USER_KYC = {
          ...window.USER_KYC,
          phone: contact_phone,
          email: contact_email,
          id_type: kyc_id_type,
          id_number: kyc_id_number,
          has_kyc: true
        };
      }

      setTimeout(() => {
        // Navigate directly to Bookings so user can view their boarding tickets and KYC!
        window.location.href = legs.length > 0 ? "bookings.php" : "my_trips.php";
      }, 1500);
    } else {
      toast(d.error || "Failed to save trip plan.");
      btnConfirm.disabled = false;
      btnConfirm.textContent = "Confirm Booking & Save Trip";
    }
  } catch (err) {
    toast("Server error. Please ensure local Apache & MySQL are running.");
    btnConfirm.disabled = false;
    btnConfirm.textContent = "Confirm Booking & Save Trip";
  }
});

// Initialization
renderAirlineChips();
onDestinationChange();
updateBudgetCalculations();
doSearch(true);
