<?php

namespace App\Http\Controllers;

use App\History;
use App\Product;
use App\Market;
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
        $start_date = \Carbon\Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = \Carbon\Carbon::parse($request->end_date)->format('Y-m-d');
        $month = $request->month;
        $year = $request->year;





        if($request->order_by == 'week' && $start_date != '' && $end_date != ''){

            $labels = [];

            $last_date = \Carbon\Carbon::parse(date('Y') . "-" . date('m') . "-" . "01")->endOfDay()->format('d');
            
            for($i=1; $i <= (int) $last_date; $i++){
                $date = \Carbon\Carbon::parse(date('Y') . "-" . date('m') . "-" . $i)->format('Y-m-d');
                
                array_push($labels, \Carbon\Carbon::parse($date)->format('D'));

                foreach($data['product'] as $product){
                    $history = History::whereBetween('date', array($start_date, $end_date))
                            ->where('histories.product_id', $product->id)
                            ->join('products', 'histories.product_id', '=', 'products.id')
                            ->join('markets', 'markets.id', 'histories.market_id')
                            ->select(\DB::raw('CONCAT(products.name, " (", markets.name, ") ") as product_name'),'histories.amount as amount','histories.date as date', 'markets.name as market_name')
                            ->whereDate('histories.date', array($start_date, $end_date))
                            ->first();

                    if($history){
                        $data['chart'][] = [
                            'product_name' => $history->product_name,
                            'market_name' => $history->market_name,
                            'amount' => $history->amount,
                            'date' => $history->date
                        ];
                    }
                }

                // dd($labels);

            }

            $groupChart = collect($data['chart'])->groupBy('product_name');
            $tmpGroupChart = [];
            foreach($groupChart as $index => $item){
                $gChart = collect($groupChart[$index])->pluck('date');
                for($i=1; $i <= (int) $last_date; $i++){
                    $date = \Carbon\Carbon::parse(date('Y') . "-" . date('m') . "-" . $i)->format('Y-m-d');

                    if(!in_array($date, $gChart->toArray())){
                        $groupChart[$index][] = [
                            'product_name' => '',
                            'market_name' => '',
                            'amount' => 0,
                            'date' => $date
                        ];
                    }
                }

                $tmpChart = collect($groupChart[$index])->sortBy('date')->values();

                $tmpGroupChart[$index] = $tmpChart; 
            }

            $labels = collect($labels);
            $labels = $labels->sort();

            // return response()->json(collect($data['chart'])->groupBy('product_name'));

            // return response()->json($tmpGroupChart);


            return view('analisa.chart.index', [
                'labels' => $labels,
                'data' => json_encode($tmpGroupChart),
                'product' => $data['product']
            ]);
        }


        if($request->order_by == 'month' && $month != ''){

            $labels = [];

            $last_date = \Carbon\Carbon::parse(date('Y') . "-" . $month . "-" . "01")->endOfMonth()->format('d');
            
            for($i=1; $i <= (int) $last_date; $i++){
                $date = \Carbon\Carbon::parse(date('Y') . "-" . $month . "-" . $i)->format('Y-m-d');
                
                array_push($labels, \Carbon\Carbon::parse($date)->format('d'));

                foreach($data['product'] as $product){
                    $history = History::whereMonth('date', $month)
                            ->where('histories.product_id', $product->id)
                            ->join('products', 'histories.product_id', '=', 'products.id')
                            ->join('markets', 'markets.id', 'histories.market_id')
                            ->select(\DB::raw('CONCAT(products.name, " (", markets.name, ") ") as product_name'),'histories.amount as amount','histories.date as date', 'markets.name as market_name')
                            ->whereDate('histories.date', $date)
                            ->first();

                    if($history){
                        $data['chart'][] = [
                            'product_name' => $history->product_name,
                            'market_name' => $history->market_name,
                            'amount' => $history->amount,
                            'date' => $history->date
                        ];
                    }
                }

            }

            $groupChart = collect($data['chart'])->groupBy('product_name');
            $tmpGroupChart = [];
            foreach($groupChart as $index => $item){
                $gChart = collect($groupChart[$index])->pluck('date');
                for($i=1; $i <= (int) $last_date; $i++){
                    $date = \Carbon\Carbon::parse(date('Y') . "-" . $month . "-" . $i)->format('Y-m-d');

                    if(!in_array($date, $gChart->toArray())){
                        $groupChart[$index][] = [
                            'product_name' => '',
                            'market_name' => '',
                            'amount' => 0,
                            'date' => $date
                        ];
                    }
                }

                $tmpChart = collect($groupChart[$index])->sortBy('date')->values();

                $tmpGroupChart[$index] = $tmpChart; 
            }

            $labels = collect($labels);
            $labels = $labels->sort();

            //return response()->json(collect($data['chart'])->groupBy('product_name'));

            // return response()->json($tmpGroupChart);


            return view('analisa.chart.index', [
                'labels' => $labels,
                'data' => json_encode($tmpGroupChart),
                'product' => $data['product']
            ]);
        }

        if($request->order_by == 'year' && $year != ''){

            $labels = [];

            $last_date = \Carbon\Carbon::parse($year . "-" . date('m') . "-" . "01")->endOfDay()->format('m');
            for($i=1; $i <= (int) $last_date; $i++){
                $date = \Carbon\Carbon::parse($year . "-" . $i . "-" . '01')->format('Y-m-d');
                
                array_push($labels, \Carbon\Carbon::parse($date)->format('M'));

            
                foreach($data['product'] as $product){
                    $history = History::whereYear('date', $year)
                            ->where('histories.product_id', $product->id)
                            ->join('products', 'histories.product_id', '=', 'products.id')
                            ->join('markets', 'markets.id', 'histories.market_id')
                            ->select(\DB::raw('CONCAT(products.name, " (", markets.name, ") ") as product_name'),'histories.amount as amount','histories.date as date', 'markets.name as market_name')
                            ->whereDate('histories.date', $date)
                            ->groupBy('products.name')
                            ->first();

                    if($history){
                        $data['chart'][] = [
                            'product_name' => $history->product_name,
                            'market_name' => $history->market_name,
                            'amount' => $history->amount,
                            'date' => $history->date
                        ];
                    }
                }

            } 

        
            

            $groupChart = collect($data['chart'])->groupBy('product_name');
            $tmpGroupChart = [];
            foreach($groupChart as $index => $item){
                $gChart = collect($groupChart[$index])->pluck('date');
                for($i=1; $i <= (int) $last_date; $i++){
                    $date = \Carbon\Carbon::parse($year . "-" . $i . "-" . '01')->format('Y-m-d');

                    if(!in_array($date, $gChart->toArray())){
                        $groupChart[$index][] = [
                            'product_name' => '',
                            'market_name' => '',
                            'amount' => 0,
                            'date' => $date
                        ];
                    }
                }

                $tmpChart = collect($groupChart[$index])->sortBy('date')->values();

                $tmpGroupChart[$index] = $tmpChart; 
            }

            $labels = collect($labels);
            $labels = $labels->sort();



            return view('analisa.chart.index', [
                'labels' => $labels,
                'data' => json_encode($tmpGroupChart),
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
        $data['market'] = Market::all();
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
            'market_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

        $dataArray = array (
            'product_id' => $request->product_id,
            'date' => $request->date,
            'amount' => $request->amount,
            'market_id' => $request->market_id,
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
            'market_id' => 'required',
        ]);

        $dataArray = array (
            'product_id' => $request->product_id,
            'date' => $request->date,
            'amount' => $request->amount,
            'market_id' => $request->market_id,
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
