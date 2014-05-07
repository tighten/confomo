<?php

class FriendsController extends \BaseController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Auth::user()->friends;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$friend = new Friend($_POST);
		$friend->user_id = Auth::user()->id;
		$friend->save();
//		return $friend;
		// Annoyingly necessary to return *all* fields
		return Friend::find($friend->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return Friend
			::where('user_id', Auth::user()->id)
			->where('id', $id)
			->one();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$item = Input::all();
		unset($item['id']);
		unset($item['user_id']);

		$friend = Friend
			::where('user_id', Auth::user()->id)
			->where('id', $id)
			->first();
		$friend->fill($item);

		$friend->save();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return Friend
			::where('user_id', Auth::user()->id)
			->where('id', $id)
			->delete();
	}

}
