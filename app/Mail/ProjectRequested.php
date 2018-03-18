<?php
declare(strict_types=1);

namespace App\Mail;

use App\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ProjectRequested
 *
 * @package App\Mail
 */
class ProjectRequested extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param Project $project
     *
     * @return void
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->subject = '[' . env('APP_NAME') . '] ' . trans('admin/email.project.requested');
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('emails.project.requested')
            ->subject($this->subject)
            ->to(env('ADMIN_MAIL_ADDRESS'), env('ADMIN_MAIL_NAME'))
            ->from(env('SERVER_MAIL_ADDRESS'), env('SERVER_NAME'))
            ->replyTo($this->project->user->email, $this->project->user->name);
    }
}