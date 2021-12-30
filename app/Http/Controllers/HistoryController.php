<?php

namespace App\Http\Controllers;

use App\History;
use App\Product;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['dataset'] = History::orderBy('date','DESC')->paginate(10);
        return view('analisa.dataset.index', $data);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexChart(Request $request)
    {
        $data['product'] = Product::all();
        $day = $request->day;
        $month = $request->month;
        $year = $request->year;
        if($request->order_by == 'day' && $day != ''){
            $data['chart'] = History::whereDay('date', $day)->where('product_id', $request->product_id)
            ->join('products', 'histories.product_id', '=', 'products.id')
            ->select('products.name as product_name','histories.amount as amount','histories.date as date')
            ->groupBy('histories.date')
            ->get();

            $data['chart'] = json_encode($data);
            return view('analisa.chart.index', $data);
        }

        if($request->order_by == 'month' && $month != ''){

            $labels = [];

            $last_date = \Carbon\Carbon::parse(date('Y') . "-" . $month . "-" . "01")->endOfMonth()->format('d');
            
            for($i=1; $i <= (int) $last_date; $i++){
                $date = \Carbon\Carbon::parse(date('Y') . "-" . $month . "-" . $i)->format('Y-m-d');
                
                array_push($labels, \Carbon\Carbon::parse($date)->format('d'));

                $history = History::whereMonth('date', $month)->where('product_id', $request->product_id)
                ->join('products', 'histories.product_id', '=', 'products.id')
                ->select('products.name as product_name','histories.amount as amount','histories.date as date')
                ->whereDate('date', $date)
                ->groupBY('histories.date')
                ->first();

                if($history){
                    $data['chart'][] = [
                        'product_name' => $history->product_name,
                        'amount' => $history->amount,
                        'date' => $history->date
                    ];
                }
                else{
                    $data['chart'][] = [
                        'product_name' => '',
                        'amount' => 0,
                        'date' => $date
                    ];
                }

            }

            $labels = collect($labels);
            $labels = $labels->sort();


            return view('analisa.chart.index', [
                'labels' => $labels,
                'data' => json_encode($data['chart']),
                'product' => $data['product']
            ]);
        }

        if($request->order_by == 'year' && $year != ''){

            $labels = [];

            $last_month = 12;
            
            for($i=1; $i <= (int) $last_month; $i++){
                $date = \Carbon\Carbon::parse($year . "-" . $i . "-" . "01")->format('Y-m-d');
                
                array_push($labels, \Carbon\Carbon::parse($date)->format('M'));

                $history = History::whereYear('date', $year)->where('product_id', $request->product_id)
                ->join('products', 'histories.product_id', '=', 'products.id')
                ->select('products.name as product_name','histories.amount as amount','histories.date as date')
                ->whereMonth('date', $i)
                ->groupBY('histories.date')
                ->first();

                if($history){
                    $data['chart'][] = [
                        'product_name' => $history->product_name,
                        'amount' => $history->amount,
                        'date' => $history->date
                    ];
                }
                else{
                    $data['chart'][] = [
                        'product_name' => '',
                        'amount' => 0,
                        'date' => $date
                    ];
                }

            }

            $labels = collect($labels);


            return view('analisa.chart.index', [
                'labels' => $labels,
                'data' => json_encode($data['chart']),
                'product' => $data['product']
            ]);
        }


        return view('analisa.chart.index', [
            'product'=>$data['product'],
            'labels' => [],
            'data' => []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['product'] = Product::all();
        return view('analisa.dataset.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

        $dataArray = array (
            'product_id' => $request->product_id,
            'date' => $request->date,
            'amount' => $request->amount,
        );

        History::create($dataArray);

        return redirect('/dataset')->with('message','Data Berhasil Ditambah.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['analisa'] = History::where('product_id', $id)->with('product')->latest()->get();
        return view('analisa.detail', $data);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showlist($id)
    {
        $data['analisa'] = History::where('product_id', $id)->with('product')->latest()->get();
        return view('analisa.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $data['dataset'] = History::find($id);
        $data['product'] = Product::all();
        return view('analisa.dataset.edit', $data);
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
        $request->validate([
            'product_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

        $dataArray = array (
            'product_id' => $request->product_id,
            'date' => $request->date,
            'amount' => $request->amount,
        );

        History::whereId($id)->update($dataArray);

        return redirect('/dataset')->with('message','Data Berhasil Diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        History::whereId($id)->delete();
        return response()->json([
            'message' => 'Data Berhasil Dihapus'
        ], 200);
    }
}
