<?php
// --- Day 16: Aunt Sue ---
// Your Aunt Sue has given you a wonderful gift, and you'd like to send her a thank you card. However, there's a small problem: she signed it "From, Aunt Sue".

// You have 500 Aunts named "Sue".

// So, to avoid sending the card to the wrong person, you need to figure out which Aunt Sue (which you conveniently number 1 to 500, for sanity) gave you the gift. You open the present and, as luck would have it, good ol' Aunt Sue got you a My First Crime Scene Analysis Machine! Just what you wanted. Or needed, as the case may be.

// The My First Crime Scene Analysis Machine (MFCSAM for short) can detect a few specific compounds in a given sample, as well as how many distinct kinds of those compounds there are. According to the instructions, these are what the MFCSAM can detect:

// children, by human DNA age analysis.
// cats. It doesn't differentiate individual breeds.
// Several seemingly random breeds of dog: samoyeds, pomeranians, akitas, and vizslas.
// goldfish. No other kinds of fish.
// trees, all in one group.
// cars, presumably by exhaust or gasoline or something.
// perfumes, which is handy, since many of your Aunts Sue wear a few kinds.
// In fact, many of your Aunts Sue have many of these. You put the wrapping from the gift into the MFCSAM. It beeps inquisitively at you a few times and then prints out a message on ticker tape:

// children: 3
// cats: 7
// samoyeds: 2
// pomeranians: 3
// akitas: 0
// vizslas: 0
// goldfish: 5
// trees: 3
// cars: 2
// perfumes: 1
// You make a list of the things you can remember about each Aunt Sue. Things missing from your list aren't zero - you simply don't remember the value.

// What is the number of the Sue that got you the gift?


class Solution

{
    public function run()
    {

        $inputs = file('puzzle_inputs.txt');

        $aunts = self::parseInputs($inputs);

        $match_vals =
            [
                "children" => 3,
                "cats" => 7,
                "samoyeds" => 2,
                "pomeranians" => 3,
                "akitas" => 0,
                "vizslas" => 0,
                "goldfish" => 5,
                "trees" => 3,
                "cars" => 2,
                "perfumes" => 1,
            ];

        $debug = [];
        foreach ($aunts as $aunt_num => $aunt) {
            $debug[$aunt_num]['items'] = $aunt;
            foreach ($aunt as $item => $val) {
                $debug[$aunt_num]['matches'][$item] = ($match_vals[$item] === $val) ? 1 : 0;
            }
            $debug[$aunt_num]['match_count'] = array_sum($debug[$aunt_num]['matches']);

            if($debug[$aunt_num]['match_count'] >= 3){
                echo $aunt_num . PHP_EOL;
            }
        }
    }



    private static function parseInputs(array $inputs)
    {
        $aunts = [];
        foreach ($inputs as $sue_num => $line) {
            $line = trim($line);

            $line = explode(', ', $line);
            // remove Sue and num we can get this from the line number
            $line[0] = substr($line[0], strpos($line[0], ": ") + 2);
            foreach ($line as $part) {
                $split_parts = explode(": ", $part);
                $aunts[$sue_num + 1][$split_parts[0]] = (int) $split_parts[1];
            }


        }
        return $aunts;
    }
}

(new Solution())->run();
