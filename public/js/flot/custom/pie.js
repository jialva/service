var $border_color="#eee",$grid_color="#eee",$default_black="#666";$(function(){var a,b;a=[{label:"HTML",data:Math.floor(100*Math.random()+190)},{label:"CSS",data:Math.floor(100*Math.random()+220)},{label:"PHP",data:Math.floor(100*Math.random()+370)},{label:"jQuery",data:Math.floor(100*Math.random()+120)},{label:"RUBY",data:Math.floor(100*Math.random()+430)}],b={series:{pie:{show:!0,innerRadius:0,stroke:{width:0}}},grid:{hoverable:!0,clickable:!1,borderWidth:0,tickColor:"#dfe2f0",borderColor:"#dfe2f0"},legend:{position:"nw"},shadowSize:0,tooltip:!0,tooltipOpts:{content:"%s: %y"},colors:["#ff7671","#ffda68","#3fcbca","#4bb5ea"]};var c=$("#pie-chart");c.length&&$.plot(c,a,b)});