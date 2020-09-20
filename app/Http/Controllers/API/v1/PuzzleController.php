<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PuzzleController extends Controller
{
    public function index(Request $request)
    {
        $data = array(
            array(0, 0, 0, 0, 0, 0, 0, 0),
            array(0, 1, 1, 1, 1, 1, 1, 0),
            array(0, 1, 0, 0, 0, 1, 1, 0),
            array(0, 1, 1, 1, 0, 1, 0, 0),
            array(0, 1, 0, 1, 1, 1, 1, 0),
            array(0, 0, 0, 0, 0, 0, 0, 0)
          );
          
          $column = 1;
          $row = 4;
          
          $y = $row;
          $x = $column;
          $a = 1;
          foreach($data as $key){
            $x = $column;
            $y = $row - $a;
            if ($y < 0 || !$data[$y][$x]) {
              break;
            }
            $b = 0;
            $solutionsA[] = $a;
            foreach($data as $key){
              $x = $column + $b;
              $y = $row - $a;
              if ($x >= count($data[0]) || !$data[$y][$x]) {
                break;
              }
              $solutionsB[] = $b;
              $c = 0;
              foreach($data as $key){
                $x = $column + $b;
                $y = $row - $a + $c;
                if ($y >= count($data) || !$data[$y][$x]) {
                  break;
                }
                $c++;
                $solutionsC[] = $c;
              }
              $b++;
            }
            $a++;
            $solutions = array(
              'a' => $solutionsA, 
              'b' => array_slice($solutionsB, 5), 
              'c' => array_slice($solutionsC, 0, 1)
            );
          }
        $uri = $request->url();
        return response()->json([
            'data' => $solutions,
            'Solutions A ' => 'solution A walk to north '.count($solutions['a']).' steps',
            'Solutions B ' => 'solution B walk to east '.count($solutions['b']).' steps',
            'Solutions C ' => 'solution C walk to south '.count($solutions['c']).' steps'
        ]);
    }
}
