<?php
/**
 * Created by PhpStorm.
 * User: krofek
 * Date: 7/8/16
 * Time: 8:33 PM
 */

namespace App\Services;


use App\Models\Initiative;

class InitiativeService
{
    public function create()
    {
        return Initiative::class;
    }
}