<?php

class Isr extends Eloquent 
{
    public $fillable = array('isr_first_name','isr_last_name','isr_phone','isr_mobile_phone','isr_location');
    /**
     * Make a list for options in a select
     * @return array All ISRs keyed as id => name
     */
    public static function isrList()
    {
        $list = array();
        //foreach (self::all() as $isr) {
        foreach (self::orderBy('isr_last_name', 'asc')->orderBy('isr_first_name', 'asc')->get() as $isr) {
            $list[$isr->user_id] = $isr->isr_first_name.' '.$isr->isr_last_name;
        }
        return $list;
    }

    /**
     * @return object of user's associated ISR
     */
    public static function associatedIsrInfo($isrId)
    {
        if (!($isr = DB::table('isrs')->where('user_id', '=', $isrId)->first())) {
            $isr = false;
        }
        return $isr;
    }

    /**
     * @return string of user's associated ISR's email address
     */
    public static function associatedIsrEmail($isrId)
    {
        if (!($isr = User::findOrFail($isrId))) {
            $isrEmail = false;
        } else {
            $isrEmail = $isr->email;
        }
        return $isrEmail;
    }

    public function user()
    {
        // isr_user
        return $this->belongsTo('User');
    }
}
