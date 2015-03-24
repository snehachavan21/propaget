<?php namespace App\Http\Controllers\Distribution;

use App\Device;
use App\DistList;
use App\DistListMembers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DistListController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        /*$userId = 2;
        $allDistList =DistList::where('createdBy','=',$userId)->get();
        return $allDistList;*/
        $disMember = new DistList();
        $response = $disMember->loadFullDistribution();
        return $response;
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
     * @param Request $request
     * @return Response
     */
	public function store(Request $request)
	{
        // get all post data
        $postData = $request->input();
        $members = json_decode('["+919820098200", "+919820098237", "+919833356536", "+919820215537"]');
        // handle the saving of the distribution list and all it's members
        $distList = new DistList;
        $distList->saveEntireDistributionList(array(
            'name' => $postData['name'],
            'createdBy' => $postData['createdBy']
        ), $members);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        //$userId = 2;
        //$response = DistList::where('createdBy','=',$userId)->where('id','=',$id)->get();
        //$response = DistListMembers::where('distListId','=',$id)->get();
        $disMember = new DistListMembers();
        $response = $disMember->loadDisMemberList($id);
        return $response;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $userId = 2;
        $response = DistList::where('createdBy','=',$userId)->where('id','=',$id)->get();
        return $response;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        //Log::error('i m in delete dis'.$id);
        //DistList::destroy($id);
        //echo  "Delete Distribution";
	}

    public function getAllRequirement($id = null    )
    {
        Log::info('I was here');
        return array(1,2,3);
    }

}
