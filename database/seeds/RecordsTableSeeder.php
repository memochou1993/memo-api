<?php

use App\Record;
use Illuminate\Database\Seeder;

class RecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = factory(Record::class, config('seeds.record.number'))->make();

        Record::insert($records->toArray());
    }
}
