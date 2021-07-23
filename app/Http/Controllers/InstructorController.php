<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreInstructorRequest;
use App\Http\Requests\UpdateInstructorRequest;
use App\Models\Instructor;

class InstructorController extends Controller
{
    public function index(): array
    {
        return Instructor::with('appointments')->get()->toArray();
    }
    
    
    public function store(StoreInstructorRequest $request)
    {
        $validated = $request->validated();
        
        $instructor = Instructor::create(['name'         => $validated['name'],
                                          'age'          => $validated['age'],
                                          'working_days' => $validated['working_days'],
                                          'schedule'     => $validated['schedule']]);
        
        return $instructor->toArray();
    }
    
    
    public function update(UpdateInstructorRequest $request)
    {
        $validated = $request->validated();
        
        $id = Instructor::where('id', $validated['id'])
                        ->update(['name'         => $validated['name'],
                                  'age'          => $validated['age'],
                                  'working_days' => $validated['working_days'],
                                  'schedule'     => $validated['schedule']]);
        
        return Instructor::find($validated['id']);
    }
    
    
    public function destroy($id): int
    {
        return Instructor::destroy($id);
    }
}
