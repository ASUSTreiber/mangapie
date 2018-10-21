<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vote\VotePatchRequest;
use App\Http\Requests\Vote\VoteCreateRequest;
use App\Http\Requests\Vote\VoteDeleteRequest;

class VoteController extends Controller
{
    public function put(VoteCreateRequest $request)
    {
        $user = \Auth::user()->load('votes');

        $vote = $user->votes()->create([
            'manga_id' => $request->get('manga_id'),
            'rating' => $request->get('rating')
        ]);

        return ! empty($vote) ?
            redirect()->back()->with('success', 'Your vote was successfully created.') :
            redirect()->back()->withErrors(['There was an error creating your vote.']);
    }

    public function patch(VotePatchRequest $request)
    {
        $user = \Auth::user();

        $vote = $user->votes()->update([
            'id' => $request->get('vote_id'),
            'rating' => $request->get('rating')
        ]);

        return ! empty($vote) ?
            redirect()->back()->with('success', 'Your vote was successfully updated.') :
            redirect()->back()->withErrors(['There was an error updating your vote.']);
    }

    public function delete(VoteDeleteRequest $request)
    {
        $user = \Auth::user();

        $user->votes()->find($request->get('vote_id'))->forceDelete();

        return redirect()->back()->with('success', 'Your vote was successfully deleted.');
    }
}
