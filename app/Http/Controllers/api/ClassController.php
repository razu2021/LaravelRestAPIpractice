<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clas;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;


class ClassController extends Controller
{
    //
    public function index(){
        $all = Clas::all();
        return $all;
    }



// add single data 
    public function insert(Request $request){
        if($request->isMethod('post')){
            $data= $request->all();
            $roles =[
                'class_name' =>'required',
            ];
    
            $customeMassage = [
                'class_name.required' => 'Name is required!',
            ];
            $validator = Validator::make($data,$roles,$customeMassage);
            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }
    
            $insert=clas::insertGetId([
              'class_name'=>$request['class_name'],
              'created_at'=>Carbon::now()->toDateTimeString(),
            ]);
            return response('added successful !');
        
            // ********
        }
    // condition end here 
      }

// add multiple  data 
public function add_multiple_class(Request $request)
{
    if ($request->isMethod('post')) {
        $data = $request->all();

        // Define validation rules and custom error messages for each class_name
        $rules = [
            'classdata.*.class_name' => 'required',
        ];

        $customMessages = [
            'classdata.*.class_name.required' => 'Name is required!',
        ];

        // Validate the request data
        $validator = Validator::make($data, $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Initialize an array to collect IDs of inserted records
        $insertedIds = [];

        // Insert multiple data into the 'clas' table
        foreach ($data['classdata'] as $udata) {
            $insertedId = Clas::insertGetId([
                'class_name' => $udata['class_name'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            if ($insertedId) {
                $insertedIds[] = $insertedId;
            }
        }

        if (!empty($insertedIds)) {
            return response()->json(['message' => 'Added successfully!', 'inserted_ids' => $insertedIds]);
        } else {
            return response()->json(['message' => 'No records were inserted.'], 422);
        }
    }

    // Handle the case where the request method is not 'post'
}

// update data or edit data 
    public function update(Request $request){
        $id=$request['id'];
        $update=Clas::where('class_id',$id)->update([
            'class_name'=>$request['class_name'],
          ]);
        return response('update successful !');
      }

// user update data for put function 
public function updateuser(Request $request, $id)
{
    if ($request->isMethod('put')) {
        $data = $request->all();

        // Define validation rules for the update
        $rules = [
            'class_name' => 'required',
        ];

        $customMessages = [
            'class_name.required' => 'Name is required!',
        ];

        // Validate the request data
        $validator = Validator::make($data, $rules, $customMessages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find the record by ID and update it
        $updated = Clas::where('class_id', $id)->update([
            'class_name' => $data['class_name'],
            'updated_at' => Carbon::now(),
        ]);

        if ($updated) {
            return response()->json(['message' => 'Updated successfully!'],201);
        } else {
            return response()->json(['message' => 'Update failed.'], 422);
        }
    }

    // Handle the case where the request method is not 'put'
}

// single data delete 
public function delete($id = Null){
    $post =Clas::where('class_id',$id);
    $post->delete();
}

// multiple data delete 

public function multipledataDelete($ids){
    $post = explode(',',$ids);

    $data = Clas::whereIn('class_id',$post);

    $data->delete();

    $message = 'Multiple Delete Successful ! ';
    return response()->json(['message'=>$message],200);

}


// delete multiple data with jeson 
public function multipledataDelete_with_json(Request $request){
    if($request->isMethod(('delete'))){
        $data= $request->all();
        
        $alldata = Clas::whereIn('class_id',$data['ids']);
        $alldata->delete();

    }
    $message = 'Delete multiple data with json Successful ! ';
    return response()->json(['message'=>$message],200);

}



}
