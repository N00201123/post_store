<?php

namespace App\Http\Controllers;

use AppResponse;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\PlatformResource;
use App\Http\Resources\PlatformCollection;
use App\Http\Requests\StorePlatformRequest;
use App\Http\Requests\UpdatePlatformRequest;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/platforms",
     *     description="Displays all the platforms",
     *     tags={"Platforms"},
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
        return new PlatformCollection(Platform::paginate(1));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @OA\Post(
     *      path="/api/platforms",
     *      operationId="storePlatform",
     *      tags={"Platforms"},
     *      summary="Create a new Platform",
     *      description="Stores the platform in the DB",
     *      security={{"bearerAuth":{}}}, 
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"name", "description"},
     *            @OA\Property(property="name", type="string", format="string", example="Sample Name"),
     *            @OA\Property(property="description", type="string", format="string", example="A long description about this great post")
     *      )
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
        $platform = Platform::create([
            'name' => $request->name,
            'description'=> $request->description
        ]);

        return new PlatformResource($platform);
    }

    /**
     * Display the specified resource.
     * @OA\Get(
    *     path="/api/platforms/{id}",
    *     description="Gets a platform by ID",
    *     tags={"Platforms"},
    *          @OA\Parameter(
        *          name="id",
        *          description="Platform id",
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
*)
     * @param  \App\Models\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function show(Platform $platform)
    {
        return new PlatformResource($platform);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlatformRequest $request, Platform $platform)
    {
        $platform->update($request->all());
    }

    /**
     *
     *
     * @OA\Delete(
     *    path="/api/platforms/{id}",
     *    operationId="destroyPlatform",
     *    tags={"Platforms"},
     *    summary="Delete a Platform",
     *    description="Delete Platform",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="id", in="path", description="Id of a Platform", required=true,
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
     * @param  \App\Models\Platform  $platform
     * @return \Illuminate\Http\Response
     */
    public function destroy(Platform $platform)
    {
        $platform->delete();
    }
}
