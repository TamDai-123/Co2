<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Co2 Know</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/10.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <link rel="stylesheet" href="styles1.css">
</head>

<body>
  <!-- ดึงข้อมูลทั้งหมด และอัพเดททุก10วิ -->
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    let chart; // เก็บกราฟไว้ใช้ตอนอัปเดต

    function getColorClass(co2) {
      if (co2 <= 400) return "green";
      if (co2 <= 1000) return "lime";
      if (co2 <= 2000) return "yellow";
      if (co2 <= 5000) return "orange";
      return "red";
    }

    function updateLiveData() {
      fetch('latest_data.php')
        .then(res => res.json())
        .then(data => {
          if (data.error) {
            console.error(data.error);
            return;
          }

          const co2Value = data.co2;
          const co2Box = document.querySelector("#co2-status");
          const colorClass = getColorClass(co2Value);

          document.querySelector("#co2-value").textContent = co2Value;
          co2Box.textContent = data.status;
          co2Box.className = `status-box ${colorClass}`;

          document.querySelector("#tvoc-value").textContent = data.tvoc;
        })
        .catch(err => console.error("Error loading latest data:", err));
    }

    function updateChartData() {
      fetch('data.php')
        .then(response => response.json())
        .then(data => {
          const categories = data.map(row => row.date);
          const co2Data = data.map(row => row.avg_co2);
          const tvocData = data.map(row => row.avg_tvoc);

          if (!chart) {
            chart = new ApexCharts(document.querySelector("#reportsChart"), {
              series: [
                { name: 'CO2', data: co2Data },
                { name: 'TVOC', data: tvocData }
              ],
              chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false },
              },
              markers: { size: 4 },
              colors: ['#4154f1', '#2eca6a'],
              fill: {
                type: "gradient",
                gradient: {
                  shadeIntensity: 1,
                  opacityFrom: 0.3,
                  opacityTo: 0.4,
                  stops: [0, 90, 100]
                }
              },
              dataLabels: { enabled: false },
              stroke: { curve: 'smooth', width: 2 },
              xaxis: {
                categories: categories,
                title: { text: 'Date' }
              },
              yaxis: {
                title: { text: 'Average Value' }
              },
              tooltip: {
                x: { format: 'yyyy-MM-dd HH:mm' }
              }
            });

            chart.render();
          } else {
            chart.updateSeries([
              { name: 'CO2', data: co2Data },
              { name: 'TVOC', data: tvocData }
            ]);
            chart.updateOptions({
              xaxis: { categories: categories }
            });
          }
        })
        .catch(error => console.error('Error fetching chart data:', error));
    }

    // เรียกตอนโหลดหน้า
    updateLiveData();
    updateChartData();

    // ตั้งเวลาเรียกซ้ำทุก 10 วินาที
    setInterval(() => {
      updateLiveData();
      updateChartData();
    }, 10000);
  });
</script>
  
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between ">
      <a href="index.php" class="logo d-flex a-itlignems-center">
        <img src="assets/img/10.png" alt="OXY_logo" >
      </a>
    </div><!-- End Logo -->
    
    <?php
      include 'connect.php';

      // แสดง Popup
      echo "<script>alert('เชื่อมต่อสำเร็จ!');</script>";
    ?>
    
    <nav class="header-nav ms-auto">

      <img class="logo_position" src="assets/img/TamDai_JPG_O.png" alt="RBM Logo" style="width: 100px; height: auto;">
        
    </nav><!-- End Icons Navigation -->
      
      

  </header><!-- End Header -->

  

  <main id="main" class="main">

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-12 col-md-6">
                <div class="card info-card sales-card">
  
                    <div class="card-body ">
                        <div class="card-title-wrapper">
                            <h5 class="card-title"> 
                                <img src="assets/img/3.png" alt="SPO2 Logo" style="width: 50px; height: auto;">
                                Co2
                            </h5>
                        </div>
  
                        
                        <div class="ps-3 card-title-wrapper end">
                          <div class="ps-3 card-title-wrapper span text-V" id="co2-value">--</div>
                          <div class="ps-3 card-title-wrapper span text-normal ">
                            <div class="status-box" id="co2-status">--</div>
                          </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Sales Card -->

            
            <!-- Sales Card -->
            <div class="col-xxl-12 col-md-6">
                <div class="card info-card sales-card">
  
                    <div class="card-body ">
                        <div class="card-title-wrapper">
                            <h5 class="card-title"> 
                                <img src="assets/img/2.png" alt="SPO2 Logo" style="width: 40px; height: auto;">
                                Tvoc
                            </h5>
                        </div>
  
                        
                        <div class="ps-3 card-title-wrapper end">
                          <div class="ps-3 card-title-wrapper span text-V" id="tvoc-value">--</div>
                        </div>
                    </div>
                </div>
            </div><!-- End Sales Card -->

            

            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                

                <div class="card-body">
                  <h5 class="card-title">Reports </h5>
                  
                  <!-- Export Data -->
                  <form action="export.php" method="post" class="form-right" >
                    <button class="button" type="submit">Export Data</button>
                  </form>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <!--<script>
                    document.addEventListener("DOMContentLoaded", () => {
                      fetch('data.php')
                        .then(response => response.json())
                        .then(data => {
                          const categories = data.map(row => row.hour);  // เปลี่ยนตรงนี้
                          const co2Data = data.map(row => row.avg_co2);
                          const tvocData = data.map(row => row.avg_tvoc);

                          new ApexCharts(document.querySelector("#reportsChart"), {
                            series: [{
                              name: 'CO2',
                              data: co2Data
                            }, {
                              name: 'TVOC',
                              data: tvocData
                            }],
                            chart: {
                              height: 350,
                              type: 'area',
                              toolbar: { show: false },
                            },
                            markers: { size: 4 },
                            colors: ['#4154f1', '#2eca6a'],
                            fill: {
                              type: "gradient",
                              gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.3,
                                opacityTo: 0.4,
                                stops: [0, 90, 100]
                              }
                            },
                            dataLabels: { enabled: false },
                            stroke: { curve: 'smooth', width: 2 },
                            xaxis: {
                              categories: categories,
                              title: { text: 'Hour (24H)' }
                            },
                            yaxis: {
                              title: { text: 'Average Value' }
                            },
                            tooltip: {
                              x: { format: 'yyyy-MM-dd HH:mm' }
                            }
                          }).render();
                        })
                        .catch(error => console.error('Error fetching data:', error));
                    });
                  </script>-->
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->
          </div>
        

      </div>
    </section>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>