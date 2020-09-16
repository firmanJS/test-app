<?php

namespace App\Http\Controllers\API\v1;
use App\Http\Controllers\Controller;
use DB;
use App\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContainerController extends Controller
{
    public function index(Request $request, $id_containers=null)
    {
        try {
            if($id_containers){
                $query = DB::table('containers')->where('containers.id', $id_containers);
            }else{
                $query = DB::table('containers');
            }
            $query->join('players', 'players.id', '=', 'containers.player_id')
                ->select(
                    'containers.id',
                    'containers.player_id', 
                    'players.name', 
                    'containers.capacity',  
                    'containers.total'
                );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Get container not sucessfuly',
                'data' =>  $e->getMessage()
            ], 400);
        }
        return response()->json([
            'message' => 'Get container sucessfuly',
            'data' => $query->get()
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'player_id' => 'required|integer',
                'capacity' => 'required|integer',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            $container = Container::create([
                'player_id' => $request->player_id,
                'capacity' => $request->capacity
            ]);

            return response()->json([
                'message' => 'Container created',
                'data' => $container
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Container failed created',
                'data' =>  $e->getMessage()
            ], 500);
        }
    }
}
