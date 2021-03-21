<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report Visualization</title>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/echarts.min.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-select.min.js') }}" ></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/stustyle.css')}}">
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
        <p class="hello">Hello, Alice</p>
        <p class="typing">Welcome to your personal report. Let's take a look at your study during this period!</p>
    </div>

    <div class="search">
        <select class="selectpicker show-tick" id="selectBox" actionsBox="true" title="Student Name" data-size="7" data-width="auto">
            <option value="" class="optionIntro">-- Please Choose --</option>
            <option> Alice</option>
            <option> Ben</option>
            <option> Cindy</option>
            <option> Denny</option>
            <option> Emily</option>
            <option> Fannie</option>
        </select>
        <button class="submitBtn" type="submit" onclick="searchInfo()">Search</button>
        <p class="switch">Use the search box to switch to others' report.</p>
    </div>

    <div id="arrow">
        <img id="arrow-img" src="images/arrow.png" width="5%">
    </div>

    <div class="top-info">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <p class="top-info-text">Study Time</p>
                    <div id="info-chart-1"></div>
                </div>
                <div class="col-lg-4">
                    <p class="top-info-text">Finished Q-Number</p>
                    <div id="info-chart-2"></div>
                </div>
                <div class="col-lg-4">
                    <p class="top-info-text">Accuracy</p>
                    <div id="info-chart-3"></div>
                </div>
            </div>
        </div>
    </div>

    <p class="top-info-text">Activity of Learning-Online Heatmap</p>
    <div id="calendarchart" style="width: 100%; height: 300px"></div>
    <div id="calendar-chart-card">
        <p id="calendar-chart-text">
            <span class="highlight-text">2020-02-25</span> is the first day you start studying on the website!
            You have been studying online for <span class="highlight-text">198</span> days!
            Never to old to learn, just keep on going never give up! 
        </p>
    </div>

    <p class="top-info-text-left">Exercise Flow Diagram</p>

    <div class="sankey">
        <div class="container">
            <div class="row" >
                <div class="col-lg-6">
                    <div id="sankey-chart-card">
                        During your study, you have completed <span id="q-number" class="highlight-text-red"></span> exercises of  
                        <span id="k-number" class="highlight-text-red"></span> kinds of knowledge points. 
                        You have achieved the correct rate of <span id="c-rate" class="highlight-text-red" ></span><span class="highlight-text-red" >%</span>.
                    </div>
                </div>
                <div class="col-lg-6">
                    <div id="sankeychart"></div>
                </div>
            </div>
        </div>
    </div>

    <p class="top-info-text-right">Knowledge Warning Matrix</p>
    <div class="treemap">
        <div class="container">
            <div class="row" >
                <div class="col-lg-6">
                    <div id="treemapchart"></div>
                </div>
                <div class="col-lg-6">
                    <div id="treemap-chart-card">
                        According to your learning situation, we divide the knowledge you have learned into three levels: <br/>
                        The <span class="highlight-text-green">GREEN</span> area indicates the knowledge you have mastered. <br/>
                        The <span class="highlight-text-yellow">YELLOW</span> area indicates that you need to work harder. <br/>
                        The <span class="highlight-text-red">RED</span> area indicates that you are poor in study and need to pay more attention. <br/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <p class="top-info-text">Intelligent Customization</p>
    <div class="predict">
        <div class="container">
            <div class="row" >
                <div class="col-lg-6">
                    <div id="forgetchart"></div>
                </div>
                <div class="col-lg-6">
                    <div id="planchart"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="predict-chart-card">
            <span class="highlight-text">Forgetting Curve</span><br/> 
            (the diagram on the left) shows students' personalized forget behavior. 
            We can make use of it to capture the law of forgetting and customize review plan timely. <br>
            <span class="highlight-text">Learning Plan</span><br/> 
            (the diagram on the right) shows a personalized learning plan for students 
            based on their behavior, which can improve their learning efficiency.
    </div>

    
    

    

        {{--  <div id="forgetchart" style="width: 40%; height: 300px"></div>  --}}

        {{--  <div id="planchart" style="width: 40%; height: 300px"></div>  --}}
    
</body>

