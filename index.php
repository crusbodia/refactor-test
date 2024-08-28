<?php

$i = 1;
$j = 1;


$task1 = '';
$task2 = '';

while ($i <= 20) {

    switch ($i) {
        case ($i % 3 === 0) and ($i % 5 === 0):
            $task1 .= 'papow ';
            break;
        case ($i % 3 === 0):
            $task1 .= 'pa ';
            break;
        case ($i % 5 === 0):
            if ($i === 20) {
                $task1 .= 'pow';
            } else {
                $task1 .= 'pow ';
            }
            break;
        default:
            $task1 .= $i . ' ';
    }

    $i++;
}

while ($j <= 15) {
    if ($j === 15) {
        $task2 .= $j;
        $j++;
        continue;
    }
    switch ($j) {
        case ($j % 7 === 0) and ($j % 2 === 0):
            $task2 .= 'hateeho-';
            break;
        case ($j % 2 === 0):
            $task2 .= 'hatee-';
            break;
        case ($j % 7 === 0):
            $task2 .= 'ho-';
            break;
        default:
            $task2 .= $j . '-';
    }
    $j++;
}

//
print "Task v1: \n";
print $task1 . "\n";
print "Task v2: \n";
print $task2 . "\n";




abstract class Printer
{
    public string $result;

    public function __construct(private int $start, private int $end, protected string $delimiter) {
        $this->result = '';
    }

    public function generateString(): void
    {
        $i = $this->start;

        while ($i <= $this->end) {
            $this->result .= $this->condition($i);
            $i++;
        }
    }

    abstract public function condition(int $i): string;

    public function print(): void
    {
        print rtrim($this->result, $this->delimiter);
    }
}


class Task1Printer extends Printer {
    public function condition($i): string
    {
        return '';
    }
}

class Task3Printer extends Printer {

    private array $firstCase = [1, 4, 9];

    public function condition($i): string
    {
        switch ($i) {
            case $i === 9:
                return 'jofftchoff' . $this->delimiter;
            case in_array($i, $this->firstCase, true):
                return 'joff' . $this->delimiter;
            case $i > 5:
                return 'tchoff' . $this->delimiter;
            default:
                return $i . $this->delimiter;
        }
    }
}

$task3 = new Task3Printer(1, 10, '-');
$task3->generateString();
print "Task v3: \n";
$task3->print();
