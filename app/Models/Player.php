<?php

namespace App\Models;

use GearboxSolutions\EloquentFileMaker\Database\Eloquent\FMModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Player extends FMModel
{
    use HasFactory;

//    protected $connection = 'filemaker';

    protected $layout = 'Form';

    protected $fieldMapping = [
        'PrimaryKey' => 'id',
        'Name' => 'name',
        'Age' => 'age',
        'Contact' => 'contact',
        'Teams::Name' => 'team_name',
        'Image' => 'image',
        'Team ForeignKey' => 'team_id',
    ];


}
