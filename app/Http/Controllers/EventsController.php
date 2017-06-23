<?php

namespace App\Http\Controllers;

use App\Event;
use App\Services\GoogleCalender;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    public function index()
    {
        $events = Event::user()->get();
        return view('events.index',[
            'events' => $events,
        ]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request, GoogleCalender $calender)
    {
        $event = Event::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'calender_id' => Auth::user()->calender->id,
            'user_id' => Auth::user()->id,
        ]);
        $calenderEvent = $calender->createEvent(Auth::user()->calender->calender_id, [
            'summary' => $event->name,
            'description' => $event->description,
            'start' => ['dateTime' => Carbon::parse(sprintf('%s %s', $event->date, $event->time))->format(DateTime::ISO8601)],
            'end' => ['dateTime' => Carbon::parse(sprintf('%s %s', $event->date, $event->time))->addHour()->format(DateTime::ISO8601)],
        ]);

        $event->update([
            'event_id' => $calenderEvent->id,
        ]);

        return redirect('/events');
    }

    public function edit(Event $event){
        return view('events.edit',[
            'event' => $event,
        ]);
    }

    public function update(Request $request,GoogleCalender $calender,Event $event){
        $event->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'calender_id' => Auth::user()->calender->id,
            'user_id' => Auth::user()->id,
        ]);

        $startDate = new \Google_Service_Calendar_EventDateTime;
        $startDate->setDateTime(['date_time' => Carbon::parse(sprintf('%s %s', $event->date, $event->time))->format(DateTime::ISO8601)]);
        $startDate->setDate($request->input('date'));

        $endDate = new \Google_Service_Calendar_EventDateTime;
        $endDate->setDateTime(['date_time' => Carbon::parse(sprintf('%s %s', $event->date, $event->time))->addHour()->format(DateTime::ISO8601)]);
        $endDate->setDate($request->input('date'));

        $calender->updateEvent(Auth::user()->calender->calender_id,$event->event_id, [
            'summary' => $event->name,
            'description' => $event->description,
            'start' => $startDate,
            'end' => $endDate,
        ]);

        return redirect('/events');
    }
    public function destroy(Event $event,GoogleCalender $calender){
        $calender->deleteEvent($event->calender->id,$event->id);
        $event->delete();
        return back();
    }
}
