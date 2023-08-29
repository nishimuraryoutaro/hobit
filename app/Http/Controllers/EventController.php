<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use App\Services\EventService;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\Factory;



class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today();
        $events = DB::table('events')
        ->whereDate('start_date', '>=' , $today)
        ->orderBy('start_date', 'asc')//開始日時
        ->paginate(10);//１０件ずつ
        return view('manager.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {

        $start = $request['event_date'] . " " . $request['start_time'];
        $startDate = Carbon::createFromFormat(
        'Y-m-d H:i', $start
        ); 
        $end = $request['event_date'] . " " . $request['end_time'];
        $endDate = Carbon::createFromFormat(
        'Y-m-d H:i', $end
        ); 

        Event::create([
            'name' => $request['event_name'],
            'information' => $request['information'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_people' => $request['max_people'],
            'is_visible' => $request['is_visible'],
            ]); 
            session()->flash('status', '登録okです');

            return to_route('events.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
       $event =  Event::findOrFail($event->id);
       $eventDate = $event->eventDate;
       $startTime = $event->startTime;
       $endTime = $event->endTime;
       return view('manager.events.show', compact('event','eventDate','startTime','endTime'));
    }

    
    public function edit(Event $event)
    {
       $event =  Event::findOrFail($event->id);

       $event = Event::findOrFail($event->id);
       $today = Carbon::today()->format('Y年m月d日');
       if($event->eventDate < $today ){
       return abort(404);
       }
       $eventDate = $event->editEventDate;
       $startTime = $event->startTime;
       $endTime = $event->endTime;
       return view('manager.events.edit', compact('event','eventDate','startTime','endTime'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $start = $request['event_date'] . " " . $request['start_time'];
        $startDate = Carbon::createFromFormat(
        'Y-m-d H:i', $start
        ); 
        $end = $request['event_date'] . " " . $request['end_time'];
        $endDate = Carbon::createFromFormat(
        'Y-m-d H:i', $end
        ); 
        $event =  Event::findOrFail($event->id);
    
            $event->name = $request['event_name'];
            $event->information = $request['information'];
            $event->start_date = $startDate;
            $event->end_date = $endDate;
            $event->max_people = $request['max_people'];
            $event->is_visible = $request['is_visible'];
            $event->save();

            session()->flash('status', '更新しました');

            return to_route('events.index');
    }

    public function past() 
    {
        $today = Carbon::today();
        $events = DB::table('events')
        ->whereDate('start_date', '<', $today )
        ->orderBy('start_date', 'desc')
        ->paginate(10);
        return view('manager.events.past', compact('events')); 
    }
    public function destroy(Event $event)
    {
        //
    }
}
