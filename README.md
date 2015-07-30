# tarjan.php

## PHP implementation of Tarjan's strongly connected components algorithm

[Tarjan's strongly connected components algorithm](https://en.wikipedia.org/wiki/Tarjan%27s_strongly_connected_components_algorithm), published by Robert Tarjan in 1972, is a graph theory algorithm for detecting all cycles and loops in a graph.

It performs a single pass of depth-first search. It maintains a stack of vertices that have been explored by the search but not yet assigned to a component, and calculates "low numbers" of each vertex (an index number of the highest ancestor reachable in one step from a descendant of the vertex) which it uses to determine when a set of vertices should be popped off the stack into a new component.

This is a PHP implementation put together after much reading, trial and error, and peeking at implementations in numerous other programming languages. Special thanks to Jan van der Linde [@janvdl](https://github.com/janvdl) for helpful remarks and code snippets from his Python implementation.

For more information, see [vacilando.org/article/php-implementation-tarjans-cycle-detection-algorithm](https://vacilando.org/article/php-implementation-tarjans-cycle-detection-algorithm).
