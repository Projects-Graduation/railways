$(document).ready(function () {
	/*var chart = {}
	chart.fetchChart = function () {
		$.ajax({
			url: "http://localhost/chart/inc/data.php",
			method: 'GET',
			success: function (data) {
				var player = [],
					score = [];
				for (var i in data) {
					player.push(data[i].name);
					score.push(data[i].score);
				}

				chart.charData = {
					labels: player,
					datasets: [{
						label: 'player score',
						backgroundColor: 'rgba(0,93,81,0.70)',
						borderColor: 'rgba(0,93,81,0.80)',
						hoverBackgroundColor: 'rgba(0,93,81,0.90)',
						hoverBorderColor: 'rgba(0,93,81,1)',
						data: score
					}] 
				};

				// init the Chart
				var ctx = $("#playerScore"),
					playerScore = new Chart(ctx, {
						type: 'line',
						data: chart.charData
					});
			},
			error: function (data) {
				console.log(data);
			}
		});
	}
chart.interval = setInterval(chart.fetchChart, 16000);
chart.fetchChart();*/

	const	db = $("#dashboardStats"),
		 	pj = $("#projectStats");
	dashboardStats = new Chart(db, {
		type: 'bar',
		data: {
	        labels: ["المشاريع التامة", "طلبات المشاريع", "قيد العمل"],
	        datasets: [{
	            label: '',
	            data: [95, 9, 75],
	            backgroundColor: [
	                'rgba(46, 165, 3, 0.82)',
	                'rgba(235, 132, 87, 0.8)',
	                'rgba(32, 107, 165, 0.8)'
	            ],
	            borderColor: [
	                '#2ea520',
	                '#eb8457',
	                '#206ba5',	            ],
	            borderWidth: 4,
	            pointBorderWidth: 4,
	            pointHoverBorderWidth: 8
	        }]
	    },
	    options: {
	    	scales: {
	    		yAxes: [{
	    			ticks: {
	    				beginAtZero: true
	    			}
	    		}],
	    		xAxes: [{
	    			ticks: {
	    				beginAtZero: true
	    			}
	    		}]
	    	}
	    }
	});

	projectStats = new Chart(pj, {
		type: 'line',
		data: {
	        labels: ["المشاريع التامة", "طلبات المشاريع", "قيد العمل"],
	        datasets: [{
	            label: '',
	            data: [95, 9, 75],
	            backgroundColor: [
	                'rgba(46, 165, 3, 0.82)',
	                'rgba(235, 132, 87, 0.8)',
	                'rgba(32, 107, 165, 0.8)'
	            ],
	            borderColor: [
	                '#2ea520',
	                '#eb8457',
	                '#206ba5',	            ],
	            borderWidth: 4,
	            pointBorderWidth: 4,
	            pointHoverBorderWidth: 8
	        }]
	    },
	    options: {
	    	scales: {
	    		yAxes: [{
	    			ticks: {
	    				beginAtZero: true
	    			}
	    		}],
	    		xAxes: [{
	    			ticks: {
	    				beginAtZero: true
	    			}
	    		}]
	    	}
	    }
	});

});