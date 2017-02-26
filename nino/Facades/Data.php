<?php
namespace nino\Facades;
use Illuminate\Support\Facades\Facade;

class Data extends Facade {

    protected static function getFacadeAccessor() { return 'nino\Services\DataService'; }

}