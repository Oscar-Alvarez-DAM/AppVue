<?php

namespace App\Http\Controllers;

use App\Models\courses;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(courses::with('students')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course = courses::create($validated);
        return response()->json($course, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = courses::with('students')->find($id);
        
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        return response()->json($course, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = courses::find($id);
        
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course->update($validated);
        return response()->json($course, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = courses::find($id);
        
        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        // Verificar si el curso tiene estudiantes
        if ($course->students()->count() > 0) {
            return response()->json([
                'message' => 'No se puede eliminar un curso que tiene estudiantes asignados',
                'students_count' => $course->students()->count()
            ], 409);
        }

        $course->delete();
        return response()->json(['message' => 'Course deleted successfully'], 200);
    }
}
