<?php
// --- Day 14: Reindeer Olympics ---
// This year is the Reindeer Olympics! Reindeer can fly at high speeds, but must rest occasionally to recover their energy. Santa would like to know which of his reindeer is fastest, and so he has them race.

// Reindeer can only either be flying (always at their top speed) or resting (not moving at all), and always spend whole seconds in either state.

// For example, suppose you have the following Reindeer:

// Comet can fly 14 km/s for 10 seconds, but then must rest for 127 seconds.
// Dancer can fly 16 km/s for 11 seconds, but then must rest for 162 seconds.
// After one second, Comet has gone 14 km, while Dancer has gone 16 km. After ten seconds, Comet has gone 140 km, while Dancer has gone 160 km. On the eleventh second, Comet begins resting (staying at 140 km), and Dancer continues on for a total distance of 176 km. On the 12th second, both reindeer are resting. They continue to rest until the 138th second, when Comet flies for another ten seconds. On the 174th second, Dancer flies for another 11 seconds.

// In this example, after the 1000th second, both reindeer are resting, and Comet is in the lead at 1120 km (poor Dancer has only gotten 1056 km by that point). So, in this situation, Comet would win (if the race ended at 1000 seconds).

// Given the descriptions of each reindeer (in your puzzle input), after exactly 2503 seconds, what distance has the winning reindeer traveled?

// --- Part Two ---
// Seeing how reindeer move in bursts, Santa decides he's not pleased with the old scoring system.

// Instead, at the end of each second, he awards one point to the reindeer currently in the lead. (If there are multiple reindeer tied for the lead, they each get one point.) He keeps the traditional 2503 second time limit, of course, as doing otherwise would be entirely ridiculous.

// Given the example reindeer from above, after the first second, Dancer is in the lead and gets one point. He stays in the lead until several seconds into Comet's second burst: after the 140th second, Comet pulls into the lead and gets his first point. Of course, since Dancer had been in the lead for the 139 seconds before that, he has accumulated 139 points by the 140th second.

// After the 1000th second, Dancer has accumulated 689 points, while poor Comet, our old champion, only has 312. So, with the new scoring system, Dancer would win (if the race ended at 1000 seconds).

// Again given the descriptions of each reindeer (in your puzzle input), after exactly 2503 seconds, how many points does the winning reindeer have?


class Solution
{


    const RACE_TIME_IN_SECONDS = 2503;

    public function run()
    {

        $inputs = file('puzzle_inputs.txt');
        // $inputs = file('test_puzzle_inputs.txt');

        $reindeer_stats = self::parseReindeerStats($inputs);


        for ($i = 1; $i <= self::RACE_TIME_IN_SECONDS; $i++) {


            foreach ($reindeer_stats as $reindeer_name => &$values) {


                if ($i > $values['rest_until_second']) {
                    $values['distance_traveled'] += $values['speed'];

                    $values['time_till_rest']--;
                    if ($values['time_till_rest'] ===  0) {
                        $values['rest_until_second'] = $i + $values['rest_time'];

                        $values['time_till_rest'] = $values['flight_time'];
                    }
                }
            }

            $top_distance_this_second =  max(array_column($reindeer_stats, 'distance_traveled'));

            foreach ($reindeer_stats as $key => &$value) {
                if($value['distance_traveled'] === $top_distance_this_second ){
                    $value['wins']++;
                }
            }
        }

        print_r($reindeer_stats);
    }

    private static function parseReindeerStats(array $inputs): array
    {
        $stats = [];
        foreach ($inputs as $unparsed_input) {
            $unparsed_input = trim($unparsed_input);
            $input_parts = explode(' ', $unparsed_input);
            $stats[$input_parts[0]] = [
                'speed' => $input_parts[3],
                'flight_time' => $input_parts[6],
                'time_till_rest' => $input_parts[6],
                'rest_time' => $input_parts[13],
                'rest_until_second' => null,
                'distance_traveled' => 0,
                'wins' => 0,
            ];
        }
        return $stats;
    }
}

(new Solution())->run();
