<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ApiController extends Controller
{
    public function getAllArticles(){

        $articles = Article::get()->toJson(JSON_PRETTY_PRINT);
        return response($articles, 200);
    }

    public function createArticle(Request $request) {

        $article = new Article;
        $article->title = $request->title;
        $article->content = $request->content;
        $article->save();

        return response()->json(["message" =>"article record created"],201);
    }


    public function getArticle($id){

        if(Article::where('id', $id)->exists())
        {
            $article = Article::where('id',$id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($article, 200);
        }else{
            return response()->json(["message" => "Article not found"], 404);
        }
    }


    public function updateArticle(Request $request, $id){

        if(Article::where('id',$id)->exists())
        {
            $article = Article::find($id);
            $article->title = is_null($request->title) ? $article->title : $request->title;
            $article->content = is_null($request->content) ? $article->content : $request->content;
            $article->save();

            return response()->json(["message" => "records updated successfully"], 200);
            } else {
            return response()->json(["message" => "Article not found"], 404);
        }
    }

    public function deleteArticle($id){

        if(Article::where('id',$id)->exists()){
            $article = Article::find($id);
            $article->delete();

            return response()->json(["message" => "records deleted"], 202);
        }else {
            return response()->json(["message" => "Student not found"], 404);
        }

    }
}
