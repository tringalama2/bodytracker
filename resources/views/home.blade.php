@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6">

      <!-- tailwind card -->

        <div class="flex flex-wrap -mx-4">
          <div class="w-full sm:w-1/2 md:w-1/2 xl:w-1/4 p-4">
            <div class="rounded break-words bg-white shadow-sm rounded-lg overflow-hidden border border-gray-300">
              <div class="py-3 px-6 mb-0 bg-blue-700 border-b-1 border-blue-700 text-white">Dashboard</div>

              <div class="flex-auto p-6">
                @if (session('status'))
                  <div class="relative px-3 py-3 mb-4 border rounded text-green-darker border-green-dark bg-green-lighter" role="alert">
                    {{ session('status') }}
                  </div>
                @endif

                You are logged in!
              </div>
              <div class="flex-auto p-6">

              <ul>
                <li><a href="{{ route('entries.index') }}">All Entries</a></li>
                <li><a href="{{ route('entries.create') }}">Add New Entry</a></li>
              </ul>

              </div>
            </div>
          </div>


          <div class="w-full sm:w-1/2 md:w-1/2 xl:w-1/4 p-4">
            <div class="rounded break-words bg-white shadow-sm rounded-lg overflow-hidden border border-gray-300">
              <div class="py-3 px-6 mb-0 bg-blue-700 text-white">Weight Trend</div>

              <div class="">
                <canvas id="myChart"></canvas>
              </div>

              <div class="py-3 px-6 bg-grey-lighter border-t-1 border-grey-light">
                <span class="mb-0 pr-2 text-xs">View</span>
                <a href="{{ route('home') }}"
                  class="inline-block bg-gray-200 rounded-full px-2 py-1 text-xs font-semibold text-gray-700 mr-2">All</a>
                <a href="{{ route('home', ['unit' => 'days', 'interval' => 7]) }}"
                  class="inline-block bg-gray-200 rounded-full px-2 py-1 text-xs font-semibold text-gray-700 mr-2">7d</a>
                <a href="{{ route('home', ['unit' => 'weeks', 'interval' => 4]) }}"
                  class="inline-block bg-gray-200 rounded-full px-2 py-1 text-xs font-semibold text-gray-700 mr-2">4w</a>
                <a href="{{ route('home', ['unit' => 'months', 'interval' => 6]) }}"
                  class="inline-block bg-gray-200 rounded-full px-2 py-1 text-xs font-semibold text-gray-700 mr-2">6m</a>
                <a href="{{ route('home', ['unit' => 'ytd']) }}"
                  class="inline-block bg-gray-200 rounded-full px-2 py-1 text-xs font-semibold text-gray-700 mr-2">YTD</a>
                <a href="{{ route('home', ['unit' => 'years', 'interval' => 1]) }}"
                  class="inline-block bg-gray-200 rounded-full px-2 py-1 text-xs font-semibold text-gray-700 mr-2">1y</a>
                <a href="{{ route('home', ['unit' => 'years', 'interval' => 2]) }}"
                  class="inline-block bg-gray-200 rounded-full px-2 py-1 text-xs font-semibold text-gray-700">2y</a>
              </div>
          </div>
        </div>
      </div>





</div>
@endsection

