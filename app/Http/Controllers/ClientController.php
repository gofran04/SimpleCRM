<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Http\Resources\ClientResource;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view-all-clients');
        $clients = Client::all();
        return ClientResource::collection($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $this->authorize('create-client');
        $client = Client::create($request->validated());
        return (new ClientResource($client))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $this->authorize('view-client');
        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorize('edit-client');
        $updated_client = $client->update($request->validated());

        return (new ClientResource($client->refresh()))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $this->authorize('delete-client');
        $client->delete();
        return response()->json([
            'message' => __('Client successfully deleted')
        ]);
    }
}
