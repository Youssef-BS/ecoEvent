<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Messagerie;

return new class extends Migration
{
    public function up()
    {
        $messages = Messagerie::all();

        foreach ($messages as $message) {
            $content = $message->content;

            // If content contains JSON structure
            if (is_string($content) && str_contains($content, '"content"')) {
                try {
                    // Fix malformed JSON
                    $fixedJson = str_replace("'", '"', $content);
                    $fixedJson = preg_replace('/"content""/', '"content":"', $fixedJson);
                    $fixedJson = preg_replace('/,"receiver_id"/', ',"receiver_id"', $fixedJson);

                    $data = json_decode($fixedJson, true);
                    if (isset($data['content']) && is_string($data['content'])) {
                        $message->content = $data['content'];
                        $message->save();
                    }
                } catch (\Exception $e) {
                    // Skip if cannot parse
                    continue;
                }
            }
        }
    }

    public function down()
    {
        // This migration cannot be reversed safely
    }
};
