<?php

namespace App\Http\Controllers;

use App\Models\Raiting;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Rating::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'rating' => 'required|min:1|max:5',
            'ratingable_id' => 'required|integer',
            'ratingable_type' => 'required'
        ]);

        //todo Нужно вынести в функцию (дублируеться
       $ratingable_type =  $request->ratingable_type;

        if($ratingable_type=='author'){
            $ratingable_type = 'App\Models\Author';
        } elseif($ratingable_type=='book'){
            $ratingable_type = 'App\Models\Book';
        }

        $attributes = $request->all();
        $attributes['ratingable_type'] = $ratingable_type;

        return Rating::create($attributes);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Raiting  $raiting
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Rating::find($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Raiting  $raiting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'integer|min:1|max:5', // Расширить добавав 0 = удаление
            'ratingable_id' => 'integer',
            'ratingable_type' => 'string'
        ]);

        //todo Нужно вынести в функцию (дублируеться
        $ratingable_type =  $request->ratingable_type;

        if($ratingable_type=='author'){
            $ratingable_type = 'App\Models\Author';
        } elseif($ratingable_type=='book'){
            $ratingable_type = 'App\Models\Book';
        }

        $attributes = $request->all();
        $attributes['ratingable_type'] = $ratingable_type;

        $rating = Rating::findOrFail($id);
        $rating->update($attributes);
        return $rating;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Raiting  $raiting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Raiting $raiting)
    {
        // Сделать удаление оценки если проставили 0 в апдейте
    }
}
