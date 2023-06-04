# Stunts Portal API

The [Stunts Portal](https://stunts.hu) has a small API to expose active
competitions and their events.

The API root address is [https://stunts.hu/api](https://stunts.hu/api).

## Authentication

You can access read-only endpoints without authentication. Write operations
should include the following request headers:

| Header            | Description                                            |
| ----------------- | ------------------------------------------------------ |
| `X-Client-Id`     | A string identifying the client submitting the request |
| `X-Client-Secret` | The secret matching the given `client_id`              |


## Available endpoints

### List current events

```
GET /api/events
```
Returns a list of Events records, up to two for each competition active this
year. The list will include events which closed in the past 5 days, events in
progress, and events in the future.

Each event follows this structure:

| Field            | Type     | Description                                          |
| ---------------- | -------- | ---------------------------------------------------- |
| `competition_id` | String   | A short string identifying the competition           |
| `event_id`       | String   | A short string identifying this event                |
| `name`           | String   | The name or title of the event                       |
| `url`            | URL      | The address of a page describing the event           |
| `opens_on`       | DateTime | ISO 8601 opening time of the event                   |
| `closes_on`      | DateTime | ISO 8601 closing time of the event                   |
| `track_title`    | String   | (Optional) Title of the track                        |
| `track_author`   | String   | (Optional) Author of the track                       |
| `track_url`      | URL      | (Optional) Address of the `.trk` file for this event |


### List current events for one competition

```
GET /api/events/{competition_id}
```

Returns up to two events for a competition. If the `competition_id` is not a
valid one, the endpoint will return a `404` error response. The list will
include events which closed in the past 5 days, events in progress, and events
in the future.


### Create or update an event

```
POST /api/events
```

Use this endpoint to submit a new event. If an event with the same
`competition_id` and `event_id` already exists, it will be updated.

The payload should follow the Event structure. Because this is an update
operation, the request should include the credential headers for authentication.

If the operation is successful, the endpoint will return the Event record and a
`200` status response. Otherwise, it will return an error response and HTTP
status code.


### Retrieve the details of an event

```
GET /api/events/{competition_id}/{event_id}
```

If `competition_id` and `event_id` are valid, the endpoint will return the Event
data. Otherwise, it will return a `404` error.


### Delete an event

```
DELETE /api/events/{competition_id}/{event_id}
```

Events can remain in the database indefinitely, but if you want to delete one
you can call this endpoint. If the call succeeds, it will return a `204` No
Content response.
