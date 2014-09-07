<?php  namespace Confomo\Http\Controllers; 

use Auth;
use Confomo\Entities\Conference;
use Exception;
use Input;
use Redirect;
use URL;
use View;

class ConferencesController extends BaseController
{
	public function index()
	{
		$conferences = Auth::user()->conferences;

		return View::make('conferences.index')
			->with('conferences', $conferences);
	}

	public function create()
	{
		return View::make('conferences.add');
	}

	public function store()
	{
		$conference = new Conference(Input::get());
		$conference->user_id = Auth::user()->id;
		$conference->save();

		return Redirect::route('conferences.index');
	}

	public function show($conference_id)
	{
		$conference = Conference::findOrFail($conference_id);
		$public_url = URL::to('/users/' . Auth::user()->username . '/conferences/' . $conference->id . '/');

		if ($conference->list_is_public && Auth::user()->username == '')
		{
			throw new Exception('User must have username to make conference public.');
		}

		return View::make('conferences.show')
			->with('conference', $conference)
			->with('public_url', $public_url);
	}

	public function edit($conference_id)
	{
		$conference = Conference::findOrFail($conference_id);

		return View::make('conferences.edit')
			->with('conference', $conference);
	}

	public function update($conference_id)
	{
		try
		{
			$conference = Conference::findOrFail($conference_id);
		}
		catch (Exception $e)
		{
			exit('Havent programmed this page yet.');
		}

		$conference->name = Input::get('name');
		$conference->list_is_public = Input::get('list_is_public');
		$conference->save();

		return Redirect::route('conferences.index');
	}
} 
