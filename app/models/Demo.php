<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Demo extends Eloquent {

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

}
