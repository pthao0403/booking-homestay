@extends('layouts.app')

@section('content')
<div class="admin-container">
    @include('partials.sidebar-admin')

    <div class="admin-content">
        <h2>Bảng điều khiển Admin</h2>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <div id="booking_chart" style="width: 100%; height: 400px;"></div>

        <div class="row mt-4">
            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm">
                    <div class="card-body py-4">
                        <h3 class="fw-bold text-primary">{{ $totalRooms }}</h3>
                        <p class="text-muted mb-0">Tổng số phòng</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm">
                    <div class="card-body py-4">
                        <h3 class="fw-bold text-success">{{ $totalUsers }}</h3>
                        <p class="text-muted mb-0">Khách hàng</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm">
                    <div class="card-body py-4">
                        <h3 class="fw-bold text-warning">{{ $totalBookings }}</h3>
                        <p class="text-muted mb-0">Lượt đặt (Booking)</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card text-center h-100 shadow-sm">
                    <div class="card-body py-4">
                        <h3 class="fw-bold text-danger">{{ $revenue }}</h3>
                        <p class="text-muted mb-0">Doanh thu dự kiến</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
        // Nạp gói biểu đồ từ Google
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Gọi đến API bạn đã viết ở hiệp trước
            fetch('/api/dashboard')
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        // Lấy mảng dữ liệu trạng thái từ API trả về
                        const stats = result.data.booking_status_stats; 
                        
                        // Định dạng lại theo cấu trúc mảng 2 chiều Google Charts cần
                        let chartData = [['Trạng thái', 'Số lượng']];
                        
                        stats.forEach(item => {
                            chartData.push([item.status, parseInt(item.total)]);
                        });

                        var data = google.visualization.arrayToDataTable(chartData);

                        // Cấu hình hiển thị
                        var options = {
                            title: 'Tỷ lệ trạng thái đơn đặt phòng',
                            is3D: true, // Hiệu ứng 3D đổ bóng
                            backgroundColor: 'transparent',
                            chartArea: { width: '90%', height: '80%' }
                        };

                        // Vẽ biểu đồ hình tròn (PieChart) vào thẻ div có id="booking_chart"
                        var chart = new google.visualization.PieChart(document.getElementById('booking_chart'));
                        chart.draw(data, options);
                    } else {
                        console.error('API trả về trạng thái thất bại');
                    }
                })
                .catch(error => console.error('Lỗi kết nối API:', error));
        }
    </script>
@endsection