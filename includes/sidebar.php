<?php // Role-based menu: each role only sees its own links.
$menus = [
  'traveler' => [
    'dashboard'    => 'Dashboard',
    'travel'       => 'Plan Trip & Flights',
    'my_trips'     => 'My Trips',
    'bookings'     => 'Bookings & Flights',
    'itinerary'    => 'Itinerary',
    'expenses'     => 'Expenses',
    'destinations' => 'Destinations'
  ],
  'staff'    => [
    'dashboard'   => 'Dashboard',
    'bookings'    => 'Bookings',
    'trips'       => 'Trips',
    'itineraries' => 'Itineraries'
  ],
  'admin'    => [
    'dashboard'    => 'Bookings',
    'destinations' => 'Destinations',
    'flights'      => 'Flights',
    'users'        => 'Users',
    'reports'      => 'Reports'
  ],
];

foreach ($menus[user()['role']] as $file => $label) {
  $active = (basename($_SERVER['SCRIPT_NAME'] ?? '') === ($file . '.php')) ? ' class="active"' : '';
  echo '<a href="' . BASE . '/' . user()['role'] . '/' . $file . '.php"' . $active . '>' . $label . '</a>';
}
