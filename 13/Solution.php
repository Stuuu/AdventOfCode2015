<?php
// --- Day 13: Knights of the Dinner Table ---
// In years past, the holiday feast with your family hasn't gone so well. Not everyone gets along! This year, you resolve, will be different. You're going to find the optimal seating arrangement and avoid all those awkward conversations.

// You start by writing up a list of everyone invited and the amount their happiness would increase or decrease if they were to find themselves sitting next to each other person. You have a circular table that will be just big enough to fit everyone comfortably, and so each person will have exactly two neighbors.

// For example, suppose you have only four attendees planned, and you calculate their potential happiness as follows:

// Alice would gain 54 happiness units by sitting next to Bob.
// Alice would lose 79 happiness units by sitting next to Carol.
// Alice would lose 2 happiness units by sitting next to David.
// Bob would gain 83 happiness units by sitting next to Alice.
// Bob would lose 7 happiness units by sitting next to Carol.
// Bob would lose 63 happiness units by sitting next to David.
// Carol would lose 62 happiness units by sitting next to Alice.
// Carol would gain 60 happiness units by sitting next to Bob.
// Carol would gain 55 happiness units by sitting next to David.
// David would gain 46 happiness units by sitting next to Alice.
// David would lose 7 happiness units by sitting next to Bob.
// David would gain 41 happiness units by sitting next to Carol.
// Then, if you seat Alice next to David, Alice would lose 2 happiness units (because David talks so much), but David would gain 46 happiness units (because Alice is such a good listener), for a total change of 44.

// If you continue around the table, you could then seat Bob next to Alice (Bob gains 83, Alice gains 54). Finally, seat Carol, who sits next to Bob (Carol gains 60, Bob loses 7) and David (Carol gains 55, David gains 41). The arrangement looks like this:

//      +41 +46
// +55   David    -2
// Carol       Alice
// +60    Bob    +54
//      -7  +83
// After trying every other seating arrangement in this hypothetical scenario, you find that this one is the most optimal, with a total change in happiness of 330.

// What is the total change in happiness for the optimal seating arrangement of the actual guest list?

// --- Part Two ---
// In all the commotion, you realize that you forgot to seat yourself. At this point, you're pretty apathetic toward the whole thing, and your happiness wouldn't really go up or down regardless of who you sit next to. You assume everyone else would be just as ambivalent about sitting next to you, too.

// So, add yourself to the list, and give all happiness relationships that involve you a score of 0.

// What is the total change in happiness for the optimal seating arrangement that actually includes yourself?

class Solution

{
    public function run()
    {

        $inputs = file('puzzle_inputs.txt');
        // $inputs = file('test_puzzle_inputs.txt');

        $parsed_values = self::parseInput($inputs);
        $individuals = $parsed_values['individuals'];
        $possible_comboninations = (int) gmp_fact(count($individuals));


        $combo_count = 0;
        $combos = [];
        while (true) {
            shuffle($individuals);

            $seating_argangment = implode('.', $individuals);
            if (!isset($combos[$seating_argangment])) {


                $total_happy = 0;
                $last_loop = false;
                foreach ($individuals as $seat_key => $individual) {

                    if (isset($individuals[$seat_key + 1])) {
                        $pair_key_1 = $individual . '.' . $individuals[$seat_key + 1];
                        $pair_key_2 = $individuals[$seat_key + 1] . '.' . $individual;
                    } else {
                        $pair_key_1 = $individual . '.' . $individuals[0];
                        $pair_key_2 = $individuals[0] . '.' . $individual;
                        $last_loop = true;
                    }
                    $total_happy += $parsed_values['happy_scores'][$pair_key_1]['val'];
                    $total_happy += $parsed_values['happy_scores'][$pair_key_2]['val'];
                    if($last_loop){
                        break;
                    }
                }


                $combos[$seating_argangment] = $total_happy;



                $combo_count++;
                if ($combo_count === $possible_comboninations) {
                    echo $combo_count . PHP_EOL;
                    echo max($combos) . PHP_EOL;
                    break;
                };
            }
        }
    }


    private function parseInput(array $input)
    {

        $parsed_vals = [];
        $unique_individuals = [];
        foreach ($input as $seating_val) {

            $seating_val = trim($seating_val, " \t\n\r\0\x0B\.");
            $parts = explode(' ', $seating_val);
            $unique_individuals[$parts[0]] = uniqid();
            $parsed_vals[$parts[0] . "." . $parts[10]] = [
                'val' => $parts[2] === "lose" ? -$parts[3] : $parts[3],
            ];
        }
        $indivuals = array_flip($unique_individuals);

        return [
            'happy_scores' => $parsed_vals,
            'individuals' => $indivuals,
        ];
    }
}

(new Solution())->run();
