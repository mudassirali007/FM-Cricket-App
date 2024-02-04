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
    protected $appends = ['image_base64'];


    protected $fieldMapping = [
        'PrimaryKey' => 'id',
        'Name' => 'name',
        'Age' => 'age',
        'Contact' => 'contact',
        'Teams::Name' => 'team_name',
        'Image' => 'image',
        'Team ForeignKey' => 'team_id',
    ];

    protected function getImageBase64Attribute(): string
    {
        if($this->image) {
            $response = Http::get($this->image);
            if ($response->successful()) {
                // Access the response content
                return 'data:image/png;base64,' . base64_encode($response->body());
            }
        }
        return '';
    }
}
