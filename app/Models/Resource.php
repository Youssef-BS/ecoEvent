<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Resource extends Model
{
    protected $fillable = [
        'title',
        'quantity',
        'image',
        'sponsor_id'
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    protected static function booted()
    {
        static::updating(function ($resource) {

            $originalQuantity = (int) $resource->getOriginal('quantity');
            $currentQuantity  = (int) $resource->quantity;


            if ($originalQuantity > 0 && $currentQuantity === 0) {

                $sponsor = $resource->sponsor;

                if ($sponsor && !empty($sponsor->phone)) {

                    $phone = preg_replace('/\D/', '', $sponsor->phone);
                    if (strpos($phone, '216') !== 0) {
                        $phone = '+216' . $phone;
                    } else {
                        $phone = '+' . $phone;
                    }

                    $message = "Bonjour {$sponsor->name}, la ressource '{$resource->title}' est épuisée. Veuillez recharger le stock.";

                    $escapedPhone = escapeshellarg($phone);
                    $escapedMessage = escapeshellarg($message);

                    $pythonPath = 'C:\\Python\\Python310\\python.exe';
                    $scriptPath = 'C:\\testface\\whats.py';

                    $cmd = "\"$pythonPath\" \"$scriptPath\" $escapedPhone $escapedMessage";


                    exec($cmd . ' 2>&1', $output, $returnValue);

                    Log::debug("Commande WhatsApp : $cmd");
                    Log::debug("Sortie : " . implode("\n", $output));
                    Log::debug("Code retour : $returnValue");
                }
            }
        });
    }
}
