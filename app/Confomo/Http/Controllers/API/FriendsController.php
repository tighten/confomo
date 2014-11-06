<?php namespace Confomo\Http\Controllers\API;

use App;
use Auth;
use Confomo\Http\Controllers\BaseController;
use Exception;
use Confomo\Entities\Friend;
use Input;
use Queue;

class FriendsController extends BaseController
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $conference_id
     * @return Response
     */
    public function index($conference_id)
    {
        return Auth::user()->friends()->fromConference($conference_id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        App::abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $conference_id
     * @return Response
     */
    public function store($conference_id)
    {
        $friend = new Friend($_POST);
        $friend->user_id = Auth::user()->id;
        $friend->conference_id = $conference_id;
        $friend->save();

        Queue::push(
            'Confomo\Queue\API\TwitterProfilePic',
            array(
                'twitter_handle' => $friend->twitter,
                'friend_id' => $friend->id
            )
        );

        // Annoyingly necessary in order to return *all* fields
        return Friend::find($friend->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $conference_id
     * @param  int  $id
     * @return Response
     */
    public function show($conference_id, $id)
    {
        try {
            return Friend
                ::where('user_id', Auth::user()->id)
                ->fromConference($conference_id)
                ->where('id', $id)
                ->firstOrFail();
        } catch (Exception $e) {
            App::abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $conference_id
     * @param  int  $id
     * @return Response
     */
    public function edit($conference_id, $id)
    {
        App::abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @todo  Clean up the unset() to be a little less hackable
     * @param  int  $conference_id
     * @param  int  $id
     * @return Response
     */
    public function update($conference_id, $id)
    {
        $item = Input::all();
        unset($item['id']);
        unset($item['user_id']);

        try {
            $friend = Friend
                ::where('user_id', Auth::user()->id)
                ->fromConference($conference_id)
                ->where('id', $id)
                ->firstOrFail();
        } catch (Exception $e) {
            App::abort(404);
        }

        $friend->fill($item);

        $friend->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $conference_id
     * @param  int  $id
     * @return Response
     */
    public function destroy($conference_id, $id)
    {
        Friend
            ::where('user_id', Auth::user()->id)
            ->fromConference($conference_id)
            ->where('id', $id)
            ->delete();
    }

}
