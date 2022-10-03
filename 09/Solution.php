<?php
// --- Day 9: All in a Single Night ---
// Every year, Santa manages to deliver all of his presents in a single night.

// This year, however, he has some new locations to visit; his elves have provided him the distances between every pair of locations. He can start and end at any two (different) locations he wants, but he must visit each location exactly once. What is the shortest distance he can travel to achieve this?

// For example, given the following distances:

// London to Dublin = 464
// London to Belfast = 518
// Dublin to Belfast = 141
// The possible routes are therefore:

// Dublin -> London -> Belfast = 982
// London -> Dublin -> Belfast = 605
// London -> Belfast -> Dublin = 659
// Dublin -> Belfast -> London = 659
// Belfast -> Dublin -> London = 605
// Belfast -> London -> Dublin = 982
// The shortest of these is London -> Dublin -> Belfast = 605, and so the answer is 605 in this example.

// What is the distance of the shortest route?



class Solution

{

    private array $locations = [];
    private array $pair_distances = [];

    public function run()
    {

        $inputs = file('puzzle_inputs.txt');
        // $inputs = file('test_puzzle_inputs.txt');


        $this->parseInputs($inputs);

        $unique_location_count = count($this->locations);
        $num_of_possible_combos = (int) gmp_fact($unique_location_count);

        $routes = [];
        $total_routes = 0;
        while (true) {
            shuffle($this->locations);
            $key = implode('->', $this->locations);
            if (!isset($routes[$key])) {
                $total_route_distance = 0;
                foreach ($this->locations as $lk => $location) {
                    if(!isset($this->locations[$lk + 1])){
                        break;
                    }
                    $current_pair = [
                        $location,
                        $this->locations[$lk + 1]
                    ];

                    sort($current_pair);

                   $total_route_distance += $this->pair_distances[implode('->', $current_pair)];

                }
                $routes[$key] = $total_route_distance;
                $total_routes++;
            }


            if ($total_routes === $num_of_possible_combos) {
                echo 'all combos found' . PHP_EOL;
                echo min($routes);
                break;
            }
        }
    }

    private  function parseInputs($inputs)
    {

        foreach ($inputs as $line) {
            $line = trim($line);
            $line_parts = explode(' ', $line);

            $this->locations[$line_parts[0]] = uniqid();
            $this->locations[$line_parts[2]] = uniqid();


            $alpha_sort_cities = [
                $line_parts[0],
                $line_parts[2],
            ];
            sort($alpha_sort_cities);
            $this->pair_distances[implode('->', $alpha_sort_cities)] = $line_parts[4];
        }
        $this->locations = array_flip($this->locations);
    }
}

(new Solution())->run();
