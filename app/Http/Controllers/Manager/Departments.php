<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use URL;
use App\Models\Hospital;
use App\Models\Department;
use App\Http\Requests\DepartmentRequest;

class Departments extends Controller{
  public function index(Request $request){
    $departments = Department::whereHas('hospital', function($query){
      $query->whereHas('users', function($query){
        $query->where('user_id', Auth::user()->id);
      });
    });
    $links = '';
    $sort = $request->input('sort', '###');
    $search = $request->input('search', '###');

    if($sort != '###' && $search == '###'){
      $departments = $departments->orderBy($request->input('sort'), 'desc');
      $departments = $departments->paginate(10);
      $links = $departments->appends(['sort' => $request->input('sort')])->links();
    }else if($sort == '###' && $search != '###'){
      $departments = $departments->where('title', 'LIKE', "%$search%");
      $departments = $departments->paginate(10);
      $links = $departments->appends(['sort' => $request->input('sort')])->links();
    }else if($sort != '###' && $search != '###'){
      $departments = $departments->where('title', 'LIKE', "%$search%");
      $departments = $departments->orderBy($request->input('sort'), 'desc');
      $departments = $departments->paginate(10);
      $links = $departments->appends(['sort' => $request->input('sort')])->links();
    }else{
      $departments = $departments->paginate(10);
    }
    return view('manager.departments.index', [
      'departments'   => $departments,
      'links'       => $links,
      'sort'        => $sort,
      'search'      => $search,
    ]);
  }
  public function show(Department $department){
    return view('manager.departments.show', ['department' => $department]);
  }
  public function create(Request $request){
    $hospitals = Hospital::whereHas('users', function($query){
      return $query->where('user_id', Auth::user()->id);
    })->get();
    if($request->has('hospital'))
      return view('manager.departments.create',
        [
          'selected_hospital' => Hospital::where('id', $request->input('hospital'))->first(),
          'hospitals' => $hospitals,
        ]);
    return view('manager.departments.create',['hospitals' => $hospitals]);
  }
  public function store(DepartmentRequest $request){
    $department = Department::create($request->all());
    return redirect()->route('departments.show', ['department' => $department]);
  }
  public function edit(Department $department){
    return view('manager.departments.edit', ['department' => $department, 'hospitals' => Hospital::where('status', Hospital::S_ACTIVE)->get()]);
  }
  public function update(DepartmentRequest $request, Department $department){
    $inputs = $request->all();
    if($request->hasFile('image'))
      $inputs['image'] = Storage::put('public/departments', $request->file('image'));
    $department->fill($inputs)->save();
    return redirect()->route('departments.show', ['department' => $department]);
  }
  public function destroy(Department $department){
    $department->delete();
    if(URL::route('departments.show', ['department' => $department]) == URL::previous())
      return redirect()->route('departments.index');
    else
      return redirect()->back();
  }
}
