<?php

/**
 * Prints header of matrix (number columns)
 * 
 * @param array $matrix Matrix to generate header
 */
function print_matrix_header(array $matrix): void
{
    echo "\t| ";
    for ($i = 1; $i <= count($matrix[0]); $i++) {
        echo $i;
        echo $i >= 10 ? " " : "  ";
    }
    echo PHP_EOL . "--------+-";
    for ($i = 0; $i < count($matrix[0]); $i++) {
        echo "---";
    }
}

/**
 * Prints matrix with rows and columns numbered
 * 
 * @param array $matrix Matrix to print
 */
function print_matrix(array $matrix): void
{
    print_matrix_header($matrix);
    foreach ($matrix as $i => $row) {
        echo PHP_EOL . "$i\t| ";
        foreach ($row as $j => $cell) {
            if ($cell == 1) echo "\033[31m";
            echo $cell;
            if ($cell == 1) echo "\033[0m";
            echo "  ";
        }
    }
    echo PHP_EOL;
}

/**
 * Generates and prints incidence matrix basing on graph's edges and adjacency list
 * 
 * @param array $edges Array of edges
 * @param array $adjacency_list Adjacency list
 * 
 * @return array incidence matrix
 */
function generate_incidence_matrix(array $edges, array $adjacency_list): array
{
    $matrix = [];
    foreach ($adjacency_list as $i => $vertices) {
        foreach ($edges as $j => $edge) {
            $matrix[$i][$j] = 0;
        }
    }
    foreach ($edges as $i => $edge) {
        $matrix[$edge['start']][$i] = 1;
        $matrix[$edge['end']][$i] = 1;
    }
    echo PHP_EOL . 'incidence matrix:' . PHP_EOL;
    print_matrix($matrix);
    return $matrix;
}

/**
 * Generates and prints adjacency matrix basing on graph's edges and adjacency list
 * 
 * @param array $edges Array of edges
 * @param array $adjacency_list Adjacency list
 * 
 * @return array adjacency matrix
 */
function generate_adjacency_matrix(array $edges, array $adjacency_list): array
{
    echo PHP_EOL . 'adjacency matrix:' . PHP_EOL;
    $matrix = zeros(count($adjacency_list));
    foreach ($edges as $edge) {
        $matrix[$edge['start']][$edge['end']] = 1;
        $matrix[$edge['end']][$edge['start']] = 1;
    }
    print_matrix($matrix);
    return $matrix;
}