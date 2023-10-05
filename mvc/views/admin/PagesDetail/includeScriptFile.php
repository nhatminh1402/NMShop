<!-- jQuery -->
<script src="./public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./public/dist/js/adminlte.min.js"></script>

<!-- Thư viện tạo alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
 if(isset($includeManageBrandjs)) {
    echo '<script src="./public/js/ManageBrand.js"></script>';
}

?>
</body>
</html>
