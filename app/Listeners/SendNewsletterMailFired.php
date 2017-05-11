<?php

namespace App\Listeners;

use App\Events\SendNewsletterMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Models\Newsletter;

class SendNewsletterMailFired {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendNewsletterMail  $event
     * @return void
     */
    public function handle(SendNewsletterMail $event) {
        //echo "<pre>";print_r($event->newsletters);print_r($event->subscribedUsers);die;

        if (!empty($event->newsletters)) {
            $objNewsletter = new Newsletter();

            foreach ($event->newsletters as $newsletter) {
                foreach ($event->subscribedUsers as $user) {

                    // replace newsletter content with tags specified
                    $tags = ['{#USERNAME#}', '{#UNSUBSCRIBE_LINK#}'];
                    $newsletter_content = $newsletter['newsletter_content'];
                    $newsletter_content = str_replace($tags[0], $user['first_name'] . ' ' . $user['last_name'], $newsletter_content);
                    $newsletter_content = str_replace($tags[1], route('unsubscribeNewsletter', $user['id']), $newsletter_content);
                    $data['html'] = $newsletter_content;

                    // Newsletter email send
                    Mail::queue('admin.email.newsletter', $data, function ($message) use ($user, $newsletter) {
                        $message->from(config("project.newsletter_sender_email"), config("project.newsletter_sender_name"));
                        $message->to($user['email']);
                        $message->subject($newsletter['newsletter_title']);
                    });
                }

                // update newsletter status to Sent once sent to users and process in queue
                $updateData['status'] = 'Sent';
                $objNewsletter->updateCronNewsletter($updateData, $newsletter['id']);
            }
        }
    }

}