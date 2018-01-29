<?php

namespace App\Mail;

use App\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProjectRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->subject = '[' . env('APP_NAME') . '] ' . trans('admin/email.project.rejected');
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (env('ADMIN_MAIL_ADDRESS') && env('ADMIN_MAIL_NAME')) {
            return $this->text('emails.project.rejected')
                ->subject($this->subject)
                ->from( env('ADMIN_MAIL_ADDRESS'), env('ADMIN_MAIL_NAME') )
                ->replyTo( env('ADMIN_MAIL_ADDRESS'), env('ADMIN_MAIL_NAME') );
        }
    }
}
