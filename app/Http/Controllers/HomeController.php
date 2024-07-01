<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TaskMangement;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $customers = User::get()->filter(function ($user) {
            return $user->hasRole('customer');
        })->count();

        $results = User::get()->filter(function ($user) {
            return $user->hasRole('Writer');
        })->paginate(10);

        $currentDate = Carbon::now();
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $startDate = $currentDate->copy()->subMonths($i)->startOfMonth();
            $endDate = $currentDate->copy()->subMonths($i)->endOfMonth();
            $months[] = $currentDate->copy()->subMonths($i)->format('F');
        }
        
        
        foreach ($results as $result) {
            $recordsByMonth = [];
        
            for ($i = 0; $i < 12; $i++) {
                $startDate = $currentDate->copy()->subMonths($i)->startOfMonth();
                $endDate = $currentDate->copy()->subMonths($i)->endOfMonth();
        
                $records = TaskMangement::with(['article:task_mangement_id'])
                    ->where('assign_user_id', $result->id)
                    ->select('assign_user_id', 'word_count', 'status', 'article_time', 'created_at', 'priority')
                    ->where('assign_user_id', '>', 0)
                    ->whereHas('article', function ($query) {
                        $query->where('final_submit', 1);
                    })
                    ->where('status', 3)
                    ->where('created_at', '>=', $startDate)
                    ->where('created_at', '<=', $endDate)
                    ->get();
        
                // Calculate total word count for this month
                $totalWordCount = $records->sum('word_count');
        
                // Group records by writer and month
                
                $recordsByMonth[$startDate->format('F Y')] = [
                    'total_word_count' => $totalWordCount,
                    'records' => $records->groupBy(function ($record) {
                        return $record->created_at->format('F Y');
                    }),
                ];
            }
        
            $result->recordsByMonth = $recordsByMonth;
        }
    
        //echo "<pre>";print_r($results);die;
        return view('home', compact('customers','results', 'months'));
    }

    
}
