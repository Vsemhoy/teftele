<?php

namespace App\Http\Components\com_taskflow\Ext;
use stdClass;

class PostResult
{
    public string $status;
    public int $code;
    public int $user;
    public int $item_id;
    public int $log_section;
    public int $log_action;
    public stdClass $object;
    public string $message;

    public function __construct($uid){
        $this->status = "NOK";
        $this->code = 1;
        $this->user = $uid;
        $this->item_id = -1;
        $this->log_section = 0;
        $this->log_section = 0;
        $this->object = (object) array();
        $this->message = "";
    }
}