<?php

namespace App\Listeners;

use App\Events\EngineerScheduled;
use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Twilio\Rest\Client;

class SendEngineerSms
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EngineerScheduled $event): void
    {
        $schedule_engineer = $event->schedule_engineer;
        $schedule = Schedule::find($schedule_engineer->schedule_id);
        if(is_null($schedule)){
            return;
        }

        $message = "RADIO ENGINEERING SCHEDULE ALERT\n";
        $message = $message . get_presenter($schedule->presenter_id).' you have been allocated on a schedule entitled '. $schedule->title."\n";
        $message = $message . "ON ".$schedule->date."\n";
        $message = $message . "FROM ".$schedule->start_time."\n";
        $message = $message . "TO ".$schedule->end_time."\n";

        $sid = getenv("TWILIO_AUTH_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");

        $employee = Employee::find($schedule_engineer->engineer_id);
        if (is_null($employee)) {
            return;
        }

        $number = $employee->phone;
        $internationalNumber = "+263" . substr($number, 1);

        $client = new Client($sid, $token);
        $client->messages->create($internationalNumber, [
            'from' => getenv("TWILIO_WHATSAPP_FROM"),
            'body' => $message
        ]);
    }
}
