<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use App\Http\Resources\TaskResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Notifications\TaskAlert;
use App\Mail\TaskAlertMail;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view-all-tasks');
        $tasks = Task::all();
        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $this->authorize('create-task');
        $task = Task::create($request->validated());

        $validated = $request->validated();
        $assigned_user = User::find($validated['assigned_user']);
        $assigned_user->givePermissionTo(['view-task','edit-task']);

        //--------------------------------------------------------------------
        $details = [
            'title' => 'New Task',
            'body' => 'You got a new task, Check it ',
            'link' => $task->id,
        ];

        $data = $task->id;
        $assigned_user->notify( new TaskAlert($data));
       
        Mail::to($assigned_user)->send(new TaskAlertMail($details));
       
        //---------------------------------------------------------------------

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view-task');
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('edit-task');
        $validated = $request->validated();
        if($task->assigned_user != $validated['assigned_user'])
        {
            $deleted = DB::table('model_has_permissions')
                        ->where('model_id', '=', $task->assigned_user)
                        ->where('model_type', '=', 'App\Models\User')
                        ->delete();
            $assigned_user = User::find($validated['assigned_user']);
            $assigned_user->givePermissionTo(['view-task','edit-task']);
        }
        
        $task->update($request->validated());
        return (new TaskResource($task->refresh()))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete-task');
        $task->delete();
        return response()->json([
            'message' => __('Task successfully deleted')
        ]);   
    }

}
