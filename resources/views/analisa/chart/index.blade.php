@extends('layouts.app')

@section('title','Analisa')

@section('content')
<div class="row">
    <!-- /.col-md-6 -->
    <div class="col-lg-12">

        <div class="card card-primary card-outline">
            <div class="card-body">
                <form action="" method="get">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="">Cari Berdasarkan</label>
                            <select name="order_by" id="search_by" class="form-control orderby">
                                <option value="" selected disabled>Pilih Satu</option>
                                <option value="week">Week</option>
                                <option value="month">Month</option>
                                <option value="year">Year</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 parent-day" style="display: none">
                            <label for="">Masukkan Hari</label>
                            <select name="day" id="" class="form-control day">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 parent-month" style="display: none">
                            <label for="">Masukkan Bulan</label>
                            <select name="month" id="" class="form-control month">
                                <option value=""></option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 parent-year" style="display: none">
                            <label for="">Masukkan Tahun</label>
                            <select name="year" id="" class="form-control year">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 parent-week" style="display: none">
                            <label for="">Start Date</label>
                            <input type="date" name="start_date" id="" class="form-control">
                        </div>
                        <div class="form-group col-md-3 parent-week" style="display: none">
                            <label for="">End Date</label>
                            <input type="date" name="end_date" id="" class="form-control">
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Cari</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        @if (request()->order_by != '')
        <!-- LINE CHART -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Chart</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        @endif
    </div>
    <!-- /.col-md-6 -->
</div>
@endsection

@push('script')

<script>
    $(document).ready(function () {
        //console.log(datas)

        @if(request() -> order_by != '')

        let labels = {!!$labels!!};

        const statistics = JSON.parse('{!! $data !!}');

        console.log(statistics);
        var randomColorGenerator = function() {
         return '#' + (Math.random().toString(16) + '0000000').slice(2, 8);
        };


        let datasets = [];

        for(item in statistics){
            let x = statistics[item];
            datasets.push({
                label: item,
                data: x.map(i => i.amount),
                borderColor: randomColorGenerator(),
                backgroundColor: 'transparent',
                fill: false
            });
        }

        const data = {
            labels: labels,
            datasets: datasets
        };

        const config = {
            type: 'line',

            data: data,
            options: {
                plugins: {
                    legend: {
                        display: false,
                        labels: {
                            color: 'rgb(255, 99, 132)'
                        }
                    }
                }
            }
        };

        const lineChart = new Chart(
            $('#lineChart'),
            config
        );

        @endif



        $('.orderby').change(function (e) {
            e.preventDefault();

            var values = $('.orderby').find(":selected").val();
            console.log(values);

            if (values == 'week') {
                $('.parent-week').show();
                $('.parent-month').hide();
                $('.parent-year').hide();
            }
            if (values == 'month') {
                $('.parent-week').hide();
                $('.parent-month').show();
                $('.parent-year').hide();

            }
            if (values == 'year') {
                $('.parent-week').hide();
                $('.parent-month').hide();
                $('.parent-year').show();
            }
        });



        for (let day = 1; day <= 31; day++) {
            $('.day').append(`<option value="${day}">${day}</option>`)
        }

        let year = parseInt("{{ date('Y') }}");
        let yearFuture = year + 5;

        for (let i = year; i <= yearFuture; i++) {
            $('.year').append(`<option value="${i}">${i}</option>`)

        }
    });
</script>

@endpush