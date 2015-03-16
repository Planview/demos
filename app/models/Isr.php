<?php

// use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

class Isr extends Eloquent {
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
}
