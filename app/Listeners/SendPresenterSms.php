<?php

namespace App\Listeners;

use App\Events\PresenterScheduled;
use App\Models\Employee;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Twilio\Rest\Client;

class SendPresenterSms
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
    public function handle(PresenterScheduled $event): void
    {
        $schedule = $event->schedule;
        $message = "RADIO PRESENTATION SCHEDULE ALERT\n";
        $message = $message . get_presenter($schedule->presenter_id).' you have been allocated on a schedule entitled '. $schedule->title."\n";
        $message = $message . "ON ".$schedule->date."\n";
        $message = $message . "FROM ".$schedule->start_time."\n";
        $message = $message . "TO ".$schedule->end_time."\n";

        $sid = getenv("TWILIO_AUTH_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        //$twilio = new Client($sid, $token);
        $employee = Employee::find($schedule->presenter_id);
        if (is_null($employee)) {
            return;
        }

        $number = $employee->phone;
        $internationalNumber = "+263" . substr($number, 1);
        //$internationalNumber = preg_replace('/^0/', '+263', $number);

        $client = new Client($sid, $token);
        $client->messages->create($internationalNumber, [
            'from' => getenv("TWILIO_WHATSAPP_FROM"),
            'body' => $message
        ]);

    }
}
