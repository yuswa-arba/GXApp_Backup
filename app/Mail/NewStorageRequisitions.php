<?php

namespace App\Mail;

use App\Storage\Models\StorageRequisition;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewStorageRequisitions extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $requisition;

    public function __construct($requisitionId)
    {
        $this->requisition = StorageRequisition::find($requisitionId);
    }

    /**
     * Build the message
     * @return $this
     */
    public function build()
    {
        return $this->view('layouts.mails.storage.newRequisition');
    }
}
