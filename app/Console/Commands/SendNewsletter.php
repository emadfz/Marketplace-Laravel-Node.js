<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Event;
use App\Events\SendNewsletterMail;
use App\Models\Newsletter;

class SendNewsletter extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send newsletter to all subscribed users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        $dt = \Carbon\Carbon::today();
        $currentDate = $dt->format('Y-m-d');
        
        $objNewsletter = new Newsletter();

        // get all subscribed users list
        $subscribedUsers = \App\Models\User::select("*")->where('status', '=', 'Active')->where('is_subscribed', '=', 1)->get()->toArray();

        // get active newsletter for the current date (cron execute)
        //$newsletters = \App\Newsletter::select("*")->where('status', '=', 'Active')->where('newsletter_date', '=', $currentDate)->get()->toArray();
        $newsletters = $objNewsletter->getNewsletter('', TRUE);

        if (!empty($newsletters) && !empty($subscribedUsers)) {
            Event::fire(new SendNewsletterMail($newsletters, $subscribedUsers));
            $this->info('Newsletter email for the date ' . $currentDate);
        } else {
            $this->info('No active newsletter found for the date ' . $currentDate);
        }
    }

}
