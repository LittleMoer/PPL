@extends('main_departement')
@section('main1')


<style>
    .container_stat{
        margin-top: 20px;
        text-align: center;
    }
    .container_btn{
        margin-top: 30px;
        text-align: center;
    }
    .cont_list{
        background-color: rgb(104, 104, 226);
        border-radius: 10px;
        width: 120px;
        padding: 10px;
        display: inline-block;
    }
    .cont_list a{
        /* display: inline-block; */
        text-decoration: none;
        color: rgb(0, 0, 0);
    }
    #chart{
        display: block;
        margin-top: 20px;
    }
    #btn_stat{
        display: inline-block;
        background-color: rgb(198, 197, 197);
        border-radius: 10px;
        /* border: none; */
        padding: 5px 15px 5px 15px;
    }
    #btn_stat:hover{
        background-color: rgb(154, 154, 154);
        /* color: white; */
        
        transition: .3s;
    }
    .cont_list:hover{
        background-color: rgb(73, 73, 237);
        color: white;
        transition: .3s;
    }
    .container_angkatan{
      text-align: center;
        margin-top: 70px;

    }
    #angkatan{
        border-radius: 20px;
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: center;
        width: 500px;
    }
    #btn_back_stat{
      display: inline-block;
      background-color: rgb(112, 112, 112);
      text-decoration: none;
      color: white;
      border-radius: 20px;
      margin-top: 20px;
      width: 200px;
      padding-top: 10px;
      padding-bottom: 10px;
    }
    #btn_back_stat:hover{
      box-shadow: 3px 3px rgb(90, 90, 90);
    }
    .main1 {
    background-color: rgb(239, 239, 239);
    padding: 20px 50px 20px 50px;
    /* position: fixed; */
    border-radius: 20px;
    box-shadow: 0px 2px 6px 0px black;
    -o-box-shadow: 0px 2px 6px 0px black;
    -ms-box-shadow: 0px 2px 6px 0px black;
    -moz-box-shadow: 0px 2px 6px 0px black;
    -webkit-box-shadow: 0px 2px 6px 0px black;
    overflow: auto;
    margin-top: 2%;
    margin-bottom: 50px;
    margin-left: 22%;
    width: 1050px;
}
</style>

@section('main')
    <div class="judul_page" style="margin-top: 20px;">
      <h3>Statistik Mahasiswa</h3>
    </div>
    <div class="container_angkatan">
    <form action="/detail/angkatan" method="GET">
        <input type="number" name="angkatan" class="angkatan" id="angkatan"  placeholder="Input Angkatan" required>
    </form>
    <a href="/statistik/mhs" id="btn_back_stat">Reset Default</a>
    </div>
    <script>
    var currentYear = new Date().getFullYear();
    var input = document.getElementById('angkatan')
    input.setAttribute('min', currentYear - 7);
    input.setAttribute('max', currentYear + 7);
    </script>
@endsection

@php
    $decodedJml = json_decode($jml,true);
@endphp

{{-- <div class="container_btn">
    <button onclick="showstat()" id="btn_stat" >Show Statistic</button>
</div> --}}
<script>
    let a = 0;
    function showstat(){
        if(a == 0){
            var chart = document.getElementById('chart');
            chart.style.display = 'block';
            chart.style.transition = '.3s ease';
            a = 1;
        }else{
            if(a==1){
                var chart = document.getElementById('chart');
                chart.style.display = 'none';
                chart.style.transition = '.3s ease';
                a = 0;
            }
        }
    }
</script>
<div id="chart">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js" integrity="sha512-7U4rRB8aGAHGVad3u2jiC7GA5/1YhQcQjxKeaVms/bT66i3LVBMRcBI9KwABNWnxOSwulkuSXxZLGuyfvo7V1A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>  
    <div>
        <canvas id="myChart"></canvas>
    </div>
  
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <script>
    var chart = JSON.parse('<?php echo $jml ?>');
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: chart.label,
        datasets: [{
          label: 'STATISTIK',
          data: chart.jml,
          backgroundColor:[
            'green',
            'grey',
            'brown',
            'red',
            'purple',
            'blue',
            'yellow',
          ],
          borderColor:[
            'black',
            'black',
            'black',
            'black',
            'black',
            'black'
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</div>
<div class="container_stat">
  @foreach ($decodedJml['label'] as $item)
    <div class="cont_list"><a class="link_stat" href={{ route('stat',['status' => urlencode($item) ]) }}> {{ $item }}</a></div>
  @endforeach
</div>
@endsection