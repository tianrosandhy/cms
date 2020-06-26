<?php
namespace App\Core\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use App\Core\Shared\DynamicProperty;

class BaseMail extends Mailable
{
    use Queueable, SerializesModels, DynamicProperty;

    public 
        $subject,
        $precontent,
        $title,
        $subheader,
        $top_description,
        $content,
        $button,
        $unsubscribe_url,
        $additional_footer,
        $additional_view,
        $file,
        $var,
        $new_params,
        $rep;

    public function build(){
        $objvar = get_object_vars($this);
        $exclude  = [
        	'html', 'view', 'textView', 'viewData', 'callbacks', 'connection', 'queue', 'chainConnection', 'chainQueue', 'delay', 'chained'
        ];
        foreach($exclude as $exc){
        	if(isset($objvar[$exc])){
        		unset($objvar[$exc]);
        	}
        }

        $output = $this
            ->subject($this->subject)
            ->view('core::mail.master')
            ->with($objvar);

        if(!empty($this->rep)){
            $output = $output->replyTo($this->rep);
        }

        if(!empty($this->file)){
            foreach($this->file as $file){
                $output = $output->attach($file);
            }
        }

        return $output;
    }

}