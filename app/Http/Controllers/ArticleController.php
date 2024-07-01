<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\TaskMangement;



class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $article = Article::with('task')->where('task_mangement_id', $id)->first();
        return view('articles.create', compact('id', 'article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();
        $input['task_mangement_id'] = $request->task_id;
        $input['created_by']        = auth()->user()->id;
        $input['updated_by']        = auth()->user()->id;
        $finalSubmit = 0;
        if(($request->finalsubmit == 'finalsubmit')){
            $this->validate($request, [
                'article'       => 'required',
                'meta_title'    => 'required',
                'meta_keyword'  => 'required',
                'meta_desc'     => 'required',
            ]);
           $input['final_submit']      = 1;
           $finalSubmit = 1;
        }
        
        $article = Article::where('task_mangement_id', $request->task_id)->first();
       
        if(!empty($article)){
            if($article->final_submit == 1){
                $finalSubmit = 1;
            }
            if($article->status == 3){
                return redirect()->back()->with('error', 'Already approved');
            }
            $article->title         = $request->title;
            $article->article       = $request->article;
            $article->meta_title    = $request->meta_title;
            $article->meta_keyword  = $request->meta_keyword;
            $article->meta_desc     = $request->meta_desc;
            $article->final_submit  = $finalSubmit;
            $article->previous_time  = 0;
            $article->save();
        }else{
            Article::create($input);
        }
        return redirect()->back()->with('success', 'article added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function articleView($id)
    {
        $model = Article::with('task')->where('task_mangement_id', $id)->first();
        return view('articles.view', compact('id', 'model'));
    }

    public function downloadArticle($id)
    {
        $model = Article::with('task')->where('task_mangement_id', $id)->first();
        $headers = array(
            "Content-type"=>"text/html",
            "Content-Disposition"=>"attachment;Filename=article".time().".doc"
        );
        
            $title = $model->task->title ?? '';
            $article = $model->article ?? '';
            $meta_title = $model->meta_title ?? '';
            $meta_keyword = $model->meta_keyword ?? '';
            $meta_desc = $model->meta_desc ?? '';
            $created_at = $model->created_at ?? '';
            $content = '<html>
            <head><meta charset="utf-8"></head>
            <body>
                <p><strong>Title:</strong>'.$title.'</p>
                <p><strong>Article:</strong>'.$article.'</p>
                <p><strong>Meta Title:</strong>'.$meta_title.'</p>
                <p><strong>Meta Keywords:</strong>'.$meta_keyword.'</p>
                <p><strong>Meta Description:</strong>'.$meta_desc.'</p>
                <p><strong>Created At:</strong>'.$created_at.'</p>
            </body>
            </html>';
        
        

        return \Response::make($content,200, $headers);
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addArticle(Request $request){
        $checkTask = TaskMangement::where('id', $request->taskId)->first(); 
        $time = 5000;      
        if($checkTask->article_time != ''){
             $time = $checkTask->article_time + 5000;
        }
        $checkTask->article_time = $time;
        $checkTask->save();
        $article            = Article::where('task_mangement_id', $checkTask->id)->first();

        $articleaTimeValue  = $article->article_time;
        $totalWordCount     = $request->wordcount - $article->last_word; 
        $articleData        =  $article->article_time.'__'.strtotime(date('Y-m-d H:i:s')).'_'.'Time:'. $request->starttime-$article->previous_time. '_Word:'.$totalWordCount;
        Article::where('task_mangement_id', $checkTask->id)->update(['last_word' =>$request->wordcount, 'article_time' => $articleData,'article' =>$request->text, 'previous_time' => $request->starttime]);
    }


    public function articleComment(Request $request){
        $checkTask = '';
        if(Auth()->user()->hasRole(['admin', 'Buyer'])){
            if(Auth()->user()->hasRole('Buyer')){
                $checkTask = Article::whereHas('task', function($q){
                    $q->where('created_user_id', auth()->user()->id);
                })->where('task_mangement_id', $request->taskId)->first();
            }else{
               $checkTask = Article::where('task_mangement_id', $request->taskId)->first();
            }
            if(!empty($checkTask)){
                if(isset($request->reject)){
                    $checkTask->comment = $request->reject;
                    $checkTask->save();
                    $checkTask->task()->update(['status' => 5]);
                    return redirect()->back()->with('success', 'reason added succesfuly');
                }
                if(isset($request->comment)){
                    $checkTask->comment = $request->comment;
                    $checkTask->task()->status = 4;
                    $checkTask->save();
                    $checkTask->task()->update(['status' => 4]);
                    return redirect()->back()->with('success', 'Comment added succesfuly');
                }
            }else{
                return redirect()->back()->with('error', 'Invalid task');
            }

        }else{
            return redirect()->back()->with('error', 'access denied'); 
        }
        
    }  
}
