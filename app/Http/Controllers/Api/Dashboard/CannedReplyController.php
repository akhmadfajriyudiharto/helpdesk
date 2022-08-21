<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CannedReply\StoreRequest;
use App\Http\Requests\Dashboard\CannedReply\UpdateRequest;
use App\Http\Resources\CannedReply\CannedReplyResource;
use App\Models\CannedReply;
use Auth;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CannedReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        $sort = json_decode($request->get('sort', json_encode(['order' => 'asc', 'column' => 'created_at'], JSON_THROW_ON_ERROR)), true, 512, JSON_THROW_ON_ERROR);
        $items = CannedReply::filter($request->all())
            ->where(function ($builder) {
                /** @var Builder|CannedReply $builder */
                $builder->where('shared', '=', true)
                    ->orWhere('user_id', '=', Auth::id());
            })
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));
        return response()->json([
            'items' => CannedReplyResource::collection($items->items()),
            'pagination' => [
                'currentPage' => $items->currentPage(),
                'perPage' => $items->perPage(),
                'total' => $items->total(),
                'totalPages' => $items->lastPage()
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $request->validated();
        $cannedReply = new CannedReply();
        $cannedReply->user_id = Auth::id();
        $cannedReply->name = $request->get('name');
        $cannedReply->body = $request->get('body');
        $cannedReply->shared = $request->get('shared');
        if ($cannedReply->save()) {
            return response()->json(['message' => __('Data saved correctly'), 'cannedReply' => new CannedReplyResource($cannedReply)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  CannedReply  $cannedReply
     * @return JsonResponse
     */
    public function show(CannedReply $cannedReply): JsonResponse
    {
        return response()->json(new CannedReplyResource($cannedReply));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  CannedReply  $cannedReply
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, CannedReply $cannedReply): JsonResponse
    {
        $request->validated();
        if ($cannedReply->user_id !== Auth::id()) {
            return response()->json(['message' => __('This action is unauthorized')], Response::HTTP_FORBIDDEN);
        }
        $cannedReply->name = $request->get('name');
        $cannedReply->body = $request->get('body');
        $cannedReply->shared = $request->get('shared');
        if ($cannedReply->save()) {
            return response()->json(['message' => __('Data updated correctly'), 'cannedReply' => new CannedReplyResource($cannedReply)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CannedReply  $cannedReply
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(CannedReply $cannedReply): JsonResponse
    {
        if ($cannedReply->delete()) {
            return response()->json(['message' => 'Data deleted successfully']);
        }
        return response()->json(['message' => __('An error occurred while deleting data')], 500);
    }
}
