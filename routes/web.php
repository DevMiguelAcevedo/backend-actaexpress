<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/resend-test', function () {
    try {
        $resend = Resend::client('re_51zqsfz5_3ubKL16RrFoSTVN6nSuXwg4o');
        $resend->emails->send([
            'from' => 'onboarding@resend.dev',
            'to' => 'neurobytepages@gmail.com',
            'subject' => 'Hello World',
            'html' => '<p>Congrats on sending your <strong>first email</strong>!</p>'
        ]);
        return response()->json($resend);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
