<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Document;
use App\Maintenance;
use Illuminate\Support\Facades\Mail;
use App\Mail\UpcomingDocNotif;
use App\Mail\UpcomingMaintainNotif;

class emailReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $doc = Document::with('user')
            ->where('due_date', '<=', $four_weeks)
            ->where('due_date', '>', date('Y-m-d'))
            ->whereRaw("MOD(DATEDIFF(due_date, '$four_weeks'), 7) = 0")
            ->get();

        foreach ($doc as $item){
            Mail::to('chavinpradana@gmail.com')->send(new UpcomingDocNotif(Document::find($item->id)));
        }

        $maintenance = Maintenance::with('user')
            ->where('due_date', '<=', $four_weeks)
            ->where('due_date', '>', date('Y-m-d'))
            ->whereRaw("MOD(DATEDIFF(due_date, '$four_weeks'), 7) = 0")
            ->get();

        foreach ($maintenance as $item){
            Mail::to('chavinpradana@gmail.com')->send(new UpcomingMaintainNotif(Document::find($item->id)));
        }
    }
}
