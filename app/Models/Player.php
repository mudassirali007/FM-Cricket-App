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
        $image = $this->image;
        if($image) {
            $response = Http::get($image);
            if ($response->successful()) {
                // Dynamically determine the content type
                $contentType = $response->header('Content-Type');
                // Encode the image data
                $base64Image = base64_encode($response->body());

                // Format the string based on the content type
                $imageBase64String = match ($contentType) {
                    'image/png' => 'data:image/png;base64,' . $base64Image,
                    'image/jpeg' => 'data:image/jpeg;base64,' . $base64Image,
                    'image/gif' => 'data:image/gif;base64,' . $base64Image,
                    'image/webp' => 'data:image/webp;base64,' . $base64Image,
                    default => '', // Handle unknown or unsupported types as needed
                };

                return $imageBase64String;
            }
        }
        return '';
    }
}
