<?php

namespace App\Http\Controllers;

use App\User;
use App\Board;
use App\Team;
use App\CardList;
use App\Card;
use App\BoardMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($board_id)
    {
        $board = Board::select('id', 'name', 'team_id', 'description')->findOrFail($board_id);
        $cardLists = CardList::select('id', 'name', 'position')->where('board_id', $board_id)->get();

        foreach($cardLists as &$item) {
            $item['cards'] = Card::where('card_list_id', $item->id)->get();
        }

        $member_ids = BoardMember::where('board_id', $board_id)->pluck('user_id')->toArray();
        $members = User::select('id as user_id', 'name')->whereIn('id', $member_ids)->get();

        $team  = null;
        if ($board->team_id) {
            $team = Team::select('name')->find($board->team_id);
        }

        return [
            'board' => $board,
            'cardLists' => $cardLists,
            'members' => $members,
            'team' => $team,
        ];
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $board = Board::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'team_id' => $request->teamId ? $request->teamId : null
        ]);

        BoardMember::create([
            'board_id' => $board->id,
            'user_id' => Auth::user()->id,
        ]);

        return $board;
    }

    public function saveMember(Request $request, $board_id)
    {
        $user = User::whereRaw('name LIKE \'%'.$request->usernameOrEmailAddress.'%\' OR email LIKE \'%'.$request->usernameOrEmailAddress.'%\'')->first();
        // $user = DB::select('SELECT * FROM users WHERE name LIKE \'%?%\' OR email LIKE \'%?%\'' , [$request->usernameOrEmailAddress]);

        if (!$user) abort(400, 'Record not found.');

        BoardMember::create([
            'user_id' => $user['id'],
            'board_id' => $board_id,
        ]);

        return $user;
    }
}
