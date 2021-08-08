<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       /* $author_id = $request->author_id;
        $orderBy = ($request->ob) ? $request->ob : 'title';
        $orderDir = ($request->od) ? $request->od : 'asc';

        if($orderBy == 'rating'){
            $book = DB::table('books')
                ->select('books.title','books.title',  DB::raw('ROUND(AVG(ratings.rating),1) As rating'))
                ->join('ratings', 'books.id', '=', 'ratings.ratingable_id')
                ->where('ratingable_type','=','App\\Models\\Book')
                ->groupBy(['title','description'])
                ->orderBy($orderBy, $orderDir)
                ->get();
        } else {

            if ($author_id) {
                $book = Book::where('author_id', $author_id)->orderBy($orderBy, $orderDir)->get()->all();
            } else {

                $book = Book::orderBy($orderBy, $orderDir)->get()->all();
            }
        }

        return $book;*/

        $author_id = $request->author_id;
        $orderBy = $request->ob ?? 'title';
        $orderDir = $request->od ?? 'asc';
        $perPage = $request->pp ?? 10;
        $query = Book::withRating();

        if ($author_id) {
            $query->where('author_id', $author_id);
        }

        if ($orderBy && $orderDir) {
            $query->orderBy($orderBy, $orderDir);
        }

        return $query->simplePaginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'author_id' => 'required|exists:authors,id',
            'title' => 'required',
            'description' => 'required'
        ]);

        return Book::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Book::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'author_id' => 'integer|exists:authors,id',
            'title' => 'string',
            'description' => 'string'
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Book $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        return Book::destroy($id);
    }
}
