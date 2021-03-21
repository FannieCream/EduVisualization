<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/echarts.min.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-select.min.js') }}" ></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/kstyle.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" >
    <style>
        body{
            background-image: url("../images/new_bg7.png");
            background-size: cover;
            background-repeat: no-repeat;
            z-index: -1000;
        }
    </style>
</head>
<body>
    {{--  Begin Navbar    --}}
   <div class="menu-wrap">
    <input type="checkbox" class="toggler" />
    <div class="hamburger"><div></div></div>
    <div class="menu">
        <div>
            <ul>
                <li><a href="{{ url('home') }}">Home</a></li>
                <li><a href="{{ url('knowledge') }}">Knowledge Report</a></li>
                <li><a href="{{ url('student') }}">Student Report</a></li>
                <li><a href="{{ url('battle') }}">Battle Field</a></li>
            </ul>
        </div>
    </div>
    </div>
    {{--  End Navbar    --}}

    <div class="introduction">
        <p class="hello">Hi, Welcome to Knowledge Report</p>
        <p class="typing">Hover the nodes to get more details !</p>
    </div>

    <div id="gchart" style="width: 100%; height: 300px"></div>

    <div id="gchart-chart-card">
        Each node represents a knowledge point. <br/>
        The size of the node represents the number of problems to be done. 
        The <b>larger</b> the node is, the <b>more</b> questions are completed. <br/>
        The color of the node represents the accuracy rate.
        The <b>brighter</b> the color is, the <b>lower</b> the accuracy rate.
    </div>
        

    
</body>
<script type="text/javascript">
    var nodes_data = []
    var links_data = []
    myChart = echarts.init(document.getElementById("gchart"));
    myChart.showLoading();

    function GraphData(){
        $.ajaxSettings.async = false;
        $.post("{{ url('/gdata') }}", {"_token": "{{ csrf_token() }}"}, function(graphdata){
            $.each(graphdata, function(index, value){
                var cur_node = value;
                var itemstyle = {
                    color: {
                        type: 'linear',
                        x: 0,
                        y: 0,
                        x2: value["c_rate"],
                        y2: value["c_rate"],
                        colorStops: [{
                            offset: 0, color: '#544a7d' // 0% 处的颜色
                        }, {
                            offset: 1, color: '#ffd452' // 100% 处的颜色
                        }],
                        global: false // 缺省为 false
                    },
                    bolderColor: '#bbb',
                    borderWidth: 1,
                    borderType: "solid"
                };
                cur_node["itemStyle"] = itemstyle;
                nodes_data.push(cur_node);
            })
        })
    }

    GraphData();

    var option = {
        title: {

        },

        tooltip: {
            trigger: "item",
            position: "right",
            formatter: function (params, ticket, callback){
                var get_data = params.data;
                var res = "Knowledge: " + get_data["name"] + "<br/>" ;
                res += "Q Numbers: " + get_data["value"].toString() + "<br/>" ;
                res += "Correct Rate: " + (get_data["c_rate"]*100).toString() + "%" + "<br/>" ;
                return res;
            },
            backgroundColor: "rgb(50, 50, 0, 0.7)",
            borderColor: "#FFFFE0",
            borderWidth: 1,
            padding: 10,
            textStyle: {
                fontFamily: "Candara",
                fontSize: 14,
                color: "#fff"
            },
            extraCssText: "box-shadow: 0 0 3px rgba(1, 1, 1, 0.3);"
        },

        label: {
            color: "#000",
            fontFamily: "Candara",
            fontSize: 16,
            extraCssText: "box-shadow: 0 0 3px rgba(1, 1, 1, 0.3);"

        },

        series: [
            {
                type: "graph",
                layout: "force",
                force: {
                    repulsion: 30,
                    edgeLength: 20
                },
                roam:"true",
                draggable: "true",
                edgeSymbol: ['circle', 'arrow'],
                data: nodes_data,
            }
        ]
    }

    myChart.hideLoading();
    myChart.setOption(option);
</script>
</html>