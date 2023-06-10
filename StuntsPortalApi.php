<?php

class StuntsPortalApi
{
  const BASE_URL = 'https://stunts.hu/api/';
  const FORM_ENCODED = 'Content-Type: application/x-www-form-urlencoded';

  private string $lastStatus;

  public function __construct(
    private string $clientId,
    private string $clientSecret,
    private string $baseUrl = self::BASE_URL
  ) {}

  public function updateEvent(array $eventData)
  {
    return $this->post("events" , $eventData);
  }

  public function deleteEvent(string $competitionId, string $eventId)
  {
    return $this->delete("events/{$competitionId}/{$eventId}");
  }

  public function lastStatus() : string
  {
    return substr($this->lastStatus, strpos($this->lastStatus, ' ') + 1, 3);
  }

  # --- HTTP methods ---

  private function post(string $endpoint, array $data = [])
  {
    $content = http_build_query($data);
    $headers = array_merge($this->credentials(), [ self::FORM_ENCODED ]);
    return $this->request($endpoint, 'POST', $headers, $content);
  }

  private function delete(string $endpoint)
  {
    $headers = $this->credentials();
    return $this->request($endpoint, 'DELETE', $headers);
  }

  # --- Generic HTTP request

  private function request(
    string $endpoint,
    string $method = 'GET',
    array $headers = [],
    string $content = ''
  ) {
    $url = $this->baseUrl . $endpoint;
    $context = stream_context_create([ 'http' => [
      'method' => $method,
      'header' => $headers,
      'content' => $content,
      'ignore_errors' => true,
    ]]);

    $response = file_get_contents($url, context: $context);
    $this->lastStatus = $http_response_header[0];

    return $response
      ? json_decode($response, associative: true)
      : [];
  }

  private function credentials() : array
  {
    return [
      "X-Client-Id: {$this->clientId}",
      "X-Client-Secret: {$this->clientSecret}",
    ];
  }
}
