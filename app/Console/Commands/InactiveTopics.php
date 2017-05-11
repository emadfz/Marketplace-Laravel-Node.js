<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Event;
use App\Events\SendNewsletterMail;
use App\Models\Forums;
use App\Models\ForumComment;
Use DB;

class InactiveTopics extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inactive:topics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Topic don\'t have any new comments for more than 5 month after that the topic should be automatically inactive';

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
        
        $objForums = new Forums();
        $objForumComment = new ForumComment();

        // get all 5 months old forums
        $fiveMonthAgoDate = date('Y-m-d', strtotime('-5 month')); //A month from today


        $topics = $objForums->getFiveMonthOldTopics($fiveMonthAgoDate);

        $topicList = array();
        foreach ($topics as $item){

                if($item['total_comments'] > 0){
                    $CommentData = $objForumComment->getComment($item['id'],$fiveMonthAgoDate,$currentDate);

                    if(empty($CommentData)){
                        array_push($topicList,$item['id']);
                    }

                }else{
                    array_push($topicList,$item['id']);
                }

        }

        if(!empty($topicList)){
            DB::table('forums')->whereIn('id', $topicList)->update(array('status' => 'Inactive'));
            $this->info('Inactive Topics Found ' . $currentDate);
        }else{
            $this->info('No Inactive Topic found for the date ' . $currentDate);
        }
    }

}
