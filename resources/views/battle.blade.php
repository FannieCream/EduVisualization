<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome To Battle Field</title>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/echarts.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-select.min.js') }}" ></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/stustyle.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/battlestyle.css')}}">
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
        <p class="hello">Hi, Welcome to Battle Field</p>
        <p class="typing">First, Choose two students you want them to battle with !</p>
    </div>

    <div class="searchbox">
        <form target="myIframe">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <select class="selectpicker show-tick" id="selectBox-1" actionsBox="true" title="Student A" data-size="7" data-width="auto">
                        <option value="" class="optionIntro">-- Please Choose --</option>
                        <option> Alice</option>
                        <option> Ben</option>
                        <option> Cindy</option>
                        <option> Denny</option>
                        <option> Emily</option>
                        <option> Fannie</option>
                    </select>
                </div>
                <div class="col-lg-6">
                    <select class="selectpicker show-tick" id="selectBox-2" actionsBox="true" title="Student B" data-size="7" data-width="auto">
                        <option value="" class="optionIntro">-- Please Choose --</option>
                        <option> Alice</option>
                        <option> Ben</option>
                        <option> Cindy</option>
                        <option> Denny</option>
                        <option> Emily</option>
                        <option> Fannie</option>
                    </select>
                </div>
            </div>
            <div class="row" style="margin-top: 30px">
                <button class="submitBtn" type="submit" onclick="battle()">BATTLE</button>
            </div>
        </div>
        </form>
        <!--    避免页面重新加载   -->
        <iframe id="myIframe" class="myIframe" name="myIframe" style="display: none"></iframe>
    </div>

    <div id="arrow">
        <img id="arrow-img" src="images/arrow.png" width="5%">
    </div>

    <p class="top-info-text">Comparison of Finished Exercises</p>
    <div id="barchart" style="width: 80%; height: 400px"></div>

    <p class="top-info-text">Comparison of Learning Ability</p>
    <div id="radarchart" style="width: 80%; height: 400px"></div>
</body>

