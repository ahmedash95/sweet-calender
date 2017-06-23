<?php

namespace App\Services;


use App\Contracts\GoogleUpdateToken;

class GoogleCalender
{
    private $access_token;

    private $service;

    private $client;

    private $model;

    /**
     * GoogleCalender constructor.
     * @param $token
     */
    public function __construct($token,GoogleUpdateToken $model)
    {
        $this->access_token = $token;
        $this->model = $model;

        $this->client = new \Google_Client();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret((config('services.google.client_secret')));
        $this->client->setAccessToken($token);

        if($this->client->isAccessTokenExpired()) {
            $accessToken = json_decode($token);
            $refreshToken = $accessToken->refresh_token;
            $this->client->refreshToken($refreshToken);
            $newAccessToken = $this->client->getAccessToken();
            $this->updateToken($newAccessToken);
        }
        $this->service = new \Google_Service_Calendar($this->client);
    }

    public function updateToken($token){
        $this->model->updateGoogleToken($token);
    }

    public function getCalendersList()
    {
        return collect($this->service->calendarList->listCalendarList()->getItems())
            ->map(function ($item) {
                return ['id' => $item->id, 'name' => $item->summary];
            });
    }

    public function findById($id)
    {
        return $this->getCalendersList()->where('id', $id)->first();
    }

    public function createEvent($calenderId, $data)
    {
        $event = new \Google_Service_Calendar_Event($data);
        return $this->service->events->insert($calenderId, $event);
    }
    public function updateEvent($calenderId,$eventId,$data){
        $event = $this->service->events->get($calenderId,$eventId);
        foreach($data as $key => $value){
            $method = 'set'.ucfirst($key);
            $event->$method($value);
        }

        $this->service->events->update($calenderId,$eventId,$event);
    }

    public function deleteEvent($calenderId,$eventId){
        $this->service->events->delete($calenderId,$eventId);
    }
}