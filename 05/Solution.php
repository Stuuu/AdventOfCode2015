<?php

// Realizing the error of his ways, Santa has switched to a better model of determining whether a string is naughty or nice. None of the old rules apply, as they are all clearly ridiculous.

// Now, a nice string is one with all of the following properties:

// It contains a pair of any two letters that appears at least twice in the string without overlapping, like xyxy (xy) or aabcdefgaa (aa), but not like aaa (aa, but it overlaps).

// It contains at least one letter which repeats with exactly one letter between them, like xyx, abcdefeghi (efe), or even aaa.
// For example:

// qjhvhtzxzqqjkmpb is nice because is has a pair that appears twice (qj) and a letter that repeats with exactly one letter between them (zxz).
// xxyxx is nice because it has a pair that appears twice and a letter that repeats with one between, even though the letters used by each rule overlap.
// uurcxstgmygtbstg is naughty because it has a pair (tg) but no repeat with a single letter between them.
// ieodomkazucvgmuy is naughty because it has a repeating letter with one between (odo), but no pair that appears twice.
// How many strings are nice under these new rules?
class Solution

{


    public function run()
    {

        $inputs = file('puzzle_inputs.txt');
        // $inputs = file('test_puzzle_inputs.txt');

        $nice_string_count = 0;
        $debug_eval_reasons = [];
        foreach ($inputs as $key => $value) {
            $input_string = trim($value);

            $debug_eval_reasons[$input_string] = [];

            // It contains a pair of any two letters that appears at least twice in the string without overlapping, like xyxy (xy) or aabcdefgaa (aa), but not like aaa (aa, but it overlaps).
            if (!self::containsDoubleCharPair($input_string)) {
                $debug_eval_reasons[$input_string]['no_dub_pair'] = 1;
            }


            // It contains at least one letter which repeats with exactly one letter between them, like xyx, abcdefeghi (efe), or even aaa.
            if (!self::containsRepeatLetterWithCharBetween($input_string)) {
                $debug_eval_reasons[$input_string]['no letter sandwich'] = 1;
            }


            if (!empty($debug_eval_reasons[$input_string])) {
                continue;
            };


            $nice_string_count++;
        }
        print_r($debug_eval_reasons);
        echo count($debug_eval_reasons) . ' ';
        echo $nice_string_count . PHP_EOL;
    }

    private static function containsRepeatLetterWithCharBetween(string $input_string)
    {

        $input_parts = str_split($input_string);

        $input_size = strlen($input_string);
        for ($i = 0; $i < $input_size; $i++) {

            if (isset($input_parts[$i + 2])) {
                if ($input_parts[$i] === $input_parts[$i + 2]) {
                    return true;
                }
            } else {
                return false;
            }
        }
        return false;
    }


    private static function containsDoubleCharPair(string $input_string)
    {
        $chars = str_split($input_string);

            //wether or not the string has pair letters.
            $has_double = false;
            foreach($chars as $key => $letter) {
                if($key === count($chars)-1) continue;
                if( substr_count($input_string, $letter.$chars[$key+1]) > 1 ) {
                    return true;
                    break;
                }
            }

            if(!$has_double) {
            return false;
            }
    }
}



(new Solution())->run();
