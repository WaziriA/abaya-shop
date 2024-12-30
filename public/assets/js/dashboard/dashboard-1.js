(function($) {
    "use strict";

    // Data for the pie chart
    var usedCoupons = 120; // Number of used coupons
    var expiredCoupons = 80; // Number of expired coupons

    // Calculate percentages
    var totalCoupons = usedCoupons + expiredCoupons;
    var usedPercentage = (usedCoupons / totalCoupons) * 100;
    var expiredPercentage = (expiredCoupons / totalCoupons) * 100;

    // Get the context of the canvas element
    var ctx = document.getElementById('coupon-pie-chart').getContext('2d');

    // Create the pie chart
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [
                `Used Coupons (${usedCoupons})`,
                `Expired Coupons (${expiredCoupons})`
            ],
            datasets: [{
                data: [usedPercentage, expiredPercentage],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)', // Blue
                    'rgba(255, 99, 132, 0.7)'  // Red
                ],
                hoverBackgroundColor: [
                    'rgba(54, 162, 235, 0.9)',
                    'rgba(255, 99, 132, 0.9)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.raw.toFixed(2) + '%';
                            return label;
                        }
                    }
                }
            }
        }
    });

})(jQuery);


(function($) {
    "use strict";

    // Prepare labels for months
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    // Prepare datasets dynamically
    var datasets = [];
    Object.keys(chartData).forEach(function(currency) {
        datasets.push({
            label: currency,
            data: Object.values(chartData[currency]),
            borderColor: {
                'USD': '#1E90FF',
                'AED': '#FF6347',
                'EURO': '#32CD32',
                'GBP': '#FFD700'
            }[currency],
            fill: false
        });
    });

    // Line chart
    var ctx = document.getElementById('sales-line-chart').getContext('2d');
    var salesLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: months, // X-axis labels
            datasets: datasets // Dynamic datasets
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'category',
                    title: {
                        display: true,
                        text: 'Months'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Amount'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            maintainAspectRatio: false
        }
    });

})(jQuery);



(function($) {
    "use strict";



    // Morris bar chart
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
        labels: ['A', 'B'],
        barColors: ['#343957', '#5873FE'],
        hideHover: 'auto',
        gridLineColor: '#eef0f2',
        resize: true
    });

    $('#info-circle-card').circleProgress({
        value: 0.70,
        size: 100,
        fill: {
            gradient: ["#a389d5"]
        }
    });

    $('.testimonial-widget-one .owl-carousel').owlCarousel({
        singleItem: true,
        loop: true,
        autoplay: false,
        //        rtl: true,
        autoplayTimeout: 2500,
        autoplayHoverPause: true,
        margin: 10,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });

    $('#vmap13').vectorMap({
        map: 'usa_en',
        backgroundColor: 'transparent',
        borderColor: 'rgb(88, 115, 254)',
        borderOpacity: 0.25,
        borderWidth: 1,
        color: 'rgb(88, 115, 254)',
        enableZoom: true,
        hoverColor: 'rgba(88, 115, 254)',
        hoverOpacity: null,
        normalizeFunction: 'linear',
        scaleColors: ['#b6d6ff', '#005ace'],
        selectedColor: 'rgba(88, 115, 254, 0.9)',
        selectedRegions: null,
        showTooltip: true,
        // onRegionClick: function(element, code, region) {
        //     var message = 'You clicked "' +
        //         region +
        //         '" which has the code: ' +
        //         code.toUpperCase();

        //     alert(message);
        // }
    });

    var nk = document.getElementById("sold-product");
    // nk.height = 50
    new Chart(nk, {
        type: 'pie',
        data: {
            defaultFontFamily: 'Poppins',
            datasets: [{
                data: [45, 25, 20, 10],
                borderWidth: 0,
                backgroundColor: [
                    "rgba(89, 59, 219, .9)",
                    "rgba(89, 59, 219, .7)",
                    "rgba(89, 59, 219, .5)",
                    "rgba(89, 59, 219, .07)"
                ],
                hoverBackgroundColor: [
                    "rgba(89, 59, 219, .9)",
                    "rgba(89, 59, 219, .7)",
                    "rgba(89, 59, 219, .5)",
                    "rgba(89, 59, 219, .07)"
                ]

            }],
            labels: [
                "one",
                "two",
                "three",
                "four"
            ]
        },
        options: {
            responsive: true,
            legend: false,
            maintainAspectRatio: false
        }
    });



})(jQuery);

(function($) {
    "use strict";

    var data = [],
        totalPoints = 300;

    function getRandomData() {

        if (data.length > 0)
            data = data.slice(1);

        // Do a random walk

        while (data.length < totalPoints) {

            var prev = data.length > 0 ? data[data.length - 1] : 50,
                y = prev + Math.random() * 10 - 5;

            if (y < 0) {
                y = 0;
            } else if (y > 100) {
                y = 100;
            }

            data.push(y);
        }

        // Zip the generated y values with the x values

        var res = [];
        for (var i = 0; i < data.length; ++i) {
            res.push([i, data[i]])
        }

        return res;
    }

    // Set up the control widget

    var updateInterval = 30;
    $("#updateInterval").val(updateInterval).change(function() {
        var v = $(this).val();
        if (v && !isNaN(+v)) {
            updateInterval = +v;
            if (updateInterval < 1) {
                updateInterval = 1;
            } else if (updateInterval > 3000) {
                updateInterval = 3000;
            }
            $(this).val("" + updateInterval);
        }
    });

    var plot = $.plot("#cpu-load", [getRandomData()], {
        series: {
            shadowSize: 0 // Drawing is faster without shadows
        },
        yaxis: {
            min: 0,
            max: 100
        },
        xaxis: {
            show: false
        },
        colors: ["#007BFF"],
        grid: {
            color: "transparent",
            hoverable: true,
            borderWidth: 0,
            backgroundColor: 'transparent'
        },
        tooltip: true,
        tooltipOpts: {
            content: "Y: %y",
            defaultTheme: false
        }


    });

    function update() {

        plot.setData([getRandomData()]);

        // Since the axes don't change, we don't need to call plot.setupGrid()

        plot.draw();
        setTimeout(update, updateInterval);
    }

    update();


})(jQuery);


const wt = new PerfectScrollbar('.widget-todo');
const wtl = new PerfectScrollbar('.widget-timeline');