<?php

use App\RecordTag;
use Illuminate\Database\Seeder;

class RecordsTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records_tags = factory(RecordTag::class, config('seeds.records_tags.number'))->make();

        RecordTag::insert($records_tags->unique(function ($item) {
            return $item['record_id'].'-'.$item['tag_id'];
        })->toArray());
    }
}
