<?php
/**
 * Created by PhpStorm.
 * User: krofek
 * Date: 7/8/16
 * Time: 8:11 PM
 */

namespace App\Repositories;


use App\Interfaces\InitiativeRepositoryInterface;
use App\Models\Initiative;

class InitiativeRepository implements InitiativeRepositoryInterface
{
    /**
     * @var Initiative
     */
    protected $initiative;

    public function __construct(Initiative $initiative)
    {
        $this->initiative = $initiative;
    }

    public function getAll()
    {
        return $this->initiative->all();
    }

    public function find($id)
    {
        return $this->initiative->find($id);
    }
}