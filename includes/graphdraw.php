<?php

/**
 * Set color of image element in easier way
 * 
 * @param GdImage $image Image to operate on
 * @param string $hex Color in hexadecimal
 * 
 * @return int|false A color identifier or false if the allocation failed.
 */
function rgb(GdImage $image, string $hex): int|false
{
    return imagecolorallocate(
        $image,
        hexdec(substr($hex, 0, 2)),
        hexdec(substr($hex, 2, 2)),
        hexdec(substr($hex, 4, 2))
    );
}

/**
 * Calculate coordinates of the vertices
 * 
 * @param int $count Amount of vertices
 * 
 * @return array Array of the coordinates of the vertices
 */
function calculate_vertices(int $count): array
{
    for ($i = 0; $i < $count; $i++) {
        $angle = (2 * pi() * $i / $count) - 0.5 * pi();
        $x = (200 * cos($angle)) + 400;
        $y = (200 * sin($angle)) + 300;
        $vertex_coords[] = ['x' => $x, 'y' => $y];
    }
    return $vertex_coords;
}

/**
 * Calculate edge's start and end vertices
 * 
 * @param array $adjacency_list Graph's adjacency list
 * 
 * @return array Array of graph's edges
 */
function calculate_edges(array $adjacency_list): array
{
    $edges = [];
    foreach ($adjacency_list as $vertex => $neighbors) {
        foreach ($neighbors as $neighbor) {
            if (!in_array(['start' => $vertex, 'end' => $neighbor], $edges) && !in_array(['start' => $neighbor, 'end' => $vertex], $edges)) {
                $edges[] = [
                    'start' => $vertex,
                    'end' => $neighbor
                ];
            }
        }
    }
    return $edges;
}

/**
 * Draw edges between specified graph's vertices
 * 
 * @param GdImage $image Image, where edges have to be drawed
 * @param array $start Start vertex
 * @param array $end End vertex
 * @param int $color The line color. A color identifier created with `rgb(GdImage, string)`
 */
function connect_vertices(GdImage $image, array $start, array $end, int $color): void
{
    imageline($image, $start['x'], $start['y'], $end['x'], $end['y'], $color);
}

/**
 * Connect all vertices in the graph
 * 
 * @param GdImage $image Image, where edges have to be drawed
 * @param array $edges Array of edges
 * @param array $vertex_coords Coordinates of the vertices
 */
function draw_edges(GdImage $image, array $edges, array $vertex_coords): void
{
    foreach ($edges as $edge) {
        connect_vertices($image, $vertex_coords[$edge['start']], $vertex_coords[$edge['end']], rgb($image, '03a9f4'));
    }
}

/**
 * Draw vertices in calculated coordinates
 * 
 * @param GdImage $image Image, where vertices have to be drawed
 * @param array $vertex_coords Coordinates of the vertices
 * @param int $diameter vertex diameter
 */
function draw_vertices(GdImage $image, array $vertex_coords, int $diameter): void
{
    foreach ($vertex_coords as $i => $vertex) {
        $text_x = $vertex['x'] - $diameter / 8;
        $text_y = $vertex['y'] - $diameter / 4;
        imagefilledellipse($image, $vertex['x'], $vertex['y'], $diameter, $diameter, rgb($image, 'f44336'));
        imagestring($image, 5, $i <= 9 ? $text_x : $text_x - $diameter / 8, $text_y, $i, rgb($image, 'ffffff'));
        imagestring($image, 5, 10, 580, 'Generated: ' . date('Y-m-d H:i:s'), rgb($image, '000000'));
    }
}

/**
 * Generate image of graph basing on given adjacency list
 * 
 * @param array $adjacency_list Graph's adjacency list
 * @param string $path Destination path of result image
 * 
 * @return array Array of edges in graph
 */
function generate_image(array $adjacency_list, string $path): array
{
    $image = imagecreate(800, 600);
    imagefilledrectangle($image, 0, 0, 800, 600, rgb($image, 'ffffff'));
    $vertex_coords = calculate_vertices(count($adjacency_list));
    $edges = calculate_edges($adjacency_list);
    draw_edges($image, $edges, $vertex_coords);
    draw_vertices($image, $vertex_coords, 30);
    if (!is_dir(dirname($path))) mkdir(dirname($path));
    imagepng($image, $path);
    echo "Graph visualisation is saved to $path" . PHP_EOL;
    imagedestroy($image);
    return $edges;
}
