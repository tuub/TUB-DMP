<?php
declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable.
 */
class PlanToRecipient extends Mailable
{
    use Queueable, SerializesModels;

    public $sender;
    public $recipient;
    public $subject;
    public $msg;
    public $plan;
    public $attachment;

    /**
     * Creates a new message instance.
     *
     * @param array $options
     *
     * @return void
     */
    public function __construct($options)
    {
        $this->plan = $options['plan'];
        $this->sender = $options['sender'];
        $this->recipient = $options['recipient'];
        $this->subject = $this->setSubject();
        $this->msg = $options['msg'];
        $this->attachment = $options['attachment'];
    }


    /**
     * Sets the email subject.
     *
     * @return string
     */
    public function setSubject() {
        return 'Data Management Plan "' . $this->plan->title . '"'
            . ' for project ' . $this->plan->project->identifier
            . ' / Version ' . $this->plan->version;
    }

    /**
     * Sets the attachment file name.
     *
     * @return string
     */
    public function setAttachmentFileName() {
        return $this->plan->project->identifier
            . '_' . str_replace(' ', '', $this->plan->title)
            . '-' . $this->plan->version
            . '_' . $this->plan->updated_at->format( 'Ymd' )
            . '.pdf';
    }


    /**
     * Builds the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('emails.plan')
            ->subject($this->subject)
            ->from($this->sender['email'], $this->sender['name'])
            ->replyTo($this->sender['email'], $this->sender['name'])
            ->to($this->recipient['email'])
            ->attachData($this->attachment,
                         $this->setAttachmentFileName(),
                         ['mime' => 'application/pdf']);
    }
}