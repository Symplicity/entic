<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DrugReviewVote;

class DrugReviewsController extends Controller
{
    public function vote($id, Request $request)
    {
        $user = $request['user']['sub'];
        $vote = $request->input('vote');

        // Grab the vote if it already exists.
        $drug_review_vote = DrugReviewVote::where('user_id', $user)->where('drug_review_id', $id)->first();

        if ($drug_review_vote && $drug_review_vote->count()) {
            if ($drug_review_vote->vote != $vote) {
                $drug_review_vote->vote = $vote;
                $drug_review_vote->save();
            } else {
                return response()->json(['message' => 'You\'ve already voted on this review!'], 400);
            }
        } else {
            $drug_review_vote = new DrugReviewVote();
            $drug_review_vote->user_id = $user;
            $drug_review_vote->drug_review_id = $id;
            $drug_review_vote->vote = $vote;
            $drug_review_vote->save();
        }

        return response()->json($drug_review_vote, 201);
    }
}
