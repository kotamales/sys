AmCharts.makeChart("chartdiv",
	{
		"type": "serial",
		"export": {"enabled": true},
		"categoryField": "category",
		"startDuration": 1,
		"categoryAxis": {
			"labelRotation": 45,
		},
		"trendLines": [],
		"graphs": [
			{
				"balloonText": "[[title]] of [[category]]:[[value]]",
				"bullet": "round",
				"id": "Penjualan",
				"title": "Penjualan",
				"valueField": "column-1"
			}
		],
		"guides": [],
		"valueAxes": [
			{
				"id": "ValueAxis-1",
				"title": "Jumlah"
			}
		],
		"allLabels": [],
		"balloon": {},
		"legend": {
			"enabled": true,
			"align": "center",
			"labelWidth": 0,
			"left": 0,
			"maxColumns": -1,
			"rollOverGraphAlpha": 0,
			"tabIndex": 26,
			"textClickEnabled": true,
			"useGraphSettings": true
		},
		"titles": [
			{
				"id": "Title-1",
				"size": 15,
				"text": "Grafik Transaksi Penjualan per Bulan"
			}
		],
		"dataProvider": [
			{
				"category": "Januari",
				"column-1": 8,
				"": 5
			},
			{
				"category": "Februari",
				"column-1": 6,
				"": 7
			},
			{
				"category": "Maret",
				"column-1": 2,
				"": 3
			},
			{
				"category": "April",
				"column-1": 1,
				"": 3
			},
			{
				"category": "Mei",
				"column-1": 2,
				"": 1
			},
			{
				"category": "Juni",
				"column-1": 3,
				"": 2
			},
			{
				"category": "Juli",
				"column-1": 6,
				"": 8
			},
			{
				"category": "Agustus",
				"column-1": "7",
				"": null
			},
			{
				"category": "September",
				"column-1": "8",
				"": null
			},
			{
				"category": "Oktober",
				"column-1": "9",
				"": null
			},
			{
				"category": "Nopember",
				"column-1": "9",
				"": null
			},
			{
				"category": "Desember",
				"column-1": "12",
				"": null
			}
		]
	}
);
