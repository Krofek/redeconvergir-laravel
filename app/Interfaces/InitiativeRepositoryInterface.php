<?php
/**
 * Created by PhpStorm.
 * User: krofek
 * Date: 7/8/16
 * Time: 8:14 PM
 */

namespace App\Interfaces;


interface InitiativeRepositoryInterface
{
    public function getAll();

    public function find($id);
}