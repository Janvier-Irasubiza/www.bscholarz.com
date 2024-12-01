<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advert;

class AdvertsController extends Controller
{
    public function openAdvert(Request $request)
    {
        if ($request->advert) {
            $advert = Advert::findOrFail($request->advert);
            $advert->clicks++;
            $advert->save();

            return redirect()->away(url($advert->link));
        }
        else {
            return back();
        }
    }
}
