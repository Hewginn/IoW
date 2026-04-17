<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;

    protected $table = 'images';

    public $timestamps = true;

    protected $guarded = [];

    public function camera() : BelongsTo{
        return $this->belongsTo(Camera::class);
    }

    public function analyze(){

        $imagePath = $this->path;
        $id = $this->id;

        $pythonProcess = new Process([
            '/opt/pyenv/bin/python',
            base_path('machine_vision/scripts/runMachineVision.py'),
            $imagePath,
            $id
        ]);

        $pythonProcess->run();

        if (!$pythonProcess->isSuccessful()) {
            throw new ProcessFailedException($pythonProcess);
        }

        $result = json_decode($pythonProcess->getOutput(), true);
        $result['image_id'] = $id;

        $vision = Vision::create($result);

        return "Python Vision run successfully!";
    }

    public function vision() : HasOne{
        return $this->hasOne(Vision::class);
    }

}
