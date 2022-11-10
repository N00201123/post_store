<?php

namespace App\Http\Controllers;

use AppResponse;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;

//Adding CRUD functionality in Swagger Documentation/Laravel
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/posts",
     *     description="Displays all the posts",
     *     tags={"Posts"},
     *      @OA\Response(
        *          response=200,
        *          description="Successful operation, Returns a list of Posts in JSON format"
        *       ),
        *      @OA\Response(
        *          response=401,
        *          description="Unauthenticated",
        *      ),
        *      @OA\Response(
        *          response=403,
        *          description="Forbidden"
        *      )
 * )
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PostCollection(Post::with('platform')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/api/posts",
     *      operationId="store",
     *      tags={"Posts"},
     *      summary="Create a new Post",
     *      description="Stores the post in the DB",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"title", "description", "author", "date", "likes"},
     *            @OA\Property(property="title", type="string", format="string", example="Sample Title"),
     *            @OA\Property(property="description", type="string", format="string", example="A long description about this great post"),
     *            @OA\Property(property="author", type="string", format="string", example="Me"),
     *            @OA\Property(property="date", type="date", format="date", example="2014-11-25"),
     *             @OA\Property(property="likes", type="integer", format="integer", example="1")
     *          )
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=""),
     *             @OA\Property(property="data",type="object")
     *          )
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::create([
            //'title', 'description', 'author', 'date', 'likes'
            'title' => $request->title,
            'description' => $request->description,
            'author' => $request->author,
            'date' => $request->date,
            'likes' => $request->likes,
            'platform_id' => $request->platform_id
        ]);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
    * @OA\Get(
    *     path="/api/posts/{id}",
    *     description="Gets a post by ID",
    *     tags={"Posts"},
    *          @OA\Parameter(
        *          name="id",
        *          description="Post id",
        *          required=true,
        *          in="path",
        *          @OA\Schema(
        *              type="integer")
     *          ),
        *      @OA\Response(
        *          response=200,
        *          description="Successful operation"
        *       ),
        *      @OA\Response(
        *          response=401,
        *          description="Unauthenticated",
        *      ),
        *      @OA\Response(
        *          response=403,
        *          description="Forbidden"
        *      )
 * )
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {   
        $post_image = $request->file('post_image');
        $extension = $post_image->getClientOriginalExtension();

        $filename = date('Y-m-d-His') . '_' . $request->input('title') . '.' . $extension;

        $path = $post_image->storeAs('public/images', $filename);

        $post->update($request->only([
            'title', 'description', 'author', 'date', 'likes'
        ]));

        $post->update([
            'post_image' => $filename]
        );

        return new PostResource($post);
    }
    /**
     *
     *
     * @OA\Delete(
     *    path="/api/posts/{id}",
     *    operationId="destroy",
     *    tags={"Posts"},
     *    summary="Delete a Post",
     *    description="Delete Post",
     *    @OA\Parameter(name="id", in="path", description="Id of a Post", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Response(
     *         response=Response::HTTP_NO_CONTENT,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="status_code", type="integer", example="204"),
     *         @OA\Property(property="data",type="object")
     *          ),
     *       )
     *      )
     *  )

     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post) //this will delete a post off the databse
    {
        $post->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
