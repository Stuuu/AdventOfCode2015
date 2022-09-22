<?php
// --- Day 5: Doesn't He Have Intern-Elves For This? ---
// Santa needs help figuring out which strings in his text file are naughty or nice.

// A nice string is one with all of the following properties:

// It contains at least three vowels (aeiou only), like aei, xazegov, or aeiouaeiouaeiou.
// It contains at least one letter that appears twice in a row, like xx, abcdde (dd), or aabbccdd (aa, bb, cc, or dd).
// It does not contain the strings ab, cd, pq, or xy, even if they are part of one of the other requirements.
// For example:

// ugknbfddgicrmopn is nice because it has at least three vowels (u...i...o...), a double letter (...dd...), and none of the disallowed substrings.
// aaa is nice because it has at least three vowels and a double letter, even though the letters used by different rules overlap.
// jchzalrnumimnmhp is naughty because it has no double letter.
// haegwjzuvuyypxyu is naughty because it contains the string xy.
// dvszwmarrgswjxmb is naughty because it contains only one vowel.
// How many strings are nice?

class Solution

{

    const VOWEL_ORDINALS = [
        97 => 'a',
        101 => 'e',
        105 => 'i',
        111 => 'o',
        117 => 'u',
    ];

    const PROHIBITTED_SUBSTRINGS =
    ['ab', 'cd', 'pq',  'xy',];

    const VOWEL_COUNT_REQ = 3;

    public function run()
    {

        $inputs = file('puzzle_inputs.txt');
        // $inputs = file('test_puzzle_inputs.txt');

        $nice_string_count = 0;
        $debug_eval_reasons = [];
        foreach ($inputs as $key => $value) {
            $input_string = trim($value);

            $debug_eval_reasons[$input_string] = [];

            // It contains at least three vowels (aeiou only), like aei, xazegov, or aeiouaeiouaeiou.
            if (!self::hasThreeVowels($input_string)) {
                $debug_eval_reasons[$input_string] = '3 < vowels';
            };
            // It contains at least one letter that appears twice in a row, like xx, abcdde (dd), or aabbccdd (aa, bb, cc, or dd).
            if (!self::hasRepeatLetter($input_string)) {
                $debug_eval_reasons[$input_string] = 'no repeat letters';
            };
            // It does not contain the strings ab, cd, pq, or xy, even if they are part of one of the other requirements.
            if (self::hasProhibittedSubString($input_string)) {
                $debug_eval_reasons[$input_string] = 'has prohibitted sub string';
            };


            if(!empty($debug_eval_reasons[$input_string])){
                continue;
            };


            $nice_string_count++;
        }
        echo $nice_string_count . PHP_EOL;
    }

    private static function hasProhibittedSubString(string $input_string): bool
    {
        $input_parts = str_split($input_string);
        foreach ($input_parts as $key => $char) {
            if (!isset($input_parts[$key + 1])) {
                return false;
            }

            $string_pair = $char . $input_parts[$key + 1];

            if (in_array($string_pair, self::PROHIBITTED_SUBSTRINGS)) {
                echo $string_pair . PHP_EOL;
                return true;
            }
        }
        return false;
    }

    private static function hasRepeatLetter(string $input_string): bool
    {
        $input_parts = str_split($input_string);
        foreach ($input_parts as $key => $value) {
            if (!isset($input_parts[$key + 1])) {
                break;
            }
            if ($value === $input_parts[$key + 1]) {
                return true;
            }
        }
        return false;
    }
    private static function hasThreeVowels(string $input_string): bool
    {

        $vowel_count = 0;

        $counts = count_chars($input_string, 1);
        foreach (self::VOWEL_ORDINALS as $ord_val => $vowel) {
            if (isset($counts[$ord_val])) {
                $vowel_count += $counts[$ord_val];

                if ($vowel_count >= self::VOWEL_COUNT_REQ) {
                    return true;
                }
            }
        }
        return false;
    }
}


(new Solution())->run();
