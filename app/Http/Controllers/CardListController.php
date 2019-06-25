<?php

namespace App\Http\Controllers;

use App\User;
use App\Card;
use App\CardList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'board_id' => 'required',
            'position' => 'required',
        ]);

        return CardList::create([
            'name' => $request->name,
            'user_id' => Auth::user()->id,
            'board_id' => $request->board_id,
            'position' => $request->position,
        ]);
    }

    public function storePositions(Request $request)
    {
        $this->validate($request, [
            'board_id' => 'required',
            'cardListPositions' => 'required',
        ]);

        foreach ($request->cardListPositions as $key => $item) {
            $cardList = CardList::find($item['cardListId']);
            $cardList->position = $item['position'];
            $cardList->save();
        }

        return ['message' => 'ok'];
    }
}
