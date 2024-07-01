<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskMangement;
use App\Models\User;
use App\Models\Article;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportTask;
use App\Imports\ImportTask;
use DB;


class TaskMangementContoller extends Controller
{
    
    function __construct(){
        $this->writer = User::select(DB::raw("CONCAT(name, '(', email) AS full_name"),'id')->get()->filter(function ($user) {
            return $user->hasRole('Writer');
        })->pluck('full_name','id')->toArray(); 
        $this->buyer = User::select(DB::raw("CONCAT(name, '(', email) AS full_name"),'id')->get()->filter(function ($user) {
            return $user->hasRole(['admin', 'Buyer']);
        })->pluck('full_name','id')->toArray(); 
    }
    
    public function index(Request $request)
    { 
        
        $tasks = TaskMangement::with(['user', 'writer', 'article:task_mangement_id,article']);
        if(isset($request->created_by)){
            $tasks->where('created_user_id', $request->created_by);
        }
        if(isset($request->writer)){
            $tasks->where('assign_user_id', $request->writer);
        }
        if(isset($request->title)){
            $tasks->where('title', $request->title);
        }
        if(isset($request->status)){
            $tasks->where('status', $request->status);
        }
        if(isset($request->priority)){
            $tasks->where('priority', $request->priority);
        }
        if(Auth()->user()->hasRole('admin')){
         $results = $tasks;
        }elseif(Auth()->user()->hasRole('Buyer')){
          $results = $tasks->where('created_user_id', auth()->user()->id)->with('writer');
        }else{
            return redirect()->back()->with('error', 'You are not authorized');
        }
        
        $results = $tasks->orderBy('id','desc')->paginate(10);

        $title = 'All Task';
        $writerList = $this->writer;
        $buyerList = $this->buyer;
        return view('tasks.index', compact('results','title', 'writerList','buyerList'));
    }
    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'keyword' => 'required',
            'priority' => 'required',
            'word_count' => 'required|numeric',
        ]);
        $input = $request->all();
       
        $input['created_user_id'] = auth()->user()->id;
        TaskMangement::create($input);
        return redirect()->route('writers.index')
        ->with('success', 'Task created successfully.');
    }

    public function show($id)
    {
        $model = TaskMangement::with(['user', 'article'])->find($id);
        return view('tasks.show', compact('model'));
    }

    public function edit($id)
    {   $model = TaskMangement::find($id);
        if(Auth()->user()->hasRole('Buyer')){
            $model = $model->where('created_user_id', auth()->user()->id)->where('id', $id)->first();
        }
        if(!empty($model)){
            return view('tasks.edit', compact('model'));
        }else{
            return redirect()->back()->with('error ', 'Invalid url hittng');
        }
    }

    public function update($id, Request $request)
    {
        $model = TaskMangement::find($id);

        $this->validate($request, [
            'title' => 'required',
            'keyword' => 'required',
            'priority' => 'required',
            'word_count' => 'required|numeric',
        ]);

        $model->title = $request->title;
        $model->keyword = $request->keyword;
        $model->word_count = $request->word_count;
        $model->guideline = $request->guideline;
        $model->content = $request->content;
        $model->priority = $request->priority;
        $model->save();

        return redirect()->route('tasks.index')
        ->with('success', 'Task created successfully.');
    }

    public function destroy($id)
    {
        if(Auth()->user()->hasRole('Buyer') ||  Auth()->user()->hasRole('admin')){
            $model = TaskMangement::where('created_user_id', auth()->user()->id)->find($id);
            if(!empty($model) && ($model->assign_user_id > 0)){
                return redirect()->back()->with('error', 'Task assign already, can\'t not deleted'); 
            }else{
                TaskMangement::where('created_user_id', auth()->user()->id)->where('id',$id)->delete();
                return redirect()->route('tasks.index')->with('success', 'Task delted successfully.');
            }
        }else{
            return redirect()->back()->with('error', 'You are not aothorized');
        }
    }

    public function assignTask(Request $request){
        $results = [];
        $task = TaskMangement::with(['user', 'writer', 'article:task_mangement_id,article'])->where('status',1);
        if(Auth()->user()->hasRole('admin')){
            $results = $task->where('assign_user_id', '>', 0);
        }
        if(Auth()->user()->hasRole('Buyer')){
            $results = $task->where('created_user_id', auth()->user()->id)->where('assign_user_id', '>', 0);
        }
        if(Auth()->user()->hasRole('Writer')){
            $results = $task->where('assign_user_id', auth()->user()->id)->orderBy('id', 'desc');
        }
        $results = $results->orderBy('id', 'desc')->paginate();
        $title = 'Assign Task';
        $writerList = $this->writer;
        return view('tasks.assign_task', compact('results','title', 'writerList'));
    }

    public function rejectedTask(Request $request){
        $results = [];
        $task = TaskMangement::with(['user', 'writer', 'article:task_mangement_id,article'])->where('status',5);
        if(Auth()->user()->hasRole('admin')){
            $results = $task->where('assign_user_id', '>', 0);
        }
        if(Auth()->user()->hasRole('Buyer')){
            $results = $task->where('created_user_id', auth()->user()->id)->where('assign_user_id', '>', 0);
        }
        if(Auth()->user()->hasRole('Writer')){
            $results = $task->where('assign_user_id', auth()->user()->id)->orderBy('id', 'desc');
        }
        $results = $results->orderBy('id', 'desc')->paginate();
        $title = 'Rejected Task';
        return view('tasks.assign_task', compact('results','title'));
    }

    

    public function assignTaskStore(Request $request)
    {
        if(!auth()->user()->hasRole(['admin', 'Buyer'])){
            return redirect()->back()->with('error', 'Somthing went to wrong'); 
        }
        if(Auth()->user()->hasRole('Buyer')){
            $results = TaskMangement::with('user')->where('created_user_id', auth()->user()->id)->where('assign_user_id', '>', 0)->paginate();
        }
        if(isset($request->task) && count(array_filter($request->task)) > 0){
            TaskMangement::whereIn('id', $request->task)->update(['assign_user_id' => $request->user]);
            return redirect()->back()->with('success', 'Task assign successfully.');
        }else{
            return redirect()->back()->with('error', 'Please select atleast one task'); 
        }
    }

    public function unAssignTask(Request $request){
         $tasks = TaskMangement::where('assign_user_id', 0);
        if(Auth()->user()->hasRole('admin')){
         $results = $tasks->with(['user', 'writer']);
        }elseif(Auth()->user()->hasRole('Buyer')){
          $results = $tasks->where('created_user_id', auth()->user()->id)->with('writer');
        }else{
            return redirect()->back()->with('error', 'You are not authorized');
        }
        $results = $tasks->orderBy('id','desc')->paginate(10);
        $title = 'Unassign Task';
        return view('tasks.unassign_task', compact('results','title'));
    }

    public function reviewTask(Request $request){
        $results = TaskMangement::with(['user', 'writer', 'article:task_mangement_id,article'])->where('assign_user_id', '>', 0)
        ->whereHas('article', function ($query){
            $query->where('final_submit', 1);
        })->whereIn('status',[1,4]);
        if(Auth()->user()->hasRole('Buyer')){
            $results = $results->where('created_user_id', auth()->user()->id);
        }
        if(Auth()->user()->hasRole('Writer')){
            $results = $results->where('assign_user_id', auth()->user()->id);
        }
        $results = $results->orderBy('id', 'desc')->paginate();
        $title = 'Review Task';
        return view('tasks.review_task', compact('results','title'));
    }

    public function completeTask(Request $request){
        $tasks      = TaskMangement::with(['user', 'writer', 'article:task_mangement_id,article'])->where('assign_user_id', '>', 0);     
        if(isset($request->created_by)){
            $tasks->where('created_user_id', $request->created_by);
        }
        if(isset($request->writer)){
            $tasks->where('assign_user_id', $request->writer);
        }
        if(isset($request->title)){
            $tasks->where('title', $request->title);
        }
        if(isset($request->status)){
            $tasks->where('status', $request->status);
        }
        if(isset($request->priority)){
            $tasks->where('priority', $request->priority);
        }

        $results = $tasks->whereHas('article', function ($query){
            $query->where('final_submit', 1);
        })->where('status',3);

        if(Auth()->user()->hasRole('Buyer')){
            $results = $results->where('created_user_id', auth()->user()->id);
        }

        if(Auth()->user()->hasRole('Writer')){
            $results = $results->where('assign_user_id', auth()->user()->id);
        }
        
        if(Auth()->user()->hasRole('admin')){
           $results = $results;
        }

        if(isset($request->export) && ($request->export == 'export') ){
            $excelName = 'Task-'.time().'.csv';
             $data = $results->get();
             return Excel::download(new ExportTask($data,$request->all()), $excelName);
         }
        $results = $results->orderBy('id', 'desc')->paginate();
        $title = 'Complete Task';
        $writerList = $this->writer;
        $buyerList = $this->buyer;
        return view('tasks.completed_task', compact('results', 'title', 'writerList', 'buyerList'));
    }
    public function pendingTask(Request $request){

        $results = [];
        $task = TaskMangement::with(['user', 'writer', 'article:task_mangement_id,article'])->where('status',0);
        if(Auth()->user()->hasRole('admin')){
            $results = $task->where('assign_user_id', '>', 0);
        }
        if(Auth()->user()->hasRole('Buyer')){
            $results = $task->where('created_user_id', auth()->user()->id)->where('assign_user_id', '>', 0);
        }
        if(Auth()->user()->hasRole('Writer')){
            $results = $task->where('assign_user_id', auth()->user()->id)->orderBy('id', 'desc');
        }
        $results = $results->orderBy('id', 'desc')->paginate();
        $title = 'Pending Task';
        return view('tasks.pending_task', compact('results','title'));
    }
    

    public function report(Request $request){
        $results = TaskMangement::with(['user', 'writer', 'article'])->where('assign_user_id', '>', 0)->orderBy('id', 'desc')->paginate();
        $title = 'Report';
        return view('tasks.index', compact('results','title'));
    }
    public function changeStatus($id, $status){
        if(Auth()->user()->hasRole(['Writer','admin', 'Buyer'])){
            if(Auth()->user()->hasRole('Writer')){
                $checkTask = TaskMangement::where('status',0)->where('id', $id)->where('assign_user_id', auth()->user()->id)->first();
            }elseif(Auth()->user()->hasRole('Buyer')){
                $checkTask = TaskMangement::where('id', $id)->where('created_user_id', auth()->user()->id)->first();
            }else{
                $checkTask = TaskMangement::where('id', $id)->first();
            }
            if(!empty($checkTask)){
                if($status == 1){
                    TaskMangement::where('id', $id)->update(['status' => 1]);
                    $checkArticle = Article::where('task_mangement_id', $id)->count();
                    if($checkArticle == 0){
                        $articleArray = ['task_mangement_id' => $id, 'article' => $checkTask->content, 'created_by' => Auth()->user()->id, 'updated_by' => 0];
                        Article::create($articleArray);
                    }
                    return redirect()->back()->with('success', 'Task successfully accepted.');
                }elseif($status == 2){
                    TaskMangement::where('id', $id)->update(['status' => 2, 'assign_user_id' => 0]);
                    return redirect()->back()->with('success', 'Task successfully cancel.');
                }elseif($status == 3){
                    TaskMangement::where('id', $id)->update(['status' => 3]);
                    return redirect()->back()->with('success', 'Task successfully approved');
                }else{
                    return redirect()->back()->with('error', 'Something went to wrong');
                }
            }else{
                return redirect()->back()->with('error', 'You are not authorized'); 
            }
        }else{
            return redirect()->back()->with('error', 'You are not authorized'); 
        }
    }


    
    // public function startWriting($id,Request $request){
        
    //     if(Auth()->user()->hasRole('Writer')){
    //         $checkTask = TaskMangement::where('id', $request->taskId)->first();
    //     }elseif(Auth()->user()->hasRole('Writer')){
    //         $checkTask = TaskMangement::where('assign_user_id', auth()->user()->id)->where('id', $request->taskId)->first();
    //     }else{
    //       return  redirect()->back()->with('error', 'You are not authorized');
    //     }
        
    // }
    public function taskImport(Request $request){
        $request->validate([
            'file' => 'required',
        ]);
        $import = new ImportTask();
        $import->import($request->file('file'));
        $errors = [];
        //$import = Excel::import(new ImportTask, $request->file('file')->store('files'));
        $data = [];
        foreach ($import->failures() as $failure) {
            if($failure->attribute() == 0){
                $data[] = 'Row '.$failure->row().' Title  field is required';
            }
            if($failure->attribute() == 1){
                $data[] = 'Row '.$failure->row().' keyword  field is required';
            }
            if($failure->attribute() == 2){
                $data[] = 'Row '.$failure->row().' word count  field is required';
            }
            if($failure->attribute() == 3){
                $data[] = 'Row '.$failure->row().' guideline  field is required';
            }
            if($failure->attribute() == 4){
                $data[] = 'Row '.$failure->row().' content field is required';
            }
        }
        if(count($data) > 0){
            return  redirect()->back()->with('errors', $data);
        }
        return  redirect()->back()->with('success', 'Successfully uploaded');
    }


    public function deleteAll(Request $request){
        if(Auth()->user()->hasRole('Buyer') ||  Auth()->user()->hasRole('admin')){
            $taskIds = explode(',',$request->ids);
            if(Auth()->user()->hasRole('Buyer')){
                TaskMangement::where('created_user_id', auth()->user()->id)->whereIn('id', $taskIds)->delete();
                return response()->json(['success' => true, 'url' => url()->previous(), 'message' => 'Successfully deleted']);
            }elseif(Auth()->user()->hasRole('admin')){
                TaskMangement::whereIn('id',$taskIds)->delete();
                return response()->json(['success'=>true, 'url' => route('tasks.index')]);
                //return redirect()->route('tasks.index')->with('success', 'Task delted successfully.');
            }else{
                return response()->json(['success'=>false, 'url' => route('tasks.index')]);
                //return redirect()->back()->with('error', 'You are not aothorized');
            }
        }else{
            return response()->json(['success' => false, 'url' => route('tasks.index'), 'message' => 'you ate not authorized']);
        }
    }
    
    
}
