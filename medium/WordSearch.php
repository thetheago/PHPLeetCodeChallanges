<?php

declare(strict_types=1);

function dd(...$args) {
    var_dump($args);
    die;
}

function alocatePad(array &$pad): void
{
    $pad[0][0] = 'A';
    $pad[0][1] = 'C';
    $pad[0][2] = 'G';
    $pad[1][0] = 'F';
    $pad[1][1] = 'K';
    $pad[1][2] = 'A';
    $pad[2][0] = 'W';
    $pad[2][1] = 'O';
    $pad[2][2] = 'T';
}

function backtrack(array $pad, array $wordSearched, int $indexLetter, int $row, int $col): bool
{
    if (!isset($wordSearched[$indexLetter])) return true;

    $letterToSearch = $wordSearched[$indexLetter];

    // left
    if (isset($pad[$row][$col-1]) && ($pad[$row][$col-1] != '#' && ($pad[$row][$col-1] == $letterToSearch))) {
        $pad[$row][$col] = '#';
        return backtrack($pad, $wordSearched, ++$indexLetter, $row, $col-1);
    }

    // up
    if (isset($pad[$row-1][$col]) && ($pad[$row-1][$col] != '#' && ($pad[$row-1][$col] == $letterToSearch))) {
        $pad[$row][$col] = '#';
        return backtrack($pad, $wordSearched, ++$indexLetter, $row-1, $col);
    }

    // right
    if (isset($pad[$row][$col+1]) && ($pad[$row][$col+1] != '#' && ($pad[$row][$col+1] == $letterToSearch))) {
        $pad[$row][$col] = '#';
        return backtrack($pad, $wordSearched, ++$indexLetter, $row, $col+1);
    }

    // down
    if (isset($pad[$row+1][$col]) && ($pad[$row+1][$col] != '#' && ($pad[$row+1][$col] == $letterToSearch))) {
        $pad[$row][$col] = '#';
        return backtrack($pad, $wordSearched, ++$indexLetter, $row+1, $col);
    } 

    return false;
}

function search(array $pad, array $wordSearched): bool
{
    $indexLetter = 0;

    for ($n=0; $n < count($pad)-1; $n++) {
        for ($c=0; $c < count($pad[0]); $c++) {
            if ($pad[$n][$c] == $wordSearched[0]) {
                if(backtrack($pad, $wordSearched, ++$indexLetter, $n, $c)) {
                    return true;
                }
            }
        }
    }

    return false;
}

$pad = [];
alocatePad($pad);
$word = strtoupper("GATO");
$wordSearched = str_split($word);

echo search($pad, $wordSearched) ? "A palavra $word está no pad." : "A palavra $word NÃO está no pad." . PHP_EOL;
