<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\CityResource;
use App\Http\Resources\PostResource;
use App\Models\City;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return PostResource::collection(Post::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validatedRequest = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'locationName' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
            ]);
            // Create the city record
            $city = City::create([
                'city' => $request['city'],
                'locationName' => $request['locationName'],
            ]);

            // Create the post record
            $post = Post::create([
                'title' => $validatedRequest['title'],
                'content' => $validatedRequest['content'],
                'locationName' => $validatedRequest['locationName'],
                'address' => $validatedRequest['address'],
                'city' => $validatedRequest['city'],
                'created_by' => $request->user()->id
            ]);

            // Commit the transaction
            DB::commit();

            // Return both resources
            return response()->json([
                'post' => new PostResource($post),
                'city' => new CityResource($city)
            ], 201);

        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();
            return response()->json(['error' => 'Failed to create data'], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, int $id)
    {
        $validatedRequest = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'locationName' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        $post = Post::find($id);//it doesn't working yet, but i need commit
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
