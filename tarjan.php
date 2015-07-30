<?php

/*
 * Array $G is to contain the graph in node-adjacency format.
 */
$G[] = array(1);
$G[] = array(4, 6, 7);
$G[] = array(4, 6, 7);
$G[] = array(4, 6, 7);
$G[] = array(2, 3);
$G[] = array(2, 3);
$G[] = array(5, 8);
$G[] = array(5, 8);
$G[] = array();
$G[] = array();
$G[] = array(10); // This is a self-cycle (aka "loop").

/*
 * There are 11 results for the above example (strictly speaking: 10 cycles and 1 loop):
 * 2|4
 * 2|4|3|6|5
 * 2|4|3|7|5
 * 2|6|5
 * 2|6|5|3|4
 * 2|7|5
 * 2|7|5|3|4
 * 3|4
 * 3|6|5
 * 3|7|5
 * 1|0
 */
$cycles = php_tarjan_entry($G);
echo '<pre>'; print_r($cycles); echo '</pre>';

/*
 * php_tarjan_entry() iterates through the graph array rows, executing php_tarjan().
 */
function php_tarjan_entry($G_local){

  // All the following must be global to pass them to recursive function php_tarjan().
  global $cycles;
  global $marked;
  global $marked_stack;
  global $point_stack;

  // Initialize global values that are so far undefined.
  $cycles = array();
  $marked = array();
  $marked_stack = array();
  $point_stack = array();

  $marked = array();
  for ($x = 0; $x < count($G_local); $x++) {
    $marked[$x] = FALSE;
  }

  for ($i = 0; $i < count($G_local); $i++) {
    php_tarjan($i, $i);
    while (!empty($marked_stack)) {
      $marked[array_pop($marked_stack)] = FALSE;
    }
    //echo '<br>'.($i+1).' / '.count($G_local); // Enable if you wish to follow progression through the array rows.
  }

  $cycles = array_keys($cycles);

  return $cycles;
}

/*
 * Recursive function to detect strongly connected components (cycles, loops).
 */
function php_tarjan($s, $v){

  // Source node-adjacency array.
  global $G;

  // All the following must be global to pass them to recursive function php_tarjan().
  global $cycles;
  global $marked;
  global $marked_stack;
  global $point_stack;

  $f = FALSE;
  $point_stack[] = $v;
  $marked[$v] = TRUE;
  $marked_stack[] = $v;

  //$maxlooplength = 3; // Enable to Limit the length of loops to keep in the results (see below).

  foreach($G[$v] as $w) {
    if ($w < $s) {
      $G[$w] = array();
    } else if ($w == $s) {
      //if (count($point_stack) == $maxlooplength){ // Enable to collect cycles of a given length only.
        // Add new cycles as array keys to avoid duplication. Way faster than using array_search.
        $cycles[implode('|', $point_stack)] = TRUE;
      //}
      $f = TRUE;
    } else if ($marked[$w] === FALSE) {
      //if (count($point_stack) < $maxlooplength){ // Enable to only collect cycles up to $maxlooplength.
        $g = php_tarjan($s, $w);
      //}
      if (!empty($f) OR !empty($g)){
        $f = TRUE;
      }
    }
  }

  if ($f === TRUE) {
    while (end($marked_stack) != $v){
      $marked[array_pop($marked_stack)] = FALSE;
    }
    array_pop($marked_stack);
    $marked[$v] = FALSE;
  }

  array_pop($point_stack);
  return $f;
}
