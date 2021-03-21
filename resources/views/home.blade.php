<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Education Visualization</title>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/echarts.min.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.js') }}" ></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/homestyle.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" >
    <style>
        body{
            {{-- background-color: #404a59; --}}
            background-image: url("../images/bg4.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            z-index: -1000;
        }
    </style>
</head>
<body>
    <h3 id="title">Knowledge Land </h3>
    <div id="gchart" style="width: 80%; height: 70%"></div>
    <button type="button" id="home-button" class="btn btn-default btn-lg" >Explore</button>
    <div id="home-choice">
        <div class="container">
            <div class="row align-items-center">
                <div id="home-item1" class="col-lg-4">
                    <img id="pic1" src="images/home-book.png" width="25%"><br/>
                    <p class="link"><a id="link1" href="{{ url('knowledge') }}">Knowledge Report</a></p>
                </div> 
                <div id="home-item2" class="col-lg-4">
                    <img id="pic2" src="images/home-student.png" width="25%"><br/>
                    <p class="link"><a id="link2" href="{{ url('student') }}">Student Report</a></p>
                </div> 
                <div id="home-item3" class="col-lg-4">
                    <img id="pic3" src="images/home-battle.png" width="25%"><br/>
                    <p class="link"><a id="link3" href="{{ url('battle') }}">Battle Field</a></p>
                </div> 
            </div>
        </div>
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

    $("#home-button").click(function(){
        $("#home-choice").toggle();
    });

    $("#home-item1").hover(function(){
        $("#pic1").attr("src","images/home-book2.png");
        $("#link1").css("color", "white");
    }, function(){
        $("#pic1").attr("src","images/home-book.png");
        $("#link1").css("color", "#548CBD");
    })

    $("#home-item2").hover(function(){
        $("#pic2").attr("src","images/home-student2.png");
        $("#link2").css("color", "white");
    }, function(){
        $("#pic2").attr("src","images/home-student.png");
        $("#link2").css("color", "#548CBD");
    })

    $("#home-item3").hover(function(){
        $("#pic3").attr("src","images/home-battle2.png");
        $("#link3").css("color", "white");
    }, function(){
        $("#pic3").attr("src","images/home-battle.png");
        $("#link3").css("color", "#548CBD");
    })

</script>
</html>