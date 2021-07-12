<?php

namespace App\Http\Controllers;

use App\Member;
use App\Designation;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $designations = Designation::all();
        
        if($request->ajax())
        {
            // $data = Member::with('Designation')->get();
            $data = DB::table('members')
                    ->join('designations', 'designations.id', '=', 'members.designation_id')
                    ->select('members.*', 'designations.*')
                    ->get();
            
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Edit</button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })
                    
        //    ->editColumn('DesignationName', function ($row) {
        //             return getDesignation($row->designation_name);
        //         })
                    
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('members', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'member_name'    =>  'required',
            'designation_id'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'member_name'        =>  $request->member_name,
            'designation_id'         =>  $request->designation_id
        );

        Member::create($form_data);

        return response()->json(['success' => 'Member Added successfully.']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Member::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $rules = array(
            'member_name'        =>  'required',
            'designation_id'         =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'member_name'    =>  $request->member_name,
            'designation_id'     =>  $request->designation_id
        );

        Member::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Member is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Member::findOrFail($id);
        $data->delete();
    }
}
