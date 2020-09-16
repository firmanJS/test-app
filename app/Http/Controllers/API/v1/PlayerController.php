<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use DB;
use App\Player;
use App\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{
    public function index(Request $request, $id_players=null)
    {
        try {
            if($id_players){
                $query = DB::table('players')->where('players.id', $id_players);
            }else{
                $query = DB::table('players');
            }
            $query->join('containers', 'players.id', '=', 'containers.player_id')
                ->select(
                    'players.id', 
                    'players.name', 
                    'containers.capacity',  
                    'containers.total'
                );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Get player not sucessfuly',
                'data' =>  $e->getMessage()
            ], 400);
        }
        return response()->json([
            'message' => 'Get player sucessfuly',
            'data' => $query->get()
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100'
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            $player = Player::create([
                'name' => $request->name,
                'is_full' => false
            ]);


            return response()->json([
                'message' => 'Player created',
                'data' => $player
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Player failed created',
                'data' =>  $e->getMessage()
            ], 500);
        }
    }

    public function storeBall(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'player_id' => 'required|integer',
                'total' => 'required|integer'
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            // check container full or not
            $checkContainer = Container::where('player_id', '=', $request->player_id)->firstOrFail();
            $getPlayer = Player::findOrFail($checkContainer->player_id);
            $total = $checkContainer->total + $request->total;

            if($total > $checkContainer->capacity){
                return response()->json([
                    'message' => 'Player failed created',
                    'data' =>  'container is full'
                ], 500);
            }else if($getPlayer->is_full){
                return response()->json([
                    'message' => 'Player failed created',
                    'data' =>  'player is stop insert ball'
                ], 500);
            }else{
                if($checkContainer->capacity === $total){
                    $updatedPlayer = [
                        'is_full' => true,
                    ];
                    $getPlayer->fill($updatedPlayer);
                    $getPlayer->save();
                }
                $getContainer = Container::findOrFail($checkContainer->id);
                $updated = [
                    'total' => $total,
                ];
                $getContainer->fill($updated);
                $getContainer->save();
    
                return response()->json([
                    'message' => 'Container is updated',
                    'data' => $getContainer
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Player failed created',
                'data' =>  $e->getMessage()
            ], 500);
        }
    }
}
