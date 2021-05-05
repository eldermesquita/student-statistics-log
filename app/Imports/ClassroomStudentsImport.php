<?php

namespace App\Imports;

use App\Models\Period;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ClassroomStudentsImport implements ToCollection, WithStartRow
{
    private string $startRow;
    private bool $smartAddition;

    public function __construct(string $startRow, $smartAddition)
    {
        $this->startRow = $startRow;
        $this->smartAddition = $smartAddition;
    }

    public function startRow(): int
    {
        return $this->startRow;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $period = Period::active()->first();

            $classroom = $period->classrooms()->firstOrCreate([
                'number' => (int) mb_substr($row[2], 0, 1),
                'postfix' => mb_strtoupper(mb_substr($row[2], 1, 1)),
            ]);

            if ($this->smartAddition) {
                $classroom->students()->firstOrCreate([
                    'name' => $row[1]
                ]);
            } else {
                $classroom->students()->create([
                    'name' => $row[1]
                ]);
            }
        }
    }
}
