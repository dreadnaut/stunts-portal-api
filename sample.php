<?php
include 'StuntsPortalApi.php';

$competitionId = 'r4k';

$clientId = '...';
$clientSecret = '...';

$api = new StuntsPortalApi($clientId, $clientSecret);


# --- Create or update an event ---------------------------

echo '> Create or update an event', PHP_EOL;

$response = $api->updateEvent([
  'competition_id' => $competitionId,
  'event_id'       => 'r4k-2021-09',
  'name'           => '2021-09 - Tropical Springs Stunt Park',
  'url'            => 'http://www.raceforkicks.com/index.php?page=race&race=2021-09',
  'opens_on'       => '2021-09-01T15:59:00+02:00',
  'closes_on'      => '2021-09-27T01:59:00+02:00',
  'track_title'    => 'Tropical Springs Stunt Park',
  'track_url'      => 'http://www.raceforkicks.com/tracks/r4k14.trk'
]);

$statusCode = $api->lastStatus();

echo "> Server response: {$statusCode}", PHP_EOL;
var_export($response);

# If the event was not saved, stop the script here, no need to
# try and delete the event.
$eventId = $response['event_id'] ?? null;
if (!$eventId) {
  return;
}
echo PHP_EOL;


# --- Delete an event ------------------------------------

echo '> Delete an event', PHP_EOL;

$response = $api->deleteEvent($competitionId, $eventId);

$statusCode = $api->lastStatus();
echo "> Server response: {$statusCode}", PHP_EOL;
var_export($response);

