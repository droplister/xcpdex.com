<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $locale
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $locale)
    {
        App::setLocale($locale);

        return redirect(url('/'));
    }
}