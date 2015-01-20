<?php namespace Confomo\Http\Controllers\API;

use App;
use Auth;

class ConferencesController extends \Confomo\Http\Controllers\BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Auth::user()->conferences;
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
     * @return Response
     */
    public function store()
    {
        /*
            $friend = new Friend($_POST);
            $friend->user_id = Auth::user()->id;
            $friend->save();

            // Annoyingly necessary in order to return *all* fields
            return Friend::find($friend->id);
            */
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        /*
            try {
                return Friend
                    ::where('user_id', Auth::user()->id)
                    ->where('id', $id)
                    ->firstOrFail();
            } catch (Exception $e) {
                App::abort(404);
            }
            */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        App::abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @todo  Clean up the unset() to be a little less hackable
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        /*
            $item = Input::all();
            unset($item['id']);
            unset($item['user_id']);

            try {
                $friend = Friend
                    ::where('user_id', Auth::user()->id)
                    ->where('id', $id)
                    ->firstOrFail();
            } catch (Exception $e) {
                App::abort(404);
            }

            $friend->fill($item);

            $friend->save();
            */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        /*
            Friend
                ::where('user_id', Auth::user()->id)
                ->where('id', $id)
                ->delete();
            */
    }

}
