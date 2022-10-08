<?php
// --- Day 11: Corporate Policy ---
// Santa's previous password expired, and he needs help choosing a new one.

// To help him remember his new password after the old one expires, Santa has devised a method of coming up with a password based on the previous one. Corporate policy dictates that passwords must be exactly eight lowercase letters (for security reasons), so he finds his new password by incrementing his old password string repeatedly until it is valid.

// Incrementing is just like counting with numbers: xx, xy, xz, ya, yb, and so on. Increase the rightmost letter one step; if it was z, it wraps around to a, and repeat with the next letter to the left until one doesn't wrap around.

// Unfortunately for Santa, a new Security-Elf recently started, and he has imposed some additional password requirements:

// Passwords must include one increasing straight of at least three letters, like abc, bcd, cde, and so on, up to xyz. They cannot skip letters; abd doesn't count.
// Passwords may not contain the letters i, o, or l, as these letters can be mistaken for other characters and are therefore confusing.
// Passwords must contain at least two different, non-overlapping pairs of letters, like aa, bb, or zz.
// For example:

// hijklmmn meets the first requirement (because it contains the straight hij) but fails the second requirement requirement (because it contains i and l).
// abbceffg meets the third requirement (because it repeats bb and ff) but fails the first requirement.
// abbcegjk fails the third requirement, because it only has one double letter (bb).
// The next password after abcdefgh is abcdffaa.
// The next password after ghijklmn is ghjaabcc, because you eventually skip all the passwords that start with ghi..., since i is not allowed.
// Given Santa's current password (your puzzle input), what should his next password be?

// Your puzzle input is vzbxkghb.


class Solution

{

    const FORBIDDEN_LETTERS = [
        'i',
        'o',
        'l',
    ];

    public function run()
    {
        $alpha_as_string = implode('', range('a', 'z'));

        $inputs = file('puzzle_inputs.txt');
        // $inputs = file('test_puzzle_inputs.txt');
        $password = trim($inputs[0]);


        $count = 0;
        while (true) {
            // increment password
            $password++;
            // var_dump($password);

            if (self::containsForbiddenLetters($password)) {
                continue;
            }

            if (self::doesNotHaveThreeConsecutiveLetters($password, $alpha_as_string)) {
                continue;
            }

            if (self::doesNotHaveTwoOverlappingPairs($password)){
                continue;
            }

            echo $password . PHP_EOL;
            die;
        }
    }


    // Passwords must contain at least two different, non-overlapping pairs of letters, like aa, bb, or zz.
    private static function doesNotHaveTwoOverlappingPairs(string $password)
    {
        $password_parts = str_split($password);


        $found_char_pairs = [];
        foreach ($password_parts as $key => $char) {
            // We've gone over the whole password and not found two pairs
            if (!isset($password_parts[$key + 1])) {
                return true;
            }


            if ($char === $password_parts[$key + 1]) {
                if(!in_array($char, $found_char_pairs)){
                    $found_char_pairs[] = $char;
                }
                if(count($found_char_pairs) > 1){
                   return false;
                }
            }
        }
        return true;
    }

    //Passwords must include one increasing straight of at least three letters, like abc, bcd, cde, and so on, up to xyz. They cannot skip letters; abd doesn't count.
    private static function doesNotHaveThreeConsecutiveLetters(string $password, string $alpha_as_string)
    {
        $password_parts = str_split($password);

        foreach ($password_parts as $key => $char) {

            if (!isset($password_parts[$key + 2])) {
                return true;
            }

            $three_chunk = $char . $password_parts[$key + 1] . $password_parts[$key + 2];
            if (strpos($alpha_as_string, $three_chunk) !== false) {
                return false;
            }
        }
        return true;
    }
    // Passwords may not contain the letters i, o, or l, as these letters can be mistaken for other characters and are therefore confusing.
    private static function containsForbiddenLetters(string $password): bool
    {
        foreach (self::FORBIDDEN_LETTERS as $key => $forbidden_letter) {
            if (strpos($password, $forbidden_letter) !== false) {
                return true;
            }
        }
        return false;
    }
}

(new Solution())->run();