<script type="text/javascript">
    var sankey_nodes_data = []
    var sankey_links_data = []
    var sankeyChart = echarts.init(document.getElementById("sankeychart"));
    var c_rate = 0;
    var w_rate = 0;
    var q_number = 0;
    var k_number = 0;
    sankeyChart.showLoading();

    function SankeyData(){
        $.ajaxSettings.async = false;
        $.post("{{ url('/sankeydata') }}", {"_token": "{{ csrf_token() }}"}, function(sandata){
            sankey_nodes_data = sandata["nodes"];
            sankey_links_data = sandata["links"];
            c_rate = (sandata["c_rate"] * 100).toFixed(2);
            w_rate = (sandata["w_rate"] * 100).toFixed(2);
            q_number = sandata["q_number"];
            k_number = sandata["k_number"];
        })
    }

    SankeyData();
    
    document.getElementById("q-number").innerHTML = q_number;
    document.getElementById("k-number").innerHTML = k_number;
    document.getElementById("c-rate").innerHTML = c_rate;


    var infoChart1 = echarts.init(document.getElementById("info-chart-1"));
    var infooption1 = {
        series: [
            {
                type: "gauge",
                startAngle: 180,
                endAngle: 0,
                min: 0,
                max: 1000,
                splitNumber: 5,
                itemStyle: {
                    color: '#58D9F9',
                    shadowColor: 'rgba(0,138,255,0.45)',
                    shadowBlur: 10,
                    shadowOffsetX: 2,
                    shadowOffsetY: 2
                },
                progress: {
                    show: true,
                    roundCap: true,
                    width: 18
                },
                pointer: {
                    icon: 'path://M2090.36389,615.30999 L2090.36389,615.30999 C2091.48372,615.30999 2092.40383,616.194028 2092.44859,617.312956 L2096.90698,728.755929 C2097.05155,732.369577 2094.2393,735.416212 2090.62566,735.56078 C2090.53845,735.564269 2090.45117,735.566014 2090.36389,735.566014 L2090.36389,735.566014 C2086.74736,735.566014 2083.81557,732.63423 2083.81557,729.017692 C2083.81557,728.930412 2083.81732,728.84314 2083.82081,728.755929 L2088.2792,617.312956 C2088.32396,616.194028 2089.24407,615.30999 2090.36389,615.30999 Z',
                    length: '75%',
                    width: 16,
                    offsetCenter: [0, '5%']
                },
                axisLine: {
                    roundCap: true,
                    lineStyle: {
                        width: 18
                    }
                },
                axisTick: {
                    splitNumber: 2,
                    lineStyle: {
                        width: 2,
                        color: '#999'
                    }
                },
                splitLine: {
                    length: 12,
                    lineStyle: {
                        width: 3,
                        color: '#999'
                    }
                },
                axisLabel: {
                    distance: 30,
                    color: '#999',
                    fontSize: 16
                },
                title: {
                    show: false
                },
                detail: {
                    backgroundColor: '#fff',
                    borderColor: '#999',
                    borderWidth: 1,
                    width: 150,
                    lineHeight: 40,
                    height: 40,
                    borderRadius: 8,
                    offsetCenter: [0, "40%"],
                    valueAnimation: true,
                    formatter: function (value) {
                        return '{value|' + value.toFixed(1) + '}{unit|Hours}';
                    },
                    rich: {
                        value: {
                            fontSize: 35,
                            fontWeight: 'bolder',
                            color: '#777'
                        },
                        unit: {
                            fontSize: 20,
                            fontWeight: 'bold',
                            color: '#999',
                            padding: [0, 0, -20, 10],
                        }
                    }
                },
                data: [{
                    value:  Math.floor(Math.random() * 2000 + 100)/10
                }]
            }
        ]
    }
    infoChart1.setOption(infooption1);

    var infoChart2 = echarts.init(document.getElementById("info-chart-2"));
    var infooption2 = {
        series: [
            {
                type: "gauge",
                startAngle: 180,
                endAngle: 0,
                min: 0,
                max: 10000,
                splitNumber: 5,
                itemStyle: {
                    color: '#FF8247',
                    shadowColor: 'rgba(0,138,255,0.45)',
                    shadowBlur: 10,
                    shadowOffsetX: 2,
                    shadowOffsetY: 2
                },
                progress: {
                    show: true,
                    roundCap: true,
                    width: 18
                },
                pointer: {
                    icon: 'path://M2090.36389,615.30999 L2090.36389,615.30999 C2091.48372,615.30999 2092.40383,616.194028 2092.44859,617.312956 L2096.90698,728.755929 C2097.05155,732.369577 2094.2393,735.416212 2090.62566,735.56078 C2090.53845,735.564269 2090.45117,735.566014 2090.36389,735.566014 L2090.36389,735.566014 C2086.74736,735.566014 2083.81557,732.63423 2083.81557,729.017692 C2083.81557,728.930412 2083.81732,728.84314 2083.82081,728.755929 L2088.2792,617.312956 C2088.32396,616.194028 2089.24407,615.30999 2090.36389,615.30999 Z',
                    length: '75%',
                    width: 16,
                    offsetCenter: [0, '5%']
                },
                axisLine: {
                    roundCap: true,
                    lineStyle: {
                        width: 18
                    }
                },
                axisTick: {
                    splitNumber: 2,
                    lineStyle: {
                        width: 2,
                        color: '#999'
                    }
                },
                splitLine: {
                    length: 12,
                    lineStyle: {
                        width: 3,
                        color: '#999'
                    }
                },
                axisLabel: {
                    distance: 30,
                    color: '#999',
                    fontSize: 16
                },
                title: {
                    show: false
                },
                detail: {
                    backgroundColor: '#fff',
                    borderColor: '#999',
                    borderWidth: 1,
                    width: 150,
                    lineHeight: 40,
                    height: 40,
                    borderRadius: 8,
                    offsetCenter: [0, "40%"],
                    valueAnimation: true,
                    formatter: function (value) {
                        return '{value|' + value.toFixed(0) + '}{unit|Exercises}';
                    },
                    rich: {
                        value: {
                            fontSize: 35,
                            fontWeight: 'bolder',
                            color: '#777'
                        },
                        unit: {
                            fontSize: 20,
                            fontWeight: 'bold',
                            color: '#999',
                            padding: [0, 0, -20, 10],
                        }
                    }
                },
                data: [{
                    value:  q_number
                }]
            }
        ]
    }
    infoChart2.setOption(infooption2);

    var infoChart3 = echarts.init(document.getElementById("info-chart-3"));
    var infooption3 = {
        series: [
            {
                type: "gauge",
                startAngle: 180,
                endAngle: 0,
                min: 0,
                max: 100,
                splitNumber: 5,
                itemStyle: {
                    color: '#CD69C9',
                    shadowColor: 'rgba(0,138,255,0.45)',
                    shadowBlur: 10,
                    shadowOffsetX: 2,
                    shadowOffsetY: 2
                },
                progress: {
                    show: true,
                    roundCap: true,
                    width: 18
                },
                pointer: {
                    icon: 'path://M2090.36389,615.30999 L2090.36389,615.30999 C2091.48372,615.30999 2092.40383,616.194028 2092.44859,617.312956 L2096.90698,728.755929 C2097.05155,732.369577 2094.2393,735.416212 2090.62566,735.56078 C2090.53845,735.564269 2090.45117,735.566014 2090.36389,735.566014 L2090.36389,735.566014 C2086.74736,735.566014 2083.81557,732.63423 2083.81557,729.017692 C2083.81557,728.930412 2083.81732,728.84314 2083.82081,728.755929 L2088.2792,617.312956 C2088.32396,616.194028 2089.24407,615.30999 2090.36389,615.30999 Z',
                    length: '75%',
                    width: 16,
                    offsetCenter: [0, '5%']
                },
                axisLine: {
                    roundCap: true,
                    lineStyle: {
                        width: 18
                    }
                },
                axisTick: {
                    splitNumber: 2,
                    lineStyle: {
                        width: 2,
                        color: '#999'
                    }
                },
                splitLine: {
                    length: 12,
                    lineStyle: {
                        width: 3,
                        color: '#999'
                    }
                },
                axisLabel: {
                    distance: 30,
                    color: '#999',
                    fontSize: 16
                },
                title: {
                    show: false
                },
                detail: {
                    backgroundColor: '#fff',
                    borderColor: '#999',
                    borderWidth: 1,
                    width: 150,
                    lineHeight: 40,
                    height: 40,
                    borderRadius: 8,
                    offsetCenter: [0, "40%"],
                    valueAnimation: true,
                    formatter: function (value) {
                        return '{value|' + value.toFixed(2) + '}{unit|%}';
                    },
                    rich: {
                        value: {
                            fontSize: 35,
                            fontWeight: 'bolder',
                            color: '#777'
                        },
                        unit: {
                            fontSize: 20,
                            fontWeight: 'bold',
                            color: '#999',
                            padding: [0, 0, -20, 10],
                        }
                    }
                },
                data: [{
                    value:  c_rate
                }]
            }
        ]
    }
    infoChart3.setOption(infooption3);


    var calendarChart = echarts.init(document.getElementById("calendarchart"));
    calendarChart.showLoading();

    function getVirtulData(year) {
        year = year || '2020';
        var date = +echarts.number.parseDate(year + '-01-01');
        var date_begin = +echarts.number.parseDate(+year + '-02-25');
        var end = +echarts.number.parseDate((+year + 1) + '-01-01');
        var date_end = +echarts.number.parseDate(year + '-09-10');
        var dayTime = 3600 * 24 * 1000;
        var data = [];
        for (var time1 = date; time1 < date_begin ; time1 += dayTime) {
            random_time = echarts.format.formatTime('yyyy-MM-dd', time1);
            data.push([
                random_time,
                random_time.split("-")[2],
                Math.floor(0)
            ]);
        }

        for (var time2 = date_begin; time2 < date_end; time2 += dayTime) {
            random_time = echarts.format.formatTime('yyyy-MM-dd', time2);
            data.push([
                random_time,
                random_time.split("-")[2],
                Math.floor(Math.random() * 50)
            ]);
        }

        for (var time3 = date_end; time3 < end; time3 += dayTime) {
            random_time = echarts.format.formatTime('yyyy-MM-dd', time3);
            data.push([
                random_time,
                random_time.split("-")[2],
                Math.floor(0)
            ]);
        }
        return data;
    }
    
    var calendaroption = {
        tooltip: {
            trigger: "item",
            position: "right",
            formatter: function (params, ticket, callback){
                var get_data = params.data;
                var res = "Date: " + get_data[0] + "<br/>";
                res += "Finished Q-Numbers: " + get_data[2].toString();
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
        visualMap: {
            min: 0,
            max: 50,
            type: 'continuous',
            orient: 'horizontal',
            left: 'center',
            bottom: 55,
            calculable: true,
            dimension: 2,
        },
        calendar: {
            top: 20,
            left: 30,
            right: 30,
            cellSize: [30, 20],
            range: '2020',
            align: "right",
            itemStyle: {
                borderWidth: 0.5
            },
            yearLabel: {
                show: false
            },
            dayLabel: {
                color: "#fff",
                firstDay: 0,
                nameMap: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            },
            monthLabel: {
                show: true,
                color: "#fff"
            }
        },
        series: {
            type: 'heatmap',
            coordinateSystem: 'calendar',
            data: getVirtulData(2020),
            label: {
                show: true,
                formatter: function (params) {
                    var d = echarts.number.parseDate(params.value[0]);
                    return d.getDate();
                },
                color: "#fff",
                fontSize:10
            },
            emphasis: {
                itemStyle: {
                    shadowBlur: 10,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    };
    
    calendarChart.hideLoading();
    calendarChart.setOption(calendaroption);



    var sankeyoption = {
        tooltip: {
            trigger: "item",
            triggerOn: "mousemove",
            position: "right",
            formatter: function (params, ticket, callback){
                var get_data = params.data;
                var res = "";
                if(get_data.hasOwnProperty("name")){
                    var res = "Knowledge: " + get_data["name"] + "<br/>";
                    res += "Q-Numbers: " + get_data["value"].toString();
                }else{
                    var res = "Source: " + get_data["source"] + "<br/>";
                    res += "Q-Numbers: " + get_data["value"] + "<br/>";
                    res += "Target: " + get_data["target"] + "<br/>";
                }
                return res;
            },
            backgroundColor: "rgb(50, 50, 0, 0.7)",
            borderColor: "#FFFFE0",
            borderWidth: 1,
            padding: 10,
            textStyle: {
                fontFamily: "Candara",
                fontSize: 14,
                color: "#fff",
            },
            extraCssText: "box-shadow: 0 0 3px rgba(1, 1, 1, 0.3);"

        },

        series: [
            {
                type: "sankey",
                roam:"true",
                draggable: "true",
                data: sankey_nodes_data,
                links: sankey_links_data,
                emphasis: {
                    focus: 'adjacency'
                },
                lineStyle: {
                    color: 'gradient',
                    curveness: 0.5
                }
            }
        ]
    }

    sankeyChart.hideLoading();
    sankeyChart.setOption(sankeyoption);

    var red_k_list = [];
    var yellow_k_list = [];
    var green_k_list = [];

    function getTreemapData(){
        $.ajaxSettings.async = false;
        $.post("{{ url('/treemap') }}", {"_token": "{{ csrf_token() }}"}, function(treemapdata){
            red_data = treemapdata["red"];
            $.each(red_data, function(key, value){
                var cur_data = {
                    name: value, 
                    value: Math.floor(Math.random()*200 + 10),
                    itemStyle: {
                        color: '#B22222'
                    },
                    tooltip: {
                        backgroundColor: "rgb(238, 102, 102, 0.7)",
                        borderColor: "#FFFFE0",
                    },
                };
                red_k_list.push(cur_data);
            });

            green_data = treemapdata["green"];
            $.each(green_data, function(key, value){
                var cur_data = {
                    name: value, 
                    value: Math.floor(Math.random()*200 + 10),
                    itemStyle: {
                        color: '#91cc75'
                    },
                    tooltip: {
                        backgroundColor: "rgb(154, 205, 50, 0.7)",
                        borderColor: "#FFFFE0",
                    }
                };
                green_k_list.push(cur_data);
            });

            yellow_data = treemapdata["yellow"];
            $.each(yellow_data, function(key, value){
                var cur_data = {
                    name: value, 
                    value: Math.floor(Math.random()*200 + 10),
                    itemStyle: {
                        color: '#fac858'
                    },
                    tooltip: {
                        backgroundColor: "rgb(255, 193, 37, 0.7)",
                        borderColor: "#FFFFE0",
                    }
                };
                yellow_k_list.push(cur_data);
            });

        })
    }

    getTreemapData();

    var treemapChart = echarts.init(document.getElementById("treemapchart"));
    var treemapoption = {
        tooltip: {
            trigger: "item",
            triggerOn: "mousemove",
            position: "right",
            formatter: function (params, ticket, callback){
                var get_data = params.data;
                var res = "";
                var res = "Knowledge: " + get_data["name"] + "<br/>";
                res += "Q-Numbers: " + get_data["value"].toString();
                return res;
            },
            borderWidth: 1,
            padding: 10,
            textStyle: {
                fontFamily: "Candara",
                fontSize: 14,
                color: "#000",
            },
            extraCssText: "box-shadow: 0 0 3px rgba(1, 1, 1, 0.3);"
        },
        
        series: [
            {
                type: "treemap",
                data: [
                    {
                        name: "Dangerous",
                        children: red_k_list
                    },
                    {
                        name: "Keep Going",
                        children: yellow_k_list
                    },
                    {
                        name: "Mastered",
                        children: green_k_list
                    }
                ]
            }
        ]
    }

    treemapChart.hideLoading();
    treemapChart.setOption(treemapoption);

    function getVisualForgetData(){
        var res_data = [];
        year = 2020 || '2020';
        var date_begin = +echarts.number.parseDate(+year + '-02-25');
        var end = +echarts.number.parseDate((+year + 1) + '-01-01');
        var dayTime = 3600 * 24 * 1000;
        for (var time = date_begin; time < end ; time += dayTime) {
            cur_time = echarts.format.formatTime('yyyy-MM-dd', time);
            cur_day = parseInt(cur_time.split("-")[2]);
            res_data.push([
                cur_time,
                (Math.exp((-0.1)*cur_day) * (50 * Math.random() + 50)).toFixed(2)
            ]);
        }
        return res_data;
    }

    var forget_data = getVisualForgetData();
    var forgetChart = echarts.init(document.getElementById("forgetchart"));
    var forgetoption = {
        tooltip: {
            trigger: 'axis',
            position: function (pt) {
                return [pt[0], '10%'];
            }
        },
        xAxis: {
            type: 'time',
            boundaryGap: false,
            name: "Date",
            nameTextStyle: {
                color: "#bbb",
                fontFamily: "Candara",
                fontSize: 16
            },
            axisLine: {
                lineStyle: {
                    type: "dashed"
                }
            },
            axisLabel: {
                color: "#eee",
                fontFamily: "Candara",
                fontSize: 14
            }

        },
        yAxis: {
            type: 'value',
            name: "The Number of Memories",
            nameTextStyle: {
                color: "#eee",
                fontFamily: "Candara",
                fontSize: 16
            },
            axisLabel: {
                color: "#bbb",
                fontFamily: "Candara",
                fontSize: 14
            },
            boundaryGap: [0, '100%'],
            min: 0,
            max: 100
        },
        dataZoom: [
            {
                type: 'inside',
                start: 0,
                end: 20
            }, 
            {
                start: 0,
                end: 20
            }
        ],
        series: [
            {
                name: "Number of Memories",
                type: 'line',
                smooth: true,
                symbol: 'none',
                lineStyle: {
                    color: "#6495ED",
                    width: 2
                },
                itemStyle: {
                    color: "#6495ED",
                    width: 2
                },
                areaStyle: {
                    color: "#6495ED",
                    opacity: 0.5
                },
                data: forget_data
            }
        ]
    }

    forgetChart.setOption(forgetoption);


    var plan_nodes_data = [];
    function planData(){
        $.ajaxSettings.async = false;
        $.post("{{ url('/plandata') }}", {"_token": "{{ csrf_token() }}"}, function(plandata){
            $.each(plandata, function(index, value){
                var cur_node = [value["name"], value["value"], value["knowledge"]];
                plan_nodes_data.push(cur_node);
            })
        })
    }

    planData();

    var plan_links_data = plan_nodes_data.map(function (item, idx) {
        return {
            source: idx,
            target: idx + 1
        };
    });

    plan_links_data.pop();

    var planChart = echarts.init(document.getElementById("planchart"));
    var planoption = {
        tooltip: {
            trigger: "item",
            triggerOn: "mousemove",
            position: "right",
            confine: true,
            formatter: function (params, ticket, callback){
                var get_data = params.data;
                var res = "";
                var res = "Today is " + get_data[0] + "<br/>";
                if(get_data[1] === 0){
                    res += "It\'s a good idea to learn about " + get_data[2];
                }else {
                    res += "Keep on going to learning plan";
                }
                return res;
            },
            backgroundColor: "rgb(50, 50, 0, 0.7)",
            borderColor: "#FFFFE0",
            borderWidth: 1,
            padding: 10,
            textStyle: {
                fontFamily: "Candara",
                fontSize: 14,
                color: "#fff",
            },
            extraCssText: "box-shadow: 0 0 3px rgba(1, 1, 1, 0.3);"
        },
        calendar: {
            top: 'middle',
            left: 'center',
            orient: 'vertical',
            cellSize: 40,
            yearLabel: {
                margin: 50,
                fontSize: 30,
                position: "top",
                fontFamily: "Candara",
                bottom: 20
            },
            dayLabel: {
                firstDay: 0,
                nameMap: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                color: "#fff",
                fontSize: 16,
                fontFamily: "Candara"
               
            },
            monthLabel: {
                nameMap: 'en',
                margin: 15,
                fontSize: 20,
                color: '#999',
                fontFamily: "Candara"
            },
            range: ['2020-09-01', '2020-10-31']
        },
        visualMap: {
            show: false,
            min: 0,
            max: 1000,
            type: 'piecewise',
            left: 'center',
            bottom: 20,
            inRange: {
                color: ['#A2CD5A', '#6E8B3D']
            },
            seriesIndex: [1],
            orient: 'horizontal'
        },
        series: [
            {
                type: 'graph',
                edgeSymbol: ['none', 'arrow'],
                coordinateSystem: 'calendar',
                links: plan_links_data,
                symbolSize: 15,
                calendarIndex: 0,
                itemStyle: {
                    color: '#FFD700',
                    shadowBlur: 9,
                    shadowOffsetX: 1.5,
                    shadowOffsetY: 3,
                    shadowColor: '#555'
                },
                lineStyle: {
                    color: '#8B2323',
                    width: 1,
                    opacity: 1
                },
                data: plan_nodes_data,
                z: 20

        }, 
        {
            type: 'effectScatter',
            coordinateSystem: 'calendar',
            calendarIndex: 1,
            symbolSize: 10,
            data: getVirtulData(2020)
        },
        {
            type: 'heatmap',
            coordinateSystem: 'calendar',
            data: getVirtulData(2020),
            label: {
                show: true,
                formatter: function (params) {
                    var d = echarts.number.parseDate(params.value[0]);
                    return d.getDate();
                },
                color: "#fff",
                fontSize:10
            },
            emphasis: {
                itemStyle: {
                    shadowBlur: 10,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
        ]
    };
    
    planChart.setOption(planoption);



</script>
</html>