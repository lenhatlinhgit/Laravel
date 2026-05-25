<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $posts = DB::table('posts')->get();

        foreach ($posts as $post) {

            if (!$post->location) {
                continue;
            }

            $locations = explode(',', $post->location);

            foreach ($locations as $loc) {

                $loc = trim($loc);

                if (empty($loc)) {
                    continue;
                }

                $location = DB::table('locations')
                    ->where('name', $loc)
                    ->first();

                if (!$location) {

                    $locationId = DB::table('locations')->insertGetId([
                        'name' => $loc,
                        'slug' => Str::slug($loc),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                } else {

                    $locationId = $location->id;
                }

                $exists = DB::table('post_locations')
                    ->where('post_id', $post->id)
                    ->where('location_id', $locationId)
                    ->exists();

                if (!$exists) {

                    DB::table('post_locations')->insert([
                        'post_id' => $post->id,
                        'location_id' => $locationId,
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        DB::table('post_locations')->truncate();

        DB::table('locations')->truncate();
    }
};