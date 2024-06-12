<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class DestroyController extends Controller
{
    public function __invoke($id)
    {
        $task = Task::where('id', $id)->first();
        $task->delete();
        return response()->noContent();
    }
}
