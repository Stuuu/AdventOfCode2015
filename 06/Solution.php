<?php
// --- Day 6: Probably a Fire Hazard ---
// Because your neighbors keep defeating you in the holiday house decorating contest year after year, you've decided to deploy one million lights in a 1000x1000 grid.

// Furthermore, because you've been especially nice this year, Santa has mailed you instructions on how to display the ideal lighting configuration.

// Lights in your grid are numbered from 0 to 999 in each direction; the lights at each corner are at 0,0, 0,999, 999,999, and 999,0. The instructions include whether to turn on, turn off, or toggle various inclusive ranges given as coordinate pairs. Each coordinate pair represents opposite corners of a rectangle, inclusive; a coordinate pair like 0,0 through 2,2 therefore refers to 9 lights in a 3x3 square. The lights all start turned off.

// To defeat your neighbors this year, all you have to do is set up your lights by doing the instructions Santa sent you in order.

// For example:

// turn on 0,0 through 999,999 would turn on (or leave on) every light.
// toggle 0,0 through 999,0 would toggle the first line of 1000 lights, turning off the ones that were on, and turning on the ones that were off.
// turn off 499,499 through 500,500 would turn off (or leave off) the middle four lights.
// After following the instructions, how many lights are lit?

// --- Part Two ---
// You just finish implementing your winning light pattern when you realize you mistranslated Santa's message from Ancient Nordic Elvish.

// The light grid you bought actually has individual brightness controls; each light can have a brightness of zero or more. The lights all start at zero.

// The phrase turn on actually means that you should increase the brightness of those lights by 1.

// The phrase turn off actually means that you should decrease the brightness of those lights by 1, to a minimum of zero.

// The phrase toggle actually means that you should increase the brightness of those lights by 2.

// What is the total brightness of all lights combined after following Santa's instructions?

// For example:

// turn on 0,0 through 0,0 would increase the total brightness by 1.
// toggle 0,0 through 999,999 would increase the total brightness by 2000000.

class Solution

{
    const GRID_SIZE = 1000;
    public function run()
    {

        $inputs = file('puzzle_inputs.txt');
        // $inputs = file('test_puzzle_inputs.txt');

        $grid = array_fill(0, self::GRID_SIZE, array_fill(0, self::GRID_SIZE, 0));
        // self::printGrid($grid);

        foreach ($inputs as $instruction) {
            $operation =  self::parseInstruction($instruction);

            foreach ($grid as $row => &$column) {

                foreach ($column as $r2 => &$val) {

                    $fill_x = ($row >= $operation['start_x']) && ($row <= $operation['end_x']);
                    $fill_y = ($r2 >= $operation['start_y']) && ($r2 <= $operation['end_y']);

                    // echo 'row: ' . $row . ' col: ' . $r2 . ' fillx: ' . (int) $fill_x . ' filly: ' . (int) $fill_y . PHP_EOL;

                    if ($fill_x && $fill_y) {

                        switch ($operation['action']) {
                            case 'on':
                                $val++;
                                break;
                            case 'off':
                                if(($val - 1) <= 0){
                                    $val = 0;
                                } else {
                                    $val--;
                                }
                                break;
                            case 'toggle':
                                $val += 2;
                            default:
                                # code...
                                break;
                        }

                    }
                }
            }
            // self::printGrid($grid);
            // echo self::countOnLights($grid);
        }

        // self::printGrid($grid);

        echo self::countOnLights($grid);
    }

    private static function printGrid(array $grid)
    {
        foreach ($grid as $column) {
            echo implode($column) . PHP_EOL;
        }
    }

    private static function countOnLights(array $grid)
    {
        $on_count = 0;
        foreach ($grid as $column) {
            foreach ($column as $col_val) {
                $on_count += $col_val;
            }
        }
        return $on_count;
    }

    private static function parseInstruction(string $instruction): array
    {
        $instruction = trim($instruction);
        $instruction = explode(' ', $instruction);

        $operation = [];
        switch ($instruction[0]) {
            case 'turn':
                $start_cords = explode(',', $instruction[2]);
                $end_cords = explode(',', $instruction[4]);

                $operation = [
                    'action' => $instruction[1],
                    'start_x' => $start_cords[0],
                    'start_y' => $start_cords[1],
                    'end_x' => $end_cords[0],
                    'end_y' => $end_cords[1],
                ];
                break;
            case 'toggle':
                $start_cords = explode(',', $instruction[1]);
                $end_cords = explode(',', $instruction[3]);
                $operation = [
                    'action' => $instruction[0],
                    'start_x' => $start_cords[0],
                    'start_y' => $start_cords[1],
                    'end_x' => $end_cords[0],
                    'end_y' => $end_cords[1],
                ];
                break;

            default:
                throw new Exception('unknown instruciton type');
                break;
        }

        return $operation;
    }
}

(new Solution())->run();
