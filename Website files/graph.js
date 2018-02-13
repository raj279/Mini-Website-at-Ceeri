var site= "http://192.168.12.91/series/"+display_date+ "jsdata.txt" //192.168.12.91- ceeri my LAN
$(document).ready(function(){
	alert(site);
		$.ajax({
			url : site,
			type : "GET",
			dataType: "json",
			success : function(data){
				console.log(data);

				var time = [];
				var sensor1 = [];
				var sensor2 = [];
				var sensor3 = [];

				for(var i in data) {
					time.push("time " + data[i].time);
					sensor1.push(data[i].sensor1);
					sensor2.push(data[i].sensor2);
					sensor3.push(data[i].sensor3);
				}
	 
				console.log(time);
				console.log(sensor1);
				//alert(time[0]);

				var chartdata = { 
					labels: time,
					datasets: [
						{
							label: "sensor1",
							fill: false,
							lineTension: 0.1,
							backgroundColor: "rgba(59, 89, 152, 0.75)",
							borderColor: "rgba(59, 89, 152, 1)",
							pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
							pointHoverBorderColor: "rgba(59, 89, 152, 1)",
							data: sensor1
						},
						{
							label: "sensor2",
							fill: false,
							lineTension: 0.1,
							backgroundColor: "rgba(29, 202, 255, 0.75)",
							borderColor: "rgba(29, 202, 255, 1)",
							pointHoverBackgroundColor: "rgba(29, 202, 255, 1)",
							pointHoverBorderColor: "rgba(29, 202, 255, 1)",
							data: sensor2
						},
						{
							label: "sensor3",
							fill: false,
							lineTension: 0.1,
							backgroundColor: "rgba(211, 72, 54, 0.75)",
							borderColor: "rgba(211, 72, 54, 1)",
							pointHoverBackgroundColor: "rgba(211, 72, 54, 1)",
							pointHoverBorderColor: "rgba(211, 72, 54, 1)",
							data: sensor3
						}
					]
				};

				var ctx = $("#mycanvas");

				var LineGraph = new Chart(ctx, {
					type: 'line',
					data: chartdata
				});
			},
			error : function(data) {

			}
		});
});
