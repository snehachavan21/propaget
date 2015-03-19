<?php
/**
 * Created by PhpStorm.
 * User: komal
 * Date: 16/3/15
 * Time: 2:41 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Properties extends BaseModel {

    protected $table = 'properties';

    protected $fillable = ['agentId','clientId','location', 'area', 'price','type', 'title', 'description', 'clientEmail', 'address'];

    protected $rules = [
        'location' => 'required|min:5',
        'area' => 'required',
        'price' => 'required|numeric',
        'title' => 'required',
        'clientId' => 'required|numeric',
        'agentId' => 'required|numeric',
    ];

    public function save(array $options = array())
    {
        parent::save($options);
    }

}
