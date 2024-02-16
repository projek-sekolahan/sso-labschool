/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Apex Chart init js
*/
// pie chart

    var PieOptions = {
        chart: {
            height: 100,
            type: 'pie',
        }, 
        series: [45, 55],
        labels: ["Internal", "External"],
        colors: ["#34c38f", "#556ee6"],
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 350
                },
                legend: {
                    show: false
                },
            }
        }],
    }

    var PiePPOptions = {
        chart: {
            height: 450,
            type: 'pie',
        }, 
        series: [10, 15, 20, 25, 25, 5],
        labels: ["Mesin", "Listrik", "Interior", "Exterior", "Understeel", "AC"],
        colors: ["#34c38f", "#556ee6", "#84c38f", "#956ee6", "#34c98f", "#596ee6"],
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 350
                },
                legend: {
                    show: false
                },
            }
        }],
    }

    var PieADMOptions = {
        chart: {
            height: 450,
            type: 'pie',
        }, 
        series: [30, 25, 45],
        labels: ["Tahunan", "Ganti Nopol", "Tilang"],
        colors: ["#34c38f", "#556ee6", "#84c38f"],
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 350
                },
                legend: {
                    show: false
                },
            }
        }],
    }

    var PieBBMOptions = {
        chart: {
            height: 450,
            type: 'pie',
        }, 
        series: [55, 45],
        labels: ["Diesel", "Bensin"],
        colors: ["#34c38f", "#84c38f"],
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 350
                },
                legend: {
                    show: false
                },
            }
        }],
    }
  
    var BarPoolOptions = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%',
                endingShape: 'rounded'	
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        series: [{
            name: 'Perawatan & Perbaikan',
            data: [46, 57, 59, 54, 62, 58, 64, 60, 66]
        }, {
            name: 'Administrasi',
            data: [74, 83, 102, 97, 86, 106, 93, 114, 94]
        }],
        colors: ['#34c38f', '#556ee6'],
        xaxis: {
            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
            title: {
                text: 'Jumlah Total',
                style: {
                    fontWeight:  '500',
                  },
            }
        },
        grid: {
            borderColor: '#f1f1f1',
        },
        fill: {
            opacity: 1
    
        },
        
    }

    var BarAdminOptions = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%',
                endingShape: 'rounded'	
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        series: [
            {
                name: 'Event',
                data: [46, 57, 59, 54, 62, 58, 64, 60, 66]
            }, {
                name: 'Meeting',
                data: [74, 83, 102, 97, 86, 106, 93, 114, 94]
            }, 
        // {
        //     name: 'Voucher BBM',
        //     data: [37, 42, 38, 26, 47, 50, 54, 55, 43]
        // }
        ],
        colors: ['#34c38f', '#556ee6', '#f46a6a'],
        xaxis: {
            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
            title: {
                text: 'Jumlah Total',
                style: {
                    fontWeight:  '500',
                  },
            }
        },
        grid: {
            borderColor: '#f1f1f1',
        },
        fill: {
            opacity: 1
    
        },
        
    }

    var BBMOptions = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%',
                endingShape: 'rounded'	
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        series: [{
            name: 'Biro Humas',
            data: [46, 57, 59, 54, 62, 58, 64, 60, 66]
        }, {
            name: 'Biro Perencanaan',
            data: [74, 83, 102, 97, 86, 106, 93, 114, 94]
        }, {
            name: 'Pusat KUB',
            data: [37, 42, 38, 26, 47, 50, 54, 55, 43]
        }, {
            name: 'Biro Keuangan',
            data: [36, 67, 39, 59, 72, 48, 94, 70, 46]
        }, {
            name: 'Pusat Konghucu',
            data: [84, 89, 108, 92, 96, 111, 103, 144, 104]
        }, {
            name: 'Biro Ortala',
            data: [74, 48, 88, 66, 77, 55, 74, 75, 48]
        }, {
            name: 'Biro Umum',
            data: [30, 12, 98, 86, 87, 90, 94, 95, 83]
        }],
        colors: ['#34c38f', '#556ee6', '#f46a6a','#34c98f', '#156ee6', '#f99a6a','#98c38f'],
        xaxis: {
            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
            title: {
                text: 'Jumlah Total',
                style: {
                    fontWeight:  '500',
                  },
            }
        },
        grid: {
            borderColor: '#f1f1f1',
        },
        fill: {
            opacity: 1
    
        },
    }
    
    var ADMOptions = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%',
                endingShape: 'rounded'	
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        series: [{
            name: 'Biro Humas',
            data: [46, 57, 59, 54, 62, 58, 64, 60, 66]
        }, {
            name: 'Biro Perencanaan',
            data: [74, 83, 102, 97, 86, 106, 93, 114, 94]
        }, {
            name: 'Pusat KUB',
            data: [37, 42, 38, 26, 47, 50, 54, 55, 43]
        }, {
            name: 'Biro Keuangan',
            data: [36, 67, 39, 59, 72, 48, 94, 70, 46]
        }, {
            name: 'Pusat Konghucu',
            data: [84, 89, 108, 92, 96, 111, 103, 144, 104]
        }, {
            name: 'Biro Ortala',
            data: [74, 48, 88, 66, 77, 55, 74, 75, 48]
        }, {
            name: 'Biro Umum',
            data: [30, 12, 98, 86, 87, 90, 94, 95, 83]
        }],
        colors: ['#34c38f', '#556ee6', '#f46a6a','#34c98f', '#156ee6', '#f99a6a','#98c38f'],
        xaxis: {
            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
            title: {
                text: 'Jumlah Total',
                style: {
                    fontWeight:  '500',
                  },
            }
        },
        grid: {
            borderColor: '#f1f1f1',
        },
        fill: {
            opacity: 1
    
        },
    }    
    
    var PPOptions = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%',
                endingShape: 'rounded'	
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        series: [{
            name: 'Biro Humas',
            data: [46, 57, 59, 54, 62, 58, 64, 60, 66]
        }, {
            name: 'Biro Perencanaan',
            data: [74, 83, 102, 97, 86, 106, 93, 114, 94]
        }, {
            name: 'Pusat KUB',
            data: [37, 42, 38, 26, 47, 50, 54, 55, 43]
        }, {
            name: 'Biro Keuangan',
            data: [36, 67, 39, 59, 72, 48, 94, 70, 46]
        }, {
            name: 'Pusat Konghucu',
            data: [84, 89, 108, 92, 96, 111, 103, 144, 104]
        }, {
            name: 'Biro Ortala',
            data: [74, 48, 88, 66, 77, 55, 74, 75, 48]
        }, {
            name: 'Biro Umum',
            data: [30, 12, 98, 86, 87, 90, 94, 95, 83]
        }],
        colors: ['#34c38f', '#556ee6', '#f46a6a','#34c98f', '#156ee6', '#f99a6a','#98c38f'],
        xaxis: {
            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
            title: {
                text: 'Jumlah Total',
                style: {
                    fontWeight:  '500',
                  },
            }
        },
        grid: {
            borderColor: '#f1f1f1',
        },
        fill: {
            opacity: 1
    
        },
    }

    function makeChart(chartID,key) {
        if (key.split("_")[0]=="dashboard") {
            if (chartID.split("_")[0]=="pie") {
                options = PieOptions;
            }
            if (chartID.split("_")[0]=="bar" && key.split("_")[1]=="pool") {
                options = BarPoolOptions;
            }
            if (chartID.split("_")[0]=="bar" && key.split("_")[1]=="admin") {
                options = BarAdminOptions;
            }
        } else {
            if (key=="perawatan") {
                if (chartID.split("_")[0]=="pie") {
                    options = PiePPOptions;
                } else {
                    options = PPOptions;
                }
            }
            if (key=="administrasi") {
                if (chartID.split("_")[0]=="pie") {
                    options = PieADMOptions;
                } else {
                    options = ADMOptions;
                }
            }
            if (key=="bbm") {
                if (chartID.split("_")[0]=="pie") {
                    options = PieBBMOptions;
                } else {
                    options = BBMOptions;
                }
            }
        }
        var chart = new ApexCharts(
            document.querySelector("#"+chartID),options
        );
        chart.render();
    }