<script type="text/javascript">
    function battle(){
        var get_student_A = $("#selectBox-1 option:selected").text();
        var get_student_B = $("#selectBox-2 option:selected").text();
        var A_BarData = [];
        var B_BarData = [];
    
        function getCorrectData(){
            var c_data = [];
            var w_data = [];
            for(var i=0;i<10;i++){
                c_data.push(Math.round(Math.random() * (50 - 20)) + 20);
                w_data.push(Math.round(Math.random() * (30 - 1)) + 1);
            }
            var mydata = [c_data, w_data];
            return mydata;
        }
    
        A_BarData = getCorrectData();
        if(get_student_A !== get_student_B) {
            B_BarData = getCorrectData();
        }else{
            B_BarData = A_BarData;
        }
    
        var barChart = echarts.init(document.getElementById("barchart"));
    
        var yAxisData =  ['Velocity', 'Electric potential energy', 'Trigonometry', 'Scalar multiplication',
        'Mathematical statistics', 'Distributed computing', 'Dielectric', 
        'Confusion matrix', 'Apriori algorithm', 'Graphical model'];
    
        var get_student_A_correct = get_student_A + " Correct";
        var get_student_B_correct = get_student_B + " Correct";
        var get_student_A_wrong = get_student_A + " Wrong";
        var get_student_B_wrong = get_student_B + " Wrong";
        var legendData = [get_student_A_correct, get_student_B_correct, get_student_A_wrong, get_student_B_wrong];
    
        var baroption = {
            tooltip: {
                trigger: "axis",
                triggerOn: "mousemove",
                position: "right",
                axisPointer: {
                    type: 'shadow'
                },
                {{--  formatter: function (params, ticket, callback){
                    var get_data = params;
                    console.log(get_data);
                    var res = "";
                    return res;
                },  --}}
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
    
            legend: {
                left: 'center',
                bottom: 24,
                itemWidth: 15,
                itemHeight: 11,
                itemGap: 20,
                borderRadius: 4,
                textStyle: {
                    color: '#fff',
                    fontSize: 14
                },
                data: legendData
            },
    
            grid: [
                {
                    left: '12%',
                    width: '28%',
                    containLabel: true,
                }, 
                {
                    left: '52%',
                    width: '0%',
                }, 
                {
                    right: '12%',
                    width: '28%',
                    containLabel: true,
                }
            ],
            
            xAxis: [
                {
                    type: 'value',
                    inverse: true,
                    axisLabel: {
                        show: true,
                        color: '#949AA8',
                        margin: 0
                    },
                    axisLine: {
                        show: false
                    },
                    axisTick: {
                        show: false
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: '#E0E0E0',
                            type: 'dashed'
                        }
                    },
                    zlevel: 10
                }, 
                {
                    gridIndex: 1,
                    show: true
                }, 
                {
                    gridIndex: 2,
                    type: 'value',
                    axisLabel: {
                        show: true,
                        color: '#949AA8',
                        margin: 0
                    },
                    axisLine: {
                        show: false
                    },
                    axisTick: {
                        show: false
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: '#E0E0E0',
                            type: 'dashed'
                        }
                    },
                    min: 0,
                    max: 80,
                    zlevel: 10
                }
            ],
    
            yAxis: [
                {
                    type: 'category',
                    data: yAxisData,
                    inverse: false,
                    position: 'right',
                    axisLabel: {
                        show: false
                    },
                    axisLine: {
                        show: true,
                        lineStyle: {
                            color: '#E0E0E0'
                        }
                    },
                    axisTick: {
                        show: false
                    }
                },
                {
                    type: 'category',
                    data: yAxisData,
                    inverse: false,
                    gridIndex: 1,
                    position: 'center',
                    axisLabel: {
                        align: 'center',
                        padding: [20, 0, 20, 0],
                        fontSize: 12,
                        color: "#fff"
                    },
                    axisLine: {
                        show: false
                    },
                    axisTick: {
                        show: false
                    }
                },
                {
                    type: 'category',
                    data: yAxisData,
                    inverse: false,
                    gridIndex: 2,
                    position: 'left',
                    axisLabel: {
                        show: false
                    },
                    axisLine: {
                        show: true,
                        lineStyle: {
                            color: '#E0E0E0'
                        }
                    },
                    axisTick: {
                        show: false
                    }
                }
            ],
    
            series: [
                {   
                    name: get_student_A_correct,
                    type: "bar",
                    stack: '1',
                    label: {
                        position: "left"
                    },
                    itemStyle: {
                        color: '#8B658B',
                        borderRadius: [0, 0, 0, 0]
                    },
                    data: A_BarData[0],
                    barWidth: 11,
                    label: {
                        show: true,
                        fontFamily: 'Rubik-Medium',
                        fontSize: 14,
                        distance: 10
                    }
                },
                {   
                    name: get_student_A_wrong,
                    type: "bar",
                    data: A_BarData[1],
                    stack: '1',
                    barWidth: 11,
                    label: {
                        show: true,
                        fontFamily: 'Rubik-Medium',
                        fontSize: 14,
                        distance: 10,
                        color: "#111"
                    },
                    itemStyle: {
                        color: '#FFC1C1',
                        borderRadius: [4, 0, 0, 4]
                    }
                },
                {   
                    name: get_student_B_correct,
                    type: "bar",
                    data: B_BarData[0],
                    stack: '2',
                    xAxisIndex: 2,
                    yAxisIndex: 2,
                    label: {
                        show: true,
                        fontFamily: 'Rubik-Medium',
                        fontSize: 14,
                        distance: 10
                    },
                    itemStyle: {
                        color: '#6E8B3D',
                        borderRadius: [0, 0, 0, 0]
                    },
                    barWidth: 11
                },
                {   
                    name: get_student_B_wrong,
                    xAxisIndex: 2,
                    yAxisIndex: 2,
                    type: "bar",
                    data: B_BarData[1],
                    stack: '2',
                    label: {
                        position: 'right'
                    },
                    itemStyle: {
                        color: '#EEDC82',
                        borderRadius: [0, 4, 4, 0]
                    },
                    barWidth: 11,
                    label: {
                        show: true,
                        fontFamily: 'Rubik-Medium',
                        fontSize: 14,
                        distance: 10,
                        color: "#111"
                    }
                }
            ]
        }
    
        {{--  barChart.hideLoading();  --}}
        barChart.setOption(baroption);

        var radarChart = echarts.init(document.getElementById("radarchart"));
        var radar_A_data = [];
        var radar_B_data = [];

        for(var i=0;i<6;i++){
            radar_A_data.push((Math.random()*100).toFixed(2));
            radar_B_data.push((Math.random()*100).toFixed(2));
        }

        var radaroption = {
            tooltip: {

            },
            legend: {
                data: [get_student_A, get_student_B],
                orient: "vertical",
                right: 50,
                top: 50,
                textStyle: {
                    color: '#fff',
                    fontSize: 14,
                    fontFamily: "Candara"
                },
                itemGap: 20
            },

            radar: {
                // shape: 'circle',
                name: {
                    textStyle: {
                        color: '#fff',
                        backgroundColor: '#999',
                        borderRadius: 3,
                        padding: [3, 5],
                        fontFamily: "Candara",
                        fontSize: 18
                    }
                },
                indicator: [
                    { name: 'Computer Science', max: 100},
                    { name: 'Physics', max: 100},
                    { name: 'Data Mining', max: 100},
                    { name: 'Math', max: 100},
                    { name: 'Geography', max: 100},
                    { name: 'Arts', max: 100}
                ]
            },
            series: [
                {
                    name: get_student_A + " VS " + get_student_B,
                    type: 'radar',
                    data: [
                        {
                            value: radar_A_data,
                            name: get_student_A,
                            itemStyle: {
                                color: '#458B00'
                            },
                            lineStyle: {
                                color: '#458B00',
                                width: 2
                            },
                            areaStyle: {
                                color: 'rgba(202, 255, 112, 0.6)'
                            }
                        },
                        {
                            value: radar_B_data,
                            name: get_student_B,
                            itemStyle: {
                                color: '#CD5C5C'
                            },
                            lineStyle: {
                                color: '#CD5C5C',
                                width: 2
                            },
                            areaStyle: {
                                color: 'rgba(255, 231, 186, 0.7)'
                            }
                        }
                    ]
            }]

        };

        radarChart.setOption(radaroption);

    }

    




</script>
</html>