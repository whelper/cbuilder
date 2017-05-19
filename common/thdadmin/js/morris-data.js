$(function() {
	
	
	$.ajax({
		type: "GET",
		url: "https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A102956389&start-date=100daysAgo&end-date=yesterday&metrics=ga%3Asessions&dimensions=ga%3AyearMonth&access_token=ya29.oQGv9BH4GodyxH5Yc3NdpPR0QUTgpjGsJGlGumk9OIIZs-4nCSM4WNFcruflMU2w-xbJRETGv4tIbg",
		/*data: "history_file="+$(this).val(),*/
		success: function(data){
			var obj = jQuery.parseJSON(data);
			alert(obj.name );
		},
		error:function(error){alert('에러');}
	});		

   
	
	Morris.Area({
        element: 'morris-area-chart',
        data: [{
            period: '2015-01',
            iphone: 2666
        }, {
            period: '2015-02',
            iphone: 2778
        }, {
            period: '2015-03',
            iphone: 4912
        }, {
            period: '2015-04',
            iphone: 3767
        }, {
            period: '2015-05',
            iphone: 6810
        }, {
            period: '2015-06',
            iphone: 5670
        }],
        xkey: 'period',
        /*ykeys: ['iphone', 'ipad', 'itouch'],
        labels: ['iPhone', 'iPad', 'iPod Touch'],*/
		ykeys: ['iphone'],
        labels: ['접속인원'],
        pointSize: 3,
        hideHover: 'auto',
        resize: true
    });

   /* Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        resize: true
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });*/

});
