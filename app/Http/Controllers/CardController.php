<?php

namespace App\Http\Controllers;

use App\User;
use App\Card;
use App\CardList;
use App\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($card_id)
    {
        return Card::findOrFail($card_id);
    }

    public function showActivities($card_id)
    {
        $activities = Activity::select('id', 'type', 'user_id', 'created_at', 'detail')
            ->where('card_id', $card_id)
            ->latest()
            ->get();

        return ['activities' => $activities];
    }

    public function showAttachments($card_id)
    {
        return ['attachments' => []];
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'board_id' => 'required',
            'cardListId' => 'required',
            'position' => 'required',
        ]);

        $card = Card::create([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'board_id' => $request->board_id,
            'card_list_id' => $request->cardListId,
            'position' => $request->position,
        ]);

        $activity = Activity::create([
            'user_id' => Auth::user()->id,
            'card_id' => $card->id,
            'board_id' => $card->board_id,
            'type' => 9, //add-card
            'detail' => json_encode(['cardTitle' => $request->title], JSON_UNESCAPED_UNICODE),
        ]);

        return $card;
    }

    public function storePositions(Request $request)
    {
        $this->validate($request, [
            'board_id' => 'required',
            'cardPositions' => 'required',
        ]);

        foreach ($request->cardPositions as $key => $item) {
            $card = Card::find($item['cardId']);
            $card->position = $item['position'];
            $card->save();
        }

        return ['message' => 'ok'];
    }

    public function updateTitle(Request $request, $card_id)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $card = Card::findOrFail($card_id);
        $old_title = $card->title;
        $card->title = $request->title;
        $card->save();

        $activity = Activity::create([
            'user_id' => Auth::user()->id,
            'card_id' => $card->id,
            'board_id' => $card->board_id,
            'type' => 10, //change-card-title
            'detail' => json_encode(["newTitle" => $request->title, "oldTitle" => $old_title], JSON_UNESCAPED_UNICODE),
        ]);

        return $activity;
    }

    public function updateDescription(Request $request, $card_id)
    {
        $this->validate($request, [
            'description' => 'required',
        ]);

        $card = Card::findOrFail($card_id);
        $old_description = $card->description;
        $card->description = $request->description;
        $card->save();

        $activity = Activity::create([
            'user_id' => Auth::user()->id,
            'card_id' => $card->id,
            'board_id' => $card->board_id,
            'type' => 11, //change-card-description
            'detail' => json_encode(["cardTitle" => $card->title, "newDescription" => $request->description, "oldDescription" => $old_description], JSON_UNESCAPED_UNICODE),
        ]);

        return $activity;
    }

    public function storeComment(Request $request, $card_id)
    {
        $this->validate($request, [
            'comment' => 'required',
        ]);

        $card = Card::findOrFail($card_id);

        $activity = Activity::create([
            'user_id' => Auth::user()->id,
            'card_id' => $card->id,
            'board_id' => $card->board_id,
            'type' => 18, //add-comment
            'detail' => json_encode(["comment" => $request->comment], JSON_UNESCAPED_UNICODE),
        ]);

        return $activity;
    }

    public function storeAttachment(Request $request, $card_id)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        $card = Card::findOrFail($card_id);

        $activity = Activity::create([
            'user_id' => Auth::user()->id,
            'card_id' => $card->id,
            'board_id' => $card->board_id,
            'type' => null, //add-attachment
            'detail' => json_encode(["comment" => $request->comment], JSON_UNESCAPED_UNICODE),
        ]);

        return $activity;
    }
}
