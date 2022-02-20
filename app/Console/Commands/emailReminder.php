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
    // protected $signature = 'command:name';
    protected $signature = 'reminder:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notification to users about reminders';

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
        $today = date('Y-m-d');
        $four_weeks = date('Y-m-d', strtotime($today.'+ 14 days'));

        $doc = Document::with('user')
            ->where('due_date', '<=', $four_weeks)
            ->where('due_date', '>', $today)
            ->whereRaw("MOD(DATEDIFF(due_date, '$four_weeks'), 7) = 0")
            ->get();

        $list1 = [];
        foreach ($doc as $item){
            $list1[$item->created_by][] = $item->toArray();

            Mail::to(
                // 'grimmdecarole@gmail.com',

                'testaccount@jtd.co.id',
                'nefi@jtd.co.id', 
                'corporate.secretary@jtd.co.id', 
                'Legal.sdm@jtdjp.co.id', 
                'legal.jtd@gmail.com'
            )->send(new UpcomingDocNotif(Document::find($item->id)));
        }
        // dd($list1);

        $maintenance = Maintenance::with('user')
            ->where('due_date', '<=', $four_weeks)
            ->where('due_date', '>', $today)
            ->whereRaw("MOD(DATEDIFF(due_date, '$four_weeks'), 7) = 0")
            ->get();

        foreach ($maintenance as $item){
            Mail::to(
                'grimmdecarole@gmail.com',

                // 'nefi@jtd.co.id', 
                // 'corporate.secretary@jtd.co.id', 
                // 'Legal.sdm@jtdjp.co.id', 
                // 'legal.jtd@gmail.com'
            )->send(new UpcomingMaintainNotif(Maintenance::find($item->id)));
        }
    }
}
