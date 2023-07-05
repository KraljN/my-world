<?php

namespace App\Http\Controllers;

use App\Models\PostRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{
    //private constant are here to avoid magic numbers
    private const LIKED = 1;
    private const DISLIKED = -1;
    private const NEUTRAL = 0;

    /**
     * @param $object string Post or Comment object that is being rated
     * @param $id int Post or Comment ID
     * @param $action string  Post or Comment action (like / dislike)
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function rate($object, $id, $action){
        try{
            $table = $object == 'post' ? 'post_ratings' : 'comment_ratings';
            $alreadyRated = DB::table($table)->where([$object .'_id' => $id, 'user_id' => Auth::id()]);
            $index = $action == 'like' ? self::LIKED : self::DISLIKED;

            if(!$alreadyRated->first()){
                $createdId =  DB::table($table)->insertGetId([
                    $object .'_id' => $id,
                    'index' => $index,
                    'user_id' => Auth::id(),
                    'created_at' => now()
                 ]);
                //We need it as array because later on frontend we call it with .find function that requires array
                $createdObjAsArray = DB::table($table)->where('id', $createdId)->get();
                return handleResponse('Successfully rated post.', 201, 'success', $createdObjAsArray);
            }
            $previousRating = $alreadyRated->first()->index;

            //It was previously liked/disliked, we just set it to neutral. Otherwise, we will like or dislike post
            $newIndex = $previousRating == $index ? self::NEUTRAL : $index;
            $alreadyRated->update([
                'index' => $newIndex
            ]);
            return handleResponse('Successfully rated post.', 201, 'success', DB::table($table)->where([$object .'_id' => $id])->get());
        }
        catch (\Error | \Exception $ex){
            return handleResponse('There has been error while rating this post', 500, 'error', $ex);
        }

    }
}
