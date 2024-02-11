<?php

namespace App\Models;

use GearboxSolutions\EloquentFileMaker\Database\Eloquent\FMModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Http;


class Player extends FMModel
{
    use HasFactory;

//    protected $connection = 'filemaker';

    protected $layout = 'Form';

    protected $fillable = ['name','age','contact','team_name','image','document'];

    protected $fieldMapping = [
        'PrimaryKey' => 'id',
        'Name' => 'name',
        'Age' => 'age',
        'Contact' => 'contact',
        'Teams::Name' => 'team_name',
        'Image' => 'image',
        'Document' => 'document',
        'Team ForeignKey' => 'team_id',
    ];

}