@section('scripts')
  @parent

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
  <script src="https://unpkg.com/roughjs@latest/bundled/rough.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-rough@latest/dist/chartjs-plugin-rough.min.js"></script>
  <script>
  /*!
   * chartjs-plugin-trendline.js
   * Version: 0.1.3
   *
   * Copyright 2017 Marcus Alsterfjord
   * Released under the MIT license
   * https://github.com/Makanz/chartjs-plugin-trendline/blob/master/README.md
   *
   * Mod by: vesal: accept also xy-data so works with scatter
   */
  var pluginTrendlineLinear = {
      beforeDraw: function(chartInstance) {
          var yScale;
          var xScale;
          for (var axis in chartInstance.scales) {
              if ( axis[0] == 'x')
                  xScale = chartInstance.scales[axis];
              else
                  yScale = chartInstance.scales[axis];
              if ( xScale && yScale ) break;
          }
          var ctx = chartInstance.chart.ctx;

          chartInstance.data.datasets.forEach(function(dataset, index) {
              if (dataset.trendlineLinear && chartInstance.isDatasetVisible(index)) {
                  var datasetMeta = chartInstance.getDatasetMeta(index);
                  addFitter(datasetMeta, ctx, dataset, xScale, yScale);
              }
          });

          ctx.setLineDash([]);
      }
  };

  function addFitter(datasetMeta, ctx, dataset, xScale, yScale) {
      var style = dataset.trendlineLinear.style || dataset.borderColor;
      var lineWidth = dataset.trendlineLinear.width || dataset.borderWidth;
      var lineStyle = dataset.trendlineLinear.lineStyle || "solid";

      style = (style !== undefined) ? style : "rgba(169,169,169, .6)";
      lineWidth = (lineWidth !== undefined) ? lineWidth : 3;

      var fitter = new LineFitter();
      var lastIndex = dataset.data.length - 1;
      var startPos = datasetMeta.data[0]._model.x;
      var endPos = datasetMeta.data[lastIndex]._model.x;

      var xy = false;
      if ( dataset.data && typeof dataset.data[0] === 'object') xy = true;

      dataset.data.forEach(function(data, index) {
          if(data == null)
              return;
          if ( xy ) fitter.add(data.x, data.y);
          else fitter.add(index, data);
      });

      var x1 = xScale.getPixelForValue(fitter.minx);
      var x2 = xScale.getPixelForValue(fitter.maxx);
      var y1 = yScale.getPixelForValue(fitter.f(fitter.minx));
      var y2 = yScale.getPixelForValue(fitter.f(fitter.maxx));
      if ( !xy ) { x1 = startPos; x2 = endPos; }

      var drawBottom = datasetMeta.controller.chart.chartArea.bottom;
      var chartWidth = datasetMeta.controller.chart.width;

      if(y1 > drawBottom) { // Left side is below zero
          var diff = y1 - drawBottom;
          var lineHeight = y1 - y2;
          var overlapPercentage = diff / lineHeight;
          var addition = chartWidth * overlapPercentage;

          y1 = drawBottom;
          x1 = (x1 + addition);
      } else if(y2 > drawBottom) { // right side is below zero
          var diff = y2 - drawBottom;
          var lineHeight = y2 - y1;
          var overlapPercentage = diff / lineHeight;
          var subtraction = chartWidth - (chartWidth * overlapPercentage);

          y2 = drawBottom;
          x2 = chartWidth - (x2 - subtraction);
      }

      ctx.lineWidth = lineWidth;
      if (lineStyle === "dotted") { ctx.setLineDash([2, 3]); }
      ctx.beginPath();
      ctx.moveTo(x1, y1);
      ctx.lineTo(x2, y2);
      ctx.strokeStyle = style;
      ctx.stroke();
  }

  Chart.plugins.register(pluginTrendlineLinear);

  function LineFitter() {
      this.count = 0;
      this.sumX = 0;
      this.sumX2 = 0;
      this.sumXY = 0;
      this.sumY = 0;
      this.minx = 1e100;
      this.maxx = -1e100;
  }

  LineFitter.prototype = {
      'add': function (x, y) {
          this.count++;
          this.sumX += x;
          this.sumX2 += x * x;
          this.sumXY += x * y;
          this.sumY += y;
          if ( x < this.minx ) this.minx = x;
          if ( x > this.maxx ) this.maxx = x;
      },
      'f': function (x) {
          var det = this.count * this.sumX2 - this.sumX * this.sumX;
          var offset = (this.sumX2 * this.sumY - this.sumX * this.sumXY) / det;
          var scale = (this.count * this.sumXY - this.sumX * this.sumY) / det;
          return offset + x * scale;
      }
  };
  </script>

  <script>
    window.onload = function() {
      // use a handwritting font
      Chart.defaults.global.defaultFontFamily = '"Indie Flower", cursive';

      // makes all charts have the 'Rough' look
      Chart.plugins.register(ChartRough);

      var ctx = document.getElementById('myChart').getContext('2d');
      var chart = new Chart(ctx, {


        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: {!! $jsonEntryDates !!},
            datasets: [{
                label: 'Weight ({{ auth()->user()->preference->weightUnitLabel() }})',
                borderColor: 'rgb(40, 167, 69)',
                backgroundColor: 'rgba(40, 167, 69, 0.3)',
                data: {!! $jsonWeightLbs !!},
                fill: true,

                // trendline plugin
                trendlineLinear: {
                    style: "#000000",
                    lineStyle: "line",
                    width: 3
                  },
            }]
        },

        // Configuration options go here
        options: {
          scales: {
            xAxes: [{
                type: 'time',
                distribution: 'linear', //data are spread according to their time (distances can vary)
                time: {
                    displayFormats: {
                        year: 'YYYY',
                        month: 'MMM YYYY',
                        day: 'MMM D',
                        hour: 'MMM D, h A',

                    },
                }
            }]
          },
          plugins: {
            datalabels: {
              backgroundColor: function(context) {
                return context.dataset.borderColor;
              },
              borderRadius: 4,
              color: 'white',
              font: {
                weight: 'bold'
              },
              align: 'end',
              anchor: 'end',
              formatter: Math.round
            },
          },
          responsive: true,
          tooltips: {
            enabled: true,
            position: 'nearest',
            mode: 'index',
            intersect: false,
          },
        }
      });
    };
  </script>
@endsection
