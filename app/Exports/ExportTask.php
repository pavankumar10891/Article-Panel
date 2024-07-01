<?php

namespace App\Exports;

use App\Models\TaskMangement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;


class ExportTask implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $data;
    protected $filter;

    function __construct($data, $filter) {
        $this->data = $data;
        $this->filter = $filter;
    }

    public function collection()
    {
        $heafingArray[] = [
            'CREATED BY',
            'ASSI. WRITER',
            'TITLE',
            'WORDCOUNT',
            'WRITWORD',
            'PPW',
            'INR',
            'STATUS',
            'CREATED AT'
        ];
        
        $players = $this->data->map(function($item){
            $createTedBy    = $item->user->name ?? '';
            $assignWriter   = $item->writer->name ?? '';;
            $title          = $item->article->article ?? '';
            $title          = $this->htmlToPlainText($title);
            $wordcount      = '';
            $writenword     = '';
            $ppw            = '';
            $inr            = '';
            $status         = '';
            $createdAt      = $item->created_at;
            $writtenword    = isset($item->article->article)? str_word_count($this->htmlToPlainText($item->article->article)) : 0; 
            $ppw            =  isset($item->writer->ppw) ? $item->writer->ppw: 0;
            $inr            =  isset($item->writer->ppw)  ? $item->writer->ppw * $writtenword :0;

            if($item->status == 0){
                $status = 'Pending';
            }elseif($item->status == 1){
                $status = 'Accept';
            }elseif($item->status == 2){
                $status = 'Cancel';
            }elseif($item->status == 3){
                $status = 'Approve';
            }elseif($item->status == 4){
                $status = 'Need corretion';
            }elseif($item->status == 5){
                $status = 'Reject';
            }

           return [
                $createTedBy,
                $assignWriter,
                strip_tags(html_entity_decode($title)),
                $wordcount,
                $writenword,
                $ppw,
                $inr,
                $status,
                $createdAt,
           ];
        })->toArray();
        $result = array_merge($heafingArray,$players);
        return collect($result);
    }

    function htmlToPlainText($str){
        $str = str_replace('&nbsp;', ' ', $str);
        $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
        $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
        $str = html_entity_decode($str);
        $str = htmlspecialchars_decode($str);
        $str = strip_tags($str);
    
        return $str;
    }
}
