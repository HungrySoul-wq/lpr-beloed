   <?php

   use Illuminate\Support\Facades\Route;

   Route::get('/ping', fn () => response()->json([
       'message' => 'pong',
       'time' => now()->toIso8601String(),
       'student' => config('lab.slug'),
   ]